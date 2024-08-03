
<form action="{{route('supplier.purchase.save')}}" method="post" id="purchaseForm" enctype="multipart/form-data" >
    @csrf
    
    <div class="form-group col-4">
        <label>
            Date
            <input type="text" name="date" id="purchase_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
            value="{{ date('m/d/Y', strtotime(@$date))}}">
        </label>   
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="productPurchasesFields">
                @if($supplierPurchases->count() > 0)
                    @foreach($supplierPurchases as $purchaseIndex => $supplierPurchase)
                        @include('supplier.sale.supplier_purchases.partials.fields',
                        [
                            'supplierPurchase' => $supplierPurchase,
                            'supplierPurchaseIndex' => $purchaseIndex+1,
                        ])
                    @endforeach
                @else
                    @include('supplier.sale.supplier_purchases.partials.fields')
                @endif
            </div>
            <p id="purchase-product-response"></p>
        </div>
    </div>     
    
    
    <div class="text-right" style="margin-top:10px;">
        <button type="button" id="add-more-fields-for-purchases" class="btn btn-primary add-more-fields-for-purchases">Add More Fields <i class="icon-plus ml-2"></i></button>
        <button type="button" id="save-product-purchase" class="btn btn-primary">Post <i class="icon-paperplane ml-2"></i></button>
    </div> 
    
</form>