@extends('layouts.base')
@section('title','All Products')
@section('content')

        <div class="card pd-20 pd-sm-40">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>@yield('title')</h4></div><br>

                <div class="panel-body">
                   <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sl no</th>        
                                <th>Code</th>        
                                <th>Product name</th>        
                                <th>Stock availability</th>        
                                <th>Price</th>        
                                <th>GST</th>        
                                <th>Discount</th>        
                                <th>Action</th>        
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=0; @endphp
                            @foreach($products as $product)
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{$product->code}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->stock}}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->gst}}</td>
                                <td>{{$product->discount}}</td>
                                <td><a href="{{URL::to('delete/product')}}/{{$product->id}}" onclick="return confirm('Are you sure to delete {{$product->name}}?')">Delete</a></td>
                            </tr>
                            @endforeach
                            {{$products->links()}}

                        </tbody>
                    </table>
                 
                </div>
            </div>
        </div>

@endsection
@section('script')
@endsection