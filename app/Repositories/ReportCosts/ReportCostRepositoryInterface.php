<?php

namespace App\Repositories\ReportCosts;

interface ReportCostRepositoryInterface
{
    public function getUserId();

    public function getCostsOfDay($userId);

    public function getCostCategories($userId);

    public function getTotalCost($costs);

    public function getCostsOfWeek($userId);

    public function getCostsOfMonth($userId);

    public function getCategories($userId);

    public function getCategory($request);

    public function getCostsOfCategory($category);
}




