<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IncomeCategoryController extends Controller
{
    public function index()
    {
        if( Auth::guest() ){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $categories = IncomeCategory::where('user_id', $userId)->get();

        return view('users.categories.incomes.index', compact('categories'));
    }


    public function create()
    {
        $categories = IncomeCategory::where('parent_id', null)->get();

        return view('users.categories.incomes.index', compact('categories'));
    }


    public function store(Request $request)
    {
        $userId = Auth::user()->id;

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

        return redirect()->route('users.categories.incomes.index')
            ->withSuccess('دسته بندی با موفقیت در سیستم ثبت شد.');
    }
}
