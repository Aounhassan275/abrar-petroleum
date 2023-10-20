@extends('user.layout.index')

@section('title')
    Manage Customer Vehicle
@endsection
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <a href="{{route('user.customer_vehicle.create')}}" class="btn btn-primary btn-sm text-right">Add New Customer Vehicle</a>
                <table class="table datatable-button-html5-basic">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vehicle Name</th>
                            <th>Reg Number</th>
                            <th>Debit Credit Account</th>
                            <th>Action</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Auth::user()->customerVehicles as $key => $customer_vehicle)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$customer_vehicle->name}}</td>
                            <td>{{$customer_vehicle->reg_number}}</td>
                            <td>{{@$customer_vehicle->debit_credit_account->name}}</td>
                            <td>
                                <a href="{{route('user.customer_vehicle.edit',$customer_vehicle->id)}}" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                            <td>
                                <form action="{{route('user.customer_vehicle.destroy',$customer_vehicle->id)}}" method="POST">
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
        </div>
    </div>
</div>
@endsection 
