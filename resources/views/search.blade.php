@extends('layouts.base')
@section('title','Search bill')
@section('content')

        <div class="card pd-20 pd-sm-40">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>@yield('title')</h4></div><br>

                <div class="panel-body">
                    <form action="{{URL::to('bill/check')}}" method="post">
                        {{csrf_field()}}

                   
                   <div class="row">
                       <div class="col-lg-4 mg-t-20 mg-lg-t-0">
              <div class="input-group">
                <input type="text" class="form-control" name="code" placeholder="Enter bill number" value="@if(isset($transaction)) {{$transaction->billNo}} @endif">
                <button class="btn btn-success input-group-addon tx-size-sm">Find</button> 
              </div>
            </div>
                       
                    </div>
                    <div class="row"><br></div>
                    <div class="row">
                      <div class="col-md-6 col-lg-4">
            <ul class="list-group widget-list-group" style="background: #f1f1f1;">
             @if(isset($transaction))
             @if($count==1)
              <li class="list-group-item rounded-top-0">
                <p class="mg-b-0">
                    <strong class="tx-inverse tx-medium">Bill Number :</strong> 
                    <span class="text-muted">{{$transaction->id}}</span>
                </p>
              </li>
              <li class="list-group-item">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">Total Amount :</strong> <span class="text-muted">{{$transaction->total}}</span></p>
              </li>
              <li class="list-group-item">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">By Cash :</strong> <span class="text-muted">{{$transaction->cash}}</span></p>
              </li>
              <li class="list-group-item">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">By Card :</strong> <span class="text-muted">{{$transaction->card}}</span></p>
              </li>
              <li class="list-group-item rounded-bottom-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">Balance paid : </strong> <span class="text-muted">{{$transaction->balance}}</span></p>
              </li>
              <li class="list-group-item rounded-bottom-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">GST : </strong> <span class="text-muted">{{$transaction->gst}}</span></p>
              </li>
              <li class="list-group-item rounded-bottom-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">Discount : </strong> <span class="text-muted">{{$transaction->discount}}</span></p>
              </li>
               <li class="list-group-item rounded-bottom-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">Exchange Value : </strong> <span class="text-muted">{{$transaction->exchangevalue}}</span></p>
              </li>
                 <li class="list-group-item rounded-bottom-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">Customer Data: </strong> <span class="text-muted">{{$transaction->customernote}}</span></p>
              </li>
              @else
              <li class="list-group-item rounded-bottom-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">Bill not found</strong> </p>
              </li>
              @endif
              @else
              <li class="list-group-item rounded-top-0">
                <p class="mg-b-0">
                   
                </p>
              </li>
              @endif
            </ul>
          </div>

           <div class="col-md-6 col-lg-4">
            <ul class="list-group widget-list-group" style="background: #f1f1f1;">
             @if(isset($transaction))
             @if($count==1)
              @foreach($sales as $sale)
              <li class="list-group-item rounded-top-0">
                <p class="mg-b-0">
                    <strong class="tx-inverse tx-medium">{{$sale->product->name}} X </strong> 
                    <span class="text-muted">{{$sale->qty}} = </span>
                    <span class="text-muted">({{$sale->price}}*{{$sale->qty}}) - </span>
                    <span class="text-muted">{{$sale->discount}}% +</span>
                    <span class="text-muted">{{$sale->gst}}% =</span>
                    <span class="text-muted">{{$sale->total}}</span>
                </p>
              </li>
              @endforeach
              <li class="list-group-item rounded-top-0">
                <p class="mg-b-0">
    {{--                 <strong class="tx-inverse tx-medium">EDIT |</strong>  --}}
    @if($transaction->status=='exchange-completed')
<strong class="tx-inverse tx-medium">EXCHANGED |</strong> 
                                    @else
<a href="{{URL::to('exchange')}}/{{$transaction->billNo}}" onclick="return confirm('Are you sure to Exchange bill no : {{$transaction->billNo}} ?')"><strong class="tx-inverse tx-medium">EXCHANGE  |</strong> </a> 
                                    @endif
                   <a href="{{URL::to('delete/sale')}}/{{$transaction->id}}" onclick="return confirm('Are you sure to Delete bill no : {{$transaction->billNo}} ?')"> <strong class="tx-inverse tx-medium">DELETE</strong> </a>
                </p>
              </li>
              @else
              <li class="list-group-item rounded-bottom-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">Bill not found</strong> </p>
              </li>
              @endif
              @else
              <li class="list-group-item rounded-bottom-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">Bill not found</strong> </p>
              </li>
              @endif
            </ul>
          </div>
                    </div>

                     @if(Session::has('message'))
                        <p class="{{Session::get('alert')}}">{{ Session::get('message') }}</p>
                     @endif
                 </form>
                </div>
            </div>
        </div>

@endsection
@section('script')
@endsection