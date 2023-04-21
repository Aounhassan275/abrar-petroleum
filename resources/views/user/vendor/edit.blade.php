@extends('user.layout.index')

@section('title')
    Edit {{$vendor->name}} Supplier
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('user.vendor.update',$vendor->id)}}" method="post" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Supplier Name</label>
                            <input name="name" type="text" class="form-control" value="{{$vendor->name}}" placeholder="Enter Supplier Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Email</label>
                            <input name="email" type="text" value="{{$vendor->email}}" class="form-control" placeholder="Enter Supplier Email">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Phone</label>
                            <input name="phone" type="text" value="{{$vendor->phone}}" class="form-control" placeholder="Enter Supplier Phone">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Fax</label>
                            <input name="fax" type="text" value="{{$vendor->fax}}" class="form-control" placeholder="Enter Supplier Fax">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Address</label>
                            <input name="address" type="text" value="{{$vendor->address}}" class="form-control" placeholder="Enter Supplier Address">
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
        <h5 class="card-title">{{$vendor->name}} Terminals</h5>
        <div class="header-elements">
            <a href="#add-terminal-modal" data-toggle="modal" data-target="#add-terminal-modal" class="btn btn-primary btn-sm text-right">Add New Terminal</a>
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
                <th colspan="3">Name</th>
                <th>Action</th>
                <th>Action</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach ($vendor->terminals as $key => $terminal)
            <tr>
                <td>{{$key+1}}</td>
                <td colspan="3">{{$terminal->name}}</td>
                
                <td>
                    <button data-toggle="modal" data-target="#edit-terminal-modal" name="{{$terminal->name}}"
                        id="{{$terminal->id}}" class="edit-terminal-btn btn btn-primary">Edit</button>
                </td>
                <td>
                    <form action="{{route('user.vendor_terminal.destroy',$terminal->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">{{$vendor->name}} Accounts</h5>
        <div class="header-elements">
            <a href="#add-account-modal" data-toggle="modal" data-target="#add-account-modal" class="btn btn-primary btn-sm text-right">Add New Bank Account</a>
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
                <th>Title</th>
                <th>Bank</th>
                <th>Number</th>
                <th>Location</th>
                <th>Action</th>
                <th>Action</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach ($vendor->accounts as $key => $account)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$account->title}}</td>
                <td>{{@$account->bank->name}}</td>
                <td>{{$account->number}}</td>
                <td>{{$account->location}}</td>
                
                <td>
                    <button data-toggle="modal" data-target="#edit-account-modal" title="{{$account->title}}"
                        bank_id="{{$account->bank_id}}" number="{{$account->number}}" location="{{$account->location}}" 
                        id="{{$account->id}}" class="edit-account-btn btn btn-primary">Edit</button>
                </td>
                <td>
                    <form action="{{route('user.vendor_account.destroy',$account->id)}}" method="POST">
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
@include('user.vendor.partials.edit-terminal-modal')
@include('user.vendor.partials.add-terminal-modal')
@include('user.vendor.partials.add-account-modal')
@include('user.vendor.partials.edit-account-modal')

@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('.edit-terminal-btn').click(function(){
            let id = $(this).attr('id');
            let name = $(this).attr('name');
            $('#terminal_name').val(name);
            $('#updateForm').attr('action','{{route('user.vendor_terminal.update','')}}' +'/'+id);
        });
        $('.edit-account-btn').click(function(){
            let id = $(this).attr('id');
            let title = $(this).attr('title');
            let bank_id = $(this).attr('bank_id');
            let number = $(this).attr('number');
            let location = $(this).attr('location');
            $('#title').val(title);
            $('#number').val(number);
            $('#bank_id').val(bank_id);
            $('#location').val(location);
            $('#updateFormForAccount').attr('action','{{route('user.vendor_account.update','')}}' +'/'+id);
        });
    });
</script>
@endsection