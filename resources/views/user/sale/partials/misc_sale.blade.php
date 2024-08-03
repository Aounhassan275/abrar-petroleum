
<form action="{{route('user.sale.store')}}" method="post" id="miscSaleForm" enctype="multipart/form-data" >
    @csrf
    
    <div class="form-group col-4">
        <label>
            Date
            <input type="text" name="sale_date" id="misc-date" class="daterange-single form-control pull-right dates" style="height: 35px; "
            value="{{ date('m/d/Y', strtotime(@$date))}}">
        </label>   
    </div>
    <div class="text-right">
        
        <button type="button" data-toggle="modal" data-target="#add-misc-purchase-modal" 
        class="add-purchase-btn btn btn-primary btn-sm">Add New Purchase</button>
    </div>
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    <input name="is_misc_sale" value="1" type="hidden" >
    @foreach(Auth::user()->products as $product_index => $product)  
        @if($product->availableStock() > 0)
        <input type="hidden" name="product_id[]" value="{{$product->id}}">
        <input id="misc_stock_{{$product_index}}" value="{{$product->availableStock()}}" type="hidden" >
        <div class="row">
            <div class="form-group col-md-3">
                @if($product_index == 0)
                <br>
                @endif
                <label>{{$product->name}} - <span class="badge badge-success">Stock Available : {{$product->availableStock()}}</span></label>
            </div>
            <div class="form-group col-md-3">
                @if($product_index == 0)
                <label>Selling Price</label>
                @endif
                <input name="price[]" id="misc_price_{{$product_index}}" type="text" class="form-control" readonly value="{{@$product->selling_amount}}">
            </div>
            <div class="form-group col-md-3">
                @if($product_index == 0)
                <label>Qty</label>
                @endif
                <input name="qty[]" id="misc_qty_{{$product_index}}" type="number"  value="0" class="form-control" placeholder="Enter Product Quantity"  onchange="miscQuantity('{{ @$product_index }}')">
            </div>
            <div class="form-group col-md-3">
                @if($product_index == 0)
                <label>Total Amount</label>
                @endif
                <input name="total_amount[]" id="misc_total_amount_{{$product_index}}" type="text" readonly class="form-control">
            </div>
        </div>
        @endif
    @endforeach
    <div class="text-right" style="margin-top:10px;">
        <button type="button" id="save-misc-sale" class="btn btn-primary">Post <i class="icon-paperplane ml-2"></i></button>
    </div> 
    
</form>