<div id="add-expense-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="{{route('user.expense.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Add Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <div class="form-group">
                        <label>Amount</label>
                        <input name="amount" type="number" class="form-control" placeholder="Enter Expense Amount" required>
                    </div>
                    <div class="form-group">
                        <label>Expense Type</label>
                        <select class="form-control select-search" name="expense_type_id" required>
                            <option value="">Choose Type</option>
                            @foreach(App\Models\ExpenseType::all() as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
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