@extends('user.layout.index')

@section('title')
    Add New Pruchase
@endsection
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('user.purchase.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Products</label>
                            <select class="form-control select-search" name="product_id" id="product_id" required data-fouc>
                                <option value="">Choose Product</option>
                                @foreach(App\Models\Product::whereNull('supplier_id')->whereNull('user_id')->orWhere('user_id',Auth::user()->id)->get() as $product)    
                                <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Purchasing Price</label>
                            <input name="price" id="price" type="text" value="{{old('price')}}" class="form-control" placeholder="Enter Product Price" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Qty</label>
                            <input name="qty" id="qty" type="text" value="{{old('qty')}}" class="form-control" placeholder="Enter Product Quantity" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Total Amount</label>
                            <input name="total_amount" id="total_amount" type="text" value="{{old('total_amount')}}" class="form-control" placeholder="Enter Product Total Amount" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label> Date</label>
                            <input name="date" type="date" id="date"  class="form-control"  required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="checkbox">
                                <label>
                                    <input
                                            name="local_vendor"
                                            type="checkbox"
                                            id="local_vendor"
                                    > Local Vendor 
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-6" id="supplier_field">
                            <label>Supplier</label>
                            <select class="form-control select-search" name="supplier_id"readonly>
                                <option selected value="{{App\Models\Supplier::first()->id}}">{{App\Models\Supplier::first()->name}}</option>
                                
                            </select>
                        </div>
                        <div class="form-group col-md-6 local_vendor_fields" style="display:none;">
                            <label>Vendor</label>
                            <select class="form-control select-search" name="vendor_id" id="vendor_id" data-fouc>
                                <option value="">Choose Vendor</option>
                                @foreach(Auth::user()->vendors as $vendor)    
                                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6 local_vendor_fields" style="display:none;">
                            <label>Vendor Terminal</label>
                            <select class="form-control select-search" name="vendor_terminal_id" id="vendor_terminal_id" data-fouc>
                                <option value="">Choose Vendor Terminal</option>
                            </select>
                        </div>
                    </div>
                    <div class="row local_vendor_fields" style="display:none;">
                        <p><b>Vendor Payments :</b></p>
                        <div class="col-md-12 text-right">
                            <button type="button" id="show_payments" class="btn btn-success btn-sm text-right">Add Payment History</button>
                            <button type="button" id="hide_payment" style="display:none;" class="btn btn-danger btn-sm text-right">Remove Payment History</button>
                        </div>
                    </div>
                    <div class="row" style="display:none;" id="payments_fields">
                        <div class="form-group col-md-6">
                            <label>Vendor Account</label>
                            <select class="form-control select-search" name="vendor_account_id" id="vendor_account_id" >
                                <option value="">Choose Vendor Account</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Amount Pay to Vendor</label>
                            <input name="amount" id="amount" type="text" value="" class="form-control" placeholder="Enter Amoount">
                        </div>
                        {{-- <div class="form-group col-md-6">
                            <label>Image</label>
                            <input name="image" type="file" value="" class="form-control" placeholder="Enter Vendor Account Number">
                        </div> --}}
                    </div>
                    <div class="text-right" style="margin-top:10px;">
                        <button type="submit" class="btn btn-primary">Create <i class="icon-paperplane ml-2"></i></button>
                    </div>
                    
                </form>
            </div>
        </div>
        <!-- /basic layout -->

    </div>
</div>
@endsection
@section('scripts')
@include('user.purchase.partials.js')
<script>
    $(document).ready(function(){
        $('#show_payments').click(function(){
            $('#payments_fields').show();
            $('#hide_payment').show();
            $('#amount').attr('required',true);
            $('#vendor_account_id').attr('required',true);
        });
        $('#hide_payment').click(function(){
            $('#payments_fields').hide();
            $('#hide_payment').hide();
            $('#amount').attr('required',false);
            $('#amount').val('');
            $('#vendor_account_id').attr('required',false);
        });
        $('#local_vendor').change(function(){
            if (this.checked) {
                $('#supplier_field').hide();
                $('.local_vendor_fields').show();
            }else{
                $('.local_vendor_fields').hide();
                $('#supplier_field').show();
            }
        });
        $('#date').change(function(){
            let product_id = $('#product_id').val();
            let date = $(this).val();
            if(product_id == "" || product_id == null)
            {
                alert("Please Select Product First");
            }else{
                $.ajax({
                    url: "{{route('user.purchase.get_product_price')}}",
                    method: 'post',
                    data: {
                        product_id : product_id,
                        date : date,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response){
                        $('#price').val(response.price);
                    }
                });
            }
        });
    });
</script>
@endsection