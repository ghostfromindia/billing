<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;
use App\report;
use Session;

class productController extends Controller
{
    public function addui(){
    	return view('add');
    }

    public function stockui(){
    	return view('edit');
    }

    public function add(Request $request){
    	if($request->type=='new'){
    		$product =  new product;
	    	$product->code = $request->code;
	    	$product->name = $request->name;
	    	$product->price = $request->price;
	    	$product->gst = $request->gst;
	    	$product->discount = $request->discount;
	    	$product->stock = $request->stock;
	    	$product->save();

	    	#Report
	    	$report = new report;
	    	$report->product = $request->code;
	    	$report->stock = $product->stock;
	    	$report->status = 'new_product';
	    	$report->notes = $request->name.' added to inventory';
	    	$report->user = '1050';
	    	$report->save();


	    	session()->flash('alert', 'alert-success'); 
	    	session()->flash('message', 'New product added successfully!');
	    	return redirect('product/add');
		}else{
			$product = product::where('code',$request->code)->first();
	    	$product->name = $request->name;
	    	$product->price = $request->price;
	    	$product->gst = $request->gst;
	    	$product->discount = $request->discount;
	    	$product->save();

	    	#Report
	    	$report = new report;
	    	$report->product = $request->code;
	    	$report->stock = $product->stock;
	    	$report->status = 'edit_product';
	    	$report->notes = $request->name.' edited.';
	    	$report->user = '1050';
	    	$report->save();


	    	session()->flash('alert', 'alert-success'); 
	    	session()->flash('message', 'Product updated successfully!');
	    	session()->flash('code', $request->code);
	    	return redirect('product/add');
    	}
    	
    }

    public function stock(Request $request){
    	$code = $request->id;
    	if($request->type=='remove'){
    	    $product = product::where('code',$code)->first();
	    	$product->stock -= $request->stock;
	    	$product->save();

	    	#Report
	    	$report = new report;
	    	$report->product = $code;
	    	$report->stock = $product->stock;
	    	$report->status = 'stock_remove';
	    	$report->notes = $request->stock.' stock removed, Notes from author :'.$request->note.'.';
	    	$report->user = '1050';
	    	$report->save();

	    	session()->flash('alert', 'alert-success'); 
	    	session()->flash('message', 'Product updated successfully!');
	    	session()->flash('code', $code);
	    	return redirect('product/edit/stock');
		}else{
			$product = product::where('code',$code)->first();
	    	$product->stock += $request->stock;
	    	$product->save();

	    	#Report
	    	$report = new report;
	    	$report->product = $code;
	    	$report->stock = $product->stock;
	    	$report->status = 'stock_add';
	    	$report->notes = $request->stock.' stock added, Notes from author :'.$request->note.'.';
	    	$report->user = '1050';
	    	$report->save();

	    	session()->flash('alert', 'alert-success'); 
	    	session()->flash('message', 'Product updated successfully!');
	    	session()->flash('code', $code);
	    	return redirect('product/edit/stock');
    	}
    	
    }


    public function check(Request $request){
    	$product = product::where('code',$request->code)->first();
    	if(count($product)==1){
    		$data['count']=1;
    		$data['name']=$product->name;
    		$data['code']=$product->code;
    		$data['price']=$product->price;
    		$data['gst']=$product->gst;
    		$data['discount']=$product->discount;
    		$data['stock']=$product->stock;
    	    $val = json_encode($data);
    	}else{
    		$data['count']=0;
    	    $val = json_encode($data);
    	}
    	return $val;
    }
}
