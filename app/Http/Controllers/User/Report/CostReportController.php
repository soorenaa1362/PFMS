<?php

namespace App\Http\Controllers\User\Report;

use Carbon\Carbon;
use App\Models\Cost;
use Illuminate\Http\Request;
use App\Models\CostCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ReportCosts\ReportCostRepository;

class CostReportController extends Controller
{
    public $reportCostRepository;

    public function __construct(ReportCostRepository $reportCostRepository)
    {
        $this->reportCostRepository = $reportCostRepository;
    }


    public function Costs()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            return view('users.reports.costs.select');
        }
    }


    public function timeSelect()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            return view('users.reports.costs.time.timeSelect');
        }
    }


    public function day()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->reportCostRepository->getUserId();
            $costs = $this->reportCostRepository->getCostsOfDay($userId);
            $costCategories = $this->reportCostRepository->getCostCategories($userId);
            $totalCost = $this->reportCostRepository->getTotalCost($costs);

            return view('users.reports.costs.time.day', compact([
                'costs',
                'costCategories',
                'totalCost'
            ]));
        }
    }


    public function week()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->reportCostRepository->getUserId();
            $costs = $this->reportCostRepository->getCostsOfWeek($userId);
            $costCategories = $this->reportCostRepository->getCostCategories($userId);
            $totalCost = $this->reportCostRepository->getTotalCost($costs);

            return view('users.reports.costs.time.week', compact([
                'costs',
                'costCategories',
                'totalCost'
            ]));
        }
    }


    public function month()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->reportCostRepository->getUserId();
            $costs = $this->reportCostRepository->getCostsOfMonth($userId);
            $costCategories = $this->reportCostRepository->getCostCategories($userId);
            $totalCost = $this->reportCostRepository->getTotalCost($costs);

            return view('users.reports.costs.time.month', compact([
                'costs',
                'costCategories',
                'totalCost'
            ]));
        }
    }


    public function categorySelect()
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $userId = $this->reportCostRepository->getUserId();
            $categories = $this->reportCostRepository->getCategories($userId);
            return view('users.reports.costs.category.select', compact('categories'));
        }
    }


    public function category(Request $request)
    {
        if(Auth::guest()){
            return redirect()->route('login');
        }else{
            $category = $this->reportCostRepository->getCategory($request);

            if( $request->category_id === null ){
                return redirect()->back();
            }else{
                $costs = $this->reportCostRepository->getCostsOfCategory($category);

                return view('users.reports.costs.category.index', compact('category', 'costs'));
            }
        }
    }

}
