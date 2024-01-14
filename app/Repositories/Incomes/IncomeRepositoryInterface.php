<?php

namespace App\Repositories\Incomes;

interface IncomeRepositoryInterface
{
    public function getUserId();

    public function getIncomes($userId);

    public function getIncomeCategories($userId);

    public function getTotalIncome();

    public function getCards($userId);

    public function getCategories($userId);

    public function getParents($userId);

    public function storeIncome($request);

    public function showIncome($income_id);

    public function getCard($incomeCardId);

    public function updateIncome($request, $income_id);

    public function deleteIncome($income_id);
}

