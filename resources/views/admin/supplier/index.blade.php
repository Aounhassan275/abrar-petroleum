@extends('admin.layout.index')

@section('title')
    Add Supplier
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Add New Supplier</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.supplier.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Supplier Name</label>
                            <input name="name" type="text" class="form-control" placeholder="Enter Supplier Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Email</label>
                            <input name="email" type="email" class="form-control" placeholder="Enter Supplier Email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Password</label>
                            <input name="password" type="text" class="form-control" placeholder="Enter Supplier Password" required>
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
                <th>User Email</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach (App\Models\Supplier::all() as $key => $supplier)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$supplier->name}}</td>
                <td>{{$supplier->email}}</td>
                
                <td>
                    <button data-toggle="modal" data-target="#edit_modal" name="{{$supplier->name}}"
                        email="{{$supplier->email}}" id="{{$supplier->id}}" class="edit-btn btn btn-primary">Edit</button>
                </td>
                <td>
                    <form action="{{route('admin.supplier.destroy',$supplier->id)}}" method="POST">
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
                    <h5 class="modal-title mt-0" id="myModalLabel">Update Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Supplier Name</label>
                        <input class="form-control" type="text" id="name" name="name" placeholder="Enter Supplier Name" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Supplier Email</label>
                        <input class="form-control" type="email" id="email" name="email" placeholder="Enter Supplier Name" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Supplier Password <small style="color:red;">(Leave if blank if you don't want to change)</small></label>
                        <input class="form-control" type="text" id="password" name="password" placeholder="Enter Supplier Password">
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
            let email = $(this).attr('email');
            $('#email').val(email);
            $('#name').val(name);
            $('#id').val(id);
            $('#updateForm').attr('action','{{route('admin.supplier.update','')}}' +'/'+id);
        });
    });
</script>
@endsection