@extends('admin.layout.index')

@section('title')
    Update Your Account 
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Update Your Account</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form action="{{route('admin.admin.update',Auth::user()->id)}}" method="POST"  enctype="multipart/form-data"> 
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Your Name: </label>
                            <input type="text" name="name" value="{{Auth::user()->name}}" class="form-control" required>
                            <input class="form-control" type="hidden" name="id" value="{{Auth::user()->id}}" required/>

                        </div>   
                        <div class="form-group col-md-6">
                            <label>Your Email Address:</label>
                            <input type="email" name="email" value="{{Auth::user()->email}}" class="form-control" required>
                        </div>  
                        <div class="form-group col-md-12">
                            <label>Your Password:<span style="color:green;">(Leave it Blank If You Dont Want To Change)</span></label>
                            <input type="password" name="password"  class="form-control" >
                        </div>  
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update 
                            <i class="icon-plus22 ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /basic layout -->

    </div>
</div>


@endsection
