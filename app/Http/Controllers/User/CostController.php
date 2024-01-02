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

class CostController extends Controller
{
    public function index()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $costs = Cost::where('user_id', $userId)->paginate(3);
        $costCategories = CostCategory::where('user_id', $userId)->get();

        $totalCost = 0;
        foreach($costs as $cost){
            $totalCost += $cost->amount;
        }

        return view('users.costs.index', compact([
            'costs',
            'totalCost',
            'costCategories'
        ]));
    }


    public function create()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $cards = Card::where('user_id', $userId)->where('current_cash', '>', 0)->get();

        $categories = CostCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        if( count($categories) === 0 ){
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', null)->get();
        }else{
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
        }

        $parents = CostCategory::where('user_id', $userId)->where('parent_id', null)->get();
        if( count($parents) === 0 ){
            return redirect()->route('users.costs.index');
        }else{
            return view('users.costs.create', compact('cards', 'categories'));
        }
    }


    public function store(Request $request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

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

        $cost = new Cost;
        $cost->user_id = $userId;
        $cost->title = $request->title;
        $cost->amount = $request->amount;
        $cost->card_id = $request->card_id;
        $cost->category_id = $request->category_id;
        $cost->date = $myDate;
        $cost->description = $request->description;

        $card = Card::where('id', $cost->card_id)->first();

        if($request->amount > $card->current_cash){
            return redirect()->back()
                ->withSuccess('مبلغ خرجکرد نباید بیشتر از موجودی کارت باشد.');
        }else{
            $cost->save();
        }

        $newCash = $card->current_cash - $cost->amount;
        $card->update([
            'current_cash' => $newCash
        ]);

        return redirect()->route('users.costs.index')
            ->withSuccess('عملیات ثبت خرجکرد با موفقیت انجام شد.');
    }


    public function show($cost_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $cost = Cost::where('user_id', $userId)->where('id', $cost_id)->first();

        return view('users.costs.show', compact('cost'));
    }


    public function edit($cost_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $cost = cost::find($cost_id);
        $cards = Card::where('user_id', $userId)->get();
        // $cards = Card::where('user_id', $userId)->where('current_cash', '>', 0)->get();
        $categories = costCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        if( count($categories) == 0 ){
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', null)->get();
        }else{
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
        }

        return view('users.costs.edit', compact('cost', 'cards', 'categories'));
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
