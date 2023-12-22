<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function select()
    {
        return view('users.reports.select');
    }


    public function incomes()
    {
        return view('users.reports.incomes.select');
    }
}
