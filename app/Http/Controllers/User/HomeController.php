<?php

namespace App\Http\Controllers\User;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        if( Auth::guest() ){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;
        }

        $cards = Card::where('user_id', $userId)->get();

        return view('users.home', compact('cards'));
    }
}
