<table class="table datatable-save-state">
    <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Test</th>
            <th>Whole Sale</th>
            <th>Price</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        @if($petrol->totalSale($date) > 0 || $petrol->totalTestSale($date) > 0)
        <tr>
            <td>{{$petrol->name}}</td>
            <td>{{$petrol->totalSale($date)}}</td>
            <td>{{$petrol->totalTestSale($date)}}</td>
            <td>{{$petrol->totalWholeSale($date)}}</td>
            <td>{{$petrol->getSaleRate($date)}}</td>
            <td>{{$petrol->totalSaleAmount($date)}}</td>
        </tr>
        @endif
        @if($diesel->totalSale($date) > 0 || $diesel->totalTestSale($date) > 0)
        <tr>
            <td>{{$diesel->name}}</td>
            <td>{{$diesel->totalSale($date)}}</td>
            <td>{{$diesel->totalTestSale($date)}}</td>
            <td>{{$diesel->totalWholeSale($date)}}</td>
            <td>{{$diesel->getSaleRate($date)}}</td>
            <td>{{$diesel->totalSaleAmount($date)}}</td>
        </tr>
        @endif
        @foreach(Auth::user()->products as $misc_product_index => $misc_product)    
        @if($misc_product->totalSale($date) > 0 || $misc_product->totalTestSale($date) > 0)
        <tr>
            <td>{{$misc_product->name}}</td>
            <td>{{$misc_product->totalSale($date)}}</td>
            <td>{{$misc_product->totalTestSale($date)}}</td>
            <td>0</td>
            <td>{{$misc_product->getSaleRate($date)}}</td>
            <td>{{$misc_product->totalSaleAmount($date)}}</td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>