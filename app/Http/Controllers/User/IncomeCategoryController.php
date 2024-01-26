<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\IncomeCategories\IncomeCategoryRepository;

class IncomeCategoryController extends Controller
{
    public $incomeCategoryRepository;

    public function __construct(IncomeCategoryRepository $incomeCategoryRepository)
    {
        $this->incomeCategoryRepository = $incomeCategoryRepository;
    }

    public function index()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->incomeCategoryRepository->getUserId();
            $categories = $this->incomeCategoryRepository->getCategories($userId);

            return view('users.categories.incomes.index', compact('categories'));
        }
    }


    public function create()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->incomeCategoryRepository->getUserId();
            $categories = $this->incomeCategoryRepository->createForm($userId);

            return view('users.categories.incomes.create', compact('categories'));
        }
    }


    public function store(Request $request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->incomeCategoryRepository->getUserId();

            $this->incomeCategoryRepository->storeIncomeCategory($request);

            return redirect()->route('users.categories.incomes.index')
                ->withSuccess('دسته بندی با موفقیت در سیستم ثبت شد.');
        }
    }


    public function edit($category_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->incomeCategoryRepository->getUserId();
            $category = $this->incomeCategoryRepository->getCategory($category_id);
            $parents = $this->incomeCategoryRepository->getParents($userId);

            return view('users.categories.incomes.edit', compact([
                'category',
                'parents'
            ]));
        }
    }


    public function update(Request $request, $category_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $this->incomeCategoryRepository->updateIncomeCategory($request, $category_id);

            return redirect()->route('users.categories.incomes.index')
                ->withSuccess('عملیات بروزرسانی دسته بندی با موفقیت انجام شد.');
        }
    }


    public function delete($category_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $this->incomeCategoryRepository->deleteIncomeCategory($category_id);

            return redirect()->route('users.categories.incomes.index')
                ->withSuccess('دسته بندی مورد نظر با موفقیت حذف شد.');
        }
    }
}
