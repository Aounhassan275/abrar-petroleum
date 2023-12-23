<form method="GET">
    <div class="row">
        <input type="hidden" name="active_tab" value="expense_accounts">
        {{-- <div class="form-group col-2">
            <label>
                Start Date
                <input type="text" name="start_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                    value="{{ date('m/d/Y', strtotime(@$start_date))}}">
            </label>   
        </div> --}}
        <div class="form-group col-2">
            <label>
                 Date

                <input type="text" name="end_date" class="daterange-single form-control pull-right dates" style="height: 35px; "
                    value="{{ date('m/d/Y', strtotime(@$end_date))}}">
            </label>   
        </div>
        <div class="form-group col-2">
            <br>
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card">
            {{-- <div class="text-center" style="padding: 10px"> --}}
                <canvas id="pie-chart" width="500" height="500"></canvas>
            {{-- </div> --}}
        </div>
    </div>
    <div class="col-md-3"></div>

</div>