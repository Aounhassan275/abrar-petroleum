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
                        <div class="form-group col-md-6">
                            <label>Petrol Red Zone</label>
                            <input name="petrol_red_zone" type="number" class="form-control" placeholder="Enter Petrol Red Zone" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Diesel Red Zone</label>
                            <input name="diesel_red_zone" type="number" class="form-control" placeholder="Enter Diesel Red Zone" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Petrol Low Stock</label>
                            <input name="petrol_low_stock" type="number" class="form-control" placeholder="Enter Petrol Low Stock" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Diesel Low Stock</label>
                            <input name="diesel_low_stock" type="number" class="form-control" placeholder="Enter Diesel Low Stock" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Petrol Total Capacity</label>
                            <input name="petrol_total_capacity"  type="number" class="form-control" placeholder="Enter Petrol Total Capacity" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Diesel Total Capacity</label>
                            <input name="diesel_total_capacity"  type="number" class="form-control" placeholder="Enter Diesel Total Capacity" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Display Order</label>
                            <input name="display_order"  type="number" class="form-control" placeholder="Enter Display Order" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Image</label>
                            <input name="image" type="file" class="form-control" placeholder="Enter Diesel Low Stock">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Detail</label>
                            <textarea name="description" class="form-control"></textarea>
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
                <th>Image</th>
                <th>Name</th>
                <th>Petrol Red Zone</th>
                <th>Diesel Red Zone</th>
                <th>Petrol Low Stock</th>
                <th>Diesel Low Stock</th>
                <th>Petrol Total Capacity</th>
                <th>Diesel Total Capacity</th>
                <th>Display Order</th>
                <th>Action</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach (App\Models\User::orderBy('display_order')->get() as $key => $user)
            <tr>
                <td>{{$key+1}}</td>
                <td>
                    @if($user->image)
                    <img src="{{asset($user->image)}}" height="100" width="100" alt="">
                    @endif
                </td>
                <td>{{$user->username}}</td>
                <td>{{$user->petrol_red_zone}}</td>
                <td>{{$user->diesel_red_zone}}</td>
                <td>{{$user->petrol_low_stock}}</td>
                <td>{{$user->diesel_low_stock}}</td>
                <td>{{$user->petrol_total_capacity}}</td>
                <td>{{$user->diesel_total_capacity}}</td>
                <td>{{$user->display_order}}</td>
                
                <td>
                    <button data-toggle="modal" data-target="#edit_modal" username="{{$user->username}}"
                        petrol_red_zone="{{$user->petrol_red_zone}}" diesel_red_zone="{{$user->diesel_red_zone}}" 
                        petrol_low_stock="{{$user->petrol_low_stock}}" diesel_low_stock="{{$user->diesel_low_stock}}" 
                        petrol_total_capacity="{{$user->petrol_total_capacity}}" diesel_total_capacity="{{$user->diesel_total_capacity}}" 
                        id="{{$user->id}}" description="{{$user->description}}" display_order="{{$user->display_order}}" class="edit-btn btn btn-primary">Edit</button>
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
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="name">User Name</label>
                            <input class="form-control" type="text" id="username" name="username" placeholder="Enter User Name" required>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="name">User Password <small style="color:red;">(Leave if blank if you don't want to change)</small></label>
                            <input class="form-control" type="text" id="password" name="password" placeholder="Enter User Password">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Petrol Red Zone</label>
                            <input name="petrol_red_zone" id="petrol_red_zone" type="number" class="form-control" placeholder="Enter Petrol Red Zone" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Diesel Red Zone</label>
                            <input name="diesel_red_zone" id="diesel_red_zone" type="number" class="form-control" placeholder="Enter Diesel Red Zone" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Petrol Low Stock</label>
                            <input name="petrol_low_stock" id="petrol_low_stock" type="number" class="form-control" placeholder="Enter Petrol Low Stock" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Diesel Low Stock</label>
                            <input name="diesel_low_stock" id="diesel_low_stock" type="number" class="form-control" placeholder="Enter Diesel Low Stock" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Petrol Total Capacity</label>
                            <input name="petrol_total_capacity" id="petrol_total_capacity" type="number" class="form-control" placeholder="Enter Petrol Total Capacity" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Diesel Total Capacity</label>
                            <input name="diesel_total_capacity" id="diesel_total_capacity" type="number" class="form-control" placeholder="Enter Diesel Total Capacity" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Display Order</label>
                            <input name="display_order" id="display_order" type="number" class="form-control" placeholder="Enter Display Order" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Image</label>
                            <input name="image" type="file" class="form-control" placeholder="Enter Diesel Low Stock">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
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
            let petrol_red_zone = $(this).attr('petrol_red_zone');
            let diesel_red_zone = $(this).attr('diesel_red_zone');
            let diesel_low_stock = $(this).attr('diesel_low_stock');
            let petrol_low_stock = $(this).attr('petrol_low_stock');
            let diesel_total_capacity = $(this).attr('diesel_total_capacity');
            let petrol_total_capacity = $(this).attr('petrol_total_capacity');
            let description = $(this).attr('description');
            let display_order = $(this).attr('display_order');
            $('#petrol_low_stock').val(petrol_low_stock);
            $('#diesel_red_zone').val(diesel_red_zone);
            $('#petrol_red_zone').val(petrol_red_zone);
            $('#diesel_low_stock').val(diesel_low_stock);
            $('#diesel_total_capacity').val(diesel_total_capacity);
            $('#petrol_total_capacity').val(petrol_total_capacity);
            $('#description').html(description);
            $('#display_order').val(display_order);
            $('#username').val(username);
            $('#id').val(id);
            $('#updateForm').attr('action','{{route('admin.user.update','')}}' +'/'+id);
        });
    });
</script>
@endsection