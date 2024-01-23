<?php

namespace App\Repositories\ReportIncomes;

interface ReportIncomeRepositoryInterface
{
    public function getUserId();

    public function getIncomesOfDay($userId);

    public function getIncomeCategories($userId);

    public function getTotalIncome($incomes);

    public function getIncomesOfWeek($userId);

    public function getIncomesOfMonth($userId);

    public function getCategories($userId);

    public function getCategory($request);

    public function getIncomesOfCategory($category);
}




