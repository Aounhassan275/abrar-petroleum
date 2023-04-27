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
        $totalQunatity = Auth::user()->getPetrolOpeningBalance($start_date);
        $quantityBalance = Auth::user()->getPetrolOpeningBalance($start_date);
        @endphp
        @foreach($dates as $key => $date)
        @if(Auth::user()->getTodayPetrolPurchase($date) > 0 || Auth::user()->getTodayPetrolSale($date) > 0)
        @php 
            $totalPurchase = $totalPurchase + Auth::user()->getTodayPetrolPurchase($date);
            $totalQunatity = $totalQunatity + Auth::user()->getTodayPetrolPurchase($date);
            $quantityBalance = $quantityBalance + Auth::user()->getTodayPetrolPurchase($date);
            $quantityBalance = $quantityBalance - Auth::user()->getTodayPetrolSale($date);
            $totalSale = $totalSale + Auth::user()->getTodayPetrolSale($date);
        @endphp
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$date}}</td>
            <td>{{Auth::user()->getTodayPetrolPurchase($date)}}</td>
            <td>{{@$totalQunatity}}</td>
            <td>{{Auth::user()->getTodayPetrolSale($date)}}</td>
            <td>{{$quantityBalance}}</td>
            <td></td>
            <td></td>
            <td></td>
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
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>