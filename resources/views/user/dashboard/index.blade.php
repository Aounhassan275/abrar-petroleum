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
@include('user.dashboard.partials.product_tiles')
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