<form action="{{route('user.debit_credit.update_form')}}" method="post" id="debitCreditUpdateForm" enctype="multipart/form-data" >
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
        <div class="col-md-4">
            <div class="row"> 
                <div class="form-group col-md-4">
                    Debit
                </div>
                <div class="form-group col-md-4">
                    Credit
                </div>
                <div class="form-group col-md-4">
                    Description
                </div>
            </div>
        </div>
        <div class="form-group col-md-2">
            Vehicle
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
        <div class="col-md-4">
            <div class="row"> 
                <div class="form-group col-md-4">
                    <input type="text"class="form-control" value="" readonly>

                </div>
                <div class="form-group col-md-4">
                    <input type="number" name="last_day_cash" class="form-control" readonly value="{{round($lastDayCash->debit)}}">
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" readonly value="">
                </div>
            </div>
        </div>
        <div class="form-group col-md-2">
            <select class="form-control" readonly>
                <option value="">Select Vehicle</option>
            </select>
        </div>
    </div>  
    @endif  
    @if(Auth::user()->haveDebitCredit($date)->where('account_id',42)->count() == 0)
    <div class="row">
        <div class="form-group col-md-1">
        </div>
        <div class="form-group col-md-2">
            <input type="hidden" name="debit_credit_id[]" value="">
            <select name="account_id[]" class="form-control" readonly>
                <option selected value="42">Sale</option>
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
    @endif
    @foreach(Auth::user()->haveDebitCredit($date) as $key => $debit_credit)
    <div class="row">
        <input type="hidden" name="debit_credit_id[]" value="{{$debit_credit->id}}">
        <div class="form-group col-md-1">
            <button onclick="deleteDebitCredit('{{$debit_credit->id}}')" type="button" class="btn btn-danger btn-sm">Delete</button>
        </div>
        <div class="form-group col-md-2">
            <select name="account_id[]" onchange="debitCreditAccount('{{ @$key }}','0')"
            id="credit_debit_account_id_{{$key}}"
            @if($debit_credit->account_id == null) style="color:red;" @endif
            class="form-control" required @if($debit_credit->account_id == 42 || $debit_credit->account_id == $cash_account_id) readonly @endif>
                <option >Select Account</option>
                @if($debit_credit->account_id == 42)
                    <option selected value="42">Sale</option>
                @elseif($debit_credit->account_id == $cash_account_id)
                    <option selected value="{{$cash_account_id}}">Cash in Hand</option>
                @else
                    @foreach($accounts as $account)
                    <option @if($debit_credit->account_id == $account->id) selected @endif value="{{$account->id}}">{{$account->name}}</option>
                    @endforeach
                @endif
            </select>
            <p id="error-account_id-{{$key}}" class="error-fields" style="color:red;display:none;">Account ID is required.</p> 
        </div>
        <div class="form-group col-md-2">
            @if($debit_credit->account_id == 42 || $debit_credit->account_id == $cash_account_id)
            <input type="text" name="product_id[]" 
            {{-- style="color:{{$debit_credit->account->accountCategory->color}};"  --}}
            class="form-control"  readonly >
            @else
            <select name="product_id[]" 
            {{-- style="color:{{$debit_credit->account->accountCategory->color}};"  --}}
            id="credit_debit_product_{{$key}}" class="form-control">
                <option value="">Select</option>
                @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->name}}</option>
                @endforeach
            </select>

            @endif
            <p id="error-product_id-{{$key}}" class="error-fields" style="color:red;display:none;">Product ID must be numeric.</p> 
        </div>
        <div class="form-group col-md-1">
            <input type="number" name="qty[]" 
            {{-- style="color:{{$debit_credit->account->accountCategory->color}};"  --}}
            value="{{@$debit_credit->qty}}" class="form-control" id="credit_debit_qty_{{$key}}" onchange="debitQuantity('{{ @$key }}')" @if($debit_credit->account_id == 42 || $debit_credit->account_id == $cash_account_id) readonly @endif>
            <p id="error-qty-{{$key}}" class="error-fields" style="color:red;display:none;">Qty must be numeric.</p> 
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="form-group col-md-4">
                    <input type="number" name="debit[]" 
                    {{-- style="color:{{$debit_credit->account->accountCategory->color}};"  --}}
                    value="{{round(@$debit_credit->debit,0)}}"  id="credit_debit_debit_{{$key}}" class="form-control {{$debit_credit->account_id == $cash_account_id ? 'cash_debit_values' : ''}}" @if($debit_credit->account_id == 42 || $debit_credit->account_id == $cash_account_id) readonly  @endif>
                    <p id="error-debit-{{$key}}" class="error-fields" style="color:red;display:none;">Debit must be numeric.</p> 
                </div>
                <div class="form-group col-md-4">
                    <input type="number" name="credit[]" 
                    {{-- style="color:{{$debit_credit->account->accountCategory->color}};"  --}}
                    value="{{round(@$debit_credit->credit)}}" id="credit_debit_credit_{{$key}}" class="form-control {{$debit_credit->account_id == $cash_account_id ? 'cash_credit_values' : ''}}"  @if($debit_credit->account_id == 42 || $debit_credit->account_id == $cash_account_id) readonly @endif>
                    <p id="error-credit-{{$key}}" class="error-fields" style="color:red;display:none;">Credit must be numeric.</p> 
                </div>
                <div class="form-group col-md-4">
                    <input type="text" name="description[]" 
                    {{-- style="color:{{$debit_credit->account->accountCategory->color}};"  --}}
                    value="{{@$debit_credit->description}}"  class="form-control" readonly value="">
                </div>

            </div>

        </div>
        <div class="form-group col-md-2">
            <select name="vehicle_id[]" id="credit_debit_vehicle_id_{{$key}}" class="form-control" @if(!$debit_credit->customer_vehicle_id) readonly @endif>
                <option value="">Select Vehicle</option>
                @foreach(App\Models\CustomerVehicle::where('debit_credit_account_id',$debit_credit->account_id)->get() as $customer_vehicle)
                <option {{$customer_vehicle->id == $debit_credit->customer_vehicle_id ? 'selected' : ''}} value="{{$customer_vehicle->id}}">{{$customer_vehicle->name}}</option>
                @endforeach
            </select>
        </div>
    </div>  
    @endforeach
    <div id="debit_credit_field">
        
    </div>
    @if(Auth::user()->haveDebitCredit($date)->where('account_id',$cash_account_id)->count() == 0)
      
    <div class="row">
        <div class="form-group col-md-1"></div>
        <div class="form-group col-md-2">
            <input type="hidden" name="debit_credit_id[]" value="">
            <select name="account_id[]" class="form-control" required readonly>
                <option selected value="{{$cash_account_id}}">Cash In Hand</option>

            </select>
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="product_id[]" class="form-control" readonly >
        </div>
        <div class="form-group col-md-1">
            <input type="number" name="qty[]" class="form-control" readonly >
        </div>
        <div class="form-group col-md-2">
            <input type="number" name="debit[]" class="form-control cash_debit_values" id="cash_debit_values" value="" readonly>

        </div>
        <div class="form-group col-md-2">
            <input type="number" name="credit[]" class="form-control cash_credit_values" id="cash_credit_values"  readonly>
        </div>
        <div class="form-group col-md-2">
            <input type="text" name="description[]" class="form-control" readonly value="">
        </div>
    </div> 
    @endif
    <div class="row">
        <div class="form-group col-md-3">
            <input type="text" value="Total Debit" class="form-control"  readonly >
        </div>
        <div class="form-group col-md-3">
            <input type="text" value="" id="total_debit_amount" class="form-control total_debit_amount" readonly >
        </div>
        <div class="form-group col-md-3">
            <input type="text" value="Total Credit" class="form-control"  readonly >
        </div>
        <div class="form-group col-md-3">
            <input type="text" value="" id="total_credit_amount" class="form-control total_credit_amount" readonly >
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12">
            <p id="error-message-reponse" style="color:red"></p> 
        </div>
    </div>
    <div class="text-right" style="margin-top:10px;"> 
        <button type="button" class="btn btn-success add-more-fields">Add More Fields</button>
        <button type="button" class="btn btn-primary calcluate-debit-credit-values-for-updates">Calcluate</button>
        <button type="button" id="update-debit-credit-sale" class="btn btn-primary">Post <i class="icon-paperplane ml-2"></i></button>
    </div> 
    
</form>