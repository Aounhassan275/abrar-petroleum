<form action="{{route('user.sale.store')}}" method="post" id="petrolSaleForm" enctype="multipart/form-data" >
    @csrf
    
    <div class="form-group col-4">
        <label>
            Date
            <input type="text" name="sale_date" id="date" class="daterange-single form-control pull-right dates" style="height: 35px; "
            value="{{ date('m/d/Y', strtotime(@$date))}}">
        </label>   
    </div>
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    @foreach(Auth::user()->getPetrolMachine() as $index => $petrol_machine)
    <input type="hidden" name="product_id" value="{{$petrol_machine->product_id}}">
    <input type="hidden" name="machine_id[]" value="{{$petrol_machine->id}}">
    <input name="price[]" id="petrol_price_{{$index}}" type="hidden" value="{{@$petrol_machine->product->selling_amount}}">
    <input name="total_amount[]" id="petrol_total_amount_{{$index}}" type="hidden" >
    <input name="type[]" value="retail_sale" type="hidden" >
    <div class="row">
        <div class="form-group col-md-3">
            @if($index != 0)
            <label>{{$petrol_machine->product->name}}-{{$petrol_machine->boot_number}}</label>
            @endif
            @if($index == 0)
            <br>
            <label>{{$petrol_machine->product->name}}-{{$petrol_machine->boot_number}}</label>
            @endif
        </div>
        <div class="form-group col-md-3">
            @if($index == 0)
            <label>Opening</label>
            @endif
            <input name="previous_reading[]" id="petrol_previous_reading_{{$index}}" type="text" value="{{$petrol_machine->meter_reading}}" class="form-control" placeholder="" readonly>
        </div>
        <div class="form-group col-md-3 ">
            @if($index == 0)
            <label>Closing</label>
            @endif
            <input name="current_reading[]" id="petrol_current_reading_{{$index}}" type="number" onchange="petrolCurrentReading('{{ @$index }}')" value="{{old('current_reading')}}" class="form-control" placeholder="">
        </div>
        <div class="form-group col-md-3">
            @if($index == 0)
            <label>Qty</label>
            @endif
            <input name="qty[]" id="petrol_qty_{{$index}}" type="text" value="{{old('qty')}}" class="form-control" placeholder="Enter Product Quantity"  readonly>
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
                            id="petrol_testing"
                    > Testing 
                </label>
            </div>
        </div>
    </div>
    <div class="row" id="petrol_testing_fields" style="display:none;">
        <div class="form-group col-md-6">
            <label>Qty</label>
            <input type="number" class="form-control" name="testing_quantity" id="">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <div class="checkbox">
                <label>
                    <input
                            name="whole_sale"
                            type="checkbox"
                            id="petrol_whole_sale"
                    > Whole Sale 
                </label>
            </div>
        </div>
    </div>
    <div class="row" id="petrol_whole_sale_fields" style="display:none;">
        <div class="form-group col-md-4">
            <label>Qty</label>
            <input type="number" class="form-control" name="wholesale_quantity" id="petrol_wholesale_quantity">
        </div>
        <div class="form-group col-md-4">
            <label>Price</label>
            <input type="number" class="form-control" name="wholesale_price" id="petrol_wholesale_price" value="{{App\Models\Product::petrolSellingPrice()}}">
        </div>
        <div class="form-group col-md-4">
            <label>Total Amount</label>
            <input type="number" class="form-control" name="wholesale_total_amount" id="petrol_wholesale_total_amount">
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-md-2">
            <label>Dip</label>
            <input type="number" class="form-control" name="dip">
        </div>
    </div>
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Petrol</td>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <td>Opening</td>
                    <td>{{Auth::user()->getPetrolOpeningBalance($date)}}</td>
                </tr>
                <tr>
                    <td>
                        Purchase 
                        <button type="button" data-toggle="modal" data-target="#add-purchase-modal" product_name="PMG" product_id="2"
                           class="add-purchase-btn btn btn-primary btn-sm">Add New Purchase</button>

                    </td>
                    <td>{{Auth::user()->getTodayPetrolPurchase($date)}}</td>
                </tr>
                <tr>
                    <td>Total Stock</td>
                    <td>{{Auth::user()->getTodayPetrolPurchase($date) + Auth::user()->getPetrolOpeningBalance($date)}}</td>
                </tr>
                <tr>
                    <td>Sales</td>
                    <td  id="petrol_sales">{{Auth::user()->getTodayPetrolSale($date)}}</td>
                </tr>
                <tr>
                    <td>Closing</td>
                    <td>{{Auth::user()->getTodayPetrolPurchase($date) + Auth::user()->getPetrolOpeningBalance($date) - Auth::user()->getTodayPetrolSale($date)}}</td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="text-right" style="margin-top:10px;">
        <button type="button" id="save-petrol-sale" class="btn btn-primary">Post <i class="icon-paperplane ml-2"></i></button>
    </div> 
    
</form>