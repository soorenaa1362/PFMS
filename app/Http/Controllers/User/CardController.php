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
use App\Repositories\CardRepository;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function index()
    {
        $cardRepository = new CardRepository();

        $cards = $cardRepository->getCards();

        $totalCash = $cardRepository->getTotalCash();

        return view('users.cards.index', compact([
            'cards',
            'totalCash',
        ]));
    }
}


