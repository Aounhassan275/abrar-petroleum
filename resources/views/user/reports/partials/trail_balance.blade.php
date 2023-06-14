<form method="GET">
    <div class="row">
        <input type="hidden" name="active_tab" value="trail_balance">
        <input type="hidden" name="start_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
            value="{{ date('m/d/Y', strtotime(@$start_date))}}">
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
        $is_working_captial = false;
        @endphp
        @foreach($accounts as $key => $account)
        @if($account->account_category_id == $product_account_category_id)
        @if(($account->getProductBalance($start_date,$end_date) < 0 || $account->getProductBalance($start_date,$end_date) > 0))
        <tr>
            <td>{{@$account->name}}</td>
            <td>{{@$account->accountCategory->name}}</td>
            <td>
                @if($account->getProductBalance($start_date,$end_date) < 0)
                {{abs($account->getProductBalance($start_date,$end_date))}}
                @endif
            </td>
            <td>
                @if($account->getProductBalance($start_date,$end_date) > 0)
                {{$account->getProductBalance($start_date,$end_date)}}
                @endif
            </td>
        </tr>
        
        @php 
        if($account->getProductBalance($start_date,$end_date) < 0)
        {
            $totalDebit += abs($account->getProductBalance($start_date,$end_date));
        }else{
            $totalCredit += abs($account->getProductBalance($start_date,$end_date));
        }
        @endphp
        @endif
        @elseif($account->name != 'Sale' && ($account->debitCredits($start_date,$end_date) < 0 || $account->debitCredits($start_date,$end_date) > 0))
        <tr>
            <td>{{@$account->name}}</td>
            <td>{{@$account->accountCategory->name}}</td>
            <td>
                @if($account->name == "Cash in Hand")
                {{abs(@$lastDayCash->debit)}}
                @elseif($account->debitCredits($start_date,$end_date) < 0)
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
        if($account->name == "Cash in Hand")
        {
            if($account->debit < 0)
            {
                $totalDebit += abs($account->debit);
            }else{
                $totalCredit += abs($account->debit);
            }

        }else{
            if($account->debitCredits($start_date,$end_date) < 0)
            {
                $totalDebit += abs($account->debitCredits($start_date,$end_date));
            }else{
                $totalCredit += abs($account->debitCredits($start_date,$end_date));
            }
        }
        if($account->name == "Working Capital")
        {
            $is_working_captial = true;
        }
        @endphp
        @endif
        @endforeach
        @if($is_working_captial == false && $workingCaptial)
        <tr>
            <td>Working Capital</td>
            <td>Primary Account</td>
            <td>
                
            <td>
                {{$workingCaptial->credit}}
            </td>
        </tr>
        @php 
            if($account->credit < 0)
            {
                $totalDebit += abs($account->credit);
            }else{
                $totalCredit += abs($account->credit);
            }
        @endphp
        @endif
        <tr>
            <td colspan="2" class="text-center">Total Balance</td>
            <td>{{$totalDebit}}</td>
            <td>{{$totalCredit}}</td>
        </tr>
    </tbody>
</table>