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

            if($cost == true){
                return redirect()->route('users.costs.index')
                ->withSuccess('عملیات ثبت خرجکرد با موفقیت انجام شد.');
            }else{
                return redirect()->route('users.costs.create')
                    ->withSuccess('مبلغ خرجکرد نباید از موجودی کارت بیشتر باشد.');
            }
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
            $costRepository = new EloquentCostRepository();
            $costRepository->updateCost($request, $cost_id);

            return redirect()->route('users.costs.index')
                ->withSuccess('عملیات بروزرسانی اطلاعات خرجکرد با موفقیت انجام شد.');
        }
    }


    public function delete($cost_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $costRepository = new EloquentCostRepository();
            $costRepository->deleteCost($cost_id);

            return redirect()->route('users.costs.index')
                ->withSuccess('خرجکرد مورد نظر با موفقیت حذف شد.');
        }
    }



}
