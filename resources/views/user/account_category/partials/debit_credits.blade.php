@if($account_category->debitCredits($start_date,$end_date,$sub_account,request()->type)->count() > 0)
<div class="row">
    <div class="col-md-12">
        <a href="{{$url}}" target="_blank" class="btn btn-primary btn-sm float-right ">
            PDF
        </a>
    </div>
</div>
@endif 
@if($account_category->id != 6)
<p>Start Balance : {{$account_category->getOldDebitCredits($start_date,$end_date,$sub_account,request()->type)}}
</p>
@endif
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Account</th>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @php 
        if($account_category->id != 6)
            $balance = $account_category->getOldDebitCredits($start_date,$end_date,$sub_account,request()->type);
        else  
            $balance = 0;
        @endphp
        @foreach($account_category->debitCredits($start_date,$end_date,$sub_account,request()->type) as $key => $debitCredit)
        @if($sub_account == 24)
        @include('user.account_category.partials.cash_in_hand')
        @else
        @php 
            $balance = $balance + $debitCredit->credit;
            $balance = $balance - $debitCredit->debit;
        @endphp
        <tr>
            <td>{{$key+1}}</td>
            <td>{{@$debitCredit->sale_date ? $debitCredit->sale_date->format('d M,Y') : ''}}</td>
            <td>{{@$debitCredit->account->name}}</td>
            <td>{{@$debitCredit->product->name}}</td>
            <td>{{$debitCredit->qty}}</td>
            <td>{{$debitCredit->debit}}</td>
            <td>{{$debitCredit->credit}}</td>
            <td>@if($balance > 0) 
                ({{abs($balance)}}) Cr 
                @else
                ({{abs($balance)}}) Dr 
                @endif
            </td>
            <td>{{$debitCredit->description}}</td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>