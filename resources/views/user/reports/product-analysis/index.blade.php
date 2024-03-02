@extends('user.layout.index')

@section('title')
    Reports
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title">Reports</h6>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form method="GET">
                    <div class="row">
                        <input type="hidden" name="active_tab" value="trail_balance">
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
            </div>
        </div>
        <!-- Basic layout-->

    </div>
</div>
@endsection
@section('scripts')
@endsection