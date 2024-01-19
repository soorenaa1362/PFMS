<?php

namespace App\Repositories\CostCategories;


use App\Models\CostCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CostCategories\CostCategoryRepositoryInterface;

class EloquentCostCategoryRepository implements CostCategoryRepositoryInterface
{
    public function getUserId()
    {
        $userId = Auth::user()->id;
        return $userId;
    }


    public function getCategories($userId)
    {
        $categories = CostCategory::where('user_id', $userId)->paginate(5);
        return $categories;
    }


    public function getParents($userId)
    {
        $categories = CostCategory::where('user_id', $userId)->where('parent_id', null)->get();
        return $categories;
    }
}
