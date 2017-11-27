<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sales;
use App\product;
use App\transaction;


class pdfController extends Controller
{
    public function home(Request $request){
    $transaction = transaction::where('billNo',$request->billno)->first();
    $sales = sales::where('billNo',$request->billno)->get();
    return view('print',compact('transaction','sales'));
    }
  
}
