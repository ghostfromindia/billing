<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sales;
use App\product;
use App\transaction;
use App\exchange;
use carbon\Carbon;
use Session;
use App\report;

class exchangeController extends Controller
{
    public function home(Request $request){
    	$check = exchange::where('billNo',$request->billno)->where('status','completed')->first();
    	if(count($check)==1){$show = 0;return view('sale',compact('show'));}

    	if((session('exchangekey')== null)){
        $key = Carbon::now()->format('Ymdhis');	
        $key = $key.''.rand(111,999);
        Session::put('exchangekey', $key);
        }
        $key = session('exchangekey');

        $check = exchange::where('billNo',$request->billno)->where('status','processing')->first();
    	if(count($check)!=1){
    	$transaction = transaction::where('billNo',$request->billno)->first();
        $sales = sales::where('billNo',$request->billno)->get();
        $show = count($sales);
        foreach ($sales as $sale) {
        	$ex = new exchange;
        	$ex->code = $sale->code;
        	$ex->saleId = $sale->id;
        	$ex->billNo = $sale->billNo;
        	$ex->qty = $sale->qty;
        	$ex->amount = $sale->total;
        	$ex->session = $key;
        	$ex->status = 'processing';
        	$ex->save();
        }
        }

        $exchanges = exchange::where('billNo',$request->billno)->get();
        $show = count($exchanges);
        $sales = sales::where('billNo',$request->billno)->get();
        $show = count($sales);
        $newbill = sales::where('exchange',$request->billno)->get();
        $bill = $request->billno;
    	return view('exchange',compact('sales','transaction','show','exchanges','bill','newbill'));
    }
    public function add(Request $request){

        $key = session('exchangekey');
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
            $sale->exchange = $request->bill;

            $totalwdiscont = ($price*$sale->qty)-((($price*$sale->qty)*$sale->discount)/100);
            $totalwgst = $totalwdiscont+(($totalwdiscont*$sale->gst)/100);
            $sale->total = round($totalwgst);
            $sale->save();
        }
    return redirect('exchange/'.$request->bill);
    }

    public function remove(Request $request){
    $product = exchange::find($request->exid);
    if($product->qty == 0){

    $price = 0;
        $product->qty =0;
    } else{

    $price = $product->amount / $product->qty;
        $product->qty -= 1;
    }
    $product->amount -= $price;
    $bill = $product->billNo;
    $product->save();
    return redirect('exchange/'.$bill);
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
            $transaction->status = 'exchange-completed';
            $transaction->exchangevalue = $request->ev;
            $transaction->save();



            $sales = sales::where('session',session('exchangekey'))->get();
            foreach ($sales as $sale) {
                $product = sales::find($sale->id);
                $product->status = 'completed';
                $product->billNo = $billno;
                $product->save();
            }

            $exchanges = exchange::where('session',session('exchangekey'))->get();
            foreach ($exchanges as $exchange) {
                 $product = sales::find($exchange->saleId);
                 $stock = product::where('code',$sale->code)->first();
                if($exchange->qty != $product->qty){
                    if($exchange->qty == 0){
                    $qty =  $product->qty;
                    $stock->stock += $qty;
                    $stock->save();
                    $product->qty = 0;
                    $product->total = 0;
                    $product->gst = 0;
                    $product->total = 0;
                    $product->status = 'exchanged';
                    $product->save();
                    }else{
                    $qty =  $product->qty-$exchange->qty;
                    $stock->stock += $qty;
                    $stock->save();
                    $product->qty = $exchange->qty;
                    $product->total = $exchange->amount;
                    $product->status = 'exchanged';
                    $product->save();

                    }    

            #Report
            $report = new report;
            $report->product = $stock->code;
            $report->stock = $stock->stock;
            $report->status = 'exchanged';
            $report->notes = $qty.' added to inventory (exchanged product)';
            $report->user = '1050';
            $report->save();

                }
                
                $product->billNo = $billno;
            }

            $exchanges = exchange::where('session',session('exchangekey'))->get();
            foreach ($exchanges as $exchange) {
                    exchange::destroy($exchange->id);
            }



            $request->session()->forget('exchangekey');
            session()->flash('print', $billno); 
            return redirect('sale');
        }


}
