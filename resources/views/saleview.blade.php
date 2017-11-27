@extends('layouts.base')
@section('title','Bills')
@section('content')
<style>
.pagination {
    display: inline-block;
}
.pagination li {
    float: left;
    background: #eaeaea;
}

.pagination a,span {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
}
.pagination a.active {
    background-color: #4CAF50;
    color: white;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>

        <div class="card pd-20 pd-sm-40">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>@yield('title')</h4></div><br>

                <div class="panel-body">
                   <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sl no</th>        
                                <th>Bill Number</th>        
                                <th>Customer details</th>        
                                <th>total</th>        
                                <th>date</th>        
                                <th>action</th>         
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=0; @endphp
                            @foreach($transactions as $product)
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{$product->billNo}}</td>
                                <td>{{$product->customernote}}</td>
                                <td>{{$product->total}}</td>
                                <td>{{Carbon::parse($product->created_at)->format('d F Y')}}</td>
                                <td></td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                            {{$transactions->links()}}
                </div>
            </div>
        </div>

@endsection
@section('script')
@endsection