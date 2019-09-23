<?php

namespace App\Http\Controllers\Orcamento;

use App\Orcamento\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrcamentoController extends Controller
{
   public function index()
   {
       $areas = Area::where('active',1)->get();

       return view('orcamentos.index',compact('areas'));
   }

   public function store(Request $request)
   {

   }
}
