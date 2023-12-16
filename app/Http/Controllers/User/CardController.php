<?php

namespace App\Http\Controllers\User;

use App\Models\Card;
use App\Models\Income;
use Illuminate\Http\Request;
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

        $incomes = Income::where('user_id', $userId)->get();
        $totalIncome = 0;
        foreach($incomes as $income){
            $totalIncome += $income->amount;
        }

        return view('users.cards.index', compact([
            'cards',
            'totalCash',
            'totalIncome',
        ]));
    }


    public function create()
    {
        return view('users.cards.create');
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
        $card = Card::find($card_id);

        return view('users.cards.show', compact('card'));
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
}
