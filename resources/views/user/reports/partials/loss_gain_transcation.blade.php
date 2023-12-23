<form method="GET">
    <div class="row">
        <input type="hidden" name="active_tab" value="loss_gain_transcation">
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
            <th>Date</th>
            <th>Available Stock</th>
            <th>Old Purchasing Rate</th>
            <th>New Purchasing Rate</th>
            <th>Amount</th>
            <th>Old Selling Rate</th>
            <th>New Selling Rate</th>
        </tr>
    </thead>
    <tbody>
        @foreach($loss_gain_transactions as $key => $loss_gain_transaction)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{@$loss_gain_transaction->product->name}}</td>
            <td>{{$loss_gain_transaction->date?$loss_gain_transaction->date->format('Y-m-d'):''}}</td>
            <td>{{$loss_gain_transaction->qty}}</td>
            <td>{{$loss_gain_transaction->old_price}}</td>
            <td>{{$loss_gain_transaction->new_price}}</td>
            <td>
                @if($loss_gain_transaction->amount > 0)
                    <span class="badge badge-success">{{round($loss_gain_transaction->amount)}}</span>
                @else 
                    <span class="badge badge-danger">{{round(abs($loss_gain_transaction->amount))}}</span>
                @endif
            </td>
            <td>{{$loss_gain_transaction->old_selling_price}}</td>
            <td>{{$loss_gain_transaction->new_selling_price}}</td>
        </tr>
        @endforeach
    </tbody>
</table>