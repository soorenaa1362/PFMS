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
        $userId = Auth::user()->id;
        $incomes = Income::where('user_id', $userId)->get();

        return view('users.incomes.index', compact('incomes'));
    }


    public function create()
    {
        $userId = Auth::user()->id;
        $cards = Card::where('user_id', $userId)->get();
        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        return view('users.incomes.create', compact('cards', 'categories'));
    }


    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');
        $myDateJalali = Jalalian::fromDateTime($myDate)->format('Y/m/d');

        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'card_id' => 'required',
            'category_id' => 'required',
            'date' => 'required',
        ]);

        Income::create([
            'user_id' => $userId,
            'title' => $request->title,
            'amount' => $request->amount,
            'card_id' => $request->card_id,
            'category_id' => $request->category_id,
            'date' => $myDate,
        ]);

        return redirect()->route('users.incomes.index')
            ->withSuccess('عملیات ثبت درآمد با موفقیت انجام شد.');
    }
}
