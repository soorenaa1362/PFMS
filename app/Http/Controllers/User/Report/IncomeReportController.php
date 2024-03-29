<?php

namespace App\Http\Controllers\User\Report;

use Carbon\Carbon;
use App\Models\Income;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ReportIncomes\ReportIncomeRepository;

class IncomeReportController extends Controller
{
    public $reportIncomeRepository;

    public function __construct(ReportIncomeRepository $reportIncomeRepository)
    {
        $this->reportIncomeRepository = $reportIncomeRepository;
    }


    public function incomes()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            return view('users.reports.incomes.select');
        }
    }


    public function timeSelect()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            return view('users.reports.incomes.time.timeSelect');
        }
    }


    public function day()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->reportIncomeRepository->getUserId();
            $incomes = $this->reportIncomeRepository->getIncomesOfDay($userId);
            $incomeCategories = $this->reportIncomeRepository->getIncomeCategories($userId);
            $totalIncome = $this->reportIncomeRepository->getTotalIncome($incomes);

            return view('users.reports.incomes.time.day', compact([
                'incomes',
                'incomeCategories',
                'totalIncome'
            ]));
        }
    }


    public function week()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->reportIncomeRepository->getUserId();
            $incomes = $this->reportIncomeRepository->getIncomesOfWeek($userId);
            $incomeCategories = $this->reportIncomeRepository->getIncomeCategories($userId);
            $totalIncome = $this->reportIncomeRepository->getTotalIncome($incomes);

            return view('users.reports.incomes.time.week', compact([
                'incomes',
                'incomeCategories',
                'totalIncome'
            ]));
        }
    }


    public function month()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->reportIncomeRepository->getUserId();
            $incomes = $this->reportIncomeRepository->getIncomesOfMonth($userId);
            $incomeCategories = $this->reportIncomeRepository->getIncomeCategories($userId);
            $totalIncome = $this->reportIncomeRepository->getTotalIncome($incomes);

            return view('users.reports.incomes.time.month', compact([
                'incomes',
                'incomeCategories',
                'totalIncome'
            ]));
        }
    }


    public function categorySelect()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->reportIncomeRepository->getUserId();
            $categories = $this->reportIncomeRepository->getCategories($userId);
            return view('users.reports.incomes.category.select', compact('categories'));
        }
    }


    public function category(Request $request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $category = $this->reportIncomeRepository->getCategory($request);

            if( $request->category_id === null ){
                return redirect()->back();
            }else{
                $incomes = $this->reportIncomeRepository->getIncomesOfCategory($category);

                return view('users.reports.incomes.category.index', compact('category', 'incomes'));
            }
        }
    }

}
