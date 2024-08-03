<div id="add-misc-purchase-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="{{route('user.purchase.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Add Purchase</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <input type="hidden" name="is_misc_purchase" value="1">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Products</label>
                            <select class="form-control select-search" name="product_id" id="misc_product_id" required data-fouc>
                                <option value="">Choose Product</option>
                                @foreach(App\Models\Product::where('user_id',Auth::user()->id)->get() as $product)    
                                <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Purchasing Price</label>
                            <input name="price" id="misc_purchase_price" type="text" value="{{old('price')}}" class="form-control" placeholder="Enter Product Price" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Selling  Price</label>
                            <input name="selling_price" id="misc_selling_price" type="text" value="{{old('selling_price')}}" class="form-control" placeholder="Enter Product Selling Price" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Qty</label>
                            <input name="qty" id="misc_purchase_qty" type="number" value="{{old('qty')?old('qty'):0}}" min="1" class="form-control" placeholder="Enter Product Quantity" required >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Total Amount</label>
                            <input name="total_amount" id="misc_purchase_total_amount" type="text" value="{{old('total_amount')?old('total_amount'):0}}" min="1" class="form-control" placeholder="Enter Product Total Amount" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Dip</label>
                            <input name="dip" id="misc_dip" type="number" value="{{old('dip')?old('dip'):0}}"  class="form-control" placeholder="Enter Product Dip"  >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Is For Supplier ? </label>
                            <br>
                            <input type="radio" name="is_supplier" value="1" checked> Yes
                            <input type="radio" name="is_supplier" value="0" > No
                        </div>
                        <input type="hidden" name="date" value="{{@$date}}">
                        <div class="form-group col-md-6">
                            <label>Vendor</label>
                            <select class="form-control select-search" name="vendor_id" id="misc_vendor_id" data-fouc>
                                <option value="">Choose Vendor</option>
                                @foreach(Auth::user()->vendors as $vendor)    
                                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Vendor Terminal</label>
                            <select class="form-control select-search" name="vendor_terminal_id" id="misc_vendor_terminal_id" data-fouc>
                                <option value="">Choose Vendor Terminal</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>