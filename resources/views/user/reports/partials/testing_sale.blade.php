<form method="GET">
    <div class="row">
        <input type="hidden" name="active_tab" value="testing_sale">
        {{-- <div class="form-group col-2">
            <label>
                Start Date
                <input type="text" name="start_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                    value="{{ date('m/d/Y', strtotime(@$start_date))}}">
            </label>   
        </div> --}}
        <div class="form-group col-2">
            <label>
                 Date

                <input type="text" name="end_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                    value="{{ date('m/d/Y', strtotime(@$end_date))}}">
            </label>   
        </div>
        <div class="form-group col-2">
            <label>
                Choose Product
            
                <select name="testing_product" class="form-control">
                    <option>Select Product</option>
                    <option @if(request()->testing_product == 'HSD') selected @endif value="HSD">HSD</option>
                    <option @if(request()->testing_product == 'PMG') selected @endif value="PMG">PMG</option>
                </select>  
            </label> 
        </div>
        <div class="form-group col-2">
            <br>
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>
<table class="table datatable-button-html5-basic">
    <thead>
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Date</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($test_sales as $key => $sale)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$sale->product->name}}</td>
            <td>{{$sale->sale_date?$sale->sale_date->format('Y-m-d'):''}}</td>
            <td>{{$sale->price}}</td>
            <td>{{$sale->qty}}</td>
            <td>{{$sale->total_amount}}</td>
        </tr>
        @endforeach
    </tbody>
</table>