<?php

namespace App\Http\Controllers\User\Report;

use Carbon\Carbon;
use App\Models\Income;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IncomeReportController extends Controller
{
    public function incomes()
    {
        return view('users.reports.incomes.select');
    }


    public function incomeTimeSelect()
    {
        return view('users.reports.incomes.time.timeSelect');
    }


    public function incomesDay()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $incomes = Income::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->subDays(1), Carbon::now()])
            ->orderBy('date', 'DESC')->paginate(5);

        $incomeCategories = IncomeCategory::where('user_id', $userId)->get();

        $totalIncome = 0;
        foreach($incomes as $income){
            $totalIncome += $income->amount;
        }

        return view('users.reports.incomes.time.day', compact([
            'incomes',
            'incomeCategories',
            'totalIncome'
        ]));
    }


    public function incomesWeek()
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


    public function incomesMonth()
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
}
