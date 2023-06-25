@extends('user.layout.index')

@section('title')
    Reports
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Reports</h6>
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
                    <li class="nav-item"><a href="#top-tab1" @if($active_tab == 'trail_balance') class="nav-link active" @else class="nav-link" @endif data-toggle="tab">Trail Balance</a></li>
                    <li class="nav-item"><a href="#top-tab2" @if($active_tab == 'income_statement') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Income Statement</a></li>
                    <li class="nav-item"><a href="#top-tab3" @if($active_tab == 'standard_income_statement') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Standard Income Statement</a></li>
                    <li class="nav-item"><a href="#top-tab4" @if($active_tab == 'testing_sale') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Tests</a></li>
                    {{-- <li class="nav-item"><a href="#top-tab5" @if($active_tab == 'debit_credit') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Debit Credit</a></li> --}}
                </ul>

                <div class="tab-content">
                    
                    <div @if($active_tab == 'trail_balance')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab1">
                        <div class="card-body">
                                @include('user.reports.partials.trail_balance')
                        </div>

                    </div>

                    <div  @if($active_tab == 'income_statement')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab2">
                        <div class="card-body">
                            @include('user.reports.partials.income_statement')
                        </div>

                    </div>

                    <div @if($active_tab == 'standard_income_statement')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab3"> 
                        <div class="card-body">
                            @include('user.reports.partials.standard_income_statement')
                        </div>
                    </div>
                    <div @if($active_tab == 'testing_sale')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab4"> 
                        <div class="card-body">
                            @include('user.reports.partials.testing_sale')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic layout-->

    </div>
</div>
@endsection
@section('scripts')
@endsection