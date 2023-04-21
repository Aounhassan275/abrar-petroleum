@extends('user.layout.index')

@section('title')
    Add New Supplier
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/plugins/forms/tags/tagsinput.min.js')}}"></script>
<script src="{{asset('admin/global_assets/js/plugins/forms/tags/tokenfield.min.js')}}"></script>
<script src="{{asset('admin/global_assets/js/demo_pages/form_tags_input.js')}}"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Basic layout-->
        <div class="card">

            <div class="card-body">
                <form action="{{route('user.vendor.store')}}" method="post" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Supplier Name</label>
                            <input name="name" type="text" class="form-control" value="{{old('name')}}" placeholder="Enter Supplier Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Email</label>
                            <input name="email" type="text" value="{{old('email')}}" class="form-control" placeholder="Enter Supplier Email">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Phone</label>
                            <input name="phone" type="text" value="{{old('phone')}}" class="form-control" placeholder="Enter Supplier Phone">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Fax</label>
                            <input name="fax" type="text" value="{{old('fax')}}" class="form-control" placeholder="Enter Supplier Fax">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Address</label>
                            <input name="address" type="text" value="{{old('address')}}" class="form-control" placeholder="Enter Supplier Address">
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                Supplier Terminal <a href="#" id="add-more-terminals"><i class="icon-plus-circle2 ml-2"></i></a>
                            </label>
                            <input type="text" name="names[]" class="form-control" value="">
                        </div>
                    </div>
                    <div id="terminal_fields"></div>
                    <div class="row">
                        <p><b>Supplier Accounts :</b></p>
                        <div class="col-md-12 text-right">
                            <button type="button" id="add-more-accounts" class="btn btn-success btn-sm text-right">Add More Accounts</button>
                            <button type="button" id="remove-fields" style="display:none;" class="btn btn-danger btn-sm text-right">Remove Extra Accounts</button>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Account Title</label>
                            <input name="title[]" type="text" value="" class="form-control" placeholder="Enter Supplier Account Title">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Account Bank</label>
                            <select data-placeholder="Enter 'as'" name="bank_id[]"  class="form-control select-minimum " data-fouc>
                                <option></option>
                                <optgroup label="Banks">
                                    @foreach(App\Models\Bank::all() as $bank)
                                    <option value="{{$bank->id}}">{{$bank->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Account Number</label>
                            <input name="number[]" type="text" value="" class="form-control" placeholder="Enter Supplier Account Number">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Supplier Account Bank Location</label>
                            <input name="location[]" type="text" value="" class="form-control" placeholder="Enter Supplier Bank Location">
                        </div>
                    </div>
                    <div id="accounts_fields"></div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Create <i class="icon-paperplane ml-2"></i></button>
                    </div>
                    
                </form>
            </div>
        </div>
        <!-- /basic layout -->

    </div>
</div>
<div id="vendor_fields" style="display:none;">
    <div class="row">
        <div class="form-group col-md-6">
            <label>Supplier Account Title</label>
            <input name="title[]" type="text" value="" class="form-control" placeholder="Enter Supplier Account Title">
        </div>
        <div class="form-group col-md-6">
            <label>Supplier Account Bank</label>
            <select name="bank_id[]"  class="form-control">
                <option>Select Bank</option>
                @foreach(App\Models\Bank::all() as $bank)
                <option value="{{$bank->id}}">{{$bank->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label>Supplier Account Number</label>
            <input name="number[]" type="text" value="" class="form-control" placeholder="Enter Supplier Account Number">
        </div>
        <div class="form-group col-md-6">
            <label>Supplier Account Bank Location</label>
            <input name="location[]" type="text" value="" class="form-control" placeholder="Enter Supplier Bank Location">
        </div>
    </div>
</div>


@endsection
@section('scripts')

<script>
    $(document).ready(function(){
        $('#add-more-accounts').click(function(){
            var html = $('#vendor_fields').html();
            $('#accounts_fields').append(html);
            $('#remove-fields').show();
        });
        $('#remove-fields').click(function(){
            $('#accounts_fields').html('');
            $('#remove-fields').hide();
            // $('#remove-fields').attr('display',false);
        });
        $('#add-more-terminals').click(function(){
            var html = $('#terminals_fields').html();
            $('#terminal_fields').append(html);
        });
    });
</script>
@endsection