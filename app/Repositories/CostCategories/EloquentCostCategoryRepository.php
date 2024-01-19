<?php

namespace App\Repositories\CostCategories;


use App\Models\CostCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CostCategories\CostCategoryRepositoryInterface;

class EloquentCostCategoryRepository implements CostCategoryRepositoryInterface
{
    public function getUserId()
    {
        $userId = Auth::user()->id;
        return $userId;
    }


    public function getCategories($userId)
    {
        $categories = CostCategory::where('user_id', $userId)->paginate(5);
        return $categories;
    }


    public function getParents($userId)
    {
        $categories = CostCategory::where('user_id', $userId)->where('parent_id', null)->get();
        return $categories;
    }


    public function storeCostCategory($request)
    {
        $userId = $this->getUserId();

        $request->validate([
            'title' => 'required|string',
            'parent_id' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        CostCategory::create([
            'user_id' => $userId,
            'title' => $request->title,
            'parent_id' => $request->parent_id,
            'description' => $request->description
        ]);
    }


    public function getCategory($category_id)
    {
        $category = CostCategory::find($category_id);
        return $category;
    }


    public function updateCostCategory($request, $category_id)
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


    public function deleteCostCategory($category_id)
    {
        $userId = $this->getUserId();
        $category = $this->getCategory($category_id);
        $category->delete();

        $categories = CostCategory::where('user_id', $userId)->where('parent_id', $category_id)->get();
        foreach($categories as $category){
            $category->delete();
        }
    }





}
