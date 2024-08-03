
<table class="table datatable-save-state">
    <thead>
        <tr>
            <th>Account</th>
            <th>Debit Amount</th>
            <th>Credit Amount</th>
            <th>Date</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach(Auth::user()->supplierPendingDebitCredit($date) as $index => $yourPendingDebitCredit)    
        <tr>
            <td>{{@$yourPendingDebitCredit->account_name}}</td>
            <td>{{$yourPendingDebitCredit->debit ?? 0}}</td>
            <td>{{$yourPendingDebitCredit->credit ?? 0}}</td>
            <td>{{$yourPendingDebitCredit->sale_date?$yourPendingDebitCredit->sale_date->format('d M,Y'):''}}</td>
            <td>{{$yourPendingDebitCredit->description}}</td>
            <td>
                <form action="{{route('supplier.debit_credit.verify',$yourPendingDebitCredit->id)}}" method="POST">
                    @method('GET')
                    @csrf
                <button class="btn btn-danger btn-sm">Verify</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>