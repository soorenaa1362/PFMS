<?php

namespace App\Repositories\costCategories;

interface CostCategoryRepositoryInterface
{
    public function getUserId();

    public function getCategories($userId);

    public function getParents($userId);

    public function storeCostCategory($request);

    public function updateCostCategory($request, $category_id);

    public function deleteCostCategory($category_id);
}

