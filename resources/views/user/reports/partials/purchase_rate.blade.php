<form method="GET">
    <div class="row">
        <input type="hidden" name="active_tab" value="purchase_rate">
        <div class="form-group col-3">
            <label>Choose Product</label> 
            <select name="product_id" class="form-control select-search">
                <option value="">Select</option>  
                @foreach(App\Models\Product::whereNull('user_id')->orWhere('user_id',Auth::user()->id)->get() as $product)    
                <option {{@request()->product_id == $product->id ? 'selected' : ''}} value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>
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
            <th>Purchase Date</th>
            <th>Purchasing Rate</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchasesRates as $key => $purchasesRate)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{@$purchasesRate->product->name}}</td>
            <td>{{$purchasesRate->date?$purchasesRate->date->format('Y-m-d'):''}}</td>
            <td>{{$purchasesRate->price}}</td>
        </tr>
        @endforeach
    </tbody>
</table>