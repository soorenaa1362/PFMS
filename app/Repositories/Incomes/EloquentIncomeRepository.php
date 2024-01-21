<?php

namespace App\Repositories\Incomes;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Incomes\IncomeRepositoryInterface;

class EloquentIncomeRepository implements IncomeRepositoryInterface
{
    public function getUserId()
    {
        $userId = Auth::user()->id;
        return $userId;
    }


    public function getIncomes($userId)
    {
        $incomes = Income::where('user_id', $userId)->paginate(5);
        return $incomes;
    }


    public function getIncomeCategories($userId)
    {
        $incomeCategories = IncomeCategory::where('user_id', $userId)->get();
        return $incomeCategories;
    }


    public function getTotalIncome($incomes)
    {
        $totalIncome = 0;
        foreach($incomes as $income){
            $totalIncome += $income->amount;
        }

        return $totalIncome;
    }


    public function getCards($userId)
    {
        $cards = Card::where('user_id', $userId)->get();
        return $cards;
    }


    public function getSubCategories($userId)
    {
        $subCategories = IncomeCategory::where('user_id', $userId)
            ->where('parent_id', '!=', null)->get();

        if( count($subCategories) === 0 ){
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();
        }else{
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
        }

        return $categories;
    }


    public function getParents($userId)
    {
        $parents = IncomeCategory::where('user_id', $userId)
            ->where('parent_id', null)->get();

        if( count($parents) === 0 ){
            return redirect()->route('users.incomes.index');
        }else{
            return $parents;
        }
    }


    public function storeIncome($request)
    {
        $userId = $this->getUserId();

        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');

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
