<?php

namespace App\Http\Controllers\User;

use App\Models\Card;
use App\Models\Cost;
use App\Models\Income;
use App\Models\CostCategory;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeletedController extends Controller
{
    public function select()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $incomes = Income::where('user_id', $userId)->onlyTrashed()->get();
        $costs = Cost::where('user_id', $userId)->onlyTrashed()->get();

        return view('users.deleted.select', compact([
            'incomes',
            'costs'
        ]));
    }


    public function incomes()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $incomes = Income::where('user_id', $userId)->onlyTrashed()->paginate(3);
        $incomeCategories = IncomeCategory::where('user_id', $userId)->get();

        return view('users.deleted.incomes', compact([
            'incomes',
            'incomeCategories',
        ]));
    }


    public function restoreIncome($income_id)
    {
        $income = Income::withTrashed()->find($income_id);
        $income->restore();

        $card = Card::where('id', $income->card_id)->first();
        $cardNewCash = $card->current_cash + $income->amount;
        $card->update([
            'current_cash' => $cardNewCash
        ]);

        return redirect()->route('users.deleted.incomes')
            ->withSuccess('درآمد مورد نظر با موفقیت بازیابی شد.');
    }


    public function forceDeleteIncome($income_id)
    {
        $income = Income::onlyTrashed()->find($income_id)->forceDelete();

        return redirect()->route('users.deleted.incomes')
            ->withSuccess('درآمد مورد نظر به طور کامل از سیستم حذف شد.');
    }


    public function costs()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $costs = Cost::where('user_id', $userId)->onlyTrashed()->paginate(3);
        $costCategories = CostCategory::where('user_id', $userId)->get();

        return view('users.deleted.costs', compact([
            'costs',
            'costCategories',
        ]));
    }



    public function restoreCost($cost_id)
    {
        $cost = Cost::withTrashed()->find($cost_id);
        $cost->restore();

        $card = Card::where('id', $cost->card_id)->first();

        $cardNewCash = $card->current_cash - $cost->amount;
        $card->update([
            'current_cash' => $cardNewCash
        ]);

        return redirect()->route('users.deleted.costs')
            ->withSuccess('خرجکرد مورد نظر با موفقیت بازیابی شد.');
    }


    public function forceDeleteCost($cost_id)
    {
        $cost = Cost::onlyTrashed()->find($cost_id)->forceDelete();

        return redirect()->route('users.deleted.costs')
            ->withSuccess('خرجکرد مورد نظر به طور کامل از سیستم حذف شد.');
    }










}
