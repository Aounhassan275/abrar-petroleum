<tr id="remove-{{@$key ? $key : 1 }}">
    <td>
        <input type="hidden" class="form-control" name="purchase_id[]" value="{{@$purchase ? $purchase->id: null }}" >
        <input type="hidden" class="form-control" name="sale_type[]" value="site_sale" >
        <select name="user_id[]" class="form-control select-search"  id="user_id_{{@$key ? $key : 1}}">
            <option value="" >Select User</option>
            @foreach(App\Models\User::all() as $user)
            <option {{@$purchase && $purchase->user_id == $user->id ? 'selected' : '' }} value="{{$user->id}}">{{$user->username}}</option>
            @endforeach
        </select>
        {{-- <p id="user_id-response-{{@$key ? $key-1 : 0 }}"></p> --}}
    </td>
    <td>
        <select class="form-control select-search" name="product_id[]" onchange="getRates('{{@$key ? $key : 1}}')" id="product_id_{{@$key ? $key : 1}}">
            <option value="">Choose Product</option>
            @foreach(App\Models\Product::whereNull('user_id')->orWhere('supplier_id',Auth::user()->id)->get() as $product)    
            <option {{@$purchase && $purchase->product_id == $product->id ? 'selected' : '' }} value="{{$product->id}}">{{$product->name}}</option>
            @endforeach
        </select>
        {{-- <p id="product_id-response-{{@$key ? $key-1 : 0 }}"></p> --}}
    </td>
    <td>
        <input type="number" class="form-control" id="site_qty_{{@$key ? $key : 1}}"  onchange="productQuantity('{{@$key ? $key : 1}}')" name="qty[]" value="{{@$purchase ? $purchase->qty: '0' }}" >
        {{-- <p id="qty-response-{{@$key ? $key-1 : 0 }}"></p> --}}
    </td>
    <td>
        <input type="number" class="form-control"  name="price[]" id="site_price_{{@$key ? $key : 1}}" value="{{@$purchase ? $purchase->price : '0' }}">
        {{-- <p id="price-response-{{@$key ? $key-1 : 0 }}"></p> --}}
    </td>
    <td>
        <input type="number" class="form-control" readonly name="total_amount[]" id="site_total_amount_{{@$key ? $key : 1}}" value="{{@$purchase ? $purchase->total_amount : '0' }}" >
        {{-- <p id="total_amount-response-{{@$key ? $key-1 : 0 }}"></p> --}}
    </td>
    <td>
        <select class="form-control select-search" name="supplier_vehicle_id[]" >
            <option value="">Select Vehicle</option>
            @foreach(Auth::user()->vehicles as $vehicle)
            <option {{@$purchase && $purchase->supplier_vehicle_id == $vehicle->id ? 'selected' : '' }} value="{{$vehicle->id}}">{{$vehicle->name}}</option>
            @endforeach                                
        </select>
        {{-- <p id="product_id-response-{{@$key ? $key-1 : 0 }}"></p> --}}
    </td>
    <td>
        @if(@$key && !@$purchase)
        <button class="btn btn-danger btn-sm" onclick="removeField('{{@$key}}')" type="button">Remove</button>
        @endif
    </td>
</tr>