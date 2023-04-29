<form method="GET">
    <div class="row">
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
            <th>Account</th>
            <th>Account Category</th>
            <th>Debit</th>
            <th>Credit</th>
        </tr>
    </thead>
    <tbody>
        @php 
        $totalDebit = 0;
        $totalCredit = 0;
        @endphp
        @foreach($accounts as $key => $account)
        @if($account->debitCredits($start_date,$end_date) < 0 || $account->debitCredits($start_date,$end_date) > 0)
        <tr>
            <td>{{@$account->name}}</td>
            <td>{{@$account->accountCategory->name}}</td>
            <td>
                @if($account->debitCredits($start_date,$end_date) < 0)
                {{abs($account->debitCredits($start_date,$end_date))}}
                @endif
            </td>
            <td>
                @if($account->debitCredits($start_date,$end_date) > 0)
                {{$account->debitCredits($start_date,$end_date)}}
                @endif
            </td>
        </tr>
        @php 
        if($account->debitCredits($start_date,$end_date) < 0)
        {
            $totalDebit += abs($account->debitCredits($start_date,$end_date));
        }else{
            $totalCredit += abs($account->debitCredits($start_date,$end_date));
        }
        @endphp
        @endif
        @endforeach
        <tr>
            <td colspan="2" class="text-center">Total Balance</td>
            <td>{{$totalDebit}}</td>
            <td>{{$totalCredit}}</td>
        </tr>
    </tbody>
</table>