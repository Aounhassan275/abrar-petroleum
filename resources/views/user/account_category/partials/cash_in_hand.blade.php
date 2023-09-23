
@php 
$balance = $balance - $debitCredit->debit;
@endphp
<tr>
    <td>{{$key+1}}</td>
    <td>{{$debitCredit->sale_date->format('d M,Y')}}</td>
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
@php 
$balance = $balance + $debitCredit->debit;
@endphp
<tr>
    <td>{{$key+1}}</td>
    <td>{{Carbon\Carbon::parse($debitCredit->sale_date)->addDays(1)->format('d M,Y')}}</td>
    <td>{{@$debitCredit->account->name}}</td>
    <td>{{@$debitCredit->product->name}}</td>
    <td>{{$debitCredit->qty}}</td>
    <td>{{$debitCredit->credit}}</td>
    <td>{{$debitCredit->debit}}</td>
    <td>@if($balance > 0) 
        ({{abs($balance)}}) Cr 
        @else
        ({{abs($balance)}}) Dr 
        @endif
    </td>
    <td>{{$debitCredit->description}}</td>
</tr>
