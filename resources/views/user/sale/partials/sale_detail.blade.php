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
        <tr>
            <td>{{$petrol->name}}</td>
            <td>{{$petrol->totalSale($date)}}</td>
            <td>{{$petrol->totalTestSale($date)}}</td>
            <td>{{$petrol->totalWholeSale($date)}}</td>
            <td>PKR {{$petrol->getSaleRate($date)}}</td>
            <td>PKR {{$petrol->totalSaleAmount($date)}}</td>
        </tr>
        <tr>
            <td>{{$diesel->name}}</td>
            <td>{{$diesel->totalSale($date)}}</td>
            <td>{{$diesel->totalTestSale($date)}}</td>
            <td>{{$diesel->totalWholeSale($date)}}</td>
            <td>PKR {{$diesel->getSaleRate($date)}}</td>
            <td>PKR {{$diesel->totalSaleAmount($date)}}</td>
        </tr>
        @foreach(Auth::user()->products as $misc_product_index => $misc_product)    
        <tr>
            <td>{{$misc_product->name}}</td>
            <td>{{$misc_product->totalSale($date)}}</td>
            <td>{{$misc_product->totalTestSale($date)}}</td>
            <td>0</td>
            <td>PKR {{$misc_product->getSaleRate($date)}}</td>
            <td>PKR {{$misc_product->totalSaleAmount($date)}}</td>
        </tr>
        @endforeach
    </tbody>
</table>