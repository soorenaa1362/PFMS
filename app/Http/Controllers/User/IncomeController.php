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

        $categories = $incomeRepository->getIncomeCategories($userId);

        return view('users.incomes.create', compact([
            'cards',
            'categories',
        ]));
    }
}
