
<form action="{{route('user.sale.store')}}" method="post" id="dieselSaleForm" enctype="multipart/form-data" >
    @csrf
    
    <div class="form-group col-4">
        <label>
            Date
            <input type="text" name="sale_date" id="diesel_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
            value="{{ date('m/d/Y', strtotime(@$date))}}">
        </label>   
    </div>
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    @foreach(Auth::user()->getDieselMachine() as $key => $machine)
    <input type="hidden" name="product_id" value="{{$machine->product_id}}">
    <input type="hidden" name="machine_id[]" value="{{$machine->id}}">
    <input name="price[]" id="diesel_price_{{$key}}" type="hidden" value="{{@$machine->product->selling_amount}}">
    <input name="total_amount[]" id="diesel_total_amount_{{$key}}" type="hidden" >
    <input name="type[]" value="retail_sale" type="hidden" >
    <div class="row">
        <div class="form-group col-md-3 machine_fields">
            @if($key != 0)
            <label>{{$machine->product->name}}-{{$machine->boot_number}}</label>
            @endif
            @if($key == 0)
            <br>
            <label>{{$machine->product->name}}-{{$machine->boot_number}}</label>
            @endif
        </div>
        <div class="form-group col-md-3 machine_fields">
            @if($key == 0)
            <label>Opening</label>
            @endif
            <input name="previous_reading[]" id="diesel_previous_reading_{{$key}}" type="text" value="{{$machine->meter_reading}}" class="form-control" placeholder="" readonly>
        </div>
        <div class="form-group col-md-3 machine_fields">
            @if($key == 0)
            <label>Closing</label>
            @endif
            <input name="current_reading[]" id="diesel_current_reading_{{$key}}" type="number" onchange="dieselCurrentReading('{{ @$key }}')" value="{{old('current_reading')}}" class="form-control" placeholder="">
        </div>
        <div class="form-group col-md-3">
            @if($key == 0)
            <label>Qty</label>
            @endif
            <input name="qty[]" id="diesel_qty_{{$key}}" type="text" value="{{old('qty')}}" class="form-control diesel_sale_quantity" placeholder="Enter Product Quantity"  readonly>
        </div>
    </div>
    @endforeach
    <div class="row">
        <div class="form-group col-md-6">
            <div class="checkbox">
                <label>
                    <input
                            name="testing"
                            type="checkbox"
                            id="testing"
                    > Testing 
                </label>
            </div>
        </div>
    </div>
    <div class="row" id="testing_fields" style="display:none;">
        <div class="form-group col-md-6">
            <label>Qty</label>
            <input type="number" class="form-control" name="testing_quantity" id="diesel_testing_quantity">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <div class="checkbox">
                <label>
                    <input
                            name="whole_sale"
                            type="checkbox"
                            id="diesel_whole_sale"
                    > Whole Sale 
                </label>
            </div>
        </div>
    </div>
    <div class="row" id="diesel_whole_sale_fields" style="display:none;">
        <div class="form-group col-md-4">
            <label>Qty</label>
            <input type="number" class="form-control" name="wholesale_quantity" id="diesel_wholesale_quantity">
        </div>
        <div class="form-group col-md-4">
            <label>Price</label>
            <input type="number" class="form-control" name="wholesale_price" id="diesel_wholesale_price" value="{{App\Models\Product::dieselSellingPrice()}}">
        </div>
        <div class="form-group col-md-4">
            <label>Total Amount</label>
            <input type="number" class="form-control" name="wholesale_total_amount" id="diesel_wholesale_total_amount">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-2">
            <label>Dip</label>
            <input type="number" class="form-control" name="dip">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Total Sale</label>
            <input type="number" value="0" readonly class="form-control" min="0" id="diesel_total_sale" name="total_sale">
        </div>
    </div>
    <div class="row">
        <input type="hidden" name="sale_type[]" value="Day">
        <div class="form-group col-md-3">
            <label>Day Supply Sale</label>
            <input type="number" class="form-control" min="0" id="diesel_supply_sale" value="0" name="supply_sale[]" value="0" required>
            <p id="supply-sale-response" style="color:red;"></p>
        </div>
        <div class="form-group col-md-3">
            <label>Day Retail Sale</label>
            <input type="number"  class="form-control"  min="0" id="diesel_retail_sale" value="0" name="retail_sale[]" value="0">
        </div>
        <div class="form-group col-md-3">
            <label>Day Total Sale</label>
            <input type="number" value="0" readonly class="form-control" min="0" id="day_diesel_total_sale" name="day_and_night_sale[]">
        </div>
    </div>
    <div class="row">
        <input type="hidden" name="sale_type[]" value="Night">
        <div class="form-group col-md-3">
            <label>Night Supply Sale</label>
            <input type="number" class="form-control" min="0" id="night_diesel_supply_sale" value="0" name="supply_sale[]" required>
            <p id="night-diesel-supply-sale-response" style="color:red;"></p>
        </div>
        <div class="form-group col-md-3">
            <label>Night Retail Sale</label>
            <input type="number"  class="form-control" min="0" id="night_diesel_retail_sale" value="0" name="retail_sale[]">
        </div>
        <div class="form-group col-md-3">
            <label>Night Total Sale</label>
            <input type="number" value="0" readonly class="form-control" min="0" id="night_diesel_total_sale" name="day_and_night_sale[]">
        </div>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Diesel</td>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <td>Opening</td>
                    <td>{{Auth::user()->getDieselOpeningBalance($date)}}</td>
                </tr>
                <tr>
                    <td>
                        Purchase 
                        <button type="button" data-toggle="modal" data-target="#add-purchase-modal" product_name="HSD" product_id="1"
                            class="add-purchase-btn btn btn-primary btn-sm">Add New Purchase</button>

                    </td>
                    <td>{{Auth::user()->getTodayDieselPurchase($date)}}</td>
                </tr>
                <tr>
                    <td>Total Stock</td>
                    <td>{{Auth::user()->getDieselOpeningBalance($date) + Auth::user()->getTodayDieselPurchase($date)}}</td>
                </tr>
                <tr>
                    <td>Sales</td>
                    <td id="diesel_sales">{{Auth::user()->getTodayDieselSale($date)}}</td>
                </tr>
                <tr>
                    <td>Closing</td>
                    <td>{{Auth::user()->getDieselOpeningBalance($date) + Auth::user()->getTodayDieselPurchase($date) - Auth::user()->getTodayDieselSale($date)}}</td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="text-right" style="margin-top:10px;">
        <button type="button" id="save-diesel-sale" class="btn btn-primary">Post <i class="icon-paperplane ml-2"></i></button>
    </div> 
    
</form>