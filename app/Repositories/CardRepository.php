<?php

namespace App\Repositories;

use App\Models\Card;
use Illuminate\Support\Facades\Auth;

class CardRepository
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
}

