@extends('layouts.base')
@section('title','Change stock')
@section('content')

        <div class="card pd-20 pd-sm-40">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>@yield('title')</h4></div><br>

                <div class="panel-body">
                   
                        

                   
                   <div class="row">
                        <div class="col-lg-3">
                        <label>Product code</label>
                        <span id="codestatus" style="display: none;"></span>
                        <input class="form-control" placeholder="eg. 802555" type="number" id='code' name='code' required>
                        </div><!-- col -->
                        <div class="row" id="edit"   style="display: none;">
                        <div class="col-lg-4">
                        <label>Product name</label>
                        <input class="form-control" placeholder="eg. Rayban" type="text" name='name' id='name' readonly>
                        </div><!-- col -->
                        <div class="col-lg-4">
                        <label>Product Stock</label>
                        <input class="form-control" placeholder="eg. 1299" type="number" name='stock' id='stock'>
                        </div><!-- col -->
                        </div>
                    </div>
                    <div class="row"><br></div>
                    
                    
                     <div class="row">
                        <div class="col-lg-3"><br>
                            <span class="btn btn-success mg-b-10" data-toggle="modal" data-target="#modaldemo2">Remove</span>
                            <span class="btn btn-success mg-b-10" data-toggle="modal" data-target="#modaldemo1">Add</span>
                        </div>
<!-- SMALL MODAL -->
    <div id="modaldemo2" class="modal fade">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">How much stock you want to remove?</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
           <form action="{{URL::to('product/add/update/stock')}}" method="post">
            {{csrf_field()}}
          <div class="modal-body pd-20">
            <p class="mg-b-5">Enter the quantity of product you want to remove </p>
            <input type="hidden" name='id' id="id1">
            <input class="form-control" placeholder="eg. 1299" type="number" name='stock' id='stock'><br>
            <input class="form-control" placeholder="eg. Enter a remark" type="text" name='note' id='note'>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit" name="type" value="remove" class="btn btn-info pd-x-20">Update</button>
            <button type="submit" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div><!-- modal-dialog -->
    </div>
<!-- modal -->

<!-- SMALL MODAL -->
    <div id="modaldemo1" class="modal fade">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
          <div class="modal-header pd-x-20">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">How much stock you want to Add?</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{URL::to('product/add/update/stock')}}" method="post">
            {{csrf_field()}}
          <div class="modal-body pd-20">
            <input type="hidden" name='id' id="id2">
            <input class="form-control" placeholder="eg. 1299" type="number" name='stock' id='stock'><br>
            <input class="form-control" placeholder="eg. Enter a remark" type="text" name='note' id='note'>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="submit"  name="type" value="add" class="btn btn-info pd-x-20">Update</button>
            <button type="submit" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div><!-- modal-dialog -->
    </div>
<!-- modal -->
                     </div>

                     @if(Session::has('message'))
                        <p class="{{Session::get('alert')}}">{{ Session::get('message') }}</p>
                     @endif
              
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
                $("#edit").show();
               
                $("#codestatus").show();
                $("#editstatus").show();
                $("#codestatus").hide();
                $("#addbutton").hide();
                $("#updatebutton").show();
                $("#id1").val(code);
                $("#id2").val(code);
                $("#name").val(obj.name);
                $("#price").val(obj.price);
                $("#gst").val(obj.gst);
                $("#discount").val(obj.discount);
                $("#stock").val(obj.stock);$('#stock').attr('readonly', 'readonly');
             }else{
                $("#edit").hide();
                $("#codestatus").show();
                $("#codestatus").html('(<span style="color:red;">Opps.. Product not found</span>)');
                $("#editstatus").hide();
             }
          
         }
         });
         });
       
       
      </script>
@endsection