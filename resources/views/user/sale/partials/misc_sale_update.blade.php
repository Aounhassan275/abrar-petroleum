
<form action="{{route('user.sale.update',Auth::user()->id)}}" method="post" id="miscSaleUpdateForm" enctype="multipart/form-data" >
    @method('PUT')
    @csrf
    
    <div class="form-group col-4">
        <label>
            Date
            <input type="text" name="sale_date" id="misc-date" class="daterange-single form-control pull-right dates" style="height: 35px; "
            value="{{ date('m/d/Y', strtotime(@$date))}}">
        </label>   
    </div>
    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
    <input name="is_misc_sale" value="1" type="hidden" >
    @foreach(Auth::user()->products as $product_index => $product)  
        <input type="hidden" name="sale_id[]" value="{{$product->getSale($date)?$product->getSale($date)->id:''}}">
        <input type="hidden" name="product_id[]" value="{{$product->id}}">
        <input id="misc_stock_{{$product_index}}" value="{{$product->availableStock()}}" type="hidden" >
        <div class="row">
            <div class="form-group col-md-2">
                @if($product_index == 0)
                <br>
                @endif
                <label>{{$product->name}} - <span class="badge badge-success">Stock Available : {{$product->availableStock()}}</span></label>
            </div>
            <div class="form-group col-md-2">
                @if($product_index == 0)
                <label>Selling Price</label>
                @endif
                <input name="price[]" id="misc_price_{{$product_index}}" type="text" class="form-control" readonly value="{{$product->getSale($date)?$product->getSale($date)->price:@$product->selling_amount}}">
            </div>
            <div class="form-group col-md-3">
                @if($product_index == 0)
                <label>Qty</label>
                @endif
                <input name="qty[]" id="misc_qty_{{$product_index}}" type="number"  value="{{$product->getSale($date)?$product->getSale($date)->qty:''}}" class="form-control" placeholder="Enter Product Quantity"  onchange="miscQuantity('{{ @$product_index }}')">
            </div>
            <div class="form-group col-md-3">
                @if($product_index == 0)
                <label>Total Amount</label>
                @endif
                <input name="total_amount[]" id="misc_total_amount_{{$product_index}}" type="text"  value="{{$product->getSale($date)?$product->getSale($date)->total_amount:''}}" readonly class="form-control">
            </div>
            <div class="form-group col-md-2">
                @if($product_index == 0)
                <br>
                @endif
                @if($product->getSale($date))
                    <button type="button" onclick="deleteMiscSale('{{ $product->getSale($date)->id }}')" class="btn btn-danger btn-sm">Remove</button>
                @endif
            </div>
        </div>
    @endforeach
    <div class="text-right" style="margin-top:10px;">
        <button type="button" id="update-misc-sale" class="btn btn-primary">Post <i class="icon-paperplane ml-2"></i></button>
    </div> 
    
</form>