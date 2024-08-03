
<form action="{{route('supplier.sale.store')}}" method="post" id="productSaleForm" enctype="multipart/form-data" >
    @csrf
    
    <div class="form-group col-4">
        <label>
            Date
            <input type="text" name="date" id="date" class="daterange-single form-control pull-right dates" style="height: 35px; "
            value="{{ date('m/d/Y', strtotime(@$date))}}">
        </label>   
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table text-center">
                <thead>
                    <tr>
                        <td colspan="7">
                            <strong>Site Sales</strong> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Site</strong> 
                        </td>
                        <td>
                            <strong>Product</strong> 
                        </td>
                        <td>
                            <strong>Qty</strong> 
                            
                        </td>
                        <td>
                            <strong>Price</strong> 
                            
                        </td>
                        <td>
                            <strong>Total Amount</strong> 
                            
                        </td>
                        <td>
                            <strong>Vehicle</strong> 
                            
                        </td>
                        <td>
                            <strong>Action</strong> 
                            
                        </td>
                    </tr>
                </thead>
                <tbody id="siteSaleFields">
                    @if($purchases->count() > 0)
                        @foreach($purchases as $index => $purchase)
                            @include('supplier.sale.partials.product_sale_fields',
                            [
                                'purchase' => $purchase,
                                'key' => $index+1,
                            ])
                        @endforeach
                    @else
                        @include('supplier.sale.partials.product_sale_fields')
                    @endif
                </tbody>
            </table>
            <p id="product-sale-response"></p>
        </div>
    </div>     
    
    
    <div class="text-right" style="margin-top:10px;">
        <button type="button" id="add-more-fields" class="btn btn-primary add-more-fields">Add More Fields <i class="icon-plus ml-2"></i></button>
        <button type="button" id="save-product-sale" class="btn btn-primary">Post <i class="icon-paperplane ml-2"></i></button>
    </div> 
    
</form>