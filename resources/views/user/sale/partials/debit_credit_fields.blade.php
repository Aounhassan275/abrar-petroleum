<div class="row" id="remove-{{$key}}">
    <input type="hidden" name="debit_credit_id[]">
    <div class="form-group col-md-1">
        <button type="button"  class="btn btn-sm btn-danger" onclick="removeFields('{{ @$key }}')">Remove</button>
    </div>
    <div class="form-group col-md-2">
        <select name="account_id[]" id="credit_debit_account_{{$key}}"  onchange="debitCreditAccount('{{ @$key }}','1')"
        {{-- onchange="checkColor('{{ @$key }}')"  --}}
        class="form-control select-search">
            <option value="">Select</option>
            @foreach($accounts as $account)
            <option value="{{$account->id}}">{{$account->name}} @if($account->designation) ({{@$account->designation}}) @endif</option>
            @endforeach
        </select>
        <p id="error-account_id-{{$key}}" class="error-fields" style="color:red;display:none;">Account ID is required.</p> 
    </div>
    <div class="form-group col-md-2">
        <select name="product_id[]" id="credit_debit_product_{{$key}}" class="form-control select-search">
            <option value="">Select</option>
            @foreach($products as $product)
            <option value="{{$product->id}}">{{$product->name}}</option>
            @endforeach
        </select>
        <p id="error-product_id-{{$key}}" class="error-fields" style="color:red;display:none;">Product ID must be numeric.</p> 
    </div>
    <div class="form-group col-md-1">
        <input type="number" name="qty[]" id="credit_debit_qty_{{$key}}" onchange="debitQuantity('{{ @$key }}')" class="form-control" value="">
        <p id="error-qty-{{$key}}" class="error-fields" style="color:red;display:none;">Qty must be numeric.</p> 
    </div>
    <div class="col-md-4">
        <div class="row"> 
            <div class="form-group col-md-4">
                <input type="number" name="debit[]" id="credit_debit_debit_{{$key}}" class="form-control debit_values" value="">
                <p id="error-debit-{{$key}}" class="error-fields" style="color:red;display:none;">Debit must be numeric.</p> 
            </div>
            <div class="form-group col-md-4">
                <input type="number" name="credit[]" id="credit_debit_credit_{{$key}}" class="form-control credit_values" value="">
                <p id="error-credit-{{$key}}" class="error-fields" style="color:red;display:none;">Credit must be numeric.</p> 
            </div>
            <div class="form-group col-md-4">
                <input type="text" name="description[]" id="credit_debit_description_{{$key}}" class="form-control" value="">
            </div>

        </div>
    </div>
    <div class="form-group col-md-2">
        <select name="vehicle_id[]" id="credit_debit_vehicle_{{$key}}" class="form-control" readonly>
            <option value="">Select Vehicle</option>
        </select>
    </div>
</div>