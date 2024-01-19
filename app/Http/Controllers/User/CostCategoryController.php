<?php

namespace App\Http\Controllers\User;

use App\Models\CostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CostCategories\EloquentCostCategoryRepository;

class CostCategoryController extends Controller
{
    public function index()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $costCategoryRepository = new EloquentCostCategoryRepository();
            $userId = $costCategoryRepository->getUserId();
            $categories = $costCategoryRepository->getCategories($userId);

            return view('users.categories.costs.index', compact('categories'));
        }
    }



    public function create()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $costCategoryRepository = new EloquentCostCategoryRepository();
            $userId = $costCategoryRepository->getUserId();
            $categories = $costCategoryRepository->getParents($userId);

            return view('users.categories.costs.create', compact('categories'));
        }
    }


    public function store(Request $request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $costCategoryRepository = new EloquentCostCategoryRepository();
            $costCategoryRepository->storeCostCategory($request);

            return redirect()->route('users.categories.costs.index')
                ->withSuccess('دسته بندی با موفقیت در سیستم ثبت شد.');
        }
    }


    public function edit($category_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $costCategoryRepository = new EloquentCostCategoryRepository();
            $userId = $costCategoryRepository->getUserId();
            $category = $costCategoryRepository->getCategory($category_id);
            $parents = $costCategoryRepository->getParents($userId);

            return view('users.categories.costs.edit', compact('category', 'parents'));
        }
    }


    public function update(Request $request, $category_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $costCategoryRepository = new EloquentCostCategoryRepository();
            $costCategoryRepository->updateCostCategory($request, $category_id);

            return redirect()->route('users.categories.costs.index')
                ->withSuccess('عملیات بروزرسانی دسته بندی با موفقیت انجام شد.');
        }
    }


    public function delete($category_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $costCategoryRepository = new EloquentCostCategoryRepository();
            $costCategoryRepository->deleteCostCategory($category_id);

            return redirect()->route('users.categories.costs.index')
                ->withSuccess('دسته بندی مورد نظر با موفقیت حذف شد.');
        }
    }
}
