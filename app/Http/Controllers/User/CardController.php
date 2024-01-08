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
use App\Repositories\Cards\EloquentCardRepository;

class CardController extends Controller
{
    public function index()
    {
        $cardRepository = new EloquentCardRepository();

        $cards = $cardRepository->getCards();

        $totalCash = $cardRepository->getTotalCash();

        return view('users.cards.index', compact([
            'cards',
            'totalCash',
        ]));
    }


    public function create()
    {
        $cardRepository = new EloquentCardRepository();
        $userId = $cardRepository->getUserId();

        if($userId == null){
            return redirect()->route('login');
        }else{
            return view('users.cards.create');
        }
    }


    public function store(Request $request)
    {
        $cardRepository = new EloquentCardRepository();

        $card = $cardRepository->storeCard($request);

        return redirect()->route('users.cards.index')
            ->withSuccess('اطلاعات کارت با موفقیت در سیستم ثبت شد.');
    }


    public function show($card_id)
    {
        $cardRepository = new EloquentCardRepository();

        $card = $cardRepository->showCard($card_id);

        $incomes = $cardRepository->getCardIncomes($card_id);
        $incomeCount = $cardRepository->getCardIncomeCount($card_id);

        $costs = $cardRepository->getCardCosts($card_id);
        $costCount = $cardRepository->getCardCostCount($card_id);

        return view('users.cards.show', compact([
            'card',
            'incomes',
            'incomeCount',
            'costs',
            'costCount'
        ]));
    }


    public function edit($card_id)
    {
        $cardRepository = new EloquentCardRepository();
        $userId = $cardRepository->getUserId();

        if($userId == null){
            return redirect()->route('login');
        }else{
            $card = $cardRepository->editCard($card_id);

            return view('users.cards.edit', compact('card'));
        }
    }


    public function update(Request $request, $card_id)
    {
        $cardRepository = new EloquentCardRepository();
        $userId = $cardRepository->getUserId();

        $cardRepository->updateCard($request, $card_id);

        return redirect()->route('users.cards.index')
            ->withSuccess('اطلاعات کارت مورد نظر با موفقیت بروزرسانی شد.');
    }


    public function delete($card_id)
    {
        $card = Card::find($card_id);
        $card->delete();

        return redirect()->route('users.cards.index')
            ->withSuccess('عملیات حذف کارت بانکی با موفقیت انجام شد.');
    }


    public function checkTransactions($card_id)
    {
        $cardRepository = new EloquentCardRepository();

        $userId = $cardRepository->getUserId();

        $card = Card::find($card_id);

        $incomes = $cardRepository->getCardIncomes($card_id);
        $costs = $cardRepository->getCardCosts($card_id);

        return view('users.cards.transactions.index', compact('card', 'incomes', 'costs'));
    }


    public function transactionSelect($card_id)
    {
        $cardRepository = new EloquentCardRepository();

        $userId = $cardRepository->getUserId();

        $card = Card::find($card_id);

        return view('users.cards.transactions.select', compact('card'));
    }


    public function incomeCreate($card_id)
    {
        $cardRepository = new EloquentCardRepository();

        $userId = $cardRepository->getUserId();

        $card = Card::find($card_id);

        $categories = $cardRepository->getIncomeCategories($userId);

        return view('users.cards.incomes.create', compact('card', 'categories'));
    }


    public function incomeStore(Request $request, $card_id)
    {
        $cardRepository = new EloquentCardRepository();

        $userId = $cardRepository->getUserId();

        $card = Card::find($card_id);

        $income = $cardRepository->incomeStore($request, $card_id);

        return redirect()->route('users.cards.checkTransactions', $card->id)
            ->withSuccess('اطلاعات درآمد با موفقیت در سیستم ثبت شد.');
    }
}




