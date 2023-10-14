<form method="GET">
    <div class="row">
        <input type="hidden" name="active_tab" value="monthly_profit">
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
<table class="table datatable-button-html5-basic">
    <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Product Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($monthlyProfits as $key => $monthlyProfit)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$monthlyProfit->type}}</td>
            <td>{{@$monthlyProfit->product->name}}</td>
            <td>{{$monthlyProfit->start_date?$monthlyProfit->start_date->format('Y-m-d'):''}}</td>
            <td>{{$monthlyProfit->end_date?$monthlyProfit->end_date->format('Y-m-d'):''}}</td>
            <td>{{$monthlyProfit->amount}}</td>
        </tr>
        @endforeach
    </tbody>
</table>