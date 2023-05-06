@extends('supplier.layout.index')

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
                <form action="{{route('supplier.product.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <input type="hidden" name="supplier_id" value="{{Auth::user()->id}}">
                        <div class="form-group col-md-6">
                            <label>Product Name</label>
                            <input name="name" type="text" class="form-control" value="{{old('name')}}" placeholder="Enter Product Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Own Purchasing Price</label>
                            <input name="supplier_purchasing_price" type="text" value="{{old('supplier_purchasing_price')}}" class="form-control" placeholder="Enter Own Purchasing Price" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Site Selling Price</label>
                            <input name="purchasing_price" type="text" value="{{old('purchasing_price')}}" class="form-control" placeholder="Enter Own Selling Price" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Site Selling Price</label>
                            <input name="selling_price" type="text" value="{{old('selling_price')}}" class="form-control" placeholder="Enter Site Selling Price" required>
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
                <th>Own Purchasing Price</th>
                <th>Own Selling Price</th>
                <th>Product Selling Price</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach (App\Models\Product::whereNull('user_id')->orWhere('supplier_id',Auth::user()->id)->get() as $key => $product)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->supplier_purchasing_price}}</td>
                <td>{{$product->purchasing_price}}</td>
                <td>{{$product->selling_price}}</td>
                <td>
                    <button data-toggle="modal" data-target="#edit_modal" name="{{$product->name}}"
                        purchasing_price="{{$product->purchasing_price}}" selling_price="{{$product->selling_price}}" 
                        supplier_purchasing_price="{{$product->supplier_purchasing_price}}"
                        id="{{$product->id}}" class="edit-btn btn btn-primary">Edit</button>
                </td>
                <td>
                    @if($product->supplier_id)
                    <form action="{{route('supplier.product.destroy',$product->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                    <button class="btn btn-danger">Delete</button>
                    </form>
                    @endif
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
                    <h5 class="modal-title mt-0" id="myModalLabel">Update Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input name="name" id="name" type="text" class="form-control" placeholder="Enter Product Name" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Own Purchasing Price</label>
                        <input name="supplier_purchasing_price" id="supplier_purchasing_price" type="text" value="{{old('supplier_purchasing_price')}}" class="form-control" placeholder="Enter Own Purchasing Price" required>
                    </div>
                    <div class="form-group">
                        <label>Own Selling Price</label>
                        <input name="purchasing_price" id="purchasing_price" type="text" value="{{old('purchasing_price')}}" class="form-control" placeholder="Enter Own Selling Price" required>
                    </div>
                    <div class="form-group">
                        <label>Site Selling Price</label>
                        <input name="selling_price" id="selling_price" type="text" class="form-control" placeholder="Enter Product Selling Price" required>
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
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('.edit-btn').click(function(){
            let id = $(this).attr('id');
            let name = $(this).attr('name');
            let purchasing_price = $(this).attr('purchasing_price');
            let supplier_purchasing_price = $(this).attr('supplier_purchasing_price');
            let selling_price = $(this).attr('selling_price');
            $('#purchasing_price').val(purchasing_price);
            $('#selling_price').val(selling_price);
            $('#supplier_purchasing_price').val(supplier_purchasing_price);
            $('#name').val(name);
            $('#id').val(id);
            $('#updateForm').attr('action','{{route('supplier.product.update','')}}' +'/'+id);
        });
    });
</script>
@endsection