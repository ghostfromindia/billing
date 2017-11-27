<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sales;
use App\product;
use App\transaction;
use carbon\Carbon;
use Session;
class saleController extends Controller
{
    public function home(){
    	if((session('key')== null)){
    	$sales = 0;$show=0;
    	}else{
    	$key = session('key');	
        $sales = sales::where('session',$key)->get();$show=1;
    	}
    	return view('sale',compact('sales','show'));
    }


    public function add(Request $request){

        if((session('key')== null)){
        $key = Carbon::now()->format('Ymdhis');	
        $key = $key.''.rand(111,999);
        Session::put('key', $key);
        }
        $key = session('key');
    	$one = product::where('code',$request->code)->first();
    	if(count($one) == 0){
    		session()->flash('addmessage', 'Product not found. please try again'); 
    		return  redirect('sale');
    	}
    	$sale = sales::where('session',$key)->where('code',$request->code)->first();
    	$price = product::where('code',$request->code)->first()->price;
    	if(count($sale)==1){
    		$sale->qty = $request->qty+$sale->qty;
    		$sale->discount = $request->discount;
    		$sale->gst = $request->gst;

    		$totalwdiscont = ($price*$sale->qty)-((($price*$sale->qty)*$sale->discount)/100);
    		$totalwgst = $totalwdiscont+(($totalwdiscont*$sale->gst)/100);
    		$sale->total = round($totalwgst);
    		$sale->save();
    	}else{
    		$sale = new sales;
    		$sale->code = $request->code;
    		$sale->qty = $request->qty;
    		$sale->discount = $request->discount;
    		$sale->gst = $request->gst;
    		$sale->session = $key;
    		$sale->price = $price;

    		$totalwdiscont = ($price*$sale->qty)-((($price*$sale->qty)*$sale->discount)/100);
    		$totalwgst = $totalwdiscont+(($totalwdiscont*$sale->gst)/100);
    		$sale->total = round($totalwgst);
    		$sale->save();
    	}
    return redirect('sale');
    }

        public function complete(Request $request){
        	if(($request->cash+$request->card)<$request->total){
        		session()->flash('message', 'Amount mismatch fount. please verify payment mode'); 
        	    return redirect('sale');
        	}

        	$bills = transaction::orderBy('id', 'desc')->first();
        	if(count($bills)==0){$billno = 1;}else{$billno = $bills->id+1;}
        	$transaction = new transaction;
        	$transaction->billNo = $billno;
        	$transaction->cash = $request->cash;
        	$transaction->card = $request->card;
        	$transaction->gst = $request->gst;
        	$transaction->discount = $request->discount;
        	$transaction->balance = $request->balance;
        	$transaction->total = $request->total;
        	$transaction->customernote = $request->customernote;
        	$transaction->status = 'completed';
        	$transaction->save();

        	$sales = sales::where('session',session('key'))->get();
        	foreach ($sales as $sale) {
        		$product = sales::find($sale->id);
        		$product->status = 'completed';
        		$product->billNo = $billno;
        		$product->save();
        	}
        	$request->session()->forget('key');
            session()->flash('print', $billno); 
        	return redirect('sale');
        }



}
