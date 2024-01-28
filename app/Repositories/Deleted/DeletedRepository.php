<?php

namespace App\Repositories\Deleted;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Cost;
use App\Models\Income;
use App\Models\CostCategory;
use App\Models\IncomeCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Deleted\DeletedRepositoryInterface;

class DeletedRepository implements DeletedRepositoryInterface
{
    public function getUserId()
    {
        $userId = Auth::user()->id;
        return $userId;
    }


    public function getIncomes($userId)
    {
        $incomes = Income::where('user_id', $userId)->onlyTrashed()->paginate(5);
        return $incomes;
    }


    public function getCosts($userId)
    {
        $costs = Cost::where('user_id', $userId)->onlyTrashed()->paginate(5);
        return $costs;
    }


    public function getIncomeCategories($userId)
    {
        $incomeCategories = IncomeCategory::where('user_id', $userId)->get();
        return $incomeCategories;
    }
}

