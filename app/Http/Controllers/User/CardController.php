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

class CardController extends Controller
{
    public function index()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }
        
        $cards = Card::where('user_id', $userId)->get();

        $totalCash = 0;
        foreach($cards as $card){
            $totalCash += $card->current_cash;
        }

        return view('users.cards.index', compact([
            'cards',
            'totalCash',
        ]));
    }


    public function create()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            return view('users.cards.create');
        }
    }


    public function store(Request $request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $request->validate([
            'name' => 'required|string',
            'alias' => 'nullable|string',
            'number' => 'required|numeric',
            'current_cash' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Card::create([
            'user_id' => $userId,
            'name' => $request->name,
            'alias' => $request->alias,
            'number' => $request->number,
            'current_cash' => $request->current_cash,
            'description' => $request->description,
        ]);

        return redirect()->route('users.cards.index')
            ->withSuccess('اطلاعات کارت با موفقیت در سیستم ثبت شد.');
    }


    public function show($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $card = Card::find($card_id);

        $incomes = Income::where('user_id', $userId)
            ->where('card_id', $card_id)->orderBy('date', 'DESC')->get();

        return view('users.cards.show', compact([
            'card',
            'incomes'
        ]));
    }


    public function edit($card_id)
    {
        $card = Card::find($card_id);

        return view('users.cards.edit', compact('card'));
    }


    public function update(Request $request, $card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $card = Card::find($card_id);

        $request->validate([
            'name' => 'required|string',
            'alias' => 'nullable|string',
            'number' => 'required|numeric',
            'current_cash' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $card->update([
            'name' => $request->name,
            'alias' => $request->alias,
            'number' => $request->number,
            'current_cash' => $request->current_cash,
            'description' => $request->description,
        ]);

        return redirect()->route('users.cards.index')
            ->withSuccess('اطلاعات کارت مورد نظر با موفقیت بروزرسانی شد.');
    }


    public function delete($card_id)
    {
        $card = Card::find($card_id);
        $card->delete();

        return redirect()->route('users.cards.index')
            ->withSuccess('عملیات حذف کارت بانکی با موفقیت انجام شد.');
    }


    public function transactions($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $card = Card::find($card_id);
        $incomes = Income::where('card_id', $card_id)->get();

        return view('users.cards.transactions.index', compact('card', 'incomes'));
    }


    public function transactionSelect($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $card = Card::find($card_id);

        return view('users.cards.transactions.select', compact('card'));
    }


    public function incomeCreate($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $card = Card::find($card_id);
        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        if( count($categories) === 0 ){
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();
        }else{
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
        }

        return view('users.cards.incomes.create', compact('card', 'categories'));
    }


    public function incomeStore(Request $request, $card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $card = Card::find($card_id);

        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');
        $myDateJalali = Jalalian::fromDateTime($myDate)->format('Y/m/d');

        $income = Income::create([
            'user_id' => $userId,
            'card_id' => $card_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $myDate,
        ]);

        return redirect()->route('users.cards.transactions', $card->id)
            ->withSuccess('اطلاعات درآمد با موفقیت در سیستم ثبت شد.');
    }


    public function incomes($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $card = Card::find($card_id);

        $incomes = Income::where('user_id', $userId)->where('card_id', $card_id)->get();
        $totalIncome = 0;
        foreach($incomes as $income){
            $totalIncome += $income->amount;
        }

        return view('users.cards.incomes.index', compact('card', 'incomes', 'totalIncome'));
    }
}
