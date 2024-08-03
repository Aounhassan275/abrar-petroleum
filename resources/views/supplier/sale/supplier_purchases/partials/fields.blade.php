<div class="row mt-2" id="purchase-remove-{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1 }}">
    <div class="col-md-12">
        <p><strong>Purchase {{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1 }}</strong></p>
    </div>
    <div class="col-md-3 mt-2">
        <input type="hidden" class="form-control" name="supplier_purchase_id[]" value="{{@$supplierPurchase ? $supplierPurchase->id: null }}" >
        <label for="">Product</label>
        <select class="form-control select-search" name="product_id[]" onchange="getPurchasingRates('{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1}}')" id="purchase_product_id_{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1}}">
            <option value="">Choose Product</option>
            @foreach(App\Models\Product::whereNull('user_id')->orWhere('supplier_id',Auth::user()->id)->get() as $product)    
            <option {{@$supplierPurchase && $supplierPurchase->product_id == $product->id ? 'selected' : '' }} value="{{$product->id}}">{{$product->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 mt-2">
        <label for="">Price</label>
        <input type="number" class="form-control"  name="price[]" id="purchase_price_{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1}}" value="{{@$supplierPurchase ? $supplierPurchase->price : '0' }}">
    </div>
    <div class="col-md-2 mt-2">
        <label for="">Qty</label>
        <input type="number"  class="form-control" id="purchase_qty_{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1}}"  onchange="purchaseQuantity('{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1}}')" name="qty[]" value="{{@$supplierPurchase ? $supplierPurchase->qty: '0' }}" >
    </div>
    <div class="col-md-3 mt-2">
        <label for="">Total Amount</label>
        <input type="number"  class="form-control" readonly name="total_amount[]" id="purchase_total_amount_{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1}}" value="{{@$supplierPurchase ? $supplierPurchase->total_amount : '0' }}" >
    </div>
    <div class="col-md-2 mt-2">
        @if(@$supplierPurchaseIndex && !@$supplierPurchase)
        <br>
        <button class="btn btn-danger btn-sm" onclick="purchaseRemoveField('{{@$supplierPurchaseIndex}}')" type="button">Remove</button>
        @endif
    </div>
    <div class="col-md-2 mt-2">
        <label for="">Access</label>
        <input type="hidden"  class="form-control" readonly name="access_total_amount[]" id="purchase_access_total_amount_{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1}}" value="{{@$supplierPurchase ? $supplierPurchase->access_total_amount : '0' }}" >
        <input type="number"  class="form-control"  name="access[]" onchange="purchaseAccess('{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1}}')" id="purchase_access_{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1}}" value="{{@$supplierPurchase ? $supplierPurchase->access : '0' }}">
    </div>
    <div class="col-md-2 mt-2">
        <label for="">Shortage</label>
        <input type="hidden"  class="form-control" readonly name="shortage_total_amount[]" id="purchase_shortage_total_amount_{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1}}" value="{{@$supplierPurchase ? $supplierPurchase->shortage_total_amount : '0' }}" >
        <input type="number"  class="form-control"  name="shortage[]" onchange="purchaseShortage('{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1}}')" id="purchase_shortage_{{@$supplierPurchaseIndex ? $supplierPurchaseIndex : 1}}" value="{{@$supplierPurchase ? $supplierPurchase->shortage : '0' }}">
    </div>
    <div class="col-md-2 mt-2">
        <label for="">Vehicle</label>
        <select class="form-control select-search" name="supplier_vehicle_id[]" >
            <option value="">Select Vehicle</option>
            @foreach(Auth::user()->vehicles as $vehicle)
            <option {{@$supplierPurchase && $supplierPurchase->supplier_vehicle_id == $vehicle->id ? 'selected' : '' }} value="{{$vehicle->id}}">{{$vehicle->name}}</option>
            @endforeach                                
        </select>
    </div>
    <div class="col-md-3 mt-2">
        <label for="">Terminal</label>
        <select class="form-control select-search" name="supplier_terminal_id[]" >
            <option value="">Select Terminal</option>
            @foreach(Auth::user()->terminals as $terminal)
            <option {{@$supplierPurchase && $supplierPurchase->supplier_terminal_id == $terminal->id ? 'selected' : '' }} value="{{$terminal->id}}">{{$terminal->name}}</option>
            @endforeach                                
        </select>
    </div>
    <div class="col-md-3 mt-2">
        <label for="">Vendor Account</label>
        <select class="form-control select-search" name="debit_credit_account_id[]">
            <option value="">Select Account</option>
            @foreach($vendorAccounts as $account)
            <option  {{@$supplierPurchase && $supplierPurchase->debit_credit_account_id == $account->id ? 'selected' : '' }} value="{{$account->id}}">{{$account->name}}</option>
            @endforeach                                
        </select>
    </div>
</div>