@extends('supplier.layout.index')

@section('title')
    Edit Purchase
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('supplier.purchase.update',$purchase->id)}}" method="post" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Products</label>
                            <select class="form-control select-search" name="product_id" id="product_id" required data-fouc>
                                <option value="">Choose  Product</option>
                                @foreach(App\Models\Product::all() as $product)    
                                <option @if($purchase->product_id == $product->id) selected @endif value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Purchasing Price</label>
                            <input name="price" id="price" type="text" value="{{$purchase->price}}" class="form-control" placeholder="Enter Product Price" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Qty</label>
                            <input name="qty" id="qty" type="text" value="{{$purchase->qty}}" class="form-control" placeholder="Enter Product Quantity" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Total Amount</label>
                            <input name="total_amount" id="total_amount" type="text" value="{{$purchase->total_amount}}" class="form-control" placeholder="Enter Product Total Amount" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Access</label>
                            <input name="access" id="access" value="0" type="text" value="{{$purchase->access}}" class="form-control" placeholder="Enter Product Access" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Vehicle</label>
                            <select class="form-control select-search" name="supplier_vehicle_id" required>
                                <option selected disabled>Select Vehicle</option>
                                @foreach(Auth::user()->vehicles as $vehicle)
                                <option @if($purchase->supplier_vehicle_id == $vehicle->id) selected @endif value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                                @endforeach                                
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Terminal</label>
                            <select class="form-control select-search" name="supplier_terminal_id" required>
                                <option selected disabled>Select Terminal</option>
                                @foreach(Auth::user()->terminals as $terminal)
                                <option @if($purchase->supplier_terminal_id == $terminal->id) selected @endif value="{{$terminal->id}}">{{$terminal->name}}</option>
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
@include('supplier.purchase.partials.js')
@endsection