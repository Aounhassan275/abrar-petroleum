@extends('user.layout.index')

@section('title')
    Manage Expenses
@endsection
@section('content')

<div class="card">
    
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Expenses</h5>
        <div class="header-elements">
            <a href="#add-expense-modal" data-toggle="modal" data-target="#add-expense-modal" class="btn btn-primary btn-sm text-right">Add New Expense</a>
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
                <th>Amount</th>
                <th>Type</th>
                <th>User</th>
                <th>Action</th>
                <th>Action</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach (Auth::user()->expenses as $key => $expense)
            <tr>
                <td>{{$key+1}}</td>
                <td>PKR {{$expense->amount}}</td>
                <td>{{@$expense->type->name}}</td>
                <td>{{@$expense->user->username}}</td>
                
                <td>
                    <button data-toggle="modal" data-target="#edit-expense-modal" 
                        amount="{{$expense->amount}}"
                        expense_type_id="{{$expense->expense_type_id}}"  
                        id="{{$expense->id}}" class="edit-expense-btn btn btn-primary">Edit</button>
                </td>
                <td>
                    <form action="{{route('user.expense.destroy',$expense->id)}}" method="POST">
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
@include('user.expense.partials.add-expense-modal')
@include('user.expense.partials.edit-expense-modal')

@endsection
@section('scripts')
<script>
    $('.edit-expense-btn').click(function(){
            let id = $(this).attr('id');
            let amount = $(this).attr('amount');
            let expense_type_id = $(this).attr('expense_type_id');
            $('#amount').val(amount);
            $('#expense_type_id').val(expense_type_id);
            $('#updateForm').attr('action','{{route('user.expense.update','')}}' +'/'+id);
        });
</script>
@endsection