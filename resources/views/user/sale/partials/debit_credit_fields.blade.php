<div class="row" id="remove-{{$key}}">
    <input type="hidden" name="debit_credit_id[]">
    <div class="form-group col-md-1">
        <button type="button"  class="btn btn-sm btn-danger" onclick="removeFields('{{ @$key }}')">Remove</button>
    </div>
    <div class="form-group col-md-2">
        <select name="account_id[]" id="credit_debit_account_{{$key}}" 
        {{-- onchange="checkColor('{{ @$key }}')"  --}}
        class="form-control select-search">
            <option value="">Select</option>
            @foreach($accounts as $account)
            <option value="{{$account->id}}">{{$account->name}} @if($account->designation) ({{@$account->designation}}) @endif</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-2">
        <select name="product_id[]" id="credit_debit_product_{{$key}}" class="form-control select-search">
            <option value="">Select</option>
            @foreach($products as $product)
            <option value="{{$product->id}}">{{$product->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-1">
        <input type="number" name="qty[]" id="credit_debit_qty_{{$key}}" onchange="debitQuantity('{{ @$key }}')" class="form-control" value="">
    </div>
    <div class="form-group col-md-2">
        <input type="number" name="debit[]" id="credit_debit_debit_{{$key}}" class="form-control debit_values" value="">

    </div>
    <div class="form-group col-md-2">
        <input type="number" name="credit[]" id="credit_debit_credit_{{$key}}" class="form-control credit_values" value="">
    </div>
    <div class="form-group col-md-2">
        <input type="text" name="description[]" id="credit_debit_description_{{$key}}" class="form-control" value="">
    </div>
</div>