<?php

namespace App\Repositories\ReportIncomes;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ReportIncomes\ReportIncomeRepositoryInterface;

class ReportIncomeRepository implements ReportIncomeRepositoryInterface
{
    public function getUserId()
    {
        $userId = Auth::user()->id;
        return $userId;
    }


    public function getIncomesOfDay($userId)
    {
        $incomes = Income::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->subDays(1), Carbon::now()])
            ->orderBy('date', 'DESC')->paginate(5);

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


    public function getIncomesOfWeek($userId)
    {
        $incomes = Income::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->subDays(7), Carbon::now()])
            ->orderBy('date', 'DESC')->paginate(5);

        return $incomes;
    }


    public function getIncomesOfMonth($userId)
    {
        $incomes = Income::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->subDays(30), Carbon::now()])
            ->orderBy('date', 'DESC')->paginate(5);

        return $incomes;
    }


    public function getCategories($userId)
    {
        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        if( count($categories) == 0 ){
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();
        }else{
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
        }

        return $categories;
    }


    public function getCategory($request)
    {
        $category = IncomeCategory::find($request->category_id);
        return $category;
    }


    public function getIncomesOfCategory($category)
    {
        $incomes = Income::where('category_id', $category->id)
            ->orderBy('date', 'ASC')->paginate(5);

        return $incomes;
    }
}
