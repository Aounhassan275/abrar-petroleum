@extends('user.layout.index')

@section('title')
    Account Category
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Categories</h6>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-top">
                    @foreach(App\Models\AccountCategory::all() as $key => $category)
                    <li class="nav-item"><a href="#top-tab{{$key}}" @if($active_tab == $category->id) class="nav-link active" @else class="nav-link" @endif data-toggle="tab">{{$category->name}}</a></li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    @foreach(App\Models\AccountCategory::all() as $index => $account_category)
                    <div @if($active_tab == $account_category->id)  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab{{$index}}">
                        <div class="card-body">
                            <form method="GET" id="searchForm">
                                <input type="hidden" name="active_tab" value="{{ $account_category->id}}">
                                <div class="row">
                                    <div class="form-group col-2">
                                        <label>Start Date</label> 
                                            <input type="text" name="start_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                                                value="{{ date('m/d/Y', strtotime(@$start_date))}}">
                                          
                                    </div>
                                    <div class="form-group col-2">
                                        <label>
                                            End Date
                                        </label>   

                                            <input type="text" name="end_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                                                value="{{ date('m/d/Y', strtotime(@$end_date))}}">
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Choose Sub Account</label> 
                                        <select name="sub_account" class="form-control select-search">
                                            <option value="">Select</option>  
                                            @foreach($account_category->debitCreditAccount as $debitSubAccount)
                                            <option @if($sub_account == $debitSubAccount->id) selected @endif value="{{$debitSubAccount->id}}">{{$debitSubAccount->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-2">
                                        <label>Type</label> 
                                        <select name="type" class="form-control select-search">
                                            <option value="By Date">By Date</option>  
                                            <option {{request()->type == "All"?'selected':''}} value="All">All</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-2">
                                        <br>
                                        <button type="submit" id="search-form-btn" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                            @if($sub_account && $active_tab == $account_category->id)
                            @include('user.account_category.partials.debit_credits')
                            @endif
                            @if($account_category->name == "Products")
                                @include('user.product.index')
                            @else
                            <div class="row" style="margin-top:20px!important;">
                                <div class="col-md-12">
                                    <a href="{{route('user.debit_credit_account.create')}}" class="btn btn-primary btn-sm text-right">Add New Account</a>
                                    <table class="table datatable-button-html5-basic">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Designation</th>
                                                <th>Action</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (Auth::user()->debitCreditAccounts->where('account_category_id',$account_category->id) as  $account)
                                            <tr>
                                                <td>{{$account->name}}</td>
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
                            @endif
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Basic layout-->

    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('.edit-btn').click(function(){
            let id = $(this).attr('id');
            let name = $(this).attr('name');
            let purchasing_price = $(this).attr('purchasing_price');
            let selling_price = $(this).attr('selling_price');
            $('#purchasing_price').val(purchasing_price);
            $('#selling_price').val(selling_price);
            $('#name').val(name);
            $('#id').val(id);
            $('#updateForm').attr('action','{{route('user.product.update','')}}' +'/'+id);
        });
        $('.edit-expense-btn').click(function(){
            let id = $(this).attr('id');
            let amount = $(this).attr('amount');
            let expense_type_id = $(this).attr('expense_type_id');
            $('#amount').val(amount);
            $('#expense_type_id').val(expense_type_id);
            $('#updateForm').attr('action','{{route('user.expense.update','')}}' +'/'+id);
        });
    });
    
    jQuery(document).ready(function ($) {
        $('#search-form-btn').on('click', function (event) {
            event.preventDefault();
            $('#search-form-btn').attr('disabled',true).text('Please wait...');
            $('#searchForm').submit();
        });
    });
</script>
@endsection