@extends('user.layout.index')

@section('title')
    {{Auth::user()->type}} Dashboard
@endsection
@section('styles')
<style>
    blink {
        animation: blinker 2s linear infinite;
    }
    @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
  </style>   
@endsection

@section('content')
<div class="row">
    
    <div class="col-sm-3 col-xl-3">
        <div class="card card-body {{App\Models\Product::where('name','PMG')->first()->availableStock() <= Auth::user()->petrol_low_stock ? 'blink bg-danger-400' : 'bg-blue-400'}}  has-bg-image">
            <div class="media">

                <div class="mr-3 align-self-center">
                    <i class="icon-stack2 icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                <h3 class="mb-0">{{App\Models\Product::where('name','PMG')->first()->availableStock()}}</h3>
                    <span class="text-uppercase font-size-xs">Petrol Available Stock</span>
                </div>
            </div>
        </div>
    </div>


    <div class="col-sm-3 col-xl-3">
        <div class="card card-body {{App\Models\Product::where('name','HSD')->first()->availableStock() <= Auth::user()->diesel_low_stock ? 'blink bg-danger-400' : 'bg-success-400'}}  has-bg-image">
            <div class="media">
                <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{App\Models\Product::where('name','HSD')->first()->availableStock()}}</h3>
                    <span class="text-uppercase font-size-xs">Diesel Available Stock</span>
                </div>
                <div class="ml-3 text-right">
                    <i class="icon-cart-add icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-violet-400 has-bg-image">
            <div class="media">
                <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{App\Models\Product::where('name','PMG')->first()->totalCurrentMonthSales()}}</h3>
                    <span class="text-uppercase font-size-xs">Petrol Total Sales </span>
                </div>
                <div class="ml-3 text-right">
                    <i class="icon-cash icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-warning-400 has-bg-image">
            <div class="media">
                <div class="mr-3 align-self-center">
                    <i class="icon-cash2 icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                    <h3 class="mb-0">{{App\Models\Product::where('name','HSD')->first()->totalCurrentMonthSales()}}</h3>
                    <span class="text-uppercase font-size-xs">Diesel Total Sales</span>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    
    <div class="col-sm-6 col-xl-6">
        <div class="card card-body bg-teal-400 has-bg-image">
            <div class="media">

                <div class="mr-3 align-self-center">
                    <i class="icon-stack3 icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                <h3 class="mb-0">{{App\Models\Product::where('name','PMG')->first()->totalCurrentMonthPurchasesQty()}}</h3>
                    <span class="text-uppercase font-size-xs">Petrol Total Purchase</span>
                </div>
            </div>
        </div>
    </div> 


    {{-- <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-brown-400 has-bg-image">
            <div class="media">
                <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{App\Models\Product::where('name','PMG')->first()->totaPurchasesAmount()}}</h3>
                    <span class="text-uppercase font-size-xs">Petrol Total Purchase Amount</span>
                </div>
                <div class="ml-3 text-right">
                    <i class="icon-cash3 icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-sm-6 col-xl-6">
        <div class="card card-body bg-info-400 has-bg-image">
            <div class="media">
                <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{App\Models\Product::where('name','HSD')->first()->totalCurrentMonthPurchasesQty()}}</h3>
                        <span class="text-uppercase font-size-xs">Diesel Total Purchase</span>
                </div>
                <div class="ml-3 text-right">
                    <i class="icon-cart5 icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-primary-400 has-bg-image">
            <div class="media">
                <div class="mr-3 align-self-center">
                    <i class="icon-cash4 icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                    <h3 class="mb-0">{{App\Models\Product::where('name','HSD')->first()->totaPurchasesAmount()}}</h3>
                    <span class="text-uppercase font-size-xs">Diesel Total Purchase Amount</span>
                </div>
            </div>
        </div>
    </div> --}}

</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            {{-- <div class="text-center" style="padding: 10px"> --}}
                <canvas id="pie-chart" width="500" height="500"></canvas>
            {{-- </div> --}}
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            {{-- <div class="text-center" style="padding: 10px"> --}}
                <canvas id="withdraw-chart" width="500" height="500"></canvas>
            {{-- </div> --}}
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ url('chart/Chart.min.js') }}"></script>
<script>

    new Chart(document.getElementById("pie-chart"), {

        type: 'pie',

        data: {

            labels: [
                "Total Target", 
                "Total Achieved", 
                "Total Extra Achieved"
                ],
            datasets: [{

                label: "Petrol Purchase",
                backgroundColor: ["#990099","#109618","#ff9900", "#dc3912", "#3366cc","#33C4FF","#0C3343","#EC7063","#49BA98","#EC7063","#49BA98"],

                data: [
                    '{{Auth::user()->petrol_red_zone - Auth::user()->totalPetrolAchievedTarget()}}',
                    '{{Auth::user()->totalPetrolAchievedTarget()}}',
                    '{{Auth::user()->totalPetrolExtraAchieved()}}'
                ],

            }]
        },

        options: {

            responsive: true,
            title: {

                display: true,

                text: 'Total Petrol Target Achieved'
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


                        return ' ' + category + ': $' +value;
                    }
                }
            }
        }
    });
</script>


<script>

    new Chart(document.getElementById("withdraw-chart"), {

        type: 'pie',

        data: {

            labels: [
                "Total Target", 
                "Total Achieved", 
                "Total Extra Achieved"],

            datasets: [{

                label: "Total Diesel Purchase",

                backgroundColor: ["#ABB2B9","#7FB3D5","#C39BD3", "#EC7063", "#3366cc","#33C4FF","#0C3343","#49BA98"],

                data: [
                    '{{Auth::user()->diesel_red_zone - Auth::user()->totalDieselAchievedTarget()}}',
                    '{{Auth::user()->totalDieselAchievedTarget()}}',
                    '{{Auth::user()->totalDieselExtraAchieved()}}'
                ],

            }]
        },

        options: {

            responsive: true,
            title: {

                display: true,

                text: 'Total Diesel Purchase'
            },
            tooltips: {
                enabled: true,
                mode: 'single',
                callbacks: {
                    title: function(tooltipItem, data) {
                        return tooltipItem[0].xLabel;
                    },
                    label: function(dataItems, data) {
                        console.log(dataItems,data);
                        var category = data.labels[dataItems.index];
                        var value = data.datasets[0].data[dataItems.index];


                        return ' ' + category + ': $' +value;
                    }
                }
            }
        }
    });
</script>
@endsection