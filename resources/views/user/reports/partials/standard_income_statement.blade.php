<form method="GET">
    <div class="row">
        <input type="hidden" name="active_tab" value="standard_income_statement">
        {{-- <div class="form-group col-2">
            <label>
                Start Date
                <input type="text" name="start_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                    value="{{ date('m/d/Y', strtotime(@$start_date))}}">
            </label>   
        </div> --}}
        <div class="form-group col-2">
            <label>
                 Date

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

@php 
$totalRevenue = 0;
foreach($products as $key => $product)
{
    $price = round($product->availableStock() * $product->purchasing_price);
    $totalAmount = $product->totalDrAmount($start_date,$end_date);
    if($totalAmount > 0)
    {
        $revenue = $price + abs($totalAmount);
    }else{
        $revenue = $price - abs($totalAmount);
    }
    $totalRevenue += abs($revenue);
}
@endphp
<div class="row" style="border-style: inset;">
    <div class="col-md-6 text-center">
        <p><b>Total Sale Revenue</b></p>
    </div>
    <div class="col-md-6 text-center">
        <p><b>{{$totalRevenue}}</b></p>
    </div>
</div>
<br>
<div class="row" style="border-style: inset;">
    <div class="col-md-4 text-left">
        <p><b>Expense Accounts</b></p>
    </div>
</div>
<br>
@foreach($expenseAccounts as $expenseAccount)
@if(abs($expenseAccount->debitCredits($start_date,$end_date)) > 0)
<div class="row" style="border-style: inset;">
    <div class="col-md-6 text-center">
        <p><b>{{$expenseAccount->name}}</b></p>
    </div>
    <div class="col-md-6 text-center">
        <p><b>{{abs($expenseAccount->debitCredits($start_date,$end_date))}}</b></p>
    </div>
</div>
<br>
@endif
@endforeach
<div class="row" style="border-style: inset;">
    <div class="col-md-6 text-center">
        <p><b>Total Expense</b></p>
    </div>
    <div class="col-md-6 text-center">
        <p><b>{{abs(Auth::user()->totalExpense($start_date,$end_date))}}</b></p>
    </div>
</div>
<div class="row" style="border-style: inset;">
    <div class="col-md-6 text-center">
        <p><b>Total Net Profit</b></p>
    </div>
    <div class="col-md-6 text-center">
        <p><b>{{abs($totalRevenue - abs(Auth::user()->totalExpense($start_date,$end_date)))}}</b></p>
    </div>
</div>
