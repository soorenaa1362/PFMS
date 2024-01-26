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
use App\Repositories\Costs\CostRepository;

class CostController extends Controller
{
    public $costRepository;

    public function __construct(CostRepository $costRepository)
    {
        $this->costRepository = $costRepository;
    }


    public function index()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->costRepository->getUserId();
            $costs = $this->costRepository->getCosts($userId);
            $costCategories = $this->costRepository->getCategories($userId);
            $totalCost = $this->costRepository->getTotalCost($costs);

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
            $userId = $this->costRepository->getUserId();
            $cards = $this->costRepository->getCards($userId);
            $categories = $this->costRepository->getSubCategories($userId);
            $parents = $this->costRepository->getParents($userId);

            if($parents === false){
                return redirect()->route('users.costs.index');
            }else{
                return view('users.costs.create', compact('cards', 'categories'));
            }
        }
    }


    public function store(Request $request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->costRepository->getUserId();
            $cost = $this->costRepository->storeCost($request, $userId);

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
            $userId = $this->costRepository->getUserId();
            $cost = $this->costRepository->getCost($cost_id);

            return view('users.costs.show', compact('cost'));
        }
    }


    public function edit($cost_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->costRepository->getUserId();
            $cost = $this->costRepository->getCost($cost_id);
            $cards = $this->costRepository->getCards($userId);
            $categories = $this->costRepository->getSubCategories($userId);

            return view('users.costs.edit', compact('cost', 'cards', 'categories'));
        }
    }


    public function update(Request $request, $cost_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $this->costRepository->updateCost($request, $cost_id);

            return redirect()->route('users.costs.index')
                ->withSuccess('عملیات بروزرسانی اطلاعات خرجکرد با موفقیت انجام شد.');
        }
    }


    public function delete($cost_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $this->costRepository->deleteCost($cost_id);

            return redirect()->route('users.costs.index')
                ->withSuccess('خرجکرد مورد نظر با موفقیت حذف شد.');
        }
    }



}
