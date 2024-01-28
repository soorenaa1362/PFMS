<?php

namespace App\Http\Controllers\User;

use App\Models\Card;
use App\Models\Cost;
use App\Models\Income;
use App\Models\CostCategory;
use Illuminate\Http\Request;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Deleted\DeletedRepository;

class DeletedController extends Controller
{
    public $deletedRepository;

    public function __construct(DeletedRepository $deletedRepository)
    {
        $this->deletedRepository = $deletedRepository;
    }


    public function select()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->deletedRepository->getUserId();
            $incomes = $this->deletedRepository->getIncomes($userId);
            $costs = $this->deletedRepository->getCosts($userId);

            return view('users.deleted.select', compact([
                'incomes',
                'costs'
            ]));
        }
    }


    public function incomes()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->deletedRepository->getUserId();
            $incomes = $this->deletedRepository->getIncomes($userId);
            $incomeCategories = $this->deletedRepository->getIncomeCategories($userId);

            return view('users.deleted.incomes', compact([
                'incomes',
                'incomeCategories',
            ]));
        }
    }


    public function restoreIncome($income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $income = $this->deletedRepository->restoreIncome($income_id);

            return redirect()->route('users.deleted.incomes')
                ->withSuccess('درآمد مورد نظر با موفقیت بازیابی شد.');
        }
    }


    public function forceDeleteIncome($income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $income = $this->deletedRepository->forceDeleteIncome($income_id);

            return redirect()->route('users.deleted.incomes')
                ->withSuccess('درآمد مورد نظر به طور کامل از سیستم حذف شد.');
        }
    }


    public function costs()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->deletedRepository->getUserId();
            $costs = $this->deletedRepository->getCosts($userId);
            $costCategories = $this->deletedRepository->getCostCategories($userId);

            return view('users.deleted.costs', compact([
                'costs',
                'costCategories',
            ]));
        }
    }



    public function restoreCost($cost_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $cost = $this->deletedRepository->restoreCost($cost_id);

            return redirect()->route('users.deleted.costs')
                ->withSuccess('خرجکرد مورد نظر با موفقیت بازیابی شد.');
        }
    }


    public function forceDeleteCost($cost_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $cost = $this->deletedRepository->forceDeleteCost($cost_id);

            return redirect()->route('users.deleted.costs')
                ->withSuccess('خرجکرد مورد نظر به طور کامل از سیستم حذف شد.');
        }
    }










}
