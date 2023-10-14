
@extends('user.layout.index')

@section('title')
  Debit Credit Accounts
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Debit Credit Accounts</h6>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row" style="margin-top:20px!important;">
                    <div class="col-md-12">
                        <a href="{{route('user.debit_credit_account.create')}}" class="btn btn-primary btn-sm float-right">Add New Account</a>
                    </div>
                    <div class="col-md-12">
                        
                        <table class="table datatable-button-html5-basic">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Designation</th>
                                    <th>Action</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Auth::user()->debitCreditAccounts as  $account)
                                <tr>
                                    <td>{{$account->name}}</td>
                                    <td>{{$account->accountCategory->name}}</td>
                                    <td>{{$account->phone}}</td>
                                    <td>{{$account->address}}</td>
                                    <td>{{@$account->designation}}</td>
                                    <td>
                                        <a href="{{route('user.debit_credit_account.edit',$account->id)}}" class="btn btn-primary btn-sm">Edit</a>
                                    </td>
                                    <td>
                                        <form action="{{route('user.debit_credit_account.destroy',$account->id)}}" method="POST">
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
    </div>
</div>
@endsection