@extends('supplier.layout.index')

@section('title')
    Add New Sale
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
<style>
    .pending_color {
        color:rgb(18, 234, 216);
    }
    .verify_color {
        color:rgb(221, 157, 189);
    }
    .verified_color {
        color:rgb(72, 133, 72);
    }
</style>
@endsection
@section('content')
@include('supplier.sale.partials.detail')
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
                    <li class="nav-item"><a href="#top-tab4" @if($active_tab == 'product_purchase') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Product Purchase</a></li>
                    <li class="nav-item"><a href="#top-tab1" @if($active_tab == 'product') class="nav-link active" @else class="nav-link" @endif data-toggle="tab">Product Sales</a></li>
                    <li class="nav-item"><a href="#top-tab5" @if($active_tab == 'debit_credit') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Debit Credit</a></li>
                    <li class="nav-item"><a href="#top-tab6" @if($active_tab == 'debit_credit_missing') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Debit Credit Missing ({{$missing_debit_credits->count()}})</a></li>
                    <li class="nav-item"><a href="#top-tab7" @if($active_tab == 'pending_validation') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Pending Validation ({{Auth::user()->sitePendingDebitCredit($date)->where('site_validation',0)->count()}})</a></li>
                    <li class="nav-item"><a href="#top-tab8" @if($active_tab == 'your_pending_validation') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Your Pending Validation ({{Auth::user()->supplierPendingDebitCredit($date)->where('supplier_validation',0)->count()}})</a></li>
                </ul>

                <div class="tab-content">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{$nextUrl}}" class="btn btn-primary btn-sm float-right">Next Date</a>
                            <a href="{{$previousUrl}}" class="btn btn-secondary btn-sm float-right mr-2">Previous Date</a>
                        </div>
                    </div>
                    <div @if($active_tab == 'product_purchase')  class="tab-pane fade show active" @else class="tab-pane fade" @endif class="tab-pane fade" id="top-tab4">
                        <div class="card-body">
                            @include('supplier.sale.supplier_purchases.create')
                        </div>
                    </div>
                    <div @if($active_tab == 'product')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab1">
                        <div class="card-body">
                            @include('supplier.sale.partials.product_sale')
                            @include('supplier.sale.partials.product_whole_sale')
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
                    <div @if($active_tab == 'pending_validation')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab7">
                            @include('supplier.sale.validations.pending_validation')
                    </div>
                    <div @if($active_tab == 'your_pending_validation')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab8">
                            @include('supplier.sale.validations.your_pending_validation')
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic layout-->

    </div>
</div>
@include('supplier.sale.partials.delete-confirmation-modal')
@endsection
@section('scripts')
@include('supplier.sale.partials.js')
@include('supplier.sale.partials.debit_credit_js')
@include('supplier.sale.supplier_purchases.partials.js')
@endsection