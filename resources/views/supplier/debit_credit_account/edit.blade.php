@extends('supplier.layout.index')

@section('title')
    Edit {{$account->name}} Employee
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('supplier.debit_credit_account.update',$account->id)}}" method="post" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Name</label>
                            <input name="name" type="text" class="form-control" value="{{$account->name}}" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phone</label>
                            <input name="phone" type="text" value="{{$account->phone}}" class="form-control" placeholder="Enter Phone" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Address</label>
                            <input name="address" type="text" value="{{$account->address}}" class="form-control" placeholder="Enter Address" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Designation</label>
                            <input name="designation" type="text" value="{{$account->designation}}" class="form-control" placeholder="Enter Designation" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Display Order</label>
                            <input name="display_order" type="number" value="{{$account->display_order}}" class="form-control" placeholder="Enter Display Order" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Account Categories</label>
                            <select class="form-control select-search" name="account_category_id" required>
                                <option value="">Choose Type</option>
                                @foreach(App\Models\AccountCategory::all() as $category)
                                <option @if($account->account_category_id == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
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


@endsection
@section('scripts')
@endsection