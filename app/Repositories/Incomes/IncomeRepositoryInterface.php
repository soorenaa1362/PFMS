<?php

namespace App\Repositories\Incomes;

interface IncomeRepositoryInterface
{
    public function getUserId();

    public function getIncomes($userId);

    public function getIncomeCategories($userId);

    public function getCards($userId);

    public function getSubCategories($userId);

    public function getParents($userId);

    public function storeIncome($request);

    public function getIncome($income_id);
}


