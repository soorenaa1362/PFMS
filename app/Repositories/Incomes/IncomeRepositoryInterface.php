<?php

namespace App\Repositories\Incomes;

interface IncomeRepositoryInterface
{
    public function getUserId();

    public function getIncomes($userId);

    public function getIncomeCategories($userId);
}


