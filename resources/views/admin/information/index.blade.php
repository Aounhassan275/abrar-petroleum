@extends('admin.layout.index')

@section('title')
   Website Information
@endsection
@section('styles')
<script src="{{asset('admin/global_assets/js/plugins/editors/summernote/summernote.min.js')}}"></script>
<script src="{{asset('admin/global_assets/js/demo_pages/editor_summernote.js')}}"></script>
<script src="{{asset('admin/global_assets/js/demo_pages/form_tags_input.js')}}"></script>
<script src="{{asset('admin/global_assets/js/plugins/forms/tags/tokenfield.min.js')}}"></script>
@endsection


@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8 col-12 mx-auto">
                        <form action="{{route('admin.information.update',$information->id)}}" method="post" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label>Enter Site Name</label>
                                <input type="text" name="name" placeholder="Enter Site Name" value="{{$information->name}}" class="form-control" required>
                            </div>   
                            <div class="form-group">
                                <label>Enter Phone Number</label>
                                <input type="text" name="phone" placeholder="Enter Phone Number" value="{{$information->phone}}" class="form-control" required>
                            </div>   
                            <div class="form-group">
                                <label>Enter Email Address</label>
                                <input type="email" name="email" placeholder="Enter Email Address" value="{{$information->email}}" class="form-control" required>
                            </div>     
                            <div class="form-group">
                                <label>Enter Address</label>
                                <input type="text" name="address" placeholder="Enter Address" value="{{$information->address}}" class="form-control" required>
                            </div> 
                            <div class="form-group">
                                <label>Enter Home Page Content</label>
                                <textarea name="home_content" id="" cols="30" rows="2" class="form-control summernote">{{$information->home_content}}</textarea>                                        
                            </div>   
                            <div class="form-group text-right">
                                <input type="submit" value="Update" name="txt" class="mt-4 btn btn-primary">
                            </div>
                        </form>
                    </div>                                        
                </div>

            </div>
        </div>
    </div>

    
</div>
@endsection