<?php

namespace App\Http\Controllers\User;

use App\Models\CostCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CostCategoryController extends Controller
{
    public function index()
    {
        if( Auth::guest() ){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $categories = CostCategory::where('user_id', $userId)->paginate(5);

        return view('users.categories.costs.index', compact('categories'));
    }


    public function create()
    {
        $userId = Auth::user()->id;
        $categories = CostCategory::where('user_id', $userId)->where('parent_id', null)->get();

        return view('users.categories.costs.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $userId = Auth::user()->id;

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

        return redirect()->route('users.categories.costs.index')
            ->withSuccess('دسته بندی با موفقیت در سیستم ثبت شد.');
    }


    public function edit($category_id)
    {
        $userId = Auth::user()->id;
        $category = CostCategory::find($category_id);
        $parents = CostCategory::where('user_id', $userId)->where('parent_id', null)->get();
        // $parents = CostCategory::where('user_id', $userId)
        //     ->where('parent_id', null)->where('id', '!=', $category_id)->get();

        return view('users.categories.costs.edit', compact('category', 'parents'));
    }


    public function update(Request $request, $category_id)
    {
        $category = CostCategory::find($category_id);

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'title' => $request->title,
            'parent_id' => $request->parent_id,
            'description' => $request->description,
        ]);

        return redirect()->route('users.categories.costs.index')
            ->withSuccess('عملیات بروزرسانی دسته بندی با موفقیت انجام شد.');
    }


    public function delete($category_id)
    {
        $userId = Auth::user()->id;
        $category = CostCategory::find($category_id);
        $category->delete();

        $categories = CostCategory::where('user_id', $userId)->where('parent_id', $category_id)->get();
        foreach($categories as $category){
            $category->delete();
        }

        return redirect()->route('users.categories.costs.index')
            ->withSuccess('دسته بندی مورد نظر با موفقیت حذف شد.');
    }
}
