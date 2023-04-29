<table class="table datatable-button-html5-basic">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Purchase</th>
            <th>Total</th>
            <th>Sale</th>
            <th>Balance</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
        @php 
        $totalPurchase = 0;
        $totalSale = 0;
        $totalQunatity = 0;
        $quantityBalance = 0;
        $totalDebit = 0;
        $totalCredit = 0;
        $amountBalance = 0;
        @endphp
        @foreach($dates as $key => $date)
        @if(Auth::user()->getTodayPetrolPurchase($date) > 0 || Auth::user()->getTodayPetrolSale($date) > 0)
        @php 
            $totalPurchase = $totalPurchase + Auth::user()->getTodayPetrolPurchase($date);
            $totalQunatity = $totalQunatity + Auth::user()->getTodayPetrolPurchase($date);
            $quantityBalance = $quantityBalance + Auth::user()->getTodayPetrolPurchase($date);
            $quantityBalance = $quantityBalance - Auth::user()->getTodayPetrolSale($date);
            $totalCredit = $totalCredit + Auth::user()->getTodayPetrolSaleTotalAmount($date);
            $amountBalance = $amountBalance + Auth::user()->getTodayPetrolSaleTotalAmount($date);
            $amountBalance = $amountBalance - Auth::user()->getTodayPetrolPurchaseTotalAmount($date);
            $totalDebit = $totalDebit + Auth::user()->getTodayPetrolPurchaseTotalAmount($date);
            $totalSale = $totalSale + Auth::user()->getTodayPetrolSale($date);
        @endphp
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$date}}</td>
            <td>{{Auth::user()->getTodayPetrolPurchase($date)}} <span class="badge badge-sm badge-success">{{Auth::user()->getTodayPetrolPurchasePrice($date)}}</span></td>
            <td>{{@$totalQunatity}}</td>
            <td>{{Auth::user()->getTodayPetrolSale($date)}}  <span class="badge badge-sm badge-success">{{Auth::user()->getTodayPetrolSalePrice($date)}}</span></td>
            <td>{{$quantityBalance}}</td>
            <td>{{Auth::user()->getTodayPetrolPurchaseTotalAmount($date)}}</td>
            <td>{{Auth::user()->getTodayPetrolSaleTotalAmount($date)}}</td>
            <td>
                @if($amountBalance > 0) 
                ({{abs($amountBalance)}}) Cr 
                @else
                ({{abs($amountBalance)}}) Dr 
                @endif
            </td>
        </tr>
        @php 
            $totalQunatity = $quantityBalance;
        @endphp
        @endif
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td>{{$totalPurchase}}</td>
            <td></td>
            <td>{{$totalSale}}</td>
            <td></td>
            <td>{{$totalDebit}}</td>
            <td>{{$totalCredit}}</td>
            <td></td>
        </tr>
    </tbody>
</table>