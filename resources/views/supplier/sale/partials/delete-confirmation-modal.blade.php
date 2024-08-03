<div id="deletePopup" class="modal fade">
    <div class="modal-dialog">
        <form action="{{route('supplier.debit_credit.delete')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Delete Debit Credit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="delete_debit_credit_id">
                    <p>Are you sure you want to delete this entry?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>