<?php

namespace App\Repositories\IncomeCategories;


use App\Models\IncomeCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\IncomeCategories\IncomeCategoryRepositoryInterface;

class IncomeCategoryRepository implements IncomeCategoryRepositoryInterface
{
    public function getUserId()
    {
        $userId = Auth::user()->id;
        return $userId;
    }


    public function getCategories($userId)
    {
        $categories = IncomeCategory::where('user_id', $userId)->paginate(5);
        return $categories;
    }


    public function getParents($userId)
    {
        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();
        return $categories;
    }


    public function storeIncomeCategory($request)
    {
        $userId = $this->getUserId();

        $request->validate([
            'title' => 'required|string',
            'parent_id' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        IncomeCategory::create([
            'user_id' => $userId,
            'title' => $request->title,
            'parent_id' => $request->parent_id,
            'description' => $request->description
        ]);
    }


    public function getCategory($category_id)
    {
        $category = IncomeCategory::find($category_id);
        return $category;
    }


    public function updateIncomeCategory($request, $category_id)
    {
        $category = $this->getCategory($category_id);

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'title' => $request->title,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
        ]);
    }


    public function deleteIncomeCategory($category_id)
    {
        $userId = $this->getUserId();
        $category = $this->getCategory($category_id);
        $category->delete();

        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', $category_id)->get();
        foreach($categories as $category){
            $category->delete();
        }
    }





}
