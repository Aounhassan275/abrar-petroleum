@extends('supplier.layout.index')

@section('title')
    Edit Sale
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('supplier.sale.update',$sale->id)}}" method="post" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Products</label>
                            <select class="form-control select-search" name="product_id" id="product_id" required data-fouc>
                                <option value="">Choose  Product</option>
                                @foreach(App\Models\Product::all() as $product)    
                                <option @if($sale->product_id == $product->id) selected @endif value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Selling Price</label>
                            <input name="price" id="price" type="text" value="{{$sale->price}}" class="form-control" placeholder="Enter Product Price" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Qty</label>
                            <input name="qty" id="qty" type="text" value="{{$sale->qty}}" class="form-control" placeholder="Enter Product Quantity" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Total Amount</label>
                            <input name="total_amount" id="total_amount" type="text" value="{{$sale->total_amount}}" class="form-control" placeholder="Enter Product Total Amount" required readonly>
                        </div>
                        <div class="form-group col-md-6" id="supplier_field">
                            <label>User Sites</label>
                            <select class="form-control select-search" name="user_id" required>
                                <option disabled>Select Site</option>
                                @foreach(App\Models\User::all() as $user)
                                <option @if($sale->user_id == $user->user_id) selected @endif value="{{$user->id}}">{{$user->username}}</option>
                                @endforeach                                
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Edit <i class="icon-paperplane ml-2"></i></button>
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
@endsection