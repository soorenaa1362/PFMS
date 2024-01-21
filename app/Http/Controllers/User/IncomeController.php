<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Income;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Incomes\EloquentIncomeRepository;

class IncomeController extends Controller
{
    public function index()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $incomeRepository = new EloquentIncomeRepository();
            $userId = $incomeRepository->getUserId();
            $incomes = $incomeRepository->getIncomes($userId);
            $incomeCategories = $incomeRepository->getIncomeCategories($userId);
            $totalIncome = $incomeRepository->getTotalIncome($incomes);

            return view('users.incomes.index', compact([
                'incomes',
                'totalIncome',
                'incomeCategories'
            ]));
        }
    }


    public function create()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $incomeRepository = new EloquentIncomeRepository();
            $userId = $incomeRepository->getUserId();
            $cards = $incomeRepository->getCards($userId);
            $categories = $incomeRepository->getSubCategories($userId);
            $parents = $incomeRepository->getParents($userId);

            if($parents === false){
                return redirect()->route('users.incomes.index');
            }else{
                return view('users.incomes.create', compact('cards', 'categories'));
            }
        }
    }


    public function store(Request $request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $incomeRepository = new EloquentIncomeRepository();
            $userId = $incomeRepository->getUserId();
            $incomeRepository->storeIncome($request, $userId);

            return redirect()->route('users.incomes.index')
                ->withSuccess('عملیات ثبت درآمد با موفقیت انجام شد.');
        }
    }


    public function show($income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $incomeRepository = new EloquentIncomeRepository();
            $income = $incomeRepository->getIncome($income_id);

            return view('users.incomes.show', compact('income'));
        }
    }


    public function edit($income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $incomeRepository = new EloquentIncomeRepository();
            $userId = $incomeRepository->getUserId();
            $income = $incomeRepository->getIncome($income_id);
            $cards = $incomeRepository->getCards($userId);
            $categories = $incomeRepository->getSubCategories($userId);

            return view('users.incomes.edit', compact('income', 'cards', 'categories'));
        }
    }


    public function update(Request $request, $income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $incomeRepository = new EloquentIncomeRepository();
            $incomeRepository->updateIncome($request, $income_id);

            return redirect()->route('users.incomes.index')
                ->withSuccess('عملیات بروزرسانی اطلاعات درآمد با موفقیت انجام شد.');
        }
    }


    public function delete($income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $incomeRepository = new EloquentIncomeRepository();
            $incomeRepository->deleteIncome($income_id);

            return redirect()->route('users.incomes.index')
                ->withSuccess('درآمد مورد نظر با موفقیت حذف شد.');
        }
    }
}
