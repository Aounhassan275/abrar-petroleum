<div id="add-machine-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="{{route('user.machine.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Add Machine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <div class="form-group">
                        <label>Boot Number</label>
                        <input name="boot_number" type="number" class="form-control" placeholder="Enter Boot Number" required>
                    </div>
                    <div class="form-group">
                        <label>Meter Reading Per Unit</label>
                        <input name="meter_reading" type="text" class="form-control" placeholder="Enter Meter Per Reading" required>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control select-search" name="product_id" required>
                            <option value="">Choose Type</option>
                            @foreach(App\Models\Product::whereIn('name',['HSD','PMG'])->get() as $product)    
                            <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
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