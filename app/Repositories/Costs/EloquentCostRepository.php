<?php

namespace App\Repositories\Costs;

use App\Models\Cost;
use App\Models\CostCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Costs\CostRepositoryInterface;

class EloquentCostRepository implements CostRepositoryInterface
{
    public function getUserId()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;

            return $userId;
        }
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
}
