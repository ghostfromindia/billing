@extends('layouts.base')
@section('title','Add new Product')
@section('content')

        <div class="card pd-20 pd-sm-40">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>@yield('title')</h4></div><br>

                <div class="panel-body">
                    <form action="{{URL::to('product/add/new')}}" method="post">
                        {{csrf_field()}}

                   <div class="row">
                        <p id="codestatus" style="display: none;"></p>
                        <p id="editstatus" style="display: none;"></p>
                   </div>
                   <div class="row">
                        <div class="col-lg-3">
                        <label>Product code</label>
                        
                        <input class="form-control" placeholder="eg. 802555" type="number" id='code' name='code' value="@if(Session::has('code')){{Session::get('code')}}@endif" required>
                        </div><!-- col -->
                        <div class="col-lg-3">
                        <label>Product name</label>
                        <input class="form-control" placeholder="eg. Rayban" type="text" name='name' id='name' required>
                        </div><!-- col -->
                        <div class="col-lg-3">
                        <label>Product Price</label>
                        <input class="form-control" placeholder="eg. 1299" type="number" name='price' id='price' required>
                        </div><!-- col -->
                    </div>
                    <div class="row"><br></div>
                    <div class="row">
                        <div class="col-lg-3">
                        <label>Product GST</label>
                        <input class="form-control" placeholder="eg. 5" type="number" name='gst' id='gst' required>
                        </div><!-- col -->
                        <div class="col-lg-3">
                        <label>Product Discount</label>
                        <input class="form-control" placeholder="eg. 10" name='discount' id='discount' type="number">
                        </div><!-- col -->
                        <div class="col-lg-3">
                        <label>Stock</label>
                        <input class="form-control" placeholder="eg. 40" name='stock' id='stock' type="number" required>
                        </div><!-- col -->
                    </div>
                     <div class="row">
                        <div class="col-lg-3"><br>
                            <button type='submit' name='type' value='new' class="btn btn-success mg-b-10" id="addbutton">Add New Product</button>
                            <button type='submit' name='type' value='update' class="btn btn-primary mg-b-10" id="updatebutton" style="display: none;">Update Product</button>
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

<script type="text/javascript">
         
         $("#code").focus();
         $("#code").bind('keyup focus', function() { 
         var code = $("#code").val();
         $.ajax({
         type: "GET",
         url: "{{URL::to('product/add/check')}}{{'/'}}"+code,
         success: function(data) {
         obj = jQuery.parseJSON(data);
             if(obj.count==1){
                $("#codestatus").addClass("alert alert-danger");
                $("#editstatus").addClass("alert alert-warning");
                $("#codestatus").show();
                $("#editstatus").show();
                $("#codestatus").html('Opps.. You have a product with this code!. Please choose a different code');
                $("#editstatus").html('You can edit the product now (<strong> Stock can \' t change from here</strong> )');
                $("#addbutton").hide();
                $("#updatebutton").show();
                $("#name").val(obj.name);
                $("#price").val(obj.price);
                $("#gst").val(obj.gst);
                $("#discount").val(obj.discount);
                $("#stock").val(obj.stock);$('#stock').attr('readonly', 'readonly');
             }else{
                $("#codestatus").hide();
                $("#editstatus").hide();
                $("#addbutton").show();
                $("#updatebutton").hide();
                $("#name").val();
                $("#price").val();
                $("#gst").val();
                $("#discount").val();
                $("#stock").val();
                $('#stock').removeAttr('readonly', 'false');
             }
          
         }
         });
         });
       
      </script>
@endsection