<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\IncomeCategories\EloquentIncomeCategoryRepository;

class IncomeCategoryController extends Controller
{
    public function index()
    {
        $incomeCategoryRepository = new EloquentIncomeCategoryRepository();
        $userId = $incomeCategoryRepository->getUserId();
        $categories = $incomeCategoryRepository->getCategories($userId);

        return view('users.categories.incomes.index', compact('categories'));
    }


    public function create()
    {
        $incomeCategoryRepository = new EloquentIncomeCategoryRepository();
        $userId = $incomeCategoryRepository->getUserId();
        $categories = $incomeCategoryRepository->createForm($userId);

        return view('users.categories.incomes.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $incomeCategoryRepository = new EloquentIncomeCategoryRepository();
        $userId = $incomeCategoryRepository->getUserId();

        $incomeCategoryRepository->storeIncomeCategory($request);

        return redirect()->route('users.categories.incomes.index')
            ->withSuccess('دسته بندی با موفقیت در سیستم ثبت شد.');
    }


    public function edit($category_id)
    {
        $userId = Auth::user()->id;
        $category = IncomeCategory::find($category_id);
        $parents = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();
        // $parents = IncomeCategory::where('user_id', $userId)
        //     ->where('parent_id', null)->where('id', '!=', $category_id)->get();

        return view('users.categories.incomes.edit', compact('category', 'parents'));
    }


    public function update(Request $request, $category_id)
    {
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

        return redirect()->route('users.categories.incomes.index')
            ->withSuccess('عملیات بروزرسانی دسته بندی با موفقیت انجام شد.');
    }


    public function delete($category_id)
    {
        $userId = Auth::user()->id;
        $category = IncomeCategory::find($category_id);
        $category->delete();

        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', $category_id)->get();
        foreach($categories as $category){
            $category->delete();
        }

        return redirect()->route('users.categories.incomes.index')
            ->withSuccess('دسته بندی مورد نظر با موفقیت حذف شد.');
    }
}
