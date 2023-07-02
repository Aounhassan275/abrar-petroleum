@extends('admin.layout.index')

@section('title')
{{$product->name}} Rates For Sites
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">{{$product->name}} Rate For Sites</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.global_product_rate.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <input name="product_id" type="hidden" class="form-control" value="{{$product->id}}" placeholder="Enter Product Name" required>
                        <div class="form-group col-md-6">
                            <label>User Name</label>
                            <select class="form-control select-search" name="user_id" required>
                                <option value="">Choose User</option>
                                @foreach(App\Models\User::where('type','Site')->get() as $user)
                                <option value="{{$user->id}}">{{$user->username}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Product Selling Price</label>
                            <input name="selling_price" type="text" value="{{$product->selling_price}}" class="form-control" placeholder="Enter Product Selling Price" required>
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
                <th>User Name</th>
                <th>Product Selling Price</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach (App\Models\GlobalProductRate::where('product_id',$product->id)->get() as $key => $global_product)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$global_product->user->username}}</td>
                <td>{{$global_product->selling_price}}</td>
                <td>
                    <button data-toggle="modal" data-target="#edit_modal" selling_price="{{$global_product->selling_price}}" id="{{$global_product->id}}" class="edit-btn btn btn-primary">Edit</button>
                </td>
                <td>
                    <form action="{{route('admin.global_product_rate.destroy',$product->id)}}" method="POST">
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
                    <h5 class="modal-title mt-0" id="myModalLabel">Update Global Product Rate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Product Selling Price</label>
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
            let selling_price = $(this).attr('selling_price');
            $('#purchasing_price').val(purchasing_price);
            $('#selling_price').val(selling_price);
            $('#name').val(name);
            $('#id').val(id);
            $('#updateForm').attr('action','{{route('admin.global_product_rate.update','')}}' +'/'+id);
        });
    });
</script>
@endsection