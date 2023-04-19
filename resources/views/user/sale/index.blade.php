@extends('user.layout.index')

@section('title')
    Manage Sale
@endsection
@section('content')
<div class="card">
    <div class="card-header header-elements-inline text-right">
        <a href="{{route('user.sale.create')}}" class="btn btn-primary btn-sm text-right">Add New Sale</a>
    </div>
    <table class="table datatable-save-state">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total Amount</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach(Auth::user()->machines->sortBy('product_id') as $index => $machine)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$sale->product->name}}</td>
                <td>PKR {{$sale->price}}</td>
                <td>{{$sale->qty}}</td>
                <td>PKR {{$sale->total_amount}}</td>
                <td>
                    <a href="{{route('user.sale.edit',$sale->id)}}" class="btn btn-primary btn-sm">Edit</a>
                </td>
                <td>
                    <form action="{{route('user.sale.destroy',$sale->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                    <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach --}}
        </tbody>
    </table>
</div>

@endsection
@section('scripts')
@endsection