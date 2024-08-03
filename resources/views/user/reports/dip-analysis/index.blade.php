@extends('user.layout.index')

@section('title')
   Dip Analysis Reports
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Dip Analysis Reports</h6>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form method="GET">
                    <div class="row">
                        <div class="form-group col-2">
                            <label>
                                Date
                
                                <input type="text" name="end_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                                    value="{{ date('m/d/Y', strtotime(@$end_date))}}">
                            </label>   
                        </div>
                        <div class="form-group col-3">
                            <label>Choose Product 
                            <select name="product_id" class="form-control select-search">
                                <option value="">Select</option>  
                                @foreach(App\Models\Product::whereIn('name',['HSD','PMG'])->get() as $user_product)    
                                <option {{$product->id == $user_product->id ? 'selected' : ''}} value="{{$user_product->id}}">{{$user_product->name}}</option>
                                @endforeach
                            </select></label>
                        </div>
                        <div class="form-group col-2">
                            <br>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-6 col-xl-6">
                        <div class="card card-body bg-teal-400 has-bg-image">
                            <div class="media">
                
                                <div class="mr-3 align-self-center">
                                    <i class="icon-stack2 icon-3x opacity-75"></i>
                                </div>
                                <div class="media-body text-right">
                                <h3 class="mb-0">{{$totalDips->sum('dip')}}</h3>
                                    <span class="text-uppercase font-size-xs">Total Dip</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table datatable-button-html5-basic">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Dip</th>
                            <th>Access</th>
                            <th>Total Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($totalDips as $key => $purchase)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{@$purchase->product->name}}</td>
                            <td>{{$purchase->price}}</td>
                            <td>{{$purchase->qty}}</td>
                            <td>{{$purchase->dip}}</td>
                            <td>{{$purchase->access}}</td>
                            <td>{{$purchase->total_amount}}</td>
                            <td>{{$purchase->date?Carbon\Carbon::parse(@$purchase->date)->format('Y-m-d'):''}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Basic layout-->

    </div>
</div>
@endsection
@section('scripts')
@endsection