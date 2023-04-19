@extends('user.layout.index')

@section('title')
    Manage Machine
@endsection
@section('content')

<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Machines</h5>
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
            @foreach (Auth::user()->accounts as $key => $account)
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
                    <form action="{{route('user.bank_account.destroy',$account->id)}}" method="POST">
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
@include('user.bank_account.partials.add-account-modal')
@include('user.bank_account.partials.edit-account-modal')

@endsection
@section('scripts')
<script>
    
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
            $('#updateFormForAccount').attr('action','{{route('user.bank_account.update','')}}' +'/'+id);
        });
</script>
@endsection