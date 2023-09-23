@extends('supplier.layout.index')

@section('title')
    Add New Sale
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
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
                    <li class="nav-item"><a href="#top-tab1" @if($active_tab == 'products') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Products</a></li>
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
                    <div @if($active_tab == 'products')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab1">
                        <div class="card-body">
                            {{-- @if(Auth::user()->haveSale($date)->count() > 0)
                                @include('supplier.sale.partials.sale_update')
                            @else  --}}
                                @include('supplier.sale.partials.sale_store')
                            {{-- @endif --}}
                        </div>

                    </div>

                    {{-- <div @if($active_tab == 'debit_credit')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab5">
                        
                        @if(Auth::user()->haveDebitCredit($date)->count() > 0)
                            @include('user.sale.partials.debit_credit_update')
                        @else 
                            @include('user.sale.partials.debit_credit_store')
                        @endif
                    </div> --}}
                    {{-- <div @if($active_tab == 'debit_credit_missing')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab6">
                            @include('user.sale.partials.debit_credit_missing')
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- Basic layout-->

    </div>
</div>
{{-- @include('user.sale.partials.add-purchase-modal')
@include('user.sale.partials.delete-confirmation-modal') --}}
@endsection
@section('scripts')
{{-- @include('user.sale.partials.js')
@include('user.sale.partials.debit_credit_js') --}}
@endsection