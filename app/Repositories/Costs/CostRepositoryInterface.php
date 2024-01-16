<?php

namespace App\Repositories\Costs;

interface CostRepositoryInterface
{
    public function getUserId();

    public function getCosts($userId);

    public function getCategories($userId);

    public function getTotalCost($costs);
}

