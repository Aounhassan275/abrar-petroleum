
<table class="table datatable-save-state">
    <thead>
        <tr>
            <th>Account</th>
            <th>Debit Amount</th>
            <th>Credit Amount</th>
            <th>Date</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach(Auth::user()->sitePendingDebitCredit($date) as $index => $pendingDebitCredit)    
        <tr>
            <td>{{@$pendingDebitCredit->account_name}}</td>
            <td>{{$pendingDebitCredit->debit ?? 0}}</td>
            <td>{{$pendingDebitCredit->credit ?? 0}}</td>
            <td>{{$pendingDebitCredit->sale_date?$pendingDebitCredit->sale_date->format('d M,Y'):''}}</td>
            <td>{{$pendingDebitCredit->description}}</td>
        </tr>
        @endforeach
    </tbody>
</table>