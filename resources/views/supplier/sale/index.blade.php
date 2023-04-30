@extends('supplier.layout.index')

@section('title')
    Manage Sale
@endsection
@section('content')
<div class="card">
    <div class="card-header header-elements-inline text-right">
        <a href="{{route('supplier.sale.create')}}" class="btn btn-primary btn-sm text-right">Add New Sale</a>
    </div>
    <table class="table datatable-button-html5-basic">
        <thead>
            <tr>
                <th>#</th>
                <th>Site</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach (Auth::user()->sales as $key => $sale)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{@$sale->site->username}}</td>
                <td>{{@$sale->product->name}}</td>
                <td>PKR {{$sale->price}}</td>
                <td>{{$sale->qty}}</td>
                <td>PKR {{$sale->total_amount}}</td>
                <td>{{$sale->created_at->format('d M,Y')}}</td>
                <td>
                    <a href="{{route('supplier.sale.edit',$sale->id)}}" class="btn btn-primary btn-sm">Edit</a>
                </td>
                <td>
                    <form action="{{route('supplier.sale.destroy',$sale->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                    <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
@section('scripts')
@endsection