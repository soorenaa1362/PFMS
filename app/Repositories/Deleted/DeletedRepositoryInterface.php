<?php

namespace App\Repositories\Deleted;

interface DeletedRepositoryInterface
{
    public function getUserId();

    public function getIncomes($userId);

    public function getCosts($userId);

    public function getIncomeCategories($userId);

    public function restoreIncome($income_id);

    public function forceDeleteIncome($income_id);

    public function getCostCategories($userId);

    public function restoreCost($cost_id);

    public function forceDeleteCost($cost_id);
}





