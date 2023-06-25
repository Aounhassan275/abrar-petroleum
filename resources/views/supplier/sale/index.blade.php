@extends('supplier.layout.index')

@section('title')
    Manage Sale
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Product Sales</h6>
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
                    <li class="nav-item"><a href="#top-tab1" @if($active_tab == 'purchase') class="nav-link active" @else class="nav-link" @endif data-toggle="tab">Purchase</a></li>
                    <li class="nav-item"><a href="#top-tab2" @if($active_tab == 'sale') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Sale</a></li>
                    <li class="nav-item"><a href="#top-tab3" @if($active_tab == 'debit_credit') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Debit Credit</a></li>
                    <li class="nav-item"><a href="#top-tab4" @if($active_tab == 'debit_credit_missing') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Debit Credit Missing ({{$missing_debit_credits->count()}})</a></li>
                </ul>

                <div class="tab-content">
                    <div @if($active_tab == 'petrol')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab1">
                        <div class="card-body">
                            @if(Auth::user()->haveSale($date,$petrol)->count() > 0)
                                @include('user.sale.partials.sale_petrol_delete')
                                @include('user.sale.partials.petrol_sale_update')
                            @else 
                                @include('user.sale.partials.petrol_sale')
                            @endif
                        </div>

                    </div>

                    <div  @if($active_tab == 'diesel')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab2">
                        <div class="card-body">
                            @if(Auth::user()->haveSale($date,$diesel)->count() > 0)
                                @include('user.sale.partials.sale_diesel_delete')
                                @include('user.sale.partials.diesel_sale_update')
                            @else 
                            @include('user.sale.partials.diesel_sale')
                            @endif
                        </div>

                    </div>

                    <div @if($active_tab == 'misc')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab3">
                        
                        @if(Auth::user()->haveSale($date)->count() > 0)
                            @include('user.sale.partials.misc_sale_update')
                        @else 
                            @include('user.sale.partials.misc_sale')
                        @endif
                    </div>

                    <div @if($active_tab == 'sale_detail')  class="tab-pane fade show active" @else class="tab-pane fade" @endif class="tab-pane fade" id="top-tab4">
                        <div class="form-group col-4">
                            <label>
                                Date
                                <input type="text"  id="sale_detail_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                                       value="{{ date('m/d/Y', strtotime(@$date))}}">
                            </label>   
                        </div>
                        <div id="sale-detail">
                            @include('user.sale.partials.sale_detail',[
                                'petrol' => $petrol,
                                'diesel' => $diesel,
                                'date' => $date,
                            ])
                        </div>
                    </div>

                    <div @if($active_tab == 'debit_credit')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab5">
                        
                        @if(Auth::user()->haveDebitCredit($date)->count() > 0)
                            @include('user.sale.partials.debit_credit_update')
                        @else 
                            @include('user.sale.partials.debit_credit_store')
                        @endif
                    </div>
                    <div @if($active_tab == 'debit_credit_missing')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab6">
                            @include('user.sale.partials.debit_credit_missing')
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic layout-->

    </div>
</div>
{{-- <div class="card">
    <div class="card-header header-elements-inline text-right">
        <a href="{{route('supplier.sale.create')}}" class="btn btn-primary btn-sm text-right">Add New Sale</a>
    </div>
    <table class="table datatable-button-html5-basic">
        <thead>
            <tr>
                <th>#</th>
                <th>Site</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach (Auth::user()->sales as $key => $sale)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{@$sale->site->username}}</td>
                <td>{{@$sale->product->name}}</td>
                <td>{{$sale->price}}</td>
                <td>{{$sale->qty}}</td>
                <td>{{$sale->total_amount}}</td>
                <td>{{$sale->created_at->format('d M,Y')}}</td>
                <td>
                    <a href="{{route('supplier.sale.edit',$sale->id)}}" class="btn btn-primary btn-sm">Edit</a>
                </td>
                <td>
                    <form action="{{route('supplier.sale.destroy',$sale->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                    <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}

@endsection
@section('scripts')
@endsection