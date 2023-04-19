<div id="add-transcation-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="{{route('user.customer_transcation.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Add Customer Transcation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="customer_id" value="{{$customer->id}}">
                    <div class="form-group">
                        <label>Amount</label>
                        <input name="amount" type="text" value="" class="form-control" placeholder="Enter Amount" required>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control select-search" name="type" required>
                            <option value="">Choose Type</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input name="image" type="file" class="form-control">
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