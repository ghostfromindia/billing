@extends('layouts.base')
@section('title','Download Reports')
@section('content')

        <div class="card pd-20 pd-sm-40">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>@yield('title')</h4></div><br>

                <div class="panel-body">
                    <form action="{{URL::to('report/download')}}" method="post">
                        {{csrf_field()}}

                   
             <div class="row">
              <div class="col-lg-12 mg-t-20 mg-lg-t-0">
                <h5>Choose Report type</h5>
              <label class="rdiobox">
                <input name="type" type="radio" checked="" value="cash">
                <span>Cash Report</span>
              </label>
              <label class="rdiobox">
                <input name="type" type="radio" value="card">
                <span>Card Report</span>
              </label>
              <label class="rdiobox">
                <input name="type" type="radio" value="both">
                <span>Cash & Card Report</span>
              </label>
              <label class="rdiobox">
                <input name="type" type="radio" value="gst">
                <span>Gst Report</span>
              </label>
              <label class="rdiobox">
                <input name="type" type="radio" value="sales">
                <span>Sales Report</span>
              </label>
            </div>
              <div class="col-lg-3">
              <div class="input-group">
                <span class="input-group-addon">From</span>
                <input type="date" class="form-control" name="from" placeholder="Username" required>
              </div>
            </div><div class="col-lg-3">
              <div class="input-group">
                <span class="input-group-addon">To</span>
                <input type="date" class="form-control" name="to" placeholder="Username" required>
                 <button type="submit" class="btn btn-success">Download</button>
              </div>
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
                    <strong class="tx-inverse tx-medium">EDIT |</strong> 
                    <strong class="tx-inverse tx-medium">EXCHANGE |</strong> 
                    <strong class="tx-inverse tx-medium">DELETE</strong> 
                </p>
              </li>
              @else
              <li class="list-group-item rounded-bottom-0">
                <p class="mg-b-0"><strong class="tx-inverse tx-medium">Bill not found</strong> </p>
              </li>
              @endif
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