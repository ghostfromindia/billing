@extends('layouts.base')
@section('title','Add new Product')
@section('content')

<div class="row row-sm mg-t-15 mg-sm-t-20">
          <div class="col-md-3 col-lg-2">
            <ul class="list-group widget-list-group">
              <form action="{{URL::to('sale/exchange/add')}}" method="post">  
                {{csrf_field()}}
                <input type="hidden" name="bill" value="{{$bill}}">
              <li class="list-group-item rounded-top-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">PRODUCT CODE</strong></p>
                <input class="form-control" type="text" value="" id="code" name="code" autocomplete="off">
              </li>
              <li class="list-group-item" id='nameui' style="display: none;">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium" id="name"></strong></p>
              </li>
              <li class="list-group-item" id='priceui' style="display: none;">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium" id="pricee"></strong></p>
                <input type="hidden" id="price">
              </li>
              <li class="list-group-item" id='qtyui' style="display: none;">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">QUANTITY</strong></p>
                <input class="form-control" type="number" name="qty" value="1" id="qty">
              </li>
              <li class="list-group-item rounded-bottom-0" id='discountui' style="display: none;">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">DISCOUNT</strong></p>
                <input class="form-control" type="number" name="discount" value="0" id="discount">
              <li class="list-group-item rounded-bottom-0" id='gstui' style="display: none;">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">GST</strong></p>
                <input class="form-control" type="number" name="gst" value="0" id="gst">
              </li>
              <li class="list-group-item rounded-bottom-0" id='totalui' style="display: none;">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">TOTAL</strong></p>
                <input class="form-control" type="number" name="total" value="0" id="total">
              </li>
              <li class="list-group-item rounded-bottom-0" style="display: none;" id="addbutton">
               <button type='submit' class="btn btn-success btn-block">ADD</button>
              </li>
              
              @if (session('addmessage'))
              <li class="list-group-item rounded-bottom-0"  id="addbutton">
                        <span style="color: red;">{{ session('addmessage') }}</span>
               </li>
                @endif
              </form>
       
            </ul>
          </div><!-- col-4 -->
          <div class="col-lg-5 mg-t-15 mg-sm-t-20 mg-lg-t-0">
            <ul class="list-group widget-list-group">
              @if($show == 0)
               <li class="list-group-item rounded-top-0">
                <p class="mg-b-0">No products added yet</p>

              </li> 
              @else
              @php $s_total=0; @endphp
              <li class="list-group-item rounded-top-0" style="background-color: #fff">
              <p class="mg-b-0">
                Orginal bill
              </p>
              </li>
              @foreach($sales as $sale)
              
              <li class="list-group-item rounded-top-0" style="background-color: #eaeaea">
                <p class="mg-b-0"><i class="fa fa-check tx-success mg-r-8"></i>
                    <strong class="tx-inverse tx-medium">{{$sale->product->name}}</strong> X 
                    <strong class="tx-inverse tx-medium">{{$sale->qty}} QTY </strong> 
                    <span style="float: right;font-weight: bold;">₹ {{$sale->total}}</span></p>
                @php 
                $s_total+=$sale->total; 
                @endphp
              </li>
              @endforeach
               <li class="list-group-item rounded-top-0" style="background-color: #fff">
              <p class="mg-b-0">
                Edited bill
              </p>
              </li>
               @php $e_total=0; @endphp
              @foreach($exchanges as $exchange)
              <li class="list-group-item rounded-top-0" style="background-color: #f8f9fa">
                <p class="mg-b-0"><i class="fa fa-check tx-success mg-r-8"></i>
                    <strong class="tx-inverse tx-medium">{{$exchange->product->name}}</strong> X 
                    <strong class="tx-inverse tx-medium">{{$exchange->qty}} QTY </strong> 
                    <span style="float: right;font-weight: bold;">₹ {{$exchange->amount}}</span></p>
                @php 
                $e_total+=$exchange->amount; 
                @endphp
                <a href="{{URL::to('exchange/remove')}}/{{$exchange->id}}" class="btn btn-success" style="float: right;padding:2px;">Exchange</a>
              </li>
              @endforeach
              <li class="list-group-item rounded-top-0" style="background-color: #fff">
              <p class="mg-b-0">
                New bill
              </p>
              </li>
              @if(count($newbill)!=0)
                 @php 
                $n_total = 0; $gst =0;$discount =0;
                @endphp
              @foreach($newbill as $new)
              
              <li class="list-group-item rounded-top-0" style="background-color: #eaeaea">
                <p class="mg-b-0"><i class="fa fa-check tx-success mg-r-8"></i>
                    <strong class="tx-inverse tx-medium">{{$new->product->name}}</strong> X 
                    <strong class="tx-inverse tx-medium">{{$new->qty}} QTY </strong> 
                    <span style="float: right;font-weight: bold;">₹ {{$new->total}}</span></p>
                @php 
                @endphp
              </li>
                @php 
                $n_total+=$new->total; 
                $gst+= ($new->total*$new->gst)/100; 
                $discount+=($new->total*$new->discount)/100; 
                @endphp
              @endforeach
              @else
              <li class="list-group-item rounded-top-0" style="background-color: #fff">
              <p class="mg-b-0">
                No products added yet
              </p>
              </li>
              @endif
              @endif
              
            </ul>
          </div><!-- col-4 -->
           
          <div class="col-lg-4 mg-t-15 mg-sm-t-20 mg-lg-t-0">
            <ul class="list-group widget-list-group">
                <form action="{{URL::to('exchange/complete')}}" method="post">  
                {{csrf_field()}}
              <li class="list-group-item rounded-top-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">New bill amount - Exchanged value </strong><h2 class="mg-b-5 tx-inverse tx-lato">
                  ₹@if(isset($n_total)) {{$n_total}} - @if(isset($e_total)) ₹{{$s_total-$e_total}} @else $e_total=0; @endif   @else @php $n_total=0;@endphp
                 @endif</h2></p>
              </li>

         
              <li class="list-group-item rounded-top-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">Amount needs to pay</strong><h2 class="mg-b-5 tx-inverse tx-lato">₹@if(isset($s_total)) 
                    @php 
                    if(($n_total-($s_total-$e_total))<0)
                    {echo $totalamount = '0';}
                    else
                    {echo $totalamount = $n_total-($s_total-$e_total);} 
                    @endphp
                  <input type="hidden" name="total" id="grandtotal" value="{{$totalamount}}">
                  <input type="hidden" name="ev" id="ev" value="{{$s_total-$e_total}}"> 
                  @else 
                  <input type="hidden" name="total" id="grandtotal" value="0">
                  <input type="hidden" name="ev" id="ev" value="0">
                0 @endif</h2></p>
              </li>
              
              <li class="list-group-item">
                <p class="mg-b-0"><i class="fa fa-check tx-success mg-r-8"></i><strong class="tx-inverse tx-medium">DISCOUNT</strong> <span class="text-muted"> - ₹@if(isset($discount)) {{$discount}} <input type="hidden" name="discount" value="{{$discount}}"> @else <input type="hidden" name="discount" value="0">0 @endif</span></p>
              </li>
              <li class="list-group-item">
                <p class="mg-b-0"><i class="fa fa-check tx-success mg-r-8"></i><strong class="tx-inverse tx-medium">GST</strong> <span class="text-muted"> - ₹@if(isset($gst)) {{$gst}} <input type="hidden" name="gst" value="{{$gst}}"> @else <input type="hidden" name="gst" value="0">0 @endif</span></p>
              </li>
              <li class="list-group-item rounded-bottom-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">Customer Details</strong></p>
                <textarea class="form-control" type="text" name="customernote" placeholder="Enter customer details"></textarea>
              </li>
              <li class="list-group-item rounded-bottom-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">PAYMENT MODE</strong></p>
               
              </li>
              <li class="list-group-item rounded-bottom-0" id="cashui">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">BY CASH</strong></p>
                <input class="form-control" type="text" name="cash" id="cashval" value="0">
              </li>
              <li class="list-group-item rounded-bottom-0" id="cardui">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">BY CARD</strong></p>
                <input class="form-control" type="text" name="card" id="cardval" value="0">
              </li>
              <li class="list-group-item rounded-bottom-0" id="balanceui">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">BALANCE</strong></p>
                <input class="form-control" type="text" name="balance" id="balanceval" value="0">
              </li>
              <li class="list-group-item rounded-bottom-0" id="complete" style="display: none;">
                <button type='submit' class="btn btn-success btn-block">COMPLETE PURCHASE</button>
                @if (session('message'))
                        <span style="color: red;">{{ session('message') }}</span>
                @endif
              </li>
              </form>
            </ul>
          </div><!-- col-4 -->
      
          
        </div>
@endsection
@section('script')
<script type="text/javascript">
$('#code').focus();
         var total = $('#grandtotal').val();
         if(parseFloat(total)>0){$('#complete').show();}
         $('#cashval').val(total);
         $("#code").bind('keyup focus', function() {  
         var code = $("#code").val();
         $.ajax({
         type: "GET",
         url: "{{URL::to('product/add/check')}}{{'/'}}"+code,
         success: function(data) {
         obj = jQuery.parseJSON(data);
             if(obj.count==1){
                $("#name").html(obj.name);
                $("#pricee").html('₹ '+obj.price);
                $("#price").val(obj.price);
                $("#gst").val(obj.gst);
                $("#discount").val(obj.discount);
                $("#qty").val(1);

                var qty = $("#qty").val();
                var price = $("#price").val();
                var gst = $("#gst").val();
                var discount = $("#discount").val();

                var totalwdiscont = (obj.price*qty)-(((obj.price*qty)*discount)/100);
                var totalwgst = totalwdiscont+((totalwdiscont*gst)/100);
                $("#total").val(totalwgst.toFixed());
                $("#addbutton").show();

                $("#nameui").show();
                $("#priceui").show();
                $("#qtyui").show();
                $("#discountui").show();
                $("#totalui").show();
                $("#gstui").show();
             }else{
                $("#name").val('');
                $("#pricee").html('');
                $("#price").val('');
                $("#gst").val('');
                $("#discount").val('');
                $("#qty").val('');
                 $("#total").val('');
                $("#addbutton").hide();

                $("#nameui").hide();
                $("#priceui").hide();
                $("#qtyui").hide();
                $("#discountui").hide();
                $("#totalui").hide();
                $("#gstui").hide();
             }
          
         }
         });
         });


         $("#qty").bind('keyup focus', function() { 
                var qty = $("#qty").val();
                var price = $("#price").val();
                var gst = $("#gst").val();
                var discount = $("#discount").val();

                var totalwdiscont = (obj.price*qty)-(((obj.price*qty)*discount)/100);
                var totalwgst = totalwdiscont+((totalwdiscont*gst)/100);
                $("#total").val(totalwgst.toFixed());
         });

         $("#discount").bind('keyup focus', function() { 
                var qty = $("#qty").val();
                var price = $("#price").val();
                var gst = $("#gst").val();
                var discount = $("#discount").val();

                var totalwdiscont = (obj.price*qty)-(((obj.price*qty)*discount)/100);
                var totalwgst = totalwdiscont+((totalwdiscont*gst)/100);
                $("#total").val(totalwgst.toFixed());
         });

          $("#gst").bind('keyup focus', function() { 
                var qty = $("#qty").val();
                var price = $("#price").val();
                var gst = $("#gst").val();
                var discount = $("#discount").val();

                var totalwdiscont = (obj.price*qty)-(((obj.price*qty)*discount)/100);
                var totalwgst = totalwdiscont+((totalwdiscont*gst)/100);
                $("#total").val(totalwgst.toFixed());
         });

        
       
        $("#cardval").bind('keyup', function() { 
            var total = $('#grandtotal').val();
            var cash = $('#cashval').val();
            var card = $('#cardval').val();
            if(parseFloat(card)>parseFloat(total)){
                $('#cashval').val(0);
            }
            cash = $('#cashval').val();
            card = $('#cardval').val();
            var balance = parseFloat(card)+parseFloat(cash)-parseFloat(total);


            $('#balanceval').val(balance);
        });

        $("#cashval").bind('keyup', function() { 
            var total = $('#grandtotal').val();
            var cash = $('#cashval').val();
            var card = $('#cardval').val();
            if(parseFloat(cash)>parseFloat(total)){
                $('#cardval').val(0);
            }
            cash = $('#cashval').val();
            card = $('#cardval').val();
            var balance = parseFloat(card)+parseFloat(cash)-parseFloat(total);


            $('#balanceval').val(balance);
   
        });



$('#code').keypress(function(event){
  if(event.keyCode == 13){
    event.preventDefault();
    $('#qty').focus();
  }
});



</script>
@endsection