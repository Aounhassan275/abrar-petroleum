@extends('supplier.layout.index')

@section('title')
    Manage Supplier Vehicle
@endsection
@section('content')

<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Supplier Vehicle</h5>
        <div class="header-elements">
            <a href="#add-vehicle-modal" data-toggle="modal" data-target="#add-vehicle-modal" class="btn btn-primary btn-sm text-right">Add New Supplier Vehicle</a>
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
                <th>Name</th>
                <th>Number</th>
                <th>Description</th>
                <th>Action</th>
                <th>Action</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach (Auth::user()->vehicles as $key => $vehicle)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$vehicle->name}}</td>
                <td>{{$vehicle->number}}</td>
                <td>{{@$vehicle->description}}</td>
                <td>
                    <button data-toggle="modal" data-target="#edit-vehicle-modal" name="{{$vehicle->name}}"
                        number="{{$vehicle->number}}" description="{{$vehicle->description}}"  
                        id="{{$vehicle->id}}" class="edit-vehicle-btn btn btn-primary">Edit</button>
                </td>
                <td>
                    <form action="{{route('supplier.vehicle.destroy',$vehicle->id)}}" method="POST">
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
@include('supplier.vehicle.partials.add-vehicle-modal')
@include('supplier.vehicle.partials.edit-vehicle-modal')

@endsection
@section('scripts')
<script>
    
    $('.edit-vehicle-btn').click(function(){
            let id = $(this).attr('id');
            let name = $(this).attr('name');
            let number = $(this).attr('number');
            let description = $(this).attr('description');
            $('#name').val(name);
            $('#number').val(number);
            $('#description').val(description);
            $('#updateFormForVehicle').attr('action','{{route('supplier.vehicle.update','')}}' +'/'+id);
        });
</script>
@endsection