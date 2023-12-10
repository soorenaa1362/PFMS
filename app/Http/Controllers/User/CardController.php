<?php

namespace App\Http\Controllers\User;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $cards = Card::where('user_id', $userId)->get();

        return view('users.cards.index', compact('cards', 'totalCash'));
    }


    public function create()
    {
        return view('users.cards.create');
    }


    public function store(Request $request)
    {
        $userId = Auth::user()->id;

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
}
