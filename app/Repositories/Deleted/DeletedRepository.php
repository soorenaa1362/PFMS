<?php

namespace App\Repositories\Deleted;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Cost;
use App\Models\Income;
use App\Models\CostCategory;
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
        $incomes = Income::where('user_id', $userId)->onlyTrashed()->get();
        return $incomes;
    }


    public function getCosts($userId)
    {
        $costs = Cost::where('user_id', $userId)->onlyTrashed()->get();
        return $costs;
    }
}

