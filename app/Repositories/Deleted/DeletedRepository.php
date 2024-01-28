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


    public function restoreIncome($income_id)
    {
        $income = Income::withTrashed()->find($income_id);
        $income->restore();

        $card = Card::where('id', $income->card_id)->first();
        $cardNewCash = $card->current_cash + $income->amount;
        $card->update([
            'current_cash' => $cardNewCash
        ]);
    }


    public function forceDeleteIncome($income_id)
    {
        $income = Income::onlyTrashed()->find($income_id)->forceDelete();
    }


    public function getCostCategories($userId)
    {
        $costCategories = CostCategory::where('user_id', $userId)->get();
        return $costCategories;
    }


    public function restoreCost($cost_id)
    {
        $cost = cost::withTrashed()->find($cost_id);
        $cost->restore();

        $card = Card::where('id', $cost->card_id)->first();
        $cardNewCash = $card->current_cash - $cost->amount;
        $card->update([
            'current_cash' => $cardNewCash
        ]);
    }


    public function forceDeleteCost($cost_id)
    {
        $cost = cost::onlyTrashed()->find($cost_id)->forceDelete();
    }
}

