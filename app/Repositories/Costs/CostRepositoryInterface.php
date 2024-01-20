<?php

namespace App\Repositories\Costs;

interface CostRepositoryInterface
{
    public function getUserId();

    public function getCosts($userId);

    public function getCategories($userId);

    public function getTotalCost($costs);

    public function getCards($userId);

    public function getSubCategories($userId);

    public function getParents($userId);

    public function storeCost($request, $userId);

    public function getCost($cost_id);

    public function updateCost($request, $cost_id);

    public function deleteCost($cost_id);
}

