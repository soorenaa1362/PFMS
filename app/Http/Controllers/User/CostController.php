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

        $cards = Card::where('user_id', $userId)->get();

        $categories = CostCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();

        if( count($categories) === 0 ){
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', null)->get();
        }else{
            $categories = CostCategory::where('user_id', $userId)->where('parent_id', '!=', null)->get();
        }

        return view('users.costs.create', compact('cards', 'categories'));
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
            return redirect()->route('users.costs.create')
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
}
