@extends('user.layout.index')

@section('title')
    Manage Machines
@endsection
@section('content')

<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Machines</h5>
        <div class="header-elements">
            <a href="#add-machine-modal" data-toggle="modal" data-target="#add-machine-modal" class="btn btn-primary btn-sm text-right">Add New Machine</a>
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
                <th>Boot Number</th>
                <th>Meter Reading Per Unit</th>
                <th>Type</th>
                <th>Action</th>
                <th>Action</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach (Auth::user()->machines as $key => $machine)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$machine->boot_number}}</td>
                <td>{{$machine->meter_reading}}</td>
                <td>{{$machine->product->name}}</td>
                
                <td>
                    <button data-toggle="modal" data-target="#edit-machine-modal" boot_number="{{$machine->boot_number}}"
                        meter_reading="{{$machine->meter_reading}}" type="{{$machine->type}}"  
                        id="{{$machine->id}}" class="edit-account-btn btn btn-primary">Edit</button>
                </td>
                <td>
                    <form action="{{route('user.machine.destroy',$machine->id)}}" method="POST">
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
@include('user.machine.partials.add-machine-modal')
@include('user.machine.partials.edit-machine-modal')

@endsection
@section('scripts')
<script>
    
    // $('.edit-account-btn').click(function(){
    //         let id = $(this).attr('id');
    //         let title = $(this).attr('title');
    //         let bank_id = $(this).attr('bank_id');
    //         let number = $(this).attr('number');
    //         let location = $(this).attr('location');
    //         $('#title').val(title);
    //         $('#number').val(number);
    //         $('#bank_id').val(bank_id);
    //         $('#location').val(location);
    //         $('#updateFormForAccount').attr('action','{{route('user.bank_account.update','')}}' +'/'+id);
    //     });
</script>
@endsection