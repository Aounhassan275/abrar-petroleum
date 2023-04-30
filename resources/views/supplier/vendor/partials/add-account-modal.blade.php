<div id="add-account-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="{{route('user.vendor_account.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Add Supplier Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="vendor_id" value="{{$vendor->id}}">
                    <div class="form-group">
                        <label>Supplier Account Title</label>
                        <input name="title" type="text" value="" class="form-control" placeholder="Enter Supplier Account Title">
                    </div>
                    <div class="form-group">
                        <label>Supplier Account Bank</label>
                        <select data-placeholder="Enter 'as'" name="bank_id"  class="form-control select-minimum " data-fouc>
                            <option></option>
                            <optgroup label="Banks">
                                @foreach(App\Models\Bank::all() as $bank)
                                <option value="{{$bank->id}}">{{$bank->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Supplier Account Number</label>
                        <input name="number" type="text" value="" class="form-control" placeholder="Enter Supplier Account Number">
                    </div>
                    <div class="form-group">
                        <label>Supplier Account Bank Location</label>
                        <input name="location"  type="text" value="" class="form-control" placeholder="Enter Supplier Bank Location">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>