@extends('user.layout.index')

@section('title')
    Edit {{$customer->name}} Customer
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('user.customer.update',$customer->id)}}" method="post" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Customer Name</label>
                            <input name="name" type="text" class="form-control" value="{{$customer->name}}" placeholder="Enter Customer Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Father Name</label>
                            <input name="father_name" type="text" value="{{$customer->father_name}}" class="form-control" placeholder="Enter Customer Father Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Cnic</label>
                            <input name="cnic"  maxlength="15" minlength="15" id="cnic" type="text" value="{{$customer->cnic}}" class="form-control"  placeholder="XXXXX-XXXXXXX-X" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Phone</label>
                            <input name="phone" type="text" value="{{$customer->phone}}" class="form-control" placeholder="Enter Customer Phone" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer  Address</label>
                            <input name="address" type="text" value="{{$customer->address}}" class="form-control" placeholder="Enter Customer Address" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Opening Balance</label>
                            <input name="balance" type="text" value="{{$customer->balance}}" class="form-control" readonly placeholder="Enter Customer Balance" required>
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
                <td>{{@$transcation->amount}}</td>
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