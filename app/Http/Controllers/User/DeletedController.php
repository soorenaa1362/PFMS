<?php

namespace App\Http\Controllers\User;

use App\Models\Income;
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

        return view('users.deleted.select', compact('incomes'));
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


    public function restore($income_id)
    {
        $income = Income::withTrashed()->find($income_id);
        $income->restore();

        return redirect()->route('users.deleted.incomes')
            ->withSuccess('درآمد مورد نظر با موفقیت بازیابی شد.');
    }


    public function forceDelete($income_id)
    {
        $income = Income::onlyTrashed()->find($income_id)->forceDelete();

        return redirect()->route('users.deleted.incomes')
            ->withSuccess('درآمد مورد نظر به طور کامل از دیتابیس حذف شد.');
    }
}
