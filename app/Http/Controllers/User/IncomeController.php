<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Income;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Incomes\EloquentIncomeRepository;

class IncomeController extends Controller
{
    public function index()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $incomeRepository = new EloquentIncomeRepository();
            $userId = $incomeRepository->getUserId();
            $incomes = $incomeRepository->getIncomes($userId);
            $incomeCategories = $incomeRepository->getIncomeCategories($userId);
            $totalIncome = $incomeRepository->getTotalIncome($incomes);

            return view('users.incomes.index', compact([
                'incomes',
                'totalIncome',
                'incomeCategories'
            ]));
        }
    }


    public function create()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $incomeRepository = new EloquentIncomeRepository();
            $userId = $incomeRepository->getUserId();
            $cards = $incomeRepository->getCards($userId);
            $categories = $incomeRepository->getSubCategories($userId);
            $parents = $incomeRepository->getParents($userId);

            return view('users.incomes.create', compact('cards', 'categories'));
        }
    }


    public function store(Request $request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');
        $myDateJalali = Jalalian::fromDateTime($myDate)->format('Y/m/d');

        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'card_id' => 'required',
            'category_id' => 'required',
            'date' => 'required',
            'description' => 'nullable|string',
        ]);

        $income = Income::create([
            'user_id' => $userId,
            'title' => $request->title,
            'amount' => $request->amount,
            'card_id' => $request->card_id,
            'category_id' => $request->category_id,
            'date' => $myDate,
            'description' => $request->description,
        ]);

        $card = Card::where('id', $income->card_id)->first();
        $newCash = $card->current_cash + $income->amount;
        $card->update([
            'current_cash' => $newCash
        ]);

        return redirect()->route('users.incomes.index')
            ->withSuccess('عملیات ثبت درآمد با موفقیت انجام شد.');
    }


    public function show($income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $income = Income::where('user_id', $userId)->where('id', $income_id)->first();

        return view('users.incomes.show', compact('income'));
    }


    public function edit($income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $income = Income::find($income_id);
        $cards = Card::where('user_id', $userId)->get();
        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        if( count($categories) == 0 ){
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();
        }else{
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
        }

        return view('users.incomes.edit', compact('income', 'cards', 'categories'));
    }


    public function update(Request $request, $income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $income = Income::find($income_id);
        $oldIncomeAmount = $income->amount;
        $card = Card::where('id', $income->card_id)->first();

        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');

        if($request->date == null){
            $income->user_id = $userId;
            $income->card_id = $request->card_id;
            $income->category_id = $request->category_id;
            $income->title = $request->title;
            $income->amount = $request->amount;
            $income->description = $request->description;
        }else{
            $income->user_id = $userId;
            $income->card_id = $request->card_id;
            $income->category_id = $request->category_id;
            $income->title = $request->title;
            $income->amount = $request->amount;
            $income->date = $myDate;
            $income->description = $request->description;
        }

        $newCard = Card::find($income->card_id);

        if( $card == $newCard ){
            $income->update();
            $newCash = ($card->current_cash - $oldIncomeAmount) + $income->amount;
            $card->update([
                'current_cash' => $newCash
            ]);
        }else{
            $income->update();
            $oldCash = ($card->current_cash - $oldIncomeAmount);
            $card->update([
                'current_cash' => $oldCash
            ]);

            $newCash = $newCard->current_cash + $income->amount;
            $newCard->update([
                'current_cash' => $newCash
            ]);
        }

        return redirect()->route('users.incomes.index')
            ->withSuccess('عملیات بروزرسانی اطلاعات درآمد با موفقیت انجام شد.');
    }


    public function delete($income_id)
    {
        $income = Income::find($income_id);
        $income->delete();

        $card = Card::where('id', $income->card_id)->first();
        $oldCurrentCash = $card->current_cash;
        $incomeAmount = $income->amount;
        $newCurrentCash = $oldCurrentCash - $incomeAmount;

        $card->update([
            'current_cash' => $newCurrentCash,
        ]);

        return redirect()->route('users.incomes.index')
            ->withSuccess('درآمد مورد نظر با موفقیت حذف شد.');
    }
}
