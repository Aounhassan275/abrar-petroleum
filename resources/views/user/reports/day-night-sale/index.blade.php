@extends('user.layout.index')

@section('title')
   Day & Night Sale Reports
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Day & Night Sale Reports</h6>
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
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="card">
                            <canvas id="pie-chart" width="500" height="500"></canvas>
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

        type: 'pie',

        data: {

            labels: [{!! @$data['labels'] !!}],
            datasets: [{

                label: "{{$product->name}} Sales",
                backgroundColor: ["#18cc93","#f0d92b","#f25a5c", "#80ed74", "#3366cc","#33C4FF","#0C3343","#EC7063","#49BA98","#EC7063","#49BA98"],
                data: [{!! @$data['sales'] !!}],

            }]
        },

        options: {

            responsive: true,
            title: {

                display: true,

                text: '{{$product->name}}'
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
@endsection