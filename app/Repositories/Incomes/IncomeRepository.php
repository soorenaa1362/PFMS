<?php

namespace App\Repositories\Incomes;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Income;
use Morilog\Jalali\Jalalian;
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

        $income = new Income();
        $income->user_id = $userId;
        $income->title = $request->title;
        $income->amount = $request->amount;
        $income->card_id = $request->card_id;
        $income->category_id = $request->category_id;
        $income->date = $myDate;
        $income->description = $request->description;

        $card = Card::where('id', $income->card_id)->first();
        $cardDateJalali = Jalalian::fromDateTime($card->date)->format('Y/m/d');
        $incomeDateJalali = Jalalian::fromDateTime($income->date)->format('Y/m/d');

        if( $incomeDateJalali >= $cardDateJalali ){
            $income->save();
            $newCash = $card->current_cash + $income->amount;
            $card->update([
                'current_cash' => $newCash
            ]);
            return true;
        }else{
            return false;
        }
    }


    public function getIncome($income_id)
    {
        $income = Income::where('id', $income_id)->first();
        return $income;
    }


    public function updateIncome($request, $income_id)
    {
        $income = $this->getIncome($income_id);
        $oldIncomeAmount = $income->amount;
        $card = Card::where('id', $income->card_id)->first();

        if($request->date === null){

            $income->title = $request->title;
            $income->amount = $request->amount;
            $income->card_id = $request->card_id;
            $income->category_id = $request->category_id;
            $income->description = $request->description;

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
            return true;

        }else{

            $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');
            $incomeDateJalali = Jalalian::fromDateTime($myDate)->format('Y/m/d');
            $cardIncome = Card::where('id', $request->card_id)->first();
            $cardIncomeDateJalali = Jalalian::fromDateTime($cardIncome->date)->format('Y/m/d');

            if( $incomeDateJalali >= $cardIncomeDateJalali ){
                $income->title = $request->title;
                $income->amount = $request->amount;
                $income->card_id = $request->card_id;
                $income->category_id = $request->category_id;
                $income->date = $myDate;
                $income->description = $request->description;

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
                return true;

            }else{
                return false;
            }

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
