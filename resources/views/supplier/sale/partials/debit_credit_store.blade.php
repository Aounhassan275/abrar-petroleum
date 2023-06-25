<form action="{{route('supplier.debit_credit.store')}}" method="post" id="debitCreditForm" enctype="multipart/form-data" >
    @csrf
    <div class="row">
        <div class="form-group col-4">
            <label>
                Date
                <input type="text" name="sale_date" id="debit_credit_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                    value="{{ date('m/d/Y', strtotime(@$date))}}">
            </label>   
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
    @if($lastDayCash)
    <div class="row">
        <div class="form-group col-md-1"></div>
        <div class="form-group col-md-2">
            <input type="text" value="Last Day Cash In Hand" class="form-control" readonly>
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" readonly >
        </div>
        <div class="form-group col-md-1">
            <input type="text" class="form-control" readonly >
        </div>
        <div class="form-group col-md-2">
            <input type="text"class="form-control" value="" readonly>

        </div>
        <div class="form-group col-md-2">
            <input type="text" name="last_day_cash" class="form-control" readonly value="{{round($lastDayCash->debit)}}">
        </div>
        <div class="form-group col-md-2">
            <input type="text" class="form-control" readonly value="">
        </div>
    </div>  
    @endif     
    <div class="row">
        <div class="form-group col-md-1"></div>
        <div class="form-group col-md-2">
            <select name="account_id[]" class="form-control" readonly>
                <option selected value="42">Sale</option>
                {{-- @foreach($accounts as $account)
                <option value="{{$account->id}}">{{$account->name}}</option>
                @endforeach --}}
            </select>
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="product_id[]" class="form-control" readonly >
        </div>
        <div class="form-group col-md-1">
            <input type="text" name="qty[]" class="form-control" readonly >
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="debit[]" class="form-control" value="" readonly>

        </div>
        <div class="form-group col-md-2">
            <input type="text" name="credit[]" class="form-control" readonly value="{{round(Auth::user()->todaySaleAmount($date))}}">
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="description[]" class="form-control" readonly value="">
        </div>
    </div> 
    <div id="debit_credit_field">
        
    </div>    
    <div class="row">
        <div class="form-group col-md-1"></div>
        <div class="form-group col-md-2">
            <select name="account_id[]" class="form-control" readonly>
                <option selected value="{{$cash_account_id}}">Cash In Hand</option>

            </select>
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="product_id[]" class="form-control" readonly >
        </div>
        <div class="form-group col-md-1">
            <input type="text" name="qty[]" class="form-control" readonly >
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="debit[]" class="form-control cash_debit_values" id="cash_debit_values" value="" readonly>
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="credit[]" class="form-control cash_credit_values" id="cash_credit_values"  readonly>
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="description[]" class="form-control" readonly value="">
        </div>
    </div>    
    <div class="row">
        <div class="form-group col-md-3">
            <input type="text" value="Total Debit" class="form-control" readonly >
        </div>
        <div class="form-group col-md-3">
            <input type="text" value="" id="total_debit_amount" class="form-control total_debit_amount" readonly >
        </div>
        <div class="form-group col-md-3">
            <input type="text" value="Total Credit" class="form-control" readonly >
        </div>
        <div class="form-group col-md-3">
            <input type="text" value="" id="total_credit_amount" class="form-control total_credit_amount" readonly >
        </div>
    </div> 
    <div class="text-right" style="margin-top:10px;">
        <button type="button" class="btn btn-success add-more-fields">Add More Fields</button>
        <button type="button" class="btn btn-primary calcluate-debit-credit-values">Calcluate</button>
        <button type="button" id="store-debit-credit-sale" class="btn btn-primary">Post <i class="icon-paperplane ml-2"></i></button>
    </div> 
    
</form>