@extends('supplier.layout.index')

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
                <form action="{{route('supplier.purchase.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="supplier_id" value="{{Auth::user()->id}}">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Products</label>
                            <select class="form-control select-search" name="product_id" id="product_id" required data-fouc>
                                <option value="">Choose Product</option>
                                @foreach(App\Models\Product::whereNull('user_id')->orWhere('supplier_id',Auth::user()->id)->get() as $product)    
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
                            <label>Product Access</label>
                            <input name="access" id="access" value="0" type="text" value="{{old('access')}}" class="form-control" placeholder="Enter Product Access" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Vehicle</label>
                            <select class="form-control select-search" name="supplier_vehicle_id" required>
                                <option selected disabled>Select Vehicle</option>
                                @foreach(Auth::user()->vehicles as $vehicle)
                                <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                                @endforeach                                
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Terminal</label>
                            <select class="form-control select-search" name="supplier_terminal_id" required>
                                <option selected disabled>Select Terminal</option>
                                @foreach(Auth::user()->terminals as $terminal)
                                <option value="{{$terminal->id}}">{{$terminal->name}}</option>
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
@include('supplier.purchase.partials.js')

@endsection