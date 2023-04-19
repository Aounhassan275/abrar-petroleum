<div id="edit-account-modal" class="modal fade">
    <div class="modal-dialog">
        <form id="updateFormForAccount" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Update {{$vendor->name}} Bank Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Vendor Account Title</label>
                        <input name="title" type="text" id="title" value="" class="form-control" placeholder="Enter Vendor Account Title">
                    </div>
                    <div class="form-group">
                        <label>Vendor Account Bank</label>
                        <select  name="bank_id" id="bank_id"  class="form-control" >
                            <option value="">Choose Bank</option>
                            {{-- <optgroup label="Banks"> --}}
                            @foreach(App\Models\Bank::all() as $bank)
                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                            @endforeach
                            {{-- </optgroup> --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Vendor Account Number</label>
                        <input name="number" id="number" type="text" value="" class="form-control" placeholder="Enter Vendor Account Number">
                    </div>
                    <div class="form-group">
                        <label>Vendor Account Bank Location</label>
                        <input name="location" id="location" type="text" value="" class="form-control" placeholder="Enter Vendor Bank Location">
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