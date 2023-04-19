
<div id="add-vehicle-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="{{route('user.customer_vehicle.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Add New Vehicle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="customer_id" value="{{$customer->id}}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" name="name" placeholder="Enter Vehicle Title" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Registration Number</label>
                        <input class="form-control" type="text" name="reg_number" placeholder="Enter Vehicle Reg Number" required>
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