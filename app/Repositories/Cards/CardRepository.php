<?php

namespace App\Repositories\Cards;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Cost;
use App\Models\Income;
use App\Models\CostCategory;
use Morilog\Jalali\Jalalian;
use App\Models\IncomeCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Cards\CardRepositoryInterface;

class CardRepository implements CardRepositoryInterface
{
    public function getUserId()
    {
        $userId = Auth::user()->id;
        return $userId;
    }


    public function getCards()
    {
        $userId = $this->getUserId();
        $cards = Card::where('user_id', $userId)->paginate(5);
        return $cards;
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
        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');

        $request->validate([
            'name' => 'required|string',
            'alias' => 'nullable|string',
            'date' => 'required',
            'number' => 'required|numeric|unique:cards',
            'current_cash' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $card = Card::create([
            'user_id' => $userId,
            'name' => $request->name,
            'alias' => $request->alias,
            'date' => $myDate,
            'number' => $request->number,
            'current_cash' => $request->current_cash,
            'description' => $request->description,
        ]);
    }


    public function getCard($card_id)
    {
        $card = Card::where('id', $card_id)->first();
        return $card;
    }


    public function getIncomes($card_id)
    {
        $incomes = Income::where('card_id', $card_id)->orderBy('id', 'DESC')->get();
        return $incomes;
    }


    public function getCosts($card_id)
    {
        $costs = Cost::where('card_id', $card_id)->orderBy('id', 'DESC')->get();
        return $costs;
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


    public function editCard($card_id)
    {
        $card = Card::find($card_id);
        return $card;
    }


    public function updateCard($request, $card_id)
    {
        $card = $this->getCard($card_id);
        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');

        $request->validate([
            'name' => 'required|string',
            'alias' => 'nullable|string',
            'number' => 'required|numeric|unique:cards,number,'.$card_id,
            'current_cash' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if($request->date == null){
            $card->update([
                'name' => $request->name,
                'alias' => $request->alias,
                'number' => $request->number,
                'current_cash' => $request->current_cash,
                'description' => $request->description,
            ]);
        }else{
            $card->update([
                'name' => $request->name,
                'alias' => $request->alias,
                'date' => $myDate,
                'number' => $request->number,
                'current_cash' => $request->current_cash,
                'description' => $request->description,
            ]);
        }

    }


    public function getIncomeCategories($userId)
    {
        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        if( count($categories) === 0 ){
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();
        }else{
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
        }

        return $categories;
    }


    public function incomeStore($request, $card_id)
    {
        $userId = $this->getUserId();

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

        $card = Card::where('id', $income->card_id)->first();
        $newCash = $card->current_cash + $income->amount;
        $card->update([
            'current_cash' => $newCash
        ]);
    }


    public function getCostCategories($userId)
    {
        $categories = CostCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        if( count($categories) === 0 ){
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', null)->get();
        }else{
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
        }

        return $categories;
    }


    public function costStore($request, $card_id)
    {
        $userId = $this->getUserId();
        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');

            $request->validate([
                'title' => 'required|string',
                'amount' => 'required|numeric',
                'category_id' => 'required',
                'date' => 'required',
                'description' => 'nullable|string',
            ]);

            $cost = new Cost;
            $cost->user_id = $userId;
            $cost->title = $request->title;
            $cost->amount = $request->amount;
            $cost->card_id = $card_id;
            $cost->category_id = $request->category_id;
            $cost->date = $myDate;
            $cost->description = $request->description;

            $card = Card::where('id', $cost->card_id)->first();

            if($card->current_cash >= $request->amount){
                $cost->save();

                $newCash = $card->current_cash - $cost->amount;
                $card->update([
                    'current_cash' => $newCash
                ]);

                return true;
            }else{
                return false;
            }
    }









}

