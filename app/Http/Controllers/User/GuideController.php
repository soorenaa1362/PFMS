<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuideController extends Controller
{
    public function guide()
    {
        return view('users.guide');
    }
}
