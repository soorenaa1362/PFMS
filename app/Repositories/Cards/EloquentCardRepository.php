<?php

namespace App\Repositories\Cards;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Cost;
use App\Models\Income;
use App\Models\CostCategory;
use Morilog\Jalali\Jalalian;
use App\Models\IncomeCategory;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Cards\CardRepositoryInterface;

class EloquentCardRepository implements CardRepositoryInterface
{
    public function getUserId()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            return Auth::user()->id;
        }
    }


    public function getCards()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->getUserId();
            return Card::where('user_id', $userId)->paginate(3);
        }
    }


    public function getTotalCash()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $cards = $this->getCards();

            $totalCash = 0;
            foreach($cards as $card){
                $totalCash += $card->current_cash;
            }

            return $totalCash;
        }
    }


    public function storeCard($request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->getUserId();

            $request->validate([
                'name' => 'required|string',
                'alias' => 'nullable|string',
                'number' => 'required|numeric|unique:cards',
                'current_cash' => 'required|numeric',
                'description' => 'nullable|string',
            ]);

            $card = Card::create([
                'user_id' => $userId,
                'name' => $request->name,
                'alias' => $request->alias,
                'number' => $request->number,
                'current_cash' => $request->current_cash,
                'description' => $request->description,
            ]);
        }
    }


    public function showCard($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->getUserId();
            $card = Card::find($card_id);

            $costs = Cost::where('user_id', $userId)->orderBy('id', 'DESC')
                ->where('card_id', $card_id)->paginate(3);
            $costCount = count(Cost::where('user_id', $userId)->where('card_id', $card_id)->get());

            return $card;
        }
    }


    public function getCardIncomes($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->getUserId();
            $card = Card::find($card_id);

            $incomes = Income::where('user_id', $userId)->orderBy('id', 'DESC')
                ->where('card_id', $card_id)->paginate(3);
            return $incomes;
        }
    }


    public function getCardIncomeCount($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->getUserId();
            $card = Card::find($card_id);

            return count(Income::where('user_id', $userId)->where('card_id', $card_id)->get());
        }
    }


    public function getCardCosts($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->getUserId();
            $card = Card::find($card_id);

            $costs = Cost::where('user_id', $userId)->orderBy('id', 'DESC')
                ->where('card_id', $card_id)->paginate(3);
            return $costs;
        }
    }


    public function getCardCostCount($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->getUserId();
            $card = Card::find($card_id);

            return count(Cost::where('user_id', $userId)->where('card_id', $card_id)->get());
        }
    }


    public function editCard($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $card = Card::find($card_id);

            return $card;
        }
    }


    public function updateCard($request, $card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $card = Card::find($card_id);

            $request->validate([
                'name' => 'required|string',
                'alias' => 'nullable|string',
                'number' => 'required|numeric|unique:cards,number,'.$card_id,
                'current_cash' => 'required|string',
                'description' => 'nullable|string',
            ]);

            $card->update([
                'name' => $request->name,
                'alias' => $request->alias,
                'number' => $request->number,
                'current_cash' => $request->current_cash,
                'description' => $request->description,
            ]);
        }
    }


    public function getIncomeCategories($userId)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

            if( count($categories) === 0 ){
                $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', null)->get();
            }else{
                $categories = IncomeCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
            }

            return $categories;
        }
    }


    public function incomeStore($request, $card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->getUserId();

            $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');
            $myDateJalali = Jalalian::fromDateTime($myDate)->format('Y/m/d');

            $income = Income::create([
                'user_id' => $userId,
                'card_id' => $card_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'amount' => $request->amount,
                'date' => $myDate,
            ]);

            $card = Card::where('id', $income->card_id)->first();
            $newCash = $card->current_cash + $income->amount;
            $card->update([
                'current_cash' => $newCash
            ]);
        }
    }


    public function getCostCategories($userId)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

            if( count($categories) === 0 ){
                $categories = CostCategory::where('user_id', $userId)->where('parent_id', null)->get();
            }else{
                $categories = CostCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
            }

            return $categories;
        }
    }


    public function costStore($request, $card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->getUserId();

            $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');

            $cost = Cost::create([
                'user_id' => $userId,
                'card_id' => $card_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'amount' => $request->amount,
                'date' => $myDate,
            ]);

            $card = Card::where('id', $cost->card_id)->first();
            $newCash = $card->current_cash - $cost->amount;
            $card->update([
                'current_cash' => $newCash
            ]);
        }
    }









}

