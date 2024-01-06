<?php

namespace App\Repositories\Cards;

use App\Models\Card;
use App\Models\Cost;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Cards\CardRepositoryInterface;

class EloquentCardRepository implements CardRepositoryInterface
{
    public function getUserId()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            return Auth::user()->id;
        }
    }


    public function getCards()
    {
        $userId = $this->getUserId();

        return Card::where('user_id', $userId)->paginate(3);
    }


    public function getTotalCash()
    {
        $cards = $this->getCards();

        $totalCash = 0;
        foreach($cards as $card){
            $totalCash += $card->current_cash;
        }

        return $totalCash;
    }


    public function storeCard($request)
    {
        $userId = $this->getUserId();
        
        $request->validate([
            'name' => 'required|string',
            'alias' => 'nullable|string',
            'number' => 'required|numeric|unique:cards',
            'current_cash' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $card = Card::create([
            'user_id' => $userId,
            'name' => $request->name,
            'alias' => $request->alias,
            'number' => $request->number,
            'current_cash' => $request->current_cash,
            'description' => $request->description,
        ]);

        return $card;
    }


    public function showCard($card_id)
    {
        $userId = $this->getUserId();
        $card = Card::find($card_id);

        $costs = Cost::where('user_id', $userId)->orderBy('id', 'DESC')
            ->where('card_id', $card_id)->paginate(3);
        $costCount = count(Cost::where('user_id', $userId)->where('card_id', $card_id)->get());

        return $card;
    }


    public function getCardIncomes($card_id)
    {
        $userId = $this->getUserId();
        $card = Card::find($card_id);

        $incomes = Income::where('user_id', $userId)->orderBy('id', 'DESC')
            ->where('card_id', $card_id)->paginate(3);
        return $incomes;
    }


    public function getCardIncomeCount($card_id)
    {
        $userId = $this->getUserId();
        $card = Card::find($card_id);

        return count(Income::where('user_id', $userId)->where('card_id', $card_id)->get());
    }


    public function getCardCosts($card_id)
    {
        $userId = $this->getUserId();
        $card = Card::find($card_id);

        $costs = Cost::where('user_id', $userId)->orderBy('id', 'DESC')
            ->where('card_id', $card_id)->paginate(3);
        return $costs;
    }


    public function getCardCostCount($card_id)
    {
        $userId = $this->getUserId();
        $card = Card::find($card_id);

        return count(Cost::where('user_id', $userId)->where('card_id', $card_id)->get());
    }
}

