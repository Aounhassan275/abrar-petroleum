<form action="{{route('user.debit_credit.update',Auth::user()->id)}}" method="post" id="debitCreditUpdateForm" enctype="multipart/form-data" >
    @method('PUT')
    @csrf
    <div class="row">
        <div class="form-group col-4">
            <label>
                Date
                <input type="text" name="sale_date" id="debit_credit_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                       value="{{ date('m/d/Y', strtotime(@$date))}}">
            </label>   
        </div>
        <div class="form-group col-8  text-right">
            <button type="button" class="btn btn-success add-more-fields">Add More Fields</button>
        </div>
    </div>

    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    <div class="row">
        <div class="form-group col-md-1">
            
        </div>
        <div class="form-group col-md-2">
            Party ID
        </div>
        <div class="form-group col-md-2">
            Product ID
        </div>
        <div class="form-group col-md-1">
            Qty
        </div>
        <div class="form-group col-md-2">
            Debit
        </div>
        <div class="form-group col-md-2">
            Credit
        </div>
        <div class="form-group col-md-2">
            Description
        </div>
    </div>      
    @foreach(Auth::user()->haveDebitCredit($date) as $key => $debit_credit)
    <div class="row">
        <input type="hidden" name="debit_credit_id[]" value="{{$debit_credit->id}}">
        <div class="form-group col-md-1"></div>
        <div class="form-group col-md-2">
            <select name="account_id[]" class="form-control" @if($debit_credit->account_id == 1 || $debit_credit->account_id == $cash_account_id) readonly @endif>
                @if($debit_credit->account_id == 1)
                    <option selected value="1">Sale</option>
                @elseif($debit_credit->account_id == $cash_account_id)
                    <option selected value="{{$cash_account_id}}">Cash</option>
                @else
                    @foreach($accounts as $account)
                    <option @if($debit_credit->account_id == $account->id) selected @endif value="{{$account->id}}">{{$account->name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="form-group col-md-2">
            @if($debit_credit->account_id == 1 || $debit_credit->account_id == $cash_account_id)
            <input type="text" name="product_id[]" class="form-control"  readonly >
            @else
            <select name="product_id[]" id="credit_debit_product_{{$key}}" class="form-control select-search">
                <option value="">Select</option>
                @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>

            @endif
        </div>
        <div class="form-group col-md-1">
            <input type="text" name="qty[]" value="{{@$debit_credit->qty}}" class="form-control" id="credit_debit_qty_{{$key}}" onchange="debitQuantity('{{ @$key }}')" @if($debit_credit->account_id == 1 || $debit_credit->account_id == $cash_account_id) readonly @endif>
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="debit[]" value="{{@$debit_credit->debit}}"  id="credit_debit_debit_{{$key}}" class="form-control" value="0"  @if($debit_credit->account_id == 1 || $debit_credit->account_id == $cash_account_id) readonly @endif>

        </div>
        <div class="form-group col-md-2">
            <input type="text" name="credit[]" value="{{@$debit_credit->credit}}" id="credit_debit_credit_{{$key}}" class="form-control"  @if($debit_credit->account_id == 1 || $debit_credit->account_id == $cash_account_id) readonly @endif value="{{Auth::user()->todaySaleAmount($date)}}">
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="description[]" value="{{@$debit_credit->description}}"  class="form-control" readonly value="">
        </div>
    </div>  
    @endforeach
    <div id="debit_credit_field">
        
    </div>
    <div class="text-right" style="margin-top:10px;">
        <button type="button" id="update-debit-credit-sale" class="btn btn-primary">Post <i class="icon-paperplane ml-2"></i></button>
    </div> 
    
</form>