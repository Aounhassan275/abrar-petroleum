@extends('user.layout.index')

@section('title')
    Add New Customer
@endsection
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('user.customer.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Customer Name</label>
                            <input name="name" type="text" class="form-control" value="{{old('name')}}" placeholder="Enter Customer Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Father Name</label>
                            <input name="father_name" type="text" value="{{old('father_name')}}" class="form-control" placeholder="Enter Customer Father Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Cnic</label>
                            <input name="cnic"  maxlength="15" minlength="15" id="cnic" type="text" value="{{old('cnic')}}" class="form-control"  placeholder="XXXXX-XXXXXXX-X" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Phone</label>
                            <input name="phone" type="text" value="{{old('phone')}}" class="form-control" placeholder="Enter Customer Phone" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer  Address</label>
                            <input name="address" type="text" value="{{old('address')}}" class="form-control" placeholder="Enter Customer Address" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Opening Balance</label>
                            <input name="balance" type="text" value="{{old('balance')}}" class="form-control" placeholder="Enter Customer Balance" required>
                        </div>
                    </div>
                    <div class="row">
                        <p><b>Customer Vehicle :</b></p>
                        <div class="col-md-12 text-right">
                            <button type="button" id="add-more-vehicles" class="btn btn-success btn-sm text-right">Add More Accounts</button>
                            <button type="button" id="remove-fields" style="display:none;" class="btn btn-danger btn-sm text-right">Remove Extra Accounts</button>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Vehicle Title</label>
                            <input name="vehicle_name[]" type="text" value="" class="form-control" placeholder="Enter Customer Vehicle Title">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Vehicle Registration Number</label>
                            <input name="reg_number[]" type="text" value="" class="form-control" placeholder="Enter Vehicle Registration">
                        </div>
                    </div>
                    <div id="vehicle_fields"></div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Create <i class="icon-paperplane ml-2"></i></button>
                    </div>
                    
                </form>
            </div>
        </div>
        <!-- /basic layout -->

    </div>
</div>
<div id="more_vehicle_fields" style="display:none;">
    <div class="row">
        <div class="form-group col-md-6">
            <label>Customer Vehicle Title</label>
            <input name="vehicle_name[]" type="text" value="" class="form-control" placeholder="Enter Customer Vehicle Title">
        </div>
        <div class="form-group col-md-6">
            <label>Vehicle Registration Number</label>
            <input name="reg_number[]" type="text" value="" class="form-control" placeholder="Enter Vehicle Registration">
        </div>
    </div>
</div>


@endsection
@section('scripts')

<script>
    $(document).ready(function(){
        $('#add-more-vehicles').click(function(){
            var html = $('#more_vehicle_fields').html();
            $('#vehicle_fields').append(html);
            $('#remove-fields').show();
        });
        $('#remove-fields').click(function(){
            $('#vehicle_fields').html('');
            $('#remove-fields').hide();
            // $('#remove-fields').attr('display',false);
        });
    });
</script> 
<script>
    $('#cnic').keydown(function(e){
      //allow  backspace, tab, ctrl+A, escape, carriage return
      if (event.keyCode == 8 || event.keyCode == 9 
                        || event.keyCode == 27 || event.keyCode == 13 
                        || (event.keyCode == 65 && event.ctrlKey === true) )
                            return;
      if((event.keyCode < 48 || event.keyCode > 57))
       event.preventDefault();
    
      var length = $(this).val().length; 
                  
      if(length == 5 || length == 13)
       $(this).val($(this).val()+'-');
       if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)) {
        // 0-9 only
        }
     });
</script>
@endsection