<form id="changeProductSalePriceForm">
    <table class="table datatable-save-state">
        <input type="hidden" name="change_rate_date[]" value="{{$date}}">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Test</th>
                <th>Whole Sale</th>
                <th class="text-left">Price</th>
                <th>Total Commulative Amount</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @if($petrol->totalSale($date) > 0 || $petrol->totalTestSale($date) > 0)
            <tr>
                <td>{{$petrol->name}}</td>
                <td id="change_sale_quantity_petrol">{{$petrol->totalSale($date)}}</td>
                <td>{{$petrol->totalTestSale($date)}}</td>
                <td>{{$petrol->totalWholeSale($date)}}</td>
                <td> 
                    <input type="hidden" name="change_product_id[]" value="{{$petrol->id}}">
                    <input type="text" class="form-control" id="change_sale_rate_petrol"  style="width:30%;" onchange="saleDetailPrice('petrol')" name="change_sale_rate[]" required value="{{$petrol->getSaleRate($date)}}">
                </td>
                <td>
                    {{$petrol->totalCommulativeSaleAmount($date)}}
                </td>
                <td id="change_sale_amount_petrol">
                    {{$petrol->totalSaleAmount($date)}}
                </td>
            </tr>
            @endif
            @if($diesel->totalSale($date) > 0 || $diesel->totalTestSale($date) > 0)
            <tr>
                <td>{{$diesel->name}}</td>
                <td id="change_sale_quantity_diesel">{{$diesel->totalSale($date)}}</td>
                <td>{{$diesel->totalTestSale($date)}}</td>
                <td>{{$diesel->totalWholeSale($date)}}</td>
                {{-- <td>{{$diesel->getSaleRate($date)}}</td> --}}
                <td> 
                    <input type="hidden" name="change_product_id[]" value="{{$diesel->id}}">
                    <input type="text" class="form-control" id="change_sale_rate_diesel" style="width:30%;" onchange="saleDetailPrice('diesel')" name="change_sale_rate[]" required value="{{$diesel->getSaleRate($date)}}">
                </td>
                <td id="">{{$diesel->totalCommulativeSaleAmount($date)}}</td>
                <td id="change_sale_amount_diesel">{{$diesel->totalSaleAmount($date)}}</td>
            </tr>
            @endif
            @foreach(Auth::user()->products as $misc_product_index => $misc_product)    
            @if($misc_product->totalSale($date) > 0 || $misc_product->totalTestSale($date) > 0)
            <tr>
                <td>{{$misc_product->name}}</td>
                <td  id="change_sale_quantity_{{$misc_product_index}}">{{$misc_product->totalSale($date)}}</td>
                <td>{{$misc_product->totalTestSale($date)}}</td>
                <td>0</td>
                <td> 
                    <input type="hidden" name="change_product_id[]" value="{{$misc_product->id}}">
                    <input type="text" class="form-control" id="change_sale_rate_{{$misc_product_index}}" onchange="saleDetailPrice('{{$misc_product_index}}')"   style="width:30%;" name="change_sale_rate[]" required value="{{$misc_product->getSaleRate($date)}}">
                </td>
                <td id="}">{{$misc_product->totalCommulativeSaleAmount($date)}}</td>
                <td id="change_sale_amount_{{$misc_product_index}}">{{$misc_product->totalSaleAmount($date)}}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    <button type="button" style="display:none;" class="btn btn-primary text-right" id="change_sale_rate_button">Update</button>
</form>