@extends('user.layout.index')

@section('title')
    Manage Purchase or Add Access
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
@endsection
@section('content')
<div class="card">
    <div class="card-header header-elements-inline text-right">
        <a href="{{route('user.purchase.create')}}" class="btn btn-primary btn-sm text-right">Add New Purchase</a>
    </div>
    <div class="card-body">
        
    <form method="GET" id="searchForm">
        <div class="row">
            <div class="form-group col-2" >
                <label>
                    Date
                </label>   
                <input type="text" name="date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                        value="{{ date('m/d/Y', strtotime(@$date))}}">
            </div>
            <div class="form-group col-3">
                <label>Choose Product</label> 
                <select name="product_id" class="form-control select-search">
                    <option value="">Select</option>  
                    @foreach(App\Models\Product::whereNull('user_id')->orWhere('user_id',Auth::user()->id)->get() as $product)    
                    <option {{@request()->product_id == $product->id ? 'selected' : ''}} value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-2">
                <br>
                <button type="submit" id="search-form-btn" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
    <table class="table datatable-button-html5-basic">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Access</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchases as $key => $purchase)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{@$purchase->product->name}}</td>
                <td>{{$purchase->price}}</td>
                <td>{{$purchase->qty}}</td>
                <td>{{$purchase->access}}</td>
                <td>{{$purchase->total_amount}}</td>
                <td>{{$purchase->date?Carbon\Carbon::parse(@$purchase->date)->format('Y-m-d'):''}}</td>
                <td>
                    <a href="{{route('user.purchase.edit',$purchase->id)}}" class="btn btn-primary btn-sm">Edit</a>
                </td>
                <td>
                    <form action="{{route('user.purchase.destroy',$purchase->id)}}" method="POST">
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
</div>

@endsection
@section('scripts')
@endsection