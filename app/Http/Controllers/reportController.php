<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\transaction;
use Excel;
use Carbon;
use Auth;
use App\report;
class reportController extends Controller
{
    public function report(Request $request){
    		return view('report');
    }

    public function download(Request $request){
    		
    	$datefrom = Carbon::parse($request->from);
    	$dateto = Carbon::parse($request->to);

                #Report
                $report = new report;
                $report->product = '000';
                $report->stock = '000';
                $report->status = 'report';
                $report->notes = $request->type.' Report from '.$datefrom->format('d F Y').' to '.$dateto->format('d F Y').' downloaded by '.Auth::user()->name;
                $report->user = Auth::user()->id;
                $report->save();


    	if($request->type == 'cash'){

        $transactions = transaction::whereBetween('created_at', [$datefrom->format('Y-m-d')." 00:00:00", $dateto->format('Y-m-d')." 23:59:59"])->where('card','0')->get();
 if(count($transactions) == 0){
       	$a[0]['STATUS'] = 'NO REPORTS AVAILABLE';
       }
            $i=1;
            foreach ($transactions as $transaction) {
            
                $a[$i]['SL NO'] = $i++;
                $a[$i]['BILL NUMBER'] = $transaction->billNo;
                $a[$i]['TOTAL'] = $transaction->total;
                $a[$i]['CASH'] = $transaction->cash;
                $a[$i]['BAALANCE'] = $transaction->balance;
            $a[$i]['DATE'] = Carbon::parse($transaction->created_at)->format('d F Y');
            }   $lastcell= 'A2:F'.(1+$i);
            $pagename = 'Cash Report From '.$datefrom->format('d F').' to '.$dateto->format('d F Y') ; 

            Excel::create($pagename, function($excel) use($a,$lastcell){

                $excel->sheet('Cash Report', function($sheet) use($a,$lastcell){
                    $sheet->fromArray($a);
                    $sheet->cell('A1:F1', function($cell) {
                        $cell->setFontSize(11);
                        $cell->setBackground('#7cde9c');
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');

                    });
                    $sheet->setFreeze('A2');
                    $sheet->cell('A1:F1', function($cell) {
                        $cell->setFontSize(12);
                        $cell->setBackground('#43a061');
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');

                    });
                    $sheet->cell($lastcell, function($cell) {
                        $cell->setFontSize(12);
                        $cell->setFontWeight('thin');
                        $cell->setAlignment('center');

                    });

                    $sheet->setPageMargin(array(
                        0.25, 0.30, 0.25, 0.30
                    ));
                });

            })->download('xls');
        
    }

    if($request->type == 'card'){

         $transactions = transaction::whereBetween('created_at', [$datefrom->format('Y-m-d')." 00:00:00", $dateto->format('Y-m-d')." 23:59:59"])->where('cash','0')->get();
       if(count($transactions) == 0){
       	$a[0]['STATUS'] = 'NO REPORTS AVAILABLE';
       }
            $i=1;
            foreach ($transactions as $transaction) {
            
                $a[$i]['SL NO'] = $i++;
                $a[$i]['BILL NUMBER'] = $transaction->billNo;
                $a[$i]['TOTAL'] = $transaction->total;
                $a[$i]['CARD'] = $transaction->card;
                $a[$i]['BAALANCE'] = $transaction->balance;
            	$a[$i]['DATE'] = Carbon::parse($transaction->created_at)->format('d F Y');
            }   $lastcell= 'A2:F'.(1+$i);
            $pagename = 'Card Report From '.$datefrom->format('d F').' to '.$dateto->format('d F Y') ; 

            Excel::create($pagename, function($excel) use($a,$lastcell){

                $excel->sheet('Card Report', function($sheet) use($a,$lastcell){
                    $sheet->fromArray($a);
                    $sheet->cell('A1:F1', function($cell) {
                        $cell->setFontSize(11);
                        $cell->setBackground('#7cde9c');
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');

                    });
                    $sheet->setFreeze('A2');
                    $sheet->cell('A1:F1', function($cell) {
                        $cell->setFontSize(12);
                        $cell->setBackground('#43a061');
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');

                    });
                    $sheet->cell($lastcell, function($cell) {
                        $cell->setFontSize(12);
                        $cell->setFontWeight('thin');
                        $cell->setAlignment('center');

                    });

                    $sheet->setPageMargin(array(
                        0.25, 0.30, 0.25, 0.30
                    ));
                });

            })->download('xls');
        
    }

    if($request->type == 'both'){

         $transactions = transaction::whereBetween('created_at', [$datefrom->format('Y-m-d')." 00:00:00", $dateto->format('Y-m-d')." 23:59:59"])->where('cash','>','0')->where('card','>','0')->get();
       if(count($transactions) == 0){
       	$a[0]['STATUS'] = 'NO REPORTS AVAILABLE';
       }
            $i=1;
            foreach ($transactions as $transaction) {
            
                $a[$i]['SL NO'] = $i++;
                $a[$i]['BILL NUMBER'] = $transaction->billNo;
                $a[$i]['TOTAL'] = $transaction->total;
                $a[$i]['CASH'] = $transaction->cash;
                $a[$i]['CARD'] = $transaction->card;
                $a[$i]['BAALANCE'] = $transaction->balance;
                $a[$i]['DATE'] = Carbon::parse($transaction->created_at)->format('d F Y');
            
            }   $lastcell= 'A2:G'.(1+$i);
            $pagename = 'Cash and Card Report From '.$datefrom->format('d F').' to '.$dateto->format('d F Y') ; 

            Excel::create($pagename, function($excel) use($a,$lastcell){

                $excel->sheet('Card Report', function($sheet) use($a,$lastcell){
                    $sheet->fromArray($a);
                    $sheet->cell('A1:G1', function($cell) {
                        $cell->setFontSize(11);
                        $cell->setBackground('#7cde9c');
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');

                    });
                    $sheet->setFreeze('A2');
                    $sheet->cell('A1:G1', function($cell) {
                        $cell->setFontSize(12);
                        $cell->setBackground('#43a061');
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');

                    });
                    $sheet->cell($lastcell, function($cell) {
                        $cell->setFontSize(12);
                        $cell->setFontWeight('thin');
                        $cell->setAlignment('center');

                    });

                    $sheet->setPageMargin(array(
                        0.25, 0.30, 0.25, 0.30
                    ));
                });

            })->download('xls');
        
    }

    if($request->type == 'gst'){

         $transactions = transaction::whereBetween('created_at', [$datefrom->format('Y-m-d')." 00:00:00", $dateto->format('Y-m-d')." 23:59:59"])->get();
       if(count($transactions) == 0){
       	$a[0]['STATUS'] = 'NO REPORTS AVAILABLE';
       }
            $i=1;
            foreach ($transactions as $transaction) {
            
                $a[$i]['SL NO'] = $i++;
                $a[$i]['BILL NUMBER'] = $transaction->billNo;
                $a[$i]['TOTAL'] = $transaction->total;
                $a[$i]['GST IN RS'] = $transaction->gst;
                $a[$i]['DATE'] = Carbon::parse($transaction->created_at)->format('d F Y');
            }   $lastcell= 'A2:E'.(1+$i);
            $pagename = 'GST Report From '.$datefrom->format('d F').' to '.$dateto->format('d F Y') ; 

            Excel::create($pagename, function($excel) use($a,$lastcell){

                $excel->sheet('Card Report', function($sheet) use($a,$lastcell){
                    $sheet->fromArray($a);
                    $sheet->cell('A1:E1', function($cell) {
                        $cell->setFontSize(11);
                        $cell->setBackground('#7cde9c');
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');

                    });
                    $sheet->setFreeze('A2');
                    $sheet->cell('A1:E1', function($cell) {
                        $cell->setFontSize(12);
                        $cell->setBackground('#43a061');
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');

                    });
                    $sheet->cell($lastcell, function($cell) {
                        $cell->setFontSize(12);
                        $cell->setFontWeight('thin');
                        $cell->setAlignment('center');

                    });

                    $sheet->setPageMargin(array(
                        0.25, 0.30, 0.25, 0.30
                    ));
                });

            })->download('xls');
        
    }

    if($request->type == 'sales'){

         $transactions = transaction::whereBetween('created_at', [$datefrom->format('Y-m-d')." 00:00:00", $dateto->format('Y-m-d')." 23:59:59"])->get();
       if(count($transactions) == 0){
       	$a[0]['STATUS'] = 'NO REPORTS AVAILABLE';
       }
            $i=1;
            foreach ($transactions as $transaction) {
            
                $a[$i]['SL NO'] = $i++;
                $a[$i]['BILL NUMBER'] = $transaction->billNo;
                $a[$i]['TOTAL'] = $transaction->total;
                $a[$i]['DISCOUNT'] = $transaction->discount;
                $a[$i]['GST'] = $transaction->gst;
                $a[$i]['CASH'] = $transaction->cash;
                $a[$i]['CARD'] = $transaction->card;
                $a[$i]['BALANCE'] = $transaction->balance;
                $a[$i]['EXCHANGE VALUE'] = $transaction->exchangevalue;
                $a[$i]['CUSTOMER DATA'] = $transaction->customernote;
                $a[$i]['DATE'] = Carbon::parse($transaction->created_at)->format('d F Y');
            
            }   $lastcell= 'A2:J'.(1+$i);
            $pagename = 'SALES Report From '.$datefrom->format('d F').' to '.$dateto->format('d F Y') ; 

            Excel::create($pagename, function($excel) use($a,$lastcell){

                $excel->sheet('Card Report', function($sheet) use($a,$lastcell){
                    $sheet->fromArray($a);
                    $sheet->cell('A1:J1', function($cell) {
                        $cell->setFontSize(11);
                        $cell->setBackground('#7cde9c');
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');

                    });
                    $sheet->setFreeze('A2');
                    $sheet->cell('A1:J1', function($cell) {
                        $cell->setFontSize(12);
                        $cell->setBackground('#43a061');
                        $cell->setFontWeight('bold');
                        $cell->setAlignment('center');

                    });
                    $sheet->cell($lastcell, function($cell) {
                        $cell->setFontSize(12);
                        $cell->setFontWeight('thin');
                        $cell->setAlignment('center');

                    });

                    $sheet->setPageMargin(array(
                        0.25, 0.30, 0.25, 0.30
                    ));
                });

            })->download('xls');
        
    }



    }
}
