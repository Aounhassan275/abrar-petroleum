@extends('user.layout.index')

@section('title')
    {{$product->name}} Ledger
@endsection

@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
@endsection
@section('content')
<div class="card">
    <div class="card-header header-elements-inline">
        <p>{{$product->name}} Ledger 
        <span class="badge badge-success">Opening Stock : {{Auth::user()->getOpeningBalance($start_date,$product)}}</span>
        <span class="badge badge-info">Amount : {{round(Auth::user()->getPurchasePrice($start_date,$product) * Auth::user()->getOpeningBalance($start_date,$product))}}</span>        </p>
    </div>
    <form method="GET">
        <div class="row col-md-12">
            <input type="hidden" name="active_tab" value="trail_balance">
            <div class="form-group col-2">
                <label>
                    Start Date
                    <input type="text" name="start_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                        value="{{ date('m/d/Y', strtotime(@$start_date))}}">
                </label>   
            </div>
            <div class="form-group col-2">
                <label>
                    End Date
    
                    <input type="text" name="end_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                        value="{{ date('m/d/Y', strtotime(@$end_date))}}">
                </label>   
            </div>
            <div class="form-group col-2">
                <br>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
    <table class="table datatable-button-html5-basic">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Purchase</th>
                <th>Total</th>
                <th>Sale</th>
                <th>Balance</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
                <th>Profit / Loss</th>
                <th>Revenue</th>
            </tr>
        </thead>
        <tbody>
            @php 
            $totalPurchase = 0;
            $totalSale = 0;
            $totalQunatity = Auth::user()->getOpeningBalance($start_date,$product);
            $quantityBalance = Auth::user()->getOpeningBalance($start_date,$product);
            $totalDebit = 0;
            $totalCredit = 0;
            $totalRevenue = 0;
            $totallossGainAmount = 0;
            $amountBalance = -(Auth::user()->getPurchasePrice($start_date,$product) * Auth::user()->getOpeningBalance($start_date,$product));
            @endphp
            @foreach($dates as $key => $date)
            
            @if(Auth::user()->getTodayPurchase($date,$product) > 0 || Auth::user()->getTodaySale($date,$product) > 0)
            @php 
                $totalPurchase = $totalPurchase + Auth::user()->getTodayPurchase($date,$product);
                $totalQunatity = $totalQunatity + Auth::user()->getTodayPurchase($date,$product);
                $quantityBalance = $quantityBalance + Auth::user()->getTodayPurchase($date,$product);
                $quantityBalance = $quantityBalance - Auth::user()->getTodaySale($date,$product);
                $totalCredit = $totalCredit + Auth::user()->getTodaySaleTotalAmount($date,$product);
                $amountBalance = $amountBalance + Auth::user()->getTodaySaleTotalAmount($date,$product);
                $amountBalance = round($amountBalance - Auth::user()->getTodayPurchaseTotalAmount($date,$product));
                $totalDebit = $totalDebit + Auth::user()->getTodayPurchaseTotalAmount($date,$product);
                $totalSale = $totalSale + Auth::user()->getTodaySale($date,$product);
                $lossGainAmount = Auth::user()->productLossGainTranscation($date,$product->id);
                $rateDifference = Auth::user()->getTodaySalePrice($date,$product) - Auth::user()->getPurchasePrice($date,$product);
                $reveune = Auth::user()->getTodaySale($date,$product) * $rateDifference;
                $totalRevenue = $totalRevenue + $reveune;
                $totallossGainAmount = $totallossGainAmount + $lossGainAmount;
            @endphp
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$date}}</td>
                <td>{{Auth::user()->getTodayPurchase($date,$product)}} <span class="badge badge-sm badge-success">{{Auth::user()->getTodayPurchasePrice($date,$product)}}</span></td>
                <td>{{@$totalQunatity}}</td>
                <td>{{Auth::user()->getTodaySale($date,$product)}}  <span class="badge badge-sm badge-success">{{Auth::user()->getTodaySalePrice($date,$product)}}</span></td>
                <td>{{$quantityBalance}}</td>
                <td>{{Auth::user()->getTodayPurchaseTotalAmount($date,$product)}}</td>
                <td>{{Auth::user()->getTodaySaleTotalAmount($date,$product)}}</td>
                <td>
                    @if($amountBalance > 0) 
                    ({{abs($amountBalance)}}) Cr 
                    @else
                    ({{abs($amountBalance)}}) Dr 
                    @endif
                </td>
                <td>
                    @if($lossGainAmount ==  0)
                    0
                    @else
                    @if($lossGainAmount > 0) 
                    ({{abs($lossGainAmount)}}) Cr 
                    @else
                    ({{abs($lossGainAmount)}}) Dr 
                    @endif
                    @endif
                </td>
                <td>{{$reveune}}  <span class="badge badge-sm badge-success">{{Auth::user()->getPurchasePrice($date,$product)}}</span></td>
            </tr>
            @php 
                $totalQunatity = $quantityBalance;
            @endphp
            @endif
            @endforeach
        </tbody>
    </table>
</div>
<div class="row">
    
    <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-blue-400 has-bg-image">
            <div class="media">

                <div class="mr-3 align-self-center">
                    <i class="icon-unlink2 icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                <h3 class="mb-0">{{$totalPurchase}}</h3>
                    <span class="text-uppercase font-size-xs">Total Purchases</span>
                </div>
            </div>
        </div>
    </div>


    <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-success-400 has-bg-image">
            <div class="media">
                <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{$totalSale}}</h3>
                    <span class="text-uppercase font-size-xs">Total Sale</span>
                </div>
                <div class="ml-3 text-right">
                    <i class="icon-bubbles4 icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-violet-400 has-bg-image">
            <div class="media">
                <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{$totalDebit}}</h3>
                    <span class="text-uppercase font-size-xs">Total Debit</span>
                </div>
                <div class="ml-3 text-right">
                    <i class="icon-bubbles4 icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-warning-400 has-bg-image">
            <div class="media">
                <div class="mr-3 align-self-center">
                    <i class="icon-stack-picture icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                    <h3 class="mb-0">{{$totalCredit}}</h3>
                    <span class="text-uppercase font-size-xs">Total Credit</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-teal-400 has-bg-image">
            <div class="media">
                <div class="mr-3 align-self-center">
                    <i class="icon-stack-picture icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                    <h3 class="mb-0">{{$totalRevenue}}</h3>
                    <span class="text-uppercase font-size-xs">Total Revenue</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-danger-400 has-bg-image">
            <div class="media">
                <div class="mr-3 align-self-center">
                    <i class="icon-stack-picture icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                    <h3 class="mb-0">{{$totallossGainAmount}}</h3>
                    <span class="text-uppercase font-size-xs">Gross Revenue</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
@endsection