<div id="transfer-salary-modal" class="modal fade">
    <div class="modal-dialog">
        <form id="transferSalaryForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel">Transfer Salaries To Employee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Date</label>
                            <input type="date" value="{{@$date ? \Carbon\Carbon::parse(@$date)->format('Y-m-d') : ''}}" id="date" name="date" class="form-control">
                        </div>
                    </div>
                    <p id="transfer-salary-response" style="color:red;"></p>
                    <table class="table datatable-button-html5-basic">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee Name</th>
                                <th>Employee Salary</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salaryAccounts as $salaryKey => $salaryAccount)
                            <tr>
                                <td>{{$salaryKey +1 }}</td>
                                <td>{{$salaryAccount->name}}</td>
                                <td>{{$salaryAccount->salary}}</td>
                                <td>
                                    @if($salaryAccount->isSalaryTransfer($date))
                                        <span class="badge badge-success badge-sm">{{@$salaryAccount->isSalaryTransfer($date)}}</span>
                                    @else 
                                        <span class="badge badge-danger badge-sm">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="button" id="transfer-salary-btn" class="btn btn-primary waves-effect waves-light">Transfer</button>
                </div>
            </div>
        </form>
    </div>
</div>