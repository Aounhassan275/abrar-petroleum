<div id="add-vehicle-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="{{route('supplier.vehicle.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Add Vehicle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="supplier_id" value="{{Auth::user()->id}}">
                    <div class="form-group">
                        <label>Vehicle Name</label>
                        <input name="name" type="text" value="" class="form-control" placeholder="Enter Vehicle Name" required>
                    </div>
                    <div class="form-group">
                        <label>Vehicle Number</label>
                        <input name="number" type="text" value="" class="form-control" placeholder="Enter Vehicle Number" >
                    </div>
                    <div class="form-group">
                        <label>Vehicle Description</label>
                        <textarea name="description" class="form-control" ></textarea>
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