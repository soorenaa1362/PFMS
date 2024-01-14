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


    public function create()
    {
        $incomeRepository = new EloquentIncomeRepository();

        $userId = $incomeRepository->getUserId();

        $cards = $incomeRepository->getCards($userId);

        $categories = $incomeRepository->getCategories($userId);

        $parents = $incomeRepository->getParents($userId);

        if( count($parents) != 0 ){
            return view('users.incomes.create', compact([
                'cards',
                'categories'
            ]));
        }else{
            return redirect()->route('users.incomes.index');
        }
    }


    public function store(Request $request)
    {
        $incomeRepository = new EloquentIncomeRepository();

        $incomeRepository->getUserId();

        $income = $incomeRepository->storeIncome($request);

        return redirect()->route('users.incomes.index')
            ->withSuccess('عملیات ثبت درآمد با موفقیت انجام شد.');
    }


    public function show($income_id)
    {
        $incomeRepository = new EloquentIncomeRepository();

        $userId = $incomeRepository->getUserId();

        $income = $incomeRepository->showIncome($income_id);

        return view('users.incomes.show', compact('income'));
    }


    public function edit($income_id)
    {
        $incomeRepository = new EloquentIncomeRepository();

        $userId = $incomeRepository->getUserId();

        $income = $incomeRepository->showIncome($income_id);

        $cards = $incomeRepository->getCards($userId);

        $categories = $incomeRepository->getCategories($userId);

        return view('users.incomes.edit', compact('income', 'cards', 'categories'));
    }


    public function update(Request $request, $income_id)
    {
        $incomeRepository = new EloquentIncomeRepository();

        $incomeRepository->updateIncome($request, $income_id);

        return redirect()->route('users.incomes.index')
            ->withSuccess('عملیات بروزرسانی اطلاعات درآمد با موفقیت انجام شد.');
    }




}
