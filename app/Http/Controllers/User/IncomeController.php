<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Income;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use App\Models\IncomeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Incomes\IncomeRepository;

class IncomeController extends Controller
{
    public $incomeRepository;

    public function __construct(IncomeRepository $incomeRepository)
    {
        $this->incomeRepository = $incomeRepository;
    }


    public function index()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->incomeRepository->getUserId();
            $incomes = $this->incomeRepository->getincomes($userId);
            $incomeCategories = $this->incomeRepository->getCategories($userId);
            $totalIncome = $this->incomeRepository->getTotalIncome($incomes);

            return view('users.incomes.index', compact([
                'incomes',
                'totalIncome',
                'incomeCategories'
            ]));
        }
    }


    public function create()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->incomeRepository->getUserId();
            $cards = $this->incomeRepository->getCards($userId);
            $categories = $this->incomeRepository->getSubCategories($userId);
            $parents = $this->incomeRepository->getParents($userId);

            if($parents === false){
                return redirect()->route('users.incomes.index');
            }else{
                return view('users.incomes.create', compact('cards', 'categories'));
            }
        }
    }


    public function store(Request $request)
    {
        $userId = $this->incomeRepository->getUserId();
        $this->incomeRepository->storeIncome($request, $userId);

        return redirect()->route('users.incomes.index')
            ->withSuccess('عملیات ثبت درآمد با موفقیت انجام شد.');
    }


    public function show($income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->incomeRepository->getUserId();
            $income = $this->incomeRepository->getIncome($income_id);

            return view('users.incomes.show', compact('income'));
        }
    }


    public function edit($income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->incomeRepository->getUserId();
            $income = $this->incomeRepository->getIncome($income_id);
            $cards = $this->incomeRepository->getCards($userId);
            $categories = $this->incomeRepository->getSubCategories($userId);

            return view('users.incomes.edit', compact('income', 'cards', 'categories'));
        }
    }


    public function update(Request $request, $income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $this->incomeRepository->updateIncome($request, $income_id);

            return redirect()->route('users.incomes.index')
                ->withSuccess('عملیات بروزرسانی اطلاعات درآمد با موفقیت انجام شد.');
        }
    }


    public function delete($income_id)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $this->incomeRepository->deleteIncome($income_id);

            return redirect()->route('users.incomes.index')
                ->withSuccess('درآمد مورد نظر با موفقیت حذف شد.');
        }
    }



}
