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
            $userId = Auth::user()->id;
        }

        $incomes = Income::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->subDays(7), Carbon::now()])
            ->orderBy('date', 'ASC')->paginate(5);

        $incomeCategories = IncomeCategory::where('user_id', $userId)->get();

        $totalIncome = 0;
        foreach($incomes as $income){
            $totalIncome += $income->amount;
        }

        return view('users.reports.incomes.time.week', compact([
            'incomes',
            'incomeCategories',
            'totalIncome'
        ]));
    }


    public function month()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $incomes = Income::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->subDays(30), Carbon::now()])
            ->orderBy('date', 'ASC')->paginate(5);

        $incomeCategories = IncomeCategory::where('user_id', $userId)->get();

        $totalIncome = 0;
        foreach($incomes as $income){
            $totalIncome += $income->amount;
        }

        return view('users.reports.incomes.time.month', compact([
            'incomes',
            'incomeCategories',
            'totalIncome'
        ]));
    }


    public function categorySelect()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        if( count($categories) == 0 ){
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();
        }else{
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
        }

        return view('users.reports.incomes.category.select', compact('categories'));
    }


    public function category(Request $request)
    {
        $category = IncomeCategory::find($request->category_id);

        if( $request->category_id === null ){
            return redirect()->back();
        }else{
            $incomes = Income::where('category_id', $category->id)
                ->orderBy('date', 'ASC')->paginate(5);

            return view('users.reports.incomes.category.index', compact('category', 'incomes'));
        }
    }

}
