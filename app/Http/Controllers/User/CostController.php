<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Cost;
use App\Models\CostCategory;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Costs\EloquentCostRepository;

class CostController extends Controller
{
    public function index()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $costRepository = new EloquentCostRepository();
            $userId = $costRepository->getUserId();
            $costs = $costRepository->getCosts($userId);
            $costCategories = $costRepository->getCategories($userId);
            $totalCost = $costRepository->getTotalCost($costs);

            return view('users.costs.index', compact([
                'costs',
                'totalCost',
                'costCategories'
            ]));
        }
    }


    public function create()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $costRepository = new EloquentCostRepository();
            $userId = $costRepository->getUserId();
            $cards = $costRepository->getCards($userId);
            $categories = $costRepository->getSubCategories($userId);
            $parents = $costRepository->getParents($userId);

            return view('users.costs.create', compact('cards', 'categories'));
        }
    }


    public function store(Request $request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $costRepository = new EloquentCostRepository();
            $userId = $costRepository->getUserId();
            $cost = $costRepository->storeCost($request, $userId);

            return redirect()->route('users.costs.index')
                ->withSuccess('عملیات ثبت خرجکرد با موفقیت انجام شد.');
        }
    }


    public function show($cost_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $costRepository = new EloquentCostRepository();
            $userId = $costRepository->getUserId();
            $cost = $costRepository->getCost($cost_id);

            return view('users.costs.show', compact('cost'));
        }
    }


    public function edit($cost_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $costRepository = new EloquentCostRepository();
            $userId = $costRepository->getUserId();
            $cost = $costRepository->getCost($cost_id);
            $cards = $costRepository->getCards($userId);
            $categories = $costRepository->getSubCategories($userId);

            return view('users.costs.edit', compact('cost', 'cards', 'categories'));
        }
    }


    public function update(Request $request, $cost_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $cost = Cost::find($cost_id);
        $oldCostAmount = $cost->amount;
        $card = Card::where('id', $cost->card_id)->first();

        $myDate = Carbon::createFromTimestamp($request->date)->format('Y/m/d');

        if( $request->date == null ){
            $cost->user_id = $userId;
            $cost->card_id = $request->card_id;
            $cost->category_id = $request->category_id;
            $cost->title = $request->title;
            $cost->amount = $request->amount;
            $cost->description = $request->description;
        }else{
            $cost->user_id = $userId;
            $cost->card_id = $request->card_id;
            $cost->category_id = $request->category_id;
            $cost->title = $request->title;
            $cost->amount = $request->amount;
            $cost->date = $myDate;
            $cost->description = $request->description;
        }

        $newCard = Card::find($cost->card_id);
        // dd($newCard);

        if( $card == $newCard ){
            $cost->update();
            $newCash = ($card->current_cash + $oldCostAmount) - $cost->amount;
            $card->update([
                'current_cash' => $newCash
            ]);
        }else{
            $cost->update();
            $oldCash = ($card->current_cash + $oldCostAmount);
            $card->update([
                'current_cash' => $oldCash
            ]);

            $newCash = $newCard->current_cash - $cost->amount;
            $newCard->update([
                'current_cash' => $newCash
            ]);
        }

        return redirect()->route('users.costs.index')
            ->withSuccess('عملیات بروزرسانی اطلاعات خرجکرد با موفقیت انجام شد.');
    }



}
