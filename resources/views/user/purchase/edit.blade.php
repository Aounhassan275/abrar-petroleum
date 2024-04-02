@extends('user.layout.index')

@section('title')
    Edit Purchase
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('user.purchase.update',$purchase->id)}}" method="post" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Products</label>
                            <select class="form-control select-search" name="product_id" readonly id="product_id" required data-fouc>
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
                            <label>Product Access</label>
                            <input name="access" type="text" value="{{$purchase->access}}" class="form-control" placeholder="Enter Product Access" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Total Amount</label>
                            <input name="total_amount" id="total_amount" type="text" value="{{$purchase->total_amount}}" class="form-control" placeholder="Enter Product Total Amount" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label> Date</label>
                            <input name="date" type="date"  class="form-control" value="{{$purchase->date?Carbon\Carbon::parse($purchase->date)->format('Y-m-d'):''}}"  required>
                        </div>
                        @if($purchase->vendor)
                        <div class="form-group col-md-6">
                            <label>Vendor</label>
                            <select class="form-control select-search" name="vendor_id" id="vendor_id" required data-fouc>
                                <option value="">Choose  Vendor</option>
                                @foreach(Auth::user()->vendors as $vendor)    
                                <option @if($purchase->vendor_id == $vendor->id) selected @endif value="{{$vendor->id}}">{{$vendor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Vendor Terminal</label>
                            <select class="form-control select-search" name="vendor_terminal_id" id="vendor_terminal_id" required data-fouc>
                                @if($purchase->vendor)
                                @foreach($purchase->vendor->terminals as $terminal)    
                                <option @if($purchase->vendor_terminal_id == $terminal->id) selected @endif value="{{$terminal->id}}">{{$terminal->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @else 
                        <div class="form-group col-md-6" id="supplier_field">
                            <label>Supplier</label>
                            <select class="form-control select-search" name="supplier_id" readonly>
                                <option selected value="{{App\Models\Supplier::first()->id}}">{{App\Models\Supplier::first()->name}}</option>
                                
                            </select>
                        </div>

                        @endif
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
@if($purchase->vendor)
<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Payment History</h5>
        <div class="header-elements">
            <a href="#add-payment-modal" data-toggle="modal" data-target="#add-payment-modal" class="btn btn-primary btn-sm text-right">Add New Payment</a>
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>
    <table class="table datatable-save-state">
        <thead>
            <tr>
                <th>#</th>
                <th>Transcation Image</th>
                <th>Vendor Account Title</th>
                <th>Date</th>
                <th>Amount</th>
                {{-- <th>Action</th> --}}
                <th>Action</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach ($purchase->payments as $key => $payment)
            <tr>
                <td>{{$key+1}}</td>
                <td>
                    @if($payment->image)
                    <img src="{{asset($payment->image)}}" height="150" width="150">
                    @endif
                </td>
                <td >{{$payment->vendorAccount->title}}</td>
                <td >{{$payment->date->format('Y-m-d')}}</td>
                <td>{{$payment->amount}}</td>
                <td>
                    <form action="{{route('user.purchase_payment.destroy',$payment->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('user.purchase.partials.add-payment-modal')
@endif
@endsection
@section('scripts')
@include('user.purchase.partials.js')
@endsection