<div id="add-terminal-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="{{route('supplier.terminal.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Add Terminal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="supplier_id" value="{{Auth::user()->id}}">
                    <div class="form-group">
                        <label>Terminal Name</label>
                        <input name="name" type="text" value="" class="form-control" placeholder="Enter Terminal Name" required>
                    </div>
                    <div class="form-group">
                        <label>Terminal Email</label>
                        <input name="email" type="email" value="" class="form-control" placeholder="Enter Terminal Email" >
                    </div>
                    <div class="form-group">
                        <label>Terminal Phone</label>
                        <input name="phone" type="text" value="" class="form-control" placeholder="Enter Terminal Phone" >
                    </div>
                    <div class="form-group">
                        <label>Terminal Address</label>
                        <input name="address" type="text" value="" class="form-control" placeholder="Enter Terminal Address">
                    </div>
                    <div class="form-group">
                        <label>Terminal Fax</label>
                        <input name="fax" type="text" value="" class="form-control" placeholder="Enter Terminal Fax" >
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