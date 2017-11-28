<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;
use App\transaction;
use App\sales;
use App\report;
use Auth;

class deleteController extends Controller
{
    public function product($id){
  
        $product =  product::find($id);
                #Report
                $report = new report;
                $report->product = $product->code;
                $report->stock = $product->stock;
                $report->status = 'deleted';
                $report->notes = $product->name.' Deleted with stock of'.$product->stock;
                $report->user = Auth::user()->id;
                $report->save();

        product::destroy($id);
    	return redirect('product/view');
    }
    public function sale($id){
        $billno = transaction::find($id)->billNo;
         $products = sales::where('billNo',$billno)->get();
        foreach ($products as $product) {
                #qty change saving
                $change = product::where('code',$product->code)->first();
                $change->stock += $product->qty;
                $change->save();

                #Report
                $report = new report;
                $report->product = $change->code;
                $report->stock = $change->stock;
                $report->status = 'added_from_deleted_bill';
                $report->notes = $product->qty.' stock of '. $change->name.' added from deleted bill : '.$billno.' ';
                $report->user = Auth::user()->id;
                $report->save();
        }

                #Report
                $report = new report;
                $report->product = '000';
                $report->stock = '000';
                $report->status = 'bill deleted';
                $report->notes = $billno.' deleted by '.Auth::user()->name;
                $report->user = Auth::user()->id;
                $report->save();

    	transaction::destroy($id);
    	return redirect('sale/view');
    }
    public function row($id){
    	sales::destroy($id);
    	return redirect('sale');
    }

    public function clearkey(){
        session()->forget('key');
        return redirect('sale');
    }
}
