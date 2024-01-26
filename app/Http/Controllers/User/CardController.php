<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Cost;
use App\Models\Income;
use Illuminate\Support\Str;
use App\Models\CostCategory;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Cards\CardRepository;

class CardController extends Controller
{
    public $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function index()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $cards = $this->cardRepository->getCards();
            $totalCash = $this->cardRepository->getTotalCash();

            return view('users.cards.index', compact([
                'cards',
                'totalCash',
            ]));
        }
    }


    public function create()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->cardRepository->getUserId();

            return view('users.cards.create');
        }
    }


    public function store(Request $request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $card = $this->cardRepository->storeCard($request);

            return redirect()->route('users.cards.index')
                ->withSuccess('اطلاعات کارت با موفقیت در سیستم ثبت شد.');
        }
    }


    public function show($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->cardRepository->getUserId();
            $card = $this->cardRepository->getCard($card_id);
            $incomes = $this->cardRepository->getIncomes($card_id);
            $costs = $this->cardRepository->getCosts($card_id);

            return view('users.cards.show', compact([
                'card',
                'incomes',
                'costs',
            ]));
        }
    }


    public function edit($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->cardRepository->getUserId();
            $card = $this->cardRepository->editCard($card_id);

            return view('users.cards.edit', compact('card'));
        }
    }


    public function update(Request $request, $card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->cardRepository->getUserId();
            $this->cardRepository->updateCard($request, $card_id);

            return redirect()->route('users.cards.index')
                ->withSuccess('اطلاعات کارت مورد نظر با موفقیت بروزرسانی شد.');
        }
    }


    public function delete($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $card = Card::find($card_id);
            $card->delete();

            return redirect()->route('users.cards.index')
                ->withSuccess('عملیات حذف کارت بانکی با موفقیت انجام شد.');
        }
    }


    public function checkTransactions($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->cardRepository->getUserId();
            $card = Card::find($card_id);
            $incomes = $this->cardRepository->getCardIncomes($card_id);
            $costs = $this->cardRepository->getCardCosts($card_id);

            return view('users.cards.transactions.index', compact([
                'card',
                'incomes',
                'costs'
            ]));
        }
    }


    public function transactionSelect($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->cardRepository->getUserId();
            $card = Card::find($card_id);

            return view('users.cards.transactions.select', compact('card'));
        }
    }


    public function incomeCreate($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->cardRepository->getUserId();
            $card = Card::find($card_id);
            $categories = $this->cardRepository->getIncomeCategories($userId);

            return view('users.cards.incomes.create', compact([
                'card',
                'categories'
            ]));
        }
    }


    public function incomeStore(Request $request, $card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->cardRepository->getUserId();
            $card = Card::find($card_id);
            $income = $this->cardRepository->incomeStore($request, $card_id);

            return redirect()->route('users.cards.checkTransactions', $card->id)
                ->withSuccess('اطلاعات درآمد با موفقیت در سیستم ثبت شد.');
        }
    }


    public function costCreate($card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->cardRepository->getUserId();
            $card = Card::find($card_id);
            $categories = $this->cardRepository->getCostCategories($userId);

            return view('users.cards.costs.create', compact([
                'card',
                'categories'
            ]));
        }
    }


    public function costStore(Request $request, $card_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $card = $this->cardRepository->getCard($card_id);
            $cost = $this->cardRepository->costStore($request, $card_id);

            if($cost == true){
                return redirect()->route('users.cards.checkTransactions', $card->id)
                    ->withSuccess('اطلاعات خرجکرد با موفقیت در سیستم ثبت شد.');
            }else{
                return redirect()->back()
                    ->withSuccess('مبلغ خرجکرد نباید بیشتر از موجودی کارت باشد.');
            }
        }
    }



}




