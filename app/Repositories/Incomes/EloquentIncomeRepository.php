<?php

namespace App\Repositories\Incomes;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Income;
use Morilog\Jalali\Jalalian;
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
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

            if( count($categories) === 0 ){
                $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();
                return $categories;
            }else{
                $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
                return $categories;
            }
        }
    }


    public function getParents($userId)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $parents = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();

            if( count($parents) === 0 ){
                return redirect()->route('users.incomes.index');
            }else{
                return $parents;
            }
        }
    }


    public function storeIncome($request)
    {
        $userId = $this->getUserId();
        
        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');
        $myDateJalali = Jalalian::fromDateTime($myDate)->format('Y/m/d');

        $request->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'card_id' => 'required',
            'category_id' => 'required',
            'date' => 'required',
            'description' => 'nullable|string',
        ]);

        $income = Income::create([
            'user_id' => $userId,
            'title' => $request->title,
            'amount' => $request->amount,
            'card_id' => $request->card_id,
            'category_id' => $request->category_id,
            'date' => $myDate,
            'description' => $request->description,
        ]);

        $card = Card::where('id', $income->card_id)->first();
        $newCash = $card->current_cash + $income->amount;
        $card->update([
            'current_cash' => $newCash
        ]);
    }
}

