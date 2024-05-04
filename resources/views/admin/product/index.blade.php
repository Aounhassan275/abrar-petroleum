@extends('admin.layout.index')

@section('title')
    Add Product
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Add New Product</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.product.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Product Name</label>
                            <input name="name" type="text" class="form-control" value="{{old('name')}}" placeholder="Enter Product Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Purchasing Price</label>
                            <input name="purchasing_price" type="text" value="{{old('purchasing_price')}}" class="form-control" placeholder="Enter Product Purchasing Price" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Selling Price</label>
                            <input name="selling_price" type="text" value="{{old('selling_price')}}" class="form-control" placeholder="Enter Product Selling Price" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Display Order</label>
                            <input name="display_order" type="number" value="{{old('display_order')}}" class="form-control" placeholder="Enter Product Display Order" required>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Create <i class="icon-paperplane ml-2"></i></button>
                    </div>
                    
                </form>
            </div>
        </div>
        <!-- /basic layout -->

    </div>
</div>

<div class="card">

    <table class="table datatable-button-html5-basic">
        <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Product Purchasing Price</th>
                <th>Product Selling Price</th>
                <th>Site Rates</th>
                <th>Display Order</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach (App\Models\Product::whereNull('user_id')->orderBy('display_order','ASC')->get() as $key => $product)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->purchasing_price}}</td>
                <td>{{$product->selling_price}}</td>
                <td><button type="button"  class="btn btn-info btn-sm site-rate-btn" product_id="{{$product->id}}"> Site Rate</button></td>
                <td>{{$product->display_order}}</td>
                <td>
                    <button data-toggle="modal" data-target="#edit_modal" name="{{$product->name}}" display_order="{{$product->display_order}}"
                        purchasing_price="{{$product->purchasing_price}}" selling_price="{{$product->selling_price}}" id="{{$product->id}}" class="edit-btn btn btn-primary">Edit</button>
                </td>
                <td>
                    <form action="{{route('admin.product.destroy',$product->id)}}" method="POST">
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

<div id="edit_modal" class="modal fade">
    <div class="modal-dialog">
        <form id="updateForm" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input name="name" id="name" type="text" class="form-control" placeholder="Enter Product Name" required>
                    </div>
                    <div class="form-group">
                        <label>Product Purchasing Price</label>
                        <input name="purchasing_price" id="purchasing_price" type="text" class="form-control" placeholder="Enter Product Purchasing Price" required>
                    </div>
                    <div class="form-group">
                        <label>Product Selling Price</label>
                        <input name="selling_price" id="selling_price" type="text" class="form-control" placeholder="Enter Product Selling Price" required>
                    </div>
                    <div class="form-group">
                        <label>Product Change Date</label>
                        <input name="date" id="date" type="date" class="form-control" placeholder="Enter Product Selling Price" required>
                    </div>
                    <div class="form-group">
                        <label>Product Display Order</label>
                        <input name="display_order" id="display_order" type="number" class="form-control" placeholder="Enter Product Display Order" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="edit_global_rate_modal" class="modal fade">
    <div class="modal-dialog">
        <form id="updateglobalRateForm" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Update Global Product Rate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Product Selling Price</label>
                        <input name="selling_price" id="global_selling_price" type="text" class="form-control" placeholder="Enter Product Selling Price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@include('admin.product.partials.site_rate_popup')
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('.edit-btn').click(function(){
            let id = $(this).attr('id');
            let name = $(this).attr('name');
            let purchasing_price = $(this).attr('purchasing_price');
            let selling_price = $(this).attr('selling_price');
            let display_order = $(this).attr('display_order');
            $('#display_order').val(display_order);
            $('#purchasing_price').val(purchasing_price);
            $('#selling_price').val(selling_price);
            $('#name').val(name);
            $('#id').val(id);
            $('#updateForm').attr('action','{{route('admin.product.update','')}}' +'/'+id);
        });
        $('.site-rate-btn').click(function(){
            let product_id = $(this).attr('product_id');
            $.ajax({
                url: "{{route('admin.product.get_site_rate')}}",
                method: 'post',
                data: {product_id : product_id},
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    $("#site-rate-content").html(response.html);
                    $("#site-rate-modal").modal('show');
                }
            });
        });
        $(document).on('click','#save-product-rate',function(){
            data = $('#storeProductRateForm').serialize();
            $('.save-product-rate').attr('disabled',true);
            $('.save-product-rate').html('Please Wait');
            $("#store-response").html("")
            $.ajax({
                url: "{{route('admin.global_product_rate.store')}}",
                method: 'post',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    if(response.success)
                    {
                        $("#store-response").removeClass('error_reponse');
                        $("#store-response").addClass('success_reponse');
                        $("#store-response").html(response.message);
                        setTimeout(() => {
                            $("#site-rate-content").html(response.html);
                        }, 1500);
                    }else{
                        $("#store-response").removeClass('success_reponse');
                        $("#store-response").addClass('error_reponse');
                        $("#store-response").html(response.message);
                    }
                    $('.save-product-rate').attr('disabled',false);
                    $('.save-product-rate').html('Create');
                }
            });
        });
    });
    function changeRate(id,sellingPrice)
    {
        $("#site-rate-modal").modal('hide');
        $("#edit_global_rate_modal").modal('show');
        $('#global_selling_price').val(sellingPrice);
        $('#updateglobalRateForm').attr('action','{{route('admin.global_product_rate.update','')}}' +'/'+id);
    }
</script>
@endsection