<?php

namespace App\Http\Controllers\Budget;

use App\Budget\Area;
use App\Budget\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BudgetController extends Controller
{
   public function index()
   {
       $areas = Area::where('active',1)->get();

       $services = Service::where('active',1)->get();

       return view('budget.index',compact('areas','services'));
   }

   public function store(Request $request)
   {

   }
}
