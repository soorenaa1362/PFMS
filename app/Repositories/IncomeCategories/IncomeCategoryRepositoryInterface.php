<?php

namespace App\Repositories\incomeCategories;

interface IncomeCategoryRepositoryInterface
{
    public function getUserId();

    public function getCategories($userId);

    public function createForm($userId);

    public function storeIncomeCategory($request);

    public function getCategory($category_id);

    public function getParents($userId);

    public function updateIncomeCategory($request, $category_id);

    public function deleteIncomeCategory($category_id);
}

