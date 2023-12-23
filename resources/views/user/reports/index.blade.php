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
                    <li class="nav-item"><a href="#top-tab5" @if($active_tab == 'whole_sale') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Whole Sales</a></li>
                    <li class="nav-item"><a href="#top-tab6" @if($active_tab == 'monthly_profit') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Month Profit</a></li>
                    <li class="nav-item"><a href="#top-tab7" @if($active_tab == 'purchase_rate') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Purchase Rates</a></li>
                    <li class="nav-item"><a href="#top-tab8" @if($active_tab == 'loss_gain_transcation') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Loss Gain Trasncation</a></li>
                    <li class="nav-item"><a href="#top-tab9" @if($active_tab == 'expense_accounts') class="nav-link active" @else class="nav-link" @endif class="nav-link" data-toggle="tab">Expense</a></li>
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
                    <div @if($active_tab == 'whole_sale')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab5"> 
                        <div class="card-body">
                            @include('user.reports.partials.whole_sale')
                        </div>
                    </div>
                    <div @if($active_tab == 'monthly_profit')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab6"> 
                        <div class="card-body">
                            @include('user.reports.partials.monthly_profits')
                        </div>
                    </div>
                    <div @if($active_tab == 'purchase_rate')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab7"> 
                        <div class="card-body">
                            @include('user.reports.partials.purchase_rate')
                        </div>
                    </div>
                    <div @if($active_tab == 'loss_gain_transcation')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab8"> 
                        <div class="card-body">
                            @include('user.reports.partials.loss_gain_transcation')
                        </div>
                    </div>
                    <div @if($active_tab == 'expense_accounts')  class="tab-pane fade show active" @else class="tab-pane fade" @endif id="top-tab9"> 
                        <div class="card-body">
                            @include('user.reports.partials.expense_accounts')
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
<script src="{{ url('chart/Chart.min.js') }}"></script>
<script>

    new Chart(document.getElementById("pie-chart"), {

        type: 'doughnut',

        data: {

            labels: [{!! @$data['labels'] !!}],
            datasets: [{

                label: "Petrol Purchase",
                backgroundColor: ["#990099","#109618","#ff9900", "#dc3912", "#3366cc","#33C4FF","#0C3343","#EC7063","#49BA98","#EC7063","#49BA98"],

                data: [{!! $data['expense_amounts'] !!}],

            }]
        },

        options: {

            responsive: true,
            title: {

                display: true,

                text: 'Total Expenses'
            },
            tooltips: {
                enabled: true,
                mode: 'single',
                callbacks: {
                    title: function(tooltipItem, data) {
                        return tooltipItem[0].xLabel;
                    },
                    label: function(dataItems, data) {
                        var category = data.labels[dataItems.index];
                        var value = data.datasets[0].data[dataItems.index];


                        return ' ' + category + ': ' +value;
                    }
                }
            }
        }
    });
</script>
<script>
    $(document).ready(function(){
        $('#post_month_profit').change(function(){
            if(this.checked)
            {
                $('#income-statment-button').text('Post Month Profit');
            }else{
                $('#income-statment-button').text('Search');
            }
        });
    });
</script>
@endsection