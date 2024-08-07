<form action="{{route('user.sale.update',Auth::user()->id)}}" method="post" id="dieselSaleUpdateForm" enctype="multipart/form-data" >
    @method('PUT')
    @csrf
    
    <div class="form-group col-4">
        <label>
            Date
            <input type="text" name="sale_date" id="diesel_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
            value="{{ date('m/d/Y', strtotime(@$date))}}">
        </label>   
    </div>
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    @foreach(Auth::user()->getDieselMachine() as $index => $diesel_machine)
    <input type="hidden" name="product_id" value="{{$diesel_machine->product_id}}">
    <input type="hidden" name="machine_id[]" value="{{$diesel_machine->id}}">
    <input name="price[]" id="diesel_price_{{$index}}" type="hidden" value="{{@$diesel_machine->product->selling_amount}}">
    <input name="total_amount[]" id="diesel_total_amount_{{$index}}" value="{{$diesel_machine->getSale($date)?$diesel_machine->getSale($date)->total_amount:''}}" type="hidden" >
    <input name="type[]" value="retail_sale" type="hidden" >
    <input type="hidden" name="sale_id[]" value="{{$diesel_machine->getSale($date)?$diesel_machine->getSale($date)->id:''}}">
    <div class="row">
        <div class="form-group col-md-3">
            @if($index != 0)
            <label>{{$diesel_machine->product->name}}-{{$diesel_machine->boot_number}}</label>
            @endif
            @if($index == 0)
            <br>
            <label>{{$diesel_machine->product->name}}-{{$diesel_machine->boot_number}}</label>
            @endif
        </div>
        <div class="form-group col-md-3">
            @if($index == 0)
            <label>Opening</label>
            @endif
            <input name="previous_reading[]" id="diesel_previous_reading_{{$index}}" type="text" value="{{$diesel_machine->getSale($date)?$diesel_machine->getSale($date)->previous_reading:$diesel_machine->meter_reading}}" class="form-control" placeholder="" readonly>
        </div>
        <div class="form-group col-md-3 ">
            @if($index == 0)
            <label>Closing</label>
            @endif
            <input name="current_reading[]" id="diesel_current_reading_{{$index}}" type="number" value="{{$diesel_machine->getSale($date)?$diesel_machine->getSale($date)->current_reading:''}}" onchange="dieselCurrentReading('{{ @$index }}')" class="form-control" placeholder="">
        </div>
        <div class="form-group col-md-3">
            @if($index == 0)
            <label>Qty</label>
            @endif
            <input name="qty[]" id="diesel_qty_{{$index}}" type="text" class="form-control diesel_sale_quantity" placeholder="Enter Product Quantity" value="{{$diesel_machine->getSale($date)?$diesel_machine->getSale($date)->qty:''}}"  readonly>
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
                            @if(Auth::user()->getTestSale($date,$diesel))
                            checked
                            @endif
                    > Testing 
                </label>
            </div>
        </div>
    </div>
    <div class="row" id="testing_fields" @if(Auth::user()->getTestSale($date,$diesel)) @else style="display:none;" @endif>
        <div class="form-group col-md-6">
            <label>Qty</label>
            <input type="hidden" name="testing_sale_id" value="{{Auth::user()->getTestSale($date,$diesel)?Auth::user()->getTestSale($date,$diesel)->id:null}}">
            <input type="number" class="form-control" style="width:50%;" value="{{Auth::user()->getTestSale($date,$diesel)?Auth::user()->getTestSale($date,$diesel)->qty:''}}" name="testing_quantity" id="diesel_testing_quantity">
        </div>
        @if(Auth::user()->getTestSale($date,$diesel))
        <div class="form-group col-md-6">
            <br>
            <button class="btn btn-danger btn-sm" type="button" onclick="deleteMiscSale('{{ Auth::user()->getTestSale($date,$diesel)->id }}')" >Delete</button>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <div class="checkbox">
                <label>
                    <input
                            name="whole_sale"
                            type="checkbox"
                            id="diesel_whole_sale"
                            @if(Auth::user()->getWholeSale($date,$diesel))
                            checked
                            @endif
                    > Whole Sale 
                </label>
            </div>
        </div>
    </div>
    <input type="hidden" name="whole_sale_id" value="{{Auth::user()->getWholeSale($date,$diesel)?Auth::user()->getWholeSale($date,$diesel)->id:null}}" id="">
    <div class="row" id="diesel_whole_sale_fields" @if(Auth::user()->getWholeSale($date,$diesel)) @else style="display:none;" @endif>
        <div class="form-group col-md-3">
            <label>Qty</label>
            <input type="number" class="form-control" style="width:50%;" name="wholesale_quantity" id="diesel_wholesale_quantity" value="{{Auth::user()->getWholeSale($date,$diesel)?Auth::user()->getWholeSale($date,$diesel)->qty:null}}">
        </div>
        <div class="form-group col-md-3">
            <label>Price</label>
            <input type="number" class="form-control" style="width:50%;" name="wholesale_price" id="diesel_wholesale_price" value="{{Auth::user()->getWholeSale($date,$diesel)?Auth::user()->getWholeSale($date,$diesel)->price:App\Models\Product::dieselSellingPrice()}}">
        </div>
        <div class="form-group col-md-3">
            <label>Total Amount</label>
            <input type="number" class="form-control" style="width:50%;" name="wholesale_total_amount" id="diesel_wholesale_total_amount" value="{{Auth::user()->getWholeSale($date,$diesel)?Auth::user()->getWholeSale($date,$diesel)->total_amount:null}}">
        </div>
        @if(Auth::user()->getWholeSale($date,$diesel))
        <div class="form-group col-md-3">
            <br>
            <button class="btn btn-danger btn-sm" type="button"  onclick="deleteMiscSale('{{ Auth::user()->getWholeSale($date,$diesel)->id }}')" >Delete</button>
        </div>
        @endif
    </div>
    {{-- <div class="row">
        <input type="hidden" name="dip_id" value="{{Auth::user()->getDip($date,$diesel)?Auth::user()->getDip($date,$diesel)->id:''}}">
        <div class="form-group col-md-2">
            <label>Dip</label>
            <input type="number" class="form-control" name="dip" value="{{Auth::user()->getDip($date,$diesel)?Auth::user()->getDip($date,$diesel)->access:''}}">
        </div>
    </div> --}}
    <div class="row">
        <div class="form-group col-md-3">
            <label>Total Sale</label>
            <input type="number" style="width:50%;" value="0" readonly class="form-control" min="0" id="diesel_total_sale" name="total_sale">
        </div>
    </div>
    <div class="row">
        <input type="hidden" name="sale_detail_id[]" value="{{Auth::user()->getSaleDetail($date,$diesel,'Day')?Auth::user()->getSaleDetail($date,$diesel,'Day')->id:''}}">
        <input type="hidden" name="sale_type[]" value="Day">
        <div class="form-group col-md-3">
            <label>Day Supply Sale</label>
            <input type="number" style="width:50%;" class="form-control" min="0" id="diesel_supply_sale" value="{{Auth::user()->getSaleDetail($date,$diesel,'Day')?Auth::user()->getSaleDetail($date,$diesel,'Day')->supply_sale:'0'}}" name="supply_sale[]" value="0" required>
            <p id="diesel-supply-sale-response" style="color:red;"></p>
        </div>
        <div class="form-group col-md-3">
            <label>Day Retail Sale</label>
            <input type="number" style="width:50%;" class="form-control"  min="0" id="diesel_retail_sale" value="{{Auth::user()->getSaleDetail($date,$diesel,'Day')?Auth::user()->getSaleDetail($date,$diesel,'Day')->retail_sale:'0'}}" name="retail_sale[]" value="0">
        </div>
        <div class="form-group col-md-3">
            <label>Day Total Sale</label>
            <input type="number" style="width:50%;" value="{{Auth::user()->getSaleDetail($date,$diesel,'Day')?Auth::user()->getSaleDetail($date,$diesel,'Day')->total_sale:'0'}}" readonly class="form-control" min="0" id="day_diesel_total_sale" name="day_and_night_sale[]">
        </div>
    </div>
    <div class="row">
        <input type="hidden" name="sale_detail_id[]" value="{{Auth::user()->getSaleDetail($date,$diesel,'Night')?Auth::user()->getSaleDetail($date,$diesel,'Night')->id:''}}">
        <input type="hidden" name="sale_type[]" value="Night">
        <div class="form-group col-md-3">
            <label>Night Supply Sale</label>
            <input type="number" style="width:50%;" class="form-control" min="0" id="night_diesel_supply_sale" value="{{Auth::user()->getSaleDetail($date,$diesel,'Night')?Auth::user()->getSaleDetail($date,$diesel,'Night')->supply_sale:'0'}}" name="supply_sale[]" required>
            <p id="night-diesel-supply-sale-response" style="color:red;"></p>
        </div>
        <div class="form-group col-md-3">
            <label>Night Retail Sale</label>
            <input type="number" style="width:50%;" class="form-control" min="0" id="night_diesel_retail_sale" value="{{Auth::user()->getSaleDetail($date,$diesel,'Night')?Auth::user()->getSaleDetail($date,$diesel,'Night')->retail_sale:'0'}}" name="retail_sale[]">
        </div>
        <div class="form-group col-md-3">
            <label>Night Total Sale</label>
            <input type="number" style="width:50%;" value="{{Auth::user()->getSaleDetail($date,$diesel,'Night')?Auth::user()->getSaleDetail($date,$diesel,'Night')->total_sale:'0'}}" readonly class="form-control" min="0" id="night_diesel_total_sale" name="day_and_night_sale[]">
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
                        <button type="button" data-toggle="modal" data-target="#add-purchase-modal" date="{{$date}}" product_name="HSD" product_id="1"
                           class="add-purchase-btn btn btn-primary btn-sm">Add New Purchase</button>

                    </td>
                    <td>{{Auth::user()->getTodayDieselPurchase($date)}}</td>
                </tr>
                <tr>
                    <td>Total Stock</td>
                    <td>{{Auth::user()->getTodayDieselPurchase($date) + Auth::user()->getDieselOpeningBalance($date)}}</td>
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
        <button type="button" id="update-diesel-sale" class="btn btn-primary">Update <i class="icon-paperplane ml-2"></i></button>
    </div> 
    
</form>