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
            {{-- <th>Account Category</th> --}}
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
            <td>{{@$account->name}} @if($account->designation) ({{$account->designation}}) @endif</td>
            {{-- <td>{{@$account->accountCategory->name}}</td> --}}
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
        @elseif($account->name == 'Expense Less')
        @if(Auth::user()->totalExpense($start_date,$end_date) < 0 || Auth::user()->totalExpense($start_date,$end_date) > 0)
        <tr>
            <td>{{@$account->name}} @if($account->designation) ({{$account->designation}}) @endif</td>
            {{-- <td>{{@$account->accountCategory->name}}</td> --}}
            <td>
                @if(Auth::user()->totalExpense($start_date,$end_date) < 0)
                {{abs(Auth::user()->totalExpense($start_date,$end_date))}}
                @endif
            </td>
            <td>
                @if(Auth::user()->totalExpense($start_date,$end_date) > 0)
                {{Auth::user()->totalExpense($start_date,$end_date)}}
                @endif
            </td>
        </tr>
        @php 
            if(Auth::user()->totalExpense($start_date,$end_date) < 0)
            {
                $totalDebit += abs(Auth::user()->totalExpense($start_date,$end_date));
            }else{
                $totalCredit += abs(Auth::user()->totalExpense($start_date,$end_date));
            }
        @endphp 
        @endif
        {{-- @elseif($account->account_category_id == $category_id) --}}
        {{-- @if($account->debitCredits($inital_start_date,$end_date) < 0 || $account->debitCredits($inital_start_date,$end_date) > 0)
        <tr>
            <td>{{@$account->name}} @if($account->designation) ({{$account->designation}}) @endif</td>
            <td>{{@$account->accountCategory->name}}</td>
            <td>
                @if($account->getExpenseDebitCredits($inital_start_date,$end_date) < 0)
                {{abs($account->getExpenseDebitCredits($inital_start_date,$end_date))}}
                @endif
            </td>
            <td>
                @if($account->getExpenseDebitCredits($inital_start_date,$end_date) > 0)
                {{$account->getExpenseDebitCredits($inital_start_date,$end_date)}}
                @endif
            </td>
        </tr>
        @php 
            if($account->getExpenseDebitCredits($inital_start_date,$end_date) < 0)
            {
                $totalDebit += abs($account->getExpenseDebitCredits($inital_start_date,$end_date));
            }else{
                $totalCredit += abs($account->getExpenseDebitCredits($inital_start_date,$end_date));
            }
        @endphp
        @endif --}}
        @elseif($account->name != 'Sale' && ($account->debitCredits($inital_start_date,$end_date) < 0 || $account->debitCredits($inital_start_date,$end_date) > 0))
        <tr>
            <td>{{@$account->name}} @if($account->designation) ({{$account->designation}}) @endif</td>
            {{-- <td>{{@$account->accountCategory->name}}</td> --}}
            <td>
                @if($account->name == "Cash in Hand")
                @if(@$lastDayCash->debit < 0)
                {{(abs(@$lastDayCash->debit))}}
                @else 
                {{abs(@$lastDayCash->debit)}}
                @endif
                @elseif($account->debitCredits($inital_start_date,$end_date) < 0)
                {{abs($account->debitCredits($inital_start_date,$end_date))}}
                @endif
            </td>
            <td>
                @if($account->debitCredits($inital_start_date,$end_date) > 0)
                {{$account->debitCredits($inital_start_date,$end_date)}}
                @endif
            </td>
        </tr>
        @php 
        if($account->name == "Cash in Hand")
        {
            if(@$lastDayCash->debit < 0)
            {
                $totalDebit += @$lastDayCash->debit;
            }else{
                $totalDebit += abs(@$lastDayCash->debit);
            }

        }else{
            if($account->debitCredits($inital_start_date,$end_date) < 0)
            {
                $totalDebit += abs($account->debitCredits($inital_start_date,$end_date));
            }else{
                $totalCredit += abs($account->debitCredits($inital_start_date,$end_date));
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
            {{-- <td>Primary Account</td> --}}
            <td>
                
            <td>
                {{$workingCaptial->credit}}
            </td>
        </tr>
        @php 
            if($account->credit < 0)
            {
                $totalDebit += abs($workingCaptial->credit);
            }else{
                $totalCredit += abs($workingCaptial->credit);
            }
        @endphp
        @endif
        <tr>
            <td class="text-center">Total Balance</td>
            <td>{{$totalDebit}}</td>
            <td>{{$totalCredit}}</td>
        </tr>
    </tbody>
</table>