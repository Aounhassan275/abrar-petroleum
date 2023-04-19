<div id="edit-expense-modal" class="modal fade">
    <div class="modal-dialog">
        <form id="updateForm" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Update Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body"> <div class="form-group">
                    <label>Amount</label>
                    <input name="amount" id="amount" type="number" class="form-control" placeholder="Enter Expense Amount" required>
                </div>
                <div class="form-group">
                    <label>Expense Type</label>
                    <select class="form-control" name="expense_type_id" id="expense_type_id" required>
                        <option value="">Choose Type</option>
                        @foreach(App\Models\ExpenseType::all() as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
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