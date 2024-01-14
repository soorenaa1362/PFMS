<?php

namespace App\Repositories\IncomeCategories;


use App\Models\IncomeCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\IncomeCategories\IncomeCategoryRepositoryInterface;

class EloquentIncomeCategoryRepository implements IncomeCategoryRepositoryInterface
{
    public function getUserId()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;

            return $userId;
        }
    }


    public function getCategories($userId)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $categories = IncomeCategory::where('user_id', $userId)->paginate(5);

            return $categories;
        }
    }


    public function createForm($userId)
    {
        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();

        return $categories;
    }


    public function storeIncomeCategory($request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
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
    }


    public function getCategory($category_id)
    {
        $category = IncomeCategory::find($category_id);

        return $category;
    }


    public function getParents($userId)
    {
        $parents = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();

        return $parents;
    }



}
