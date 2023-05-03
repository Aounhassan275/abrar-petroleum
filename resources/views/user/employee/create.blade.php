@extends('user.layout.index')
@section('title')
    Add New Employee
@endsection
@section('css')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">
            <div class="card-body">
                <form action="{{route('user.employee.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Employee Name</label>
                            <input name="name" type="text" class="form-control" value="{{old('name')}}" placeholder="Enter Employee Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Employee Phone</label>
                            <input name="phone" type="text" value="{{old('phone')}}" class="form-control" placeholder="Enter Employee Phone" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Employee  Address</label>
                            <input name="address" type="text" value="{{old('address')}}" class="form-control" placeholder="Enter Employee Address" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Employee Designation</label>
                            <input name="designation" type="text" value="{{old('designation')}}" class="form-control" placeholder="Enter Employee Designation" required>
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