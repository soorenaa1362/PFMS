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
// use App\Repositories\CardRepository;
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
}


