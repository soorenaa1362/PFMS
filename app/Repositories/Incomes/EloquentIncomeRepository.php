<?php

namespace App\Repositories\Incomes;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Incomes\IncomeRepositoryInterface;

class EloquentIncomeRepository implements IncomeRepositoryInterface
{
    public function getUserId()
    {
        $userId = Auth::user()->id;
        return $userId;
    }


    public function getIncomes($userId)
    {
        $incomes = Income::where('user_id', $userId)->get();
        return $incomes;
    }


    public function getIncomeCategories($userId)
    {
        $incomeCategories = IncomeCategory::where('user_id', $userId)->get();
        return $incomeCategories;
    }


    public function getTotalIncome($incomes)
    {
        $totalIncome = 0;
        foreach($incomes as $income){
            $totalIncome += $income->amount;
        }

        return $totalIncome;
    }
}
