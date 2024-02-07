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
        $incomeDate = Jalalian::fromDateTime($income->date)->format('Y/m/d'); // تاریخ فعلی درآمد
        $oldCard = Card::where('id', $income->card_id)->first(); // درآمد برای این کارت ثبت شده است
        $oldCardDate = Jalalian::fromDateTime($oldCard->date)->format('Y/m/d'); // تاریخ ثبت کارت
        $newCard = Card::where('id', $request->card_id)->first(); // این کارت برای درآمد ثبت شد

        if( ($oldCard->id === $newCard->id) && ($request->date === null) ){

            $incomeAmountBeforeUpdated = $income->amount;

            $income->title = $request->title;
            $income->amount = $request->amount;
            $income->card_id = $request->card_id;
            $income->category_id = $request->category_id;
            $income->description = $request->description;
            $income->update();

            $newCardCash = ($oldCard->current_cash - $incomeAmountBeforeUpdated) + $request->amount;
            $oldCard->update([
                'current_cash' => $newCardCash
            ]);

            return true;

        }elseif( ($oldCard->id === $newCard->id) && ($request->date != null) ){

            $incomeDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');
            $incomeDateJalali = Jalalian::fromDateTime($incomeDate)->format('Y/m/d');
            $oldCardDate = Jalalian::fromDateTime($oldCard->date)->format('Y/m/d');
            $incomeAmountBeforeUpdated = $income->amount;

            $income->title = $request->title;
            $income->amount = $request->amount;
            $income->card_id = $request->card_id;
            $income->category_id = $request->category_id;
            $income->date = $incomeDate;
            $income->description = $request->description;

            if( $incomeDateJalali >= $oldCardDate ){
                $income->update();

                $newCardCash = ($oldCard->current_cash - $incomeAmountBeforeUpdated) + $request->amount;
                $oldCard->update([
                    'current_cash' => $newCardCash
                ]);

                return true;
            }else{
                return false;
            }

        }elseif( ($oldCard->id != $newCard->id) && ($request->date != null) ){
            $incomeDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');
            $incomeDateJalali = Jalalian::fromDateTime($incomeDate)->format('Y/m/d');
            $newCardDate = Jalalian::fromDateTime($newCard->date)->format('Y/m/d');

            $income->title = $request->title;
            $income->amount = $request->amount;
            $income->card_id = $request->card_id;
            $income->category_id = $request->category_id;
            $income->date = $incomeDate;
            $income->description = $request->description;

            if( $incomeDateJalali >= $newCardDate ){
                $income->update();
                dd("تاریخ بدرستی وارد شده است و کارت تغییر کرد.");
            }else{
                dd("تاریخ درآمد نباید قبل از تاریخ ثبت کارت باشد. ");
            }
        }
    }


    // public function getUpdateIncome($income, $card)
    // {
    //     $newCard = Card::find($income->card_id);

    //     if( $card == $newCard ){
    //         $income->update();
    //         $newCash = ($card->current_cash - $oldIncomeAmount) + $income->amount;
    //         $card->update([
    //             'current_cash' => $newCash
    //         ]);
    //     }else{
    //         $income->update();
    //         $oldCash = ($card->current_cash - $oldIncomeAmount);
    //         $card->update([
    //             'current_cash' => $oldCash
    //         ]);

    //         $newCash = $newCard->current_cash + $income->amount;
    //         $newCard->update([
    //             'current_cash' => $newCash
    //         ]);
    //     }
    // }


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
