<?php

namespace App\Repositories\costCategories;

interface CostCategoryRepositoryInterface
{
    public function getUserId();

    public function getCategories($userId);

    public function getParents($userId);
}

