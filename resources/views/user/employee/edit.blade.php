@extends('user.layout.index')

@section('title')
    Edit {{$employee->name}} Employee
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('user.employee.update',$employee->id)}}" method="post" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Employee Name</label>
                            <input name="name" type="text" class="form-control" value="{{$employee->name}}" placeholder="Enter Employee Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Employee Phone</label>
                            <input name="phone" type="text" value="{{$employee->phone}}" class="form-control" placeholder="Enter Employee Phone" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Employee Address</label>
                            <input name="address" type="text" value="{{$employee->address}}" class="form-control" placeholder="Enter Employee Address" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Employee Designation</label>
                            <input name="designation" type="text" value="{{$employee->designation}}" class="form-control" placeholder="Enter Employee Designation" required>
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

<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{{$customer->name}} Vehicles</h5>
        <div class="header-elements">
            <a href="#add-vehicle-modal" data-toggle="modal" data-target="#add-vehicle-modal" class="btn btn-primary btn-sm text-right">Add New Vehicle</a>
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
                <th>Vehicle Name</th>
                <th>Registration Number</th>
                <th>Action</th>
                <th>Action</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach ($customer->vehicles as $key => $vehicle)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$vehicle->name}}</td>
                <td>{{$vehicle->reg_number}}</td>
                
                <td>
                    <button data-toggle="modal" data-target="#edit-vehicle-modal" name="{{$vehicle->name}}"
                        reg_number="{{$vehicle->reg_number}}"  id="{{$vehicle->id}}" class="edit-vehicle-btn btn btn-primary">Edit</button>
                </td>
                <td>
                    <form action="{{route('user.customer_vehicle.destroy',$vehicle->id)}}" method="POST">
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
<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Customer Transcations</h5>
        <div class="header-elements">
            <a href="#add-transcation-modal" data-toggle="modal" data-target="#add-transcation-modal" class="btn btn-primary btn-sm text-right">Add New Transcation</a>
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
                <th>Image</th>
                <th>Amount</th>
                <th>Type</th>            
            </tr>
        </thead>
        <tbody>
            @foreach ($customer->transcations as $key => $transcation)
            <tr>
                <td>{{$key+1}}</td>
                <td>
                    @if($transcation->image)
                    <img src="{{asset($transcation->image)}}" height="150" width="150" alt="">
                    @endif
                </td>
                <td>PKR {{@$transcation->amount}}</td>
                <td>{{$transcation->type}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('user.customer.partials.edit-vehicle-modal')
@include('user.customer.partials.add-vehicle-modal')
@include('user.customer.partials.add-transcation-modal')

@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('.edit-vehicle-btn').click(function(){
            let id = $(this).attr('id');
            let name = $(this).attr('name');
            let reg_number = $(this).attr('reg_number');
            $('#vehicle_name').val(name);
            $('#reg_number').val(reg_number);
            $('#updateForm').attr('action','{{route('user.customer_vehicle.update','')}}' +'/'+id);
        });
    });
</script>
@endsection