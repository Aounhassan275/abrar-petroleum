@extends('user.layout.index')

@section('title')
    Edit Sale
@endsection
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('user.sale.update',$sale->id)}}" method="post" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Products</label>
                            <select class="form-control select-search" name="product_id" id="product_id" required>
                                <option value="">Choose  Product</option>
                                @foreach(App\Models\Product::all() as $product)    
                                <option @if($sale->product_id == $sale->id) selected @endif value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Selling Price</label>
                            <input name="price" id="price" type="text" value="{{$sale->price}}" class="form-control" placeholder="Enter Product Price" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Type</label>
                            <select class="form-control select-search" name="type" id="type" required >
                                <option value="">Choose  Type</option>
                                <option @if($sale->type == 'retail_sale') selected @endif value="retail_sale">Retail Sale</option>
                                <option @if($sale->type == 'test') selected @endif value="test">Test</option>
                                <option @if($sale->type == 'whole_sale') selected @endif value="whole_sale">Whole Sale</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Sale modes</label>
                            <select class="form-control select-search" name="sale_mode" id="sale_modes" required >
                                <option value="">Choose  Sale Mode</option>
                                <option  @if($sale->sale_mode == 'Cash') selected @endif value="Cash">Cash</option>
                                <option  @if($sale->sale_mode == 'Debit') selected @endif value="Debit">Debit</option>
                                <option  @if($sale->sale_mode == 'Credit') selected @endif value="Credit">Credit</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 machine_fields" @if($sale->type == 'whole_sale') style="display:none;" @endif>
                            <label>Machine</label>
                            <select class="form-control select-search" name="machine_id" id="machine_id" required >
                                <option value="">Choose  Machine</option>
                                @foreach(Auth::user()->machines as $machine)    
                                <option @if($sale->machine_id == $machine->id) selected @endif value="{{$machine->id}}">Boot Number # {{$machine->boot_number}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6 machine_fields" @if($sale->type == 'whole_sale') style="display:none;" @endif>
                            <label>Machine Previous Meter Reading</label>
                            <input name="previous_reading" id="previous_reading" type="text" value="{{$sale->previous_reading}}" class="form-control" placeholder="" required readonly>
                        </div>
                        <div class="form-group col-md-6 machine_fields" @if($sale->type == 'whole_sale') style="display:none;" @endif>
                            <label>Machine Current Meter Reading</label>
                            <input name="current_reading" id="current_reading" value="{{$sale->current_reading}}"  type="text" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Qty</label>
                            <input name="qty" id="qty" type="text" value="{{$sale->qty}}" class="form-control" placeholder="Enter Product Quantity" required  @if($sale->type != 'whole_sale') readonly @endif>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Total Amount</label>
                            <input name="total_amount" id="total_amount" type="text" value="{{$sale->total_amount}}" class="form-control" placeholder="Enter Product Total Amount" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer</label>
                            <select class="form-control select-search" name="customer_id" id="customer_id" >
                                <option value="">Choose  Customer</option>
                                @foreach(Auth::user()->customers as $customer)
                                <option @if($sale->customer_id == $customer->id) selected @endif value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6 customer_fields" @if(!$sale->customer_id) style="display:none;" @endif>
                            <label>Customer Vehicle</label>
                            <select class="form-control select-search" name="customer_vehicle_id" id="customer_vehicle_id" >
                                <option value="">Choose  Customer Vehicle</option>
                                @if($sale->customer)
                                @foreach($sale->customer->vehicles as $vehicle)
                                <option @if($sale->customer_vehicle_id == $vehicle->id) selected @endif value="{{$vehicle->id}}">{{$vehicle->name}} - {{$vehicle->reg_number}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="text-right" style="margin-top:10px;">
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
@include('user.sale.partials.js')
@endsection