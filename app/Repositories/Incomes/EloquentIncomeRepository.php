<?php

namespace App\Repositories\Incomes;

use App\Models\Card;
use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Incomes\IncomeRepositoryInterface;

class EloquentIncomeRepository implements IncomeRepositoryInterface
{
    public function getUserId()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            return Auth::user()->id;
        }
    }


    public function getIncomes($userId)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $incomes = Income::where('user_id', $userId)->paginate(3);
            return $incomes;
        }
    }


    public function getIncomeCategories($userId)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $incomeCategories = IncomeCategory::where('user_id', $userId)->get();
            return $incomeCategories;
        }
    }


    public function getTotalIncome()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->getUserId();
            $incomes = $this->getIncomes($userId);

            $totalIncome = 0;
            foreach($incomes as $income){
                $totalIncome += $income->amount;
            }

            return $totalIncome;
        }
    }


    public function getCards($userId)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $cards = Card::where('user_id', $userId)->get();
            return $cards;
        }
    }


    public function getCategories($userId)
    {
        $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        if( count($categories) === 0 ){
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();
            return $categories;
        }else{
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
            return $categories;
        }
    }


    public function getParents($userId)
    {
        $parents = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();

        if( count($parents) === 0 ){
            return redirect()->route('users.incomes.index');
        }else{
            return $parents;
        }
    }
}

