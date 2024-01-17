<?php

namespace App\Repositories\Costs;

use App\Models\Card;
use App\Models\Cost;
use App\Models\CostCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Costs\CostRepositoryInterface;

class EloquentCostRepository implements CostRepositoryInterface
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
            return redirect()->route('users.costs.index');
        }else{
            return $parents;
        }
    }
}
