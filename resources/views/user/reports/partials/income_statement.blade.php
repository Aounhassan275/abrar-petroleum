<form method="GET">
    <div class="row">
        <input type="hidden" name="active_tab" value="income_statement">
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
            <th>Name</th>
            <th>Stock</th>
            <th>Rate</th>
            <th>Stock Value</th>
            <th>Dr Balance</th>
            <th>Cr Balance</th>
            <th>Revenue</th>
        </tr>
    </thead>
    <tbody>
        @php 
        $totalRevenue = 0;
        @endphp
        @foreach($products as $key => $product)
        @php 
            $price = round($product->availableStock() * $product->purchasing_price);
            $totalAmount = $product->totalDrAmount($start_date,$end_date);
            $revenue = $price - abs($totalAmount);
            $totalRevenue += abs($revenue);
        @endphp
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$product->name}}</td>
            <td>{{$product->availableStock()}}</td>
            <td>{{$product->purchasing_price}}</td>
            <td>{{($price)}}</td>
            <td>
                @if($totalAmount < 0) 
                Dr ({{abs($totalAmount)}})
                @endif
            </td>
            <td>
                @if($totalAmount > 0) 
                Cr ({{abs($totalAmount)}})
                @endif
            </td>
            <td>{{round($revenue)}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>
<br>
<br>
<div class="row">   
    <div class="col-sm-4 col-xl-4">
        <div class="card card-body bg-blue-400 has-bg-image">
            <div class="media">

                <div class="mr-3 align-self-center">
                    <i class="icon-unlink2 icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                <h3 class="mb-0">{{$totalRevenue}}</h3>
                    <span class="text-uppercase font-size-xs">Total Revenue</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xl-4">
        <div class="card card-body bg-success-400 has-bg-image">
            <div class="media">
                <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{abs(Auth::user()->totalExpense($start_date,$end_date))}}</h3>
                    <span class="text-uppercase font-size-xs">Total Expense</span>
                </div>
                <div class="ml-3 text-right">
                    <i class="icon-bubbles4 icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-xl-4">
        <div class="card card-body bg-warning-400 has-bg-image">
            <div class="media">
                <div class="mr-3 align-self-center">
                    <i class="icon-stack-picture icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                    <h3 class="mb-0">{{abs($totalRevenue - abs(Auth::user()->totalExpense($start_date,$end_date)))}}</h3>
                    <span class="text-uppercase font-size-xs">Net Profit</span>
                </div>
            </div>
        </div>
    </div>
</div>