@extends('supplier.layout.index')

@section('title')
    Add New Sale
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
@endsection
@section('content')
{{-- @include('supplier.sale.partials.detail') --}}
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
                    <li class="nav-item"><a href="#top-tab2" @if($active_tab == 'diesel') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Diesel</a></li>
                    <li class="nav-item"><a href="#top-tab1" @if($active_tab == 'petrol') class="nav-link active" @else class="nav-link" @endif data-toggle="tab">Petrol</a></li>
                    <li class="nav-item"><a href="#top-tab3" @if($active_tab == 'misc') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Misc. Products</a></li>
                    <li class="nav-item"><a href="#top-tab4" @if($active_tab == 'sale_detail') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Sales Detail</a></li>
                    <li class="nav-item"><a href="#top-tab5" @if($active_tab == 'debit_credit') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Debit Credit</a></li>
                    <li class="nav-item"><a href="#top-tab6" @if($active_tab == 'debit_credit_missing') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Debit Credit Missing ({{$missing_debit_credits->count()}})</a></li>
                </ul>

                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{$nextUrl}}" class="btn btn-primary btn-sm float-right">Next Date</a>
                            <a href="{{$previousUrl}}" class="btn btn-secondary btn-sm float-right mr-2">Previous Date</a>
                        </div>
                    </div>
                    <div @if($active_tab == 'petrol')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab1">
                        <div class="card-body">
                            @if(Auth::user()->haveSale($date,$petrol)->count() > 0)
                                @include('supplier.sale.partials.petrol_sale_update')
                            @else 
                                @include('supplier.sale.partials.petrol_sale')
                            @endif
                        </div>

                    </div>

                    <div  @if($active_tab == 'diesel')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab2">
                        <div class="card-body">
                            @if(Auth::user()->haveSale($date,$diesel)->count() > 0)
                                @include('supplier.sale.partials.diesel_sale_update')
                            @else 
                                @include('supplier.sale.partials.diesel_sale')
                            @endif
                        </div>

                    </div>

                    <div @if($active_tab == 'misc')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab3">
                        
                        @if(Auth::user()->haveSale($date)->count() > 0)
                            @include('supplier.sale.partials.misc_sale_update')
                        @else 
                            @include('supplier.sale.partials.misc_sale')
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
                            @include('supplier.sale.partials.sale_detail',[
                                'petrol' => $petrol,
                                'diesel' => $diesel,
                                'date' => $date,
                            ])
                        </div>
                    </div>

                    <div @if($active_tab == 'debit_credit')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab5">
                        
                        @if(Auth::user()->haveDebitCredit($date)->count() > 0)
                            @include('supplier.sale.partials.debit_credit_update')
                        @else 
                            @include('supplier.sale.partials.debit_credit_store')
                        @endif
                    </div>
                    <div @if($active_tab == 'debit_credit_missing')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab6">
                            @include('supplier.sale.partials.debit_credit_missing')
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic layout-->

    </div>
</div>
@include('supplier.sale.partials.add-purchase-modal')
@include('supplier.sale.partials.delete-confirmation-modal')
@endsection
@section('scripts')
@include('supplier.sale.partials.js')
@include('supplier.sale.partials.debit_credit_js')
@endsection