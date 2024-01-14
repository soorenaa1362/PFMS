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
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();

            return $categories;
        }
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
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $category = IncomeCategory::find($category_id);

            return $category;
        }
    }


    public function getParents($userId)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $parents = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();

            return $parents;
        }
    }


    public function updateIncomeCategory($request, $category_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $category = IncomeCategory::find($category_id);

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
    }


    public function deleteIncomeCategory($category_id)
    {
        $userId = Auth::user()->id;
        $category = IncomeCategory::find($category_id);
        $category->delete();

        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', $category_id)->get();
        foreach($categories as $category){
            $category->delete();
        }
    }



}
