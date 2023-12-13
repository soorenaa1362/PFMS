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

class IncomeController extends Controller
{
    public function index()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }
        $incomes = Income::where('user_id', $userId)->get();

        return view('users.incomes.index', compact('incomes'));
    }


    public function create()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }
        $cards = Card::where('user_id', $userId)->get();
        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        return view('users.incomes.create', compact('cards', 'categories'));
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

        Income::create([
            'user_id' => $userId,
            'title' => $request->title,
            'amount' => $request->amount,
            'card_id' => $request->card_id,
            'category_id' => $request->category_id,
            'date' => $myDate,
            'description' => $request->description,
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
        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');
        $myDateJalali = Jalalian::fromDateTime($myDate)->format('Y/m/d');

        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|string',
            'card_id' => 'required',
            'category_id' => 'required',
            'date' => 'required',
            'description' => 'nullable|string',
        ]);

        $income->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'card_id' => $request->card_id,
            'category_id' => $request->category_id,
            'date' => $myDate,
            'description' => $request->description,
        ]);

        return redirect()->route('users.incomes.index')
            ->withSuccess('عملیات بروزرسانی اطلاعات درآمد با موفقیت انجام شد.');
    }
}
