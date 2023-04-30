@extends('supplier.layout.index')

@section('title')
    Manage Supplier Terminal
@endsection
@section('content')

<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Supplier Terminal</h5>
        <div class="header-elements">
            <a href="#add-terminal-modal" data-toggle="modal" data-target="#add-terminal-modal" class="btn btn-primary btn-sm text-right">Add New Supplier Terminal</a>
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
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Fax</th>
                <th>Action</th>
                <th>Action</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach (Auth::user()->terminals as $key => $terminal)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$terminal->name}}</td>
                <td>{{$terminal->email}}</td>
                <td>{{@$terminal->phone}}</td>
                <td>{{@$terminal->address}}</td>
                <td>{{@$terminal->fax}}</td>
                <td>
                    <button data-toggle="modal" data-target="#edit-terminal-modal" name="{{$terminal->name}}"
                        email="{{$terminal->email}}" phone="{{$terminal->phone}}" address="{{$terminal->address}}" 
                        fax="{{$terminal->fax}}" id="{{$terminal->id}}" class="edit-terminal-btn btn btn-primary">Edit</button>
                </td>
                <td>
                    <form action="{{route('supplier.terminal.destroy',$terminal->id)}}" method="POST">
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
@include('supplier.terminal.partials.add-terminal-modal')
@include('supplier.terminal.partials.edit-terminal-modal')

@endsection
@section('scripts')
<script>
    
    $('.edit-terminal-btn').click(function(){
            let id = $(this).attr('id');
            let name = $(this).attr('name');
            let email = $(this).attr('email');
            let phone = $(this).attr('phone');
            let address = $(this).attr('address');
            let fax = $(this).attr('fax');
            $('#name').val(name);
            $('#email').val(email);
            $('#phone').val(phone);
            $('#address').val(address);
            $('#fax').val(fax);
            $('#updateFormForTerminal').attr('action','{{route('supplier.terminal.update','')}}' +'/'+id);
        });
</script>
@endsection