@extends('user.layout.index')

@section('title')
    Manage Purchase or Add Access
@endsection
@section('content')
<div class="card">
    <div class="card-header header-elements-inline text-right">
        <a href="{{route('user.purchase.create')}}" class="btn btn-primary btn-sm text-right">Add New Purchase</a>
    </div>
    <table class="table datatable-button-html5-basic">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Access</th>
                <th>Total Amount</th>
                <th>Vendor Name</th>
                <th>Vendor Terminal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach (Auth::user()->purchases as $key => $purchase)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{@$purchase->product->name}}</td>
                <td>{{$purchase->price}}</td>
                <td>{{$purchase->qty}}</td>
                <td>{{$purchase->access}}</td>
                <td>{{$purchase->total_amount}}</td>
                <td>{{@$purchase->vendor->name}}</td>
                <td>{{@$purchase->terminal->name}}</td>
                <td>
                    <a href="{{route('user.purchase.edit',$purchase->id)}}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
@section('scripts')
@endsection