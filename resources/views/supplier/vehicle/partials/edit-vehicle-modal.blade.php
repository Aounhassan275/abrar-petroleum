<div id="edit-vehicle-modal" class="modal fade">
    <div class="modal-dialog">
        <form id="updateFormForVehicle" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Update Vehicle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Vehicle Name</label>
                        <input name="name" id="name" type="text" value="" class="form-control" placeholder="Enter Vehicle Name" required>
                    </div>
                    <div class="form-group">
                        <label>Vehicle Number</label>
                        <input name="number" id="number" type="text" value="" class="form-control" placeholder="Enter Vehicle Number" >
                    </div>
                    <div class="form-group">
                        <label>Vehicle Description</label>
                        <textarea name="description" id="description" class="form-control" ></textarea>
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