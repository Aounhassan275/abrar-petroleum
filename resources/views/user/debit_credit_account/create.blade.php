@extends('user.layout.index')
@section('title')
    Add New Account
@endsection
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">
            <div class="card-body">
                <form action="{{route('user.debit_credit_account.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Name</label>
                            <input name="name" type="text" class="form-control" value="{{old('name')}}" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label> Phone</label>
                            <input name="phone" type="text" value="{{old('phone')}}" class="form-control" placeholder="Enter  Phone" >
                        </div>
                        <div class="form-group col-md-6">
                            <label> Address</label>
                            <input name="address" type="text" value="{{old('address')}}" class="form-control" placeholder="Enter Address" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Designation</label>
                            <input name="designation" type="text" value="{{old('designation')}}" class="form-control" placeholder="Enter Designation" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Display Order</label>
                            <input name="display_order" type="number" value="{{old('display_order')}}" class="form-control" placeholder="Enter Display Order" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Account Categories</label>
                            <select class="form-control select-search" name="account_category_id" required>
                                <option value="">Choose Type</option>
                                @foreach(App\Models\AccountCategory::all() as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Create <i class="icon-paperplane ml-2"></i></button>
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