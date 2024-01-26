<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function select()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            return view('users.categories.select');
        }
    }
}
