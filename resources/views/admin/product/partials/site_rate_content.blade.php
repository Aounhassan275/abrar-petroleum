
<div class="modal-header">
    <h5 class="modal-title mt-0" id="myModalLabel">{{$product->name}} Rates For Sites</h5>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form id="storeProductRateForm" >
        <div class="row">
            <input name="product_id" type="hidden" class="form-control" value="{{$product->id}}" placeholder="Enter Product Name" required>
            <div class="form-group col-md-6">
                <label>User Name</label>
                <select class="form-control select-search" name="user_id" required>
                    <option value="">Choose User</option>
                    @foreach(App\Models\User::where('type','Site')->get() as $user)
                    @if(!in_array($user->id,$userIds))
                    <option value="{{$user->id}}">{{$user->username}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Product Selling Price</label>
                <input name="selling_price" type="text" value="{{$product->selling_price}}" class="form-control" placeholder="Enter Product Selling Price" required>
            </div>
        </div>
        <p id="store-response"></p>
        <div class="text-right">
            <button type="button" id="save-product-rate" class="btn btn-primary save-product-rate">Create <i class="icon-paperplane ml-2"></i></button>
        </div>
    </form>
        <table class="table datatable-button-html5-basic">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Product Selling Price</th>
                    <th>Action</th>
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($globalProductRates as $key => $global_product)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$global_product->user->username}}</td>
                    <td>{{$global_product->selling_price}}</td>
                    <td>
                        <button type="button" selling_price="" id="{{$global_product->id}}" onclick="changeRate('{{ @$global_product->id }}','{{ @$global_product->selling_price }}')" class="edit-global-rate-btn btn btn-primary">Edit</button>
                    </td>
                    <td>
                        <form action="{{route('admin.global_product_rate.destroy',$global_product->id)}}" method="POST">
                            @method('DELETE')
                            @csrf
                        <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
{{-- <div class="modal-footer"> --}}
    {{-- <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button> --}}
    {{-- <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button> --}}
{{-- </div> --}}