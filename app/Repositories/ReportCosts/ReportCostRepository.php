<?php

namespace App\Repositories\ReportCosts;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Cost;
use App\Models\CostCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ReportCosts\ReportCostRepositoryInterface;

class ReportCostRepository implements ReportCostRepositoryInterface
{
    public function getUserId()
    {
        $userId = Auth::user()->id;
        return $userId;
    }


    public function getCostsOfDay($userId)
    {
        $costs = Cost::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->subDays(1), Carbon::now()])
            ->orderBy('date', 'DESC')->paginate(5);

        return $costs;
    }


    public function getCostCategories($userId)
    {
        $costCategories = CostCategory::where('user_id', $userId)->get();
        return $costCategories;
    }


    public function getTotalCost($costs)
    {
        $totalCost = 0;
        foreach($costs as $cost){
            $totalCost -= $cost->amount;
        }

        return $totalCost;
    }


    public function getCostsOfWeek($userId)
    {
        $costs = Cost::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->subDays(7), Carbon::now()])
            ->orderBy('date', 'DESC')->paginate(5);

        return $costs;
    }


    public function getCostsOfMonth($userId)
    {
        $costs = Cost::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->subDays(30), Carbon::now()])
            ->orderBy('date', 'DESC')->paginate(5);

        return $costs;
    }


    public function getCategories($userId)
    {
        $categories = CostCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        if( count($categories) == 0 ){
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', null)->get();
        }else{
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
        }

        return $categories;
    }


    public function getCategory($request)
    {
        $category = CostCategory::find($request->category_id);
        return $category;
    }


    public function getCostsOfCategory($category)
    {
        $costs = Cost::where('category_id', $category->id)
            ->orderBy('date', 'ASC')->paginate(5);

        return $costs;
    }
}
