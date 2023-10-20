@extends('user.layout.index')

@section('title')
    Edit {{$customer_vehicle->name}} Customer Vehicle
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('user.customer_vehicle.update',$customer_vehicle->id)}}" method="post" enctype="multipart/form-data" >
                    @method('PUT')
                    @csrf<div class="row">
                        <div class="form-group col-md-6">
                            <label>Customer Account</label>
                            <select class="form-control select-search" name="debit_credit_account_id" id="debit_credit_account_id" required data-fouc>
                                <option value="">Choose Debit Credit Account</option>
                                @foreach(App\Models\DebitCreditAccount::where('user_id',Auth::user()->id)->get() as $account)    
                                <option {{$customer_vehicle->debit_credit_account_id == $account->id ? 'selected' : ''}} value="{{$account->id}}">{{$account->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Customer Vehicle Title</label>
                            <input name="name" type="text" value="{{$customer_vehicle->name}}" class="form-control" placeholder="Enter Customer Vehicle Title">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Vehicle Registration Number</label>
                            <input name="reg_number" type="text" value="{{$customer_vehicle->reg_number}}" class="form-control" placeholder="Enter Vehicle Registration">
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