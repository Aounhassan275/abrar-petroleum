<div id="edit-terminal-modal" class="modal fade">
    <div class="modal-dialog">
        <form id="updateFormForTerminal" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Update Terminal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Terminal Name</label>
                        <input name="name" id="name" type="text" value="" class="form-control" placeholder="Enter Terminal Name" required>
                    </div>
                    <div class="form-group">
                        <label>Terminal Email</label>
                        <input name="email" id="email" type="email" value="" class="form-control" placeholder="Enter Terminal Email" required>
                    </div>
                    <div class="form-group">
                        <label>Terminal Phone</label>
                        <input name="phone" id="phone" type="text" value="" class="form-control" placeholder="Enter Terminal Phone" required>
                    </div>
                    <div class="form-group">
                        <label>Terminal Address</label>
                        <input name="address" id="address" type="text" value="" class="form-control" placeholder="Enter Terminal Address" required>
                    </div>
                    <div class="form-group">
                        <label>Terminal Fax</label>
                        <input name="fax" id="fax" type="text" value="" class="form-control" placeholder="Enter Terminal Fax" required>
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