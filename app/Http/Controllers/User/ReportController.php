<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cost;
use App\Models\Income;
use App\Models\CostCategory;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function select()
    {
        return view('users.reports.select');
    }


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














    public function  costs()
    {
        return view('users.reports.costs.select');
    }


    public function costsDay()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $costs = Cost::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->subDays(1), Carbon::now()])
            ->orderBy('date', 'DESC')->paginate(5);

        $costCategories = CostCategory::where('user_id', $userId)->get();

        $totalCost = 0;
        foreach($costs as $cost){
            $totalCost += $cost->amount;
        }

        return view('users.reports.costs.day', compact([
            'costs',
            'costCategories',
            'totalCost'
        ]));
    }


    public function costsWeek()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $costs = Cost::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->subDays(7), Carbon::now()])
            ->orderBy('date', 'ASC')->paginate(5);

        $costCategories = CostCategory::where('user_id', $userId)->get();

        $totalCost = 0;
        foreach($costs as $cost){
            $totalCost += $cost->amount;
        }

        return view('users.reports.costs.week', compact([
            'costs',
            'costCategories',
            'totalCost'
        ]));
    }


    public function costsMonth()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $costs = Cost::where('user_id', $userId)
            ->whereBetween('date', [Carbon::now()->subDays(30), Carbon::now()])
            ->orderBy('date', 'ASC')->paginate(5);

        $costCategories = CostCategory::where('user_id', $userId)->get();

        $totalCost = 0;
        foreach($costs as $cost){
            $totalCost += $cost->amount;
        }

        return view('users.reports.costs.month', compact([
            'costs',
            'costCategories',
            'totalCost'
        ]));
    }

















}
