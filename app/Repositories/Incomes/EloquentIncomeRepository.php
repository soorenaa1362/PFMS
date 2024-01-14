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
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
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


    public function showIncome($income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $income = Income::where('id', $income_id)->first();

            return $income;
        }
    }


    public function getCard($incomeCardId)
    {
        $card = Card::where('id', $incomeCardId)->first();

        return $card;
    }


    public function updateIncome($request, $income_id)
    {
        $userId = $this->getUserId();

        $income = $this->showIncome($income_id);

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

}
