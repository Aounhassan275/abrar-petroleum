<form action="{{route('supplier.sale.store')}}" method="post" id="dieselSaleForm" enctype="multipart/form-data" >
    @csrf
    
    <div class="form-group col-4">
        <label>
            Date
            <input type="text" name="sale_date" id="diesel_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
            value="{{ date('m/d/Y', strtotime(@$date))}}">
        </label>   
    </div>
    <input type="hidden" name="supplier_id" value="{{Auth::user()->id}}">
    @foreach($products as $key => $product)
    <input type="hidden" name="product_id[]" value="{{$product->product_id}}">
    <div class="row">
        <div class="form-group col-md-3 machine_fields">
            @if($key != 0)
            <label>{{$product->name}}</label>
            @endif
            @if($key == 0)
            <br>
            <label>{{$product->name}}</label>
            @endif
        </div>
        <div class="form-group col-md-3 machine_fields">
            @if($key == 0)
            <label>Qty</label>
            @endif
            <input name="sale_qty[]" id="sale_qty_{{$key}}" type="text"  class="form-control" onchange="productSaleQuantity('{{ @$key }}')" placeholder="">
        </div>
        <div class="form-group col-md-3 machine_fields">
            @if($key == 0)
            <label>Price</label>
            @endif
            <input name="sale_price[]" id="sale_price_{{$key}}" type="number" onchange="productSalePrice('{{ @$key }}')"  class="form-control" placeholder="">
        </div>
        <div class="form-group col-md-3">
            @if($key == 0)
            <label>Total Amount</label>
            @endif
            <input name="sale_total_amount[]" id="sale_total_amount_{{$key}}" type="text" class="form-control" placeholder="Enter Product Amount"  readonly>
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
            <input type="number" class="form-control" name="testing_quantity" id="testing_quantity">
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
    <div class="text-right" style="margin-top:10px;">
        <button type="button" id="save-product-sale" class="btn btn-primary">Post <i class="icon-paperplane ml-2"></i></button>
    </div> 
    
</form>