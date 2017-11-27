<html>

<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Esteban|Oswald|Pavanam|Sansita" rel="stylesheet">
   <style>

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {

    padding: 2px;font-size: 18px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
    font-weight: 400;

}

.description{
	font-size: 19px;
}
.head{
font-size: 18px;
   
}
</style>
</head>
	<script type="text/javascript">
    window.print();
    setTimeout(function(){ document.getElementById('footer').innerHTML = "Original copy"; window.print(); }, 500);
    </script>

<body style="max-width: 800px;font-family: 'Oswald', sans-serif;  font-size: 12px;">

<div align="center" style="width: 800px;">
<h2>Heera foodex</h2>
</div>

<div align="left" style="float: left;width: 350px;">
<h2>Heera Foodex,</h2>
<p class="description">NAdeem colony,
Tolichowki,
PIN: 6800007</p>
</div>

<div align="right" width='50%' style="float: right;width: 50%;">
<p class="description"><br>
INVOICE NO : {{$transaction->billNo}}<br>
DATE : {{Carbon::parse($transaction->created_at)->format('d-F-Y')}}<br>
TIME : {{Carbon::parse($transaction->created_at)->format('H:i:s')}}</p>
</div>

<div align="left" width='50%' style="float: left">
<p class="head">
	TO,<br>
	 {!! $transaction->customernote !!}</p>
</div>

<table  class="table table-striped" style="width: 800px;margin-top: 250px;">
	<thead>
		<tr>
		<th>SL NO</th>
		<th>Product</th>
		<th>Price</th>
		<th>Quantity</th>
		<th>Discount</th>
		<th>GST</th>
		<th>Total</th>
	    </tr>
	</thead>
	<tbody>
	@php $i=1;$gst=0;$discount=0; $price=0; $total = 0; @endphp
	@foreach($sales as $sale)
		<tr>
		<td>{{$i}}</td>
		<td>{{$sale->product->name}}</td>
		<td>{{$sale->price}}</td>
		<td>{{$sale->qty}}</td>
		<td>{{$sale->discount}}%</td>
		<td>{{$sale->gst}}%</td>
		<td>{{$sale->total}}</td>
	    </tr>
	    @php $i+=1;
	    $price += $sale->price;
	    $total += $sale->total;
	    $gst+= ($sale->total*$sale->gst)/100; 
        $discount+=($sale->total*$sale->discount)/100; 
	    @endphp
    @endforeach
	</tbody>
</table>
</div>
<div align="right" style="float: left;width: 800px;position: absolute;bottom: 50px;" >
	<p class="head">
		Gross amount : {{$price}}<br>
		-DISCOUNT : {{$discount}}<br>
		+CGST : {{$gst/2}}<br>
		+SGST : {{$gst/2}}<br>
		@if($transaction->exchangevalue>0)
		-EXCHANGE VALUE : {{$transaction->exchangevalue}} @endif <br>
		<span style="font-size: 28px;">Total : {{$total}}</span><br><br>
	</p>

	<p class="head">
		Payment mode : 
		@if($transaction->card>0 && $transaction->cash>0)
		CARD & CASH
		@elseif($transaction->card>0)
		CARD
		@elseif($transaction->cash>0)
		CASH
		@endif
		<br>
		<span style="font-size: 20px;">Advance : 0</span><br>
		<span style="font-size: 28px;">Balance amount : {{$total}}</span><br>
	</p>
	<p id="footer">Orginal bill</p>
</div>
<p id="footer">Orginal bill</p>
</body>
</html>