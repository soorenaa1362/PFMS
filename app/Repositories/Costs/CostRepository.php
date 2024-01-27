<?php

namespace App\Repositories\Costs;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Cost;
use App\Models\CostCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Costs\CostRepositoryInterface;

class CostRepository implements CostRepositoryInterface
{
    public function getUserId()
    {
        $userId = Auth::user()->id;
        return $userId;
    }


    public function getCosts($userId)
    {
        $costs = Cost::where('user_id', $userId)->paginate(3);
        return $costs;
    }


    public function getCategories($userId)
    {
        $categories = CostCategory::where('user_id', $userId)->get();
        return $categories;
    }


    public function getTotalCost($costs)
    {
        $totalCost = 0;
        foreach($costs as $cost){
            $totalCost += $cost->amount;
        }
        return $totalCost;
    }


    public function getCards($userId)
    {
        $cards = Card::where('user_id', $userId)
            ->where('current_cash', '>', 0)->get();
        return $cards;
    }


    public function getSubCategories($userId)
    {
        $subCategories = CostCategory::where('user_id', $userId)
            ->where('parent_id', '!=', null)->get();

        if( count($subCategories) === 0 ){
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', null)->get();
        }else{
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
        }

        return $categories;
    }


    public function getParents($userId)
    {
        $parents = CostCategory::where('user_id', $userId)
            ->where('parent_id', null)->get();

            if( count($parents) === 0 ){
                return false;
            }else{
                return $parents;
            }
    }


    public function storeCost($request, $userId)
    {
        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');

        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'card_id' => 'required',
            'category_id' => 'required',
            'date' => 'required',
            'description' => 'nullable|string',
        ]);

        $cost = new Cost;
        $cost->user_id = $userId;
        $cost->title = $request->title;
        $cost->amount = $request->amount;
        $cost->card_id = $request->card_id;
        $cost->category_id = $request->category_id;
        $cost->date = $myDate;
        $cost->description = $request->description;

        $card = Card::where('id', $request->card_id)->first();

        if( $card->current_cash >= $request->amount ){
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


    public function getCost($cost_id)
    {
        $cost = Cost::where('id', $cost_id)->first();
        return $cost;
    }


    public function updateCost($request, $cost_id)
    {
        $userId = $this->getUserId();
        $cost = $this->getCost($cost_id);

        $oldCostAmount = $cost->amount;
        $card = Card::where('id', $cost->card_id)->first();

        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');

        if( $request->date == null ){
            $cost->user_id = $userId;
            $cost->card_id = $request->card_id;
            $cost->category_id = $request->category_id;
            $cost->title = $request->title;
            $cost->amount = $request->amount;
            $cost->description = $request->description;
        }else{
            $cost->user_id = $userId;
            $cost->card_id = $request->card_id;
            $cost->category_id = $request->category_id;
            $cost->title = $request->title;
            $cost->amount = $request->amount;
            $cost->date = $myDate;
            $cost->description = $request->description;
        }

        $newCard = Card::find($cost->card_id);

        if( $card == $newCard ){
            $cost->update();
            $newCash = ($card->current_cash + $oldCostAmount) - $cost->amount;
            $card->update([
                'current_cash' => $newCash
            ]);
        }else{
            $cost->update();
            $oldCash = ($card->current_cash + $oldCostAmount);
            $card->update([
                'current_cash' => $oldCash
            ]);

            $newCash = $newCard->current_cash - $cost->amount;
            $newCard->update([
                'current_cash' => $newCash
            ]);
        }
    }


    public function deleteCost($cost_id)
    {
        $cost = $this->getCost($cost_id);
        $cost->delete();
        $card = Card::where('id', $cost->card_id)->first();
        $oldCurrentCash = $card->current_cash;

        $costAmount = $cost->amount;
        $newCurrentCash = $oldCurrentCash + $costAmount;

        $card->update([
            'current_cash' => $newCurrentCash,
        ]);
    }
}
