<div id="add-payment-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="{{route('user.purchase_payment.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Add Purchase Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="purchase_id" value="{{$purchase->id}}">
                    <div class="form-group">
                        <label>Vendor Account</label>
                        <select class="form-control select-search" name="vendor_account_id" id="vendor_account_id" required>
                            <option value="">Choose Vendor Account</option>
                            @foreach($purchase->vendor->accounts as $account)
                            <option value="{{$account->id}}">{{$account->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount Pay to Vendor</label>
                        <input name="amount" type="text" value="" class="form-control" placeholder="Enter Amoount" required>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input name="date" type="date" value="" class="form-control" placeholder="Enter Vendor Account Number" required>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input name="image" type="file" value="" class="form-control" placeholder="Enter Vendor Account Number">
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