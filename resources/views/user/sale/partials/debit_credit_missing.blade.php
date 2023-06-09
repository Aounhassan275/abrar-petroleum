
<table class="table datatable-save-state">
    <thead>
        <tr>
            <th>Debit Amount</th>
            <th>Credit Amount</th>
            <th>Date</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach($missing_debit_credits as $index => $missing_debit_credit)    
        <tr>
            <td>{{$missing_debit_credit->debit}}</td>
            <td>{{$missing_debit_credit->credit}}</td>
            <td>{{$missing_debit_credit->sale_date?$missing_debit_credit->sale_date->format('d M,Y'):''}}</td>
            <td>{{$missing_debit_credit->description}}</td>
        </tr>
        @endforeach
    </tbody>
</table>