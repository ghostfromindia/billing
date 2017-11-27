<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\product;    
use App\sales;    
use App\transaction;    

class viewController extends Controller
{
   public function product(){
    $products = product::paginate('10');
   	return view('view',compact('products'));
   }

   public function sale(){
    $transactions = transaction::paginate('10');
   	return view('saleview',compact('transactions'));
   }
}
