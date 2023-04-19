@extends('user.layout.index')

@section('title')
    Manage Customers
@endsection
@section('content')
<div class="card">
    <div class="card-header header-elements-inline text-right">
        <a href="{{route('user.customer.create')}}" class="btn btn-primary btn-sm text-right">Add New Customer</a>
    </div>
    <table class="table datatable-save-state">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Cnic</th>
                <th>Phone</th>
                <th>Balance</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach (Auth::user()->customers as $key => $customer)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$customer->name .' S/o '. $customer->father_name}}</td>
                <td>{{$customer->cnic}}</td>
                <td>{{$customer->phone}}</td>
                <td>PKR {{$customer->balance}}</td>
                <td>
                    <a href="{{route('user.customer.edit',$customer->id)}}" class="btn btn-primary btn-sm">Edit</a>
                </td>
                <td>
                    <form action="{{route('user.customer.destroy',$customer->id)}}" method="POST">
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