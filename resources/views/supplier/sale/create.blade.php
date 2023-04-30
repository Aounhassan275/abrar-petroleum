@extends('supplier.layout.index')

@section('title')
    Add New Sale
@endsection
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('supplier.sale.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="supplier_id" value="{{Auth::user()->id}}">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Products</label>
                            <select class="form-control select-search" name="product_id" id="product_id" required data-fouc>
                                <option value="">Choose Product</option>
                                @foreach(App\Models\Product::all() as $product)    
                                <option @if(old('product_id') == $product->id) selected @endif value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Selling Price</label>
                            <input name="price" id="price" type="text" value="{{old('price')}}" class="form-control" placeholder="Enter Product Price" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Qty <span class="badge badge-sm badge-success" id="stocks"></span></label>
                            <input name="qty" id="qty" type="text" value="{{old('qty')}}" class="form-control" placeholder="Enter Product Quantity" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Total Amount</label>
                            <input name="total_amount" id="total_amount" type="text" value="{{old('total_amount')}}" class="form-control" placeholder="Enter Product Total Amount" required readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>User Sites</label>
                            <select class="form-control select-search" name="user_id" required>
                                <option selected disabled>Select Site</option>
                                @foreach(App\Models\User::all() as $user)
                                <option @if(old('user_id') == $user->id) selected @endif value="{{$user->id}}">{{$user->username}}</option>
                                @endforeach                                
                            </select>
                        </div>
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
@include('supplier.sale.partials.js')
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
    });
</script>
@endsection