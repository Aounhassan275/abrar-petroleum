@extends('admin.layout.index')

@section('title')
    Add User
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Add New User</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.user.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>User Name</label>
                            <input name="username" type="text" class="form-control" placeholder="Enter User Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>User Password</label>
                            <input name="password" type="text" class="form-control" placeholder="Enter User Password" required>
                        </div>
                        {{-- <div class="form-group col-md-6">
                            <label>User Type</label>
                            <select class="form-control" name="type">
                                <option >Select Type</option>
                                <option value="Site">Site</option>
                                <option value="Supplier">Supplier</option>
                            </select>
                        </div> --}}
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
                {{-- <th>User Type</th> --}}
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach (App\Models\User::all() as $key => $user)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$user->username}}</td>
                {{-- <td>{{$user->type}}</td> --}}
                
                <td>
                    <button data-toggle="modal" data-target="#edit_modal" username="{{$user->username}}"
                        type="{{$user->type}}" id="{{$user->id}}" class="edit-btn btn btn-primary">Edit</button>
                </td>
                <td>
                    <form action="{{route('admin.user.destroy',$user->id)}}" method="POST">
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
                        <label for="name">User Name</label>
                        <input class="form-control" type="text" id="username" name="username" placeholder="Enter User Name" required>
                    </div>
                    <div class="form-group">
                        <label for="name">User Password <small style="color:red;">(Leave if blank if you don't want to change)</small></label>
                        <input class="form-control" type="text" id="password" name="password" placeholder="Enter User Password">
                    </div>
                    {{-- <div class="form-group">
                        <label>User Type</label>
                        <select class="form-control" id="type" name="type">
                            <option >Select Type</option>
                            <option value="Site">Site</option>
                            <option value="Supplier">Supplier</option>
                        </select>
                    </div> --}}
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
            let username = $(this).attr('username');
            let type = $(this).attr('type');
            $('#type').val(type);
            $('#username').val(username);
            $('#id').val(id);
            $('#updateForm').attr('action','{{route('admin.user.update','')}}' +'/'+id);
        });
    });
</script>
@endsection