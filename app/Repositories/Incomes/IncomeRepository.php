<?php

namespace App\Repositories\Incomes;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Income;
use App\Models\IncomeCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Incomes\IncomeRepositoryInterface;

class IncomeRepository implements IncomeRepositoryInterface
{
    public function getUserId()
    {
        $userId = Auth::user()->id;
        return $userId;
    }


    public function getIncomes($userId)
    {
        $incomes = Income::where('user_id', $userId)->paginate(3);
        return $incomes;
    }


    public function getCategories($userId)
    {
        $categories = IncomeCategory::where('user_id', $userId)->get();
        return $categories;
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
        $cards = Card::where('user_id', $userId)
            ->where('current_cash', '>', 0)->get();
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
                return false;
            }else{
                return $parents;
            }
    }


    public function storeIncome($request, $userId)
    {
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


    public function getIncome($income_id)
    {
        $income = Income::where('id', $income_id)->first();
        return $income;
    }


    public function updateIncome($request, $income_id)
    {
        $userId = $this->getUserId();
        $income = $this->getIncome($income_id);
        $oldIncomeAmount = $income->amount;
        $card = Card::where('id', $income->card_id)->first();

        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');

        if($request->date == null){
            $income->user_id = $userId;
            $income->card_id = $request->card_id;
            $income->category_id = $request->category_id;
            $income->title = $request->title;
            $income->amount = $request->amount;
            $income->description = $request->description;
        }else{
            $income->user_id = $userId;
            $income->card_id = $request->card_id;
            $income->category_id = $request->category_id;
            $income->title = $request->title;
            $income->amount = $request->amount;
            $income->date = $myDate;
            $income->description = $request->description;
        }

        $newCard = Card::find($income->card_id);

        if( $card == $newCard ){
            $income->update();
            $newCash = ($card->current_cash - $oldIncomeAmount) + $income->amount;
            $card->update([
                'current_cash' => $newCash
            ]);
        }else{
            $income->update();
            $oldCash = ($card->current_cash - $oldIncomeAmount);
            $card->update([
                'current_cash' => $oldCash
            ]);

            $newCash = $newCard->current_cash + $income->amount;
            $newCard->update([
                'current_cash' => $newCash
            ]);
        }
    }


    public function deleteIncome($income_id)
    {
        $income = $this->getIncome($income_id);
        $income->delete();

        $card = Card::where('id', $income->card_id)->first();
        $oldCurrentCash = $card->current_cash;
        $incomeAmount = $income->amount;
        $newCurrentCash = $oldCurrentCash - $incomeAmount;

        $card->update([
            'current_cash' => $newCurrentCash,
        ]);
    }
}
