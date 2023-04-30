
<div id="add-terminal-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="{{route('user.vendor_terminal.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Add New Terminal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="vendor_id" value="{{$vendor->id}}">
                    <div class="form-group">
                        <label for="name">Terminal</label>
                        <input class="form-control" type="text" name="name" placeholder="Enter Terminal" required>
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