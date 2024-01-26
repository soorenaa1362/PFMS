<?php

namespace App\Repositories\Incomes;

interface IncomeRepositoryInterface
{
    public function getUserId();

    public function getIncomes($userId);

    public function getCategories($userId);

    public function getTotalIncome($incomes);

    public function getCards($userId);

    public function getSubCategories($userId);

    public function getParents($userId);

    public function storeIncome($request, $userId);

    public function getIncome($income_id);

    public function updateIncome($request, $income_id);

    public function deleteIncome($income_id);
}


