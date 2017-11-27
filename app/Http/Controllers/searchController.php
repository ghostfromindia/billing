<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\transaction;
use App\sales;
class searchController extends Controller
{
    public function bill(){
    	return view('search');
    }

    public function findbill(Request $request){
    	$transaction = transaction::where('billNo',$request->code)->first();
    	$sales = sales::where('billNo',$request->code)->get();
    	$count = count($transaction);
    	return view('search',compact('transaction','count','sales'));
    }
}
