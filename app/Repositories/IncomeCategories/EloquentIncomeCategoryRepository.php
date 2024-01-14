<?php

namespace App\Repositories\IncomeCategories;


use Illuminate\Support\Facades\Auth;
use App\Repositories\IncomeCategories\IncomeCategoryRepositoryInterface;

class EloquentIncomeCategoryRepository implements IncomeCategoryRepositoryInterface
{
    public function getUserId()
    {
        if( Auth::guest() ){
            return redirect()->route('login');
        }else{
            $userId = Auth::user()->id;

            return $userId;
        }
    }
}
