<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>{{Auth::user()->type}} PANEL | {{App\Models\Information::name()}}</title>
	@yield('styles')
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('admin/global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('admin/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('admin/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('admin/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('admin/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('admin/assets/css/toastr.css')}}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{asset('admin/global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{asset('admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js')}}"></script>

	<script src="{{asset('admin/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/demo_pages/form_select2.js')}}"></script>

	<script src="{{asset('admin/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script src="{{asset('admin/global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    
	<script src="{{asset('admin/global_assets/js/plugins/visualization/d3/d3.min.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/plugins/visualization/d3/d3_tooltip.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>

	<script src="{{asset('admin/assets/js/app.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/demo_pages/datatables_basic.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/demo_pages/form_layouts.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/demo_pages/dashboard.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/demo_pages/form_select2.js')}}"></script>
	<!-- /theme JS files -->
	
	<script src="{{asset('admin/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js')}}"></script>
	<script src="{{asset('admin/global_assets/js/demo_pages/datatables_extension_buttons_html5.js')}}"></script>

	<!-- Theme JS files -->

	<script src="{{asset('admin/global_assets/js/demo_pages/job_list.js')}}"></script>
	<!-- /theme JS files -->
	@yield('css')
</head>
<body style="background-color:white;">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>TRAIL BALANCE REPORT</h1> 
            <p>From {{$start_date->format('d M,Y')}} to {{$end_date->format('d M,Y')}}</p>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Account</th>
                        {{-- <th>Account Category</th> --}}
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                    $totalDebit = 0;
                    $totalCredit = 0;
                    $is_working_captial = false;
                    @endphp
                    @foreach($accounts as $key => $account)
                    @if($account->account_category_id == $product_account_category_id)
                    @if(($account->getProductBalance($inital_start_date,$end_date) < 0 || $account->getProductBalance($inital_start_date,$end_date) > 0))
                    <tr>
                        <td>{{@$account->name}} @if($account->designation) ({{$account->designation}}) @endif</td>
                        {{-- <td>{{@$account->accountCategory->name}}</td> --}}
                        <td>
                            @if($account->getProductBalance($inital_start_date,$end_date) < 0)
                            {{abs($account->getProductBalance($inital_start_date,$end_date))}}
                            @endif
                        </td>
                        <td>
                            @if($account->getProductBalance($inital_start_date,$end_date) > 0)
                            {{$account->getProductBalance($inital_start_date,$end_date)}}
                            @endif
                        </td>
                    </tr>
                    
                    @php 
                    if($account->getProductBalance($inital_start_date,$end_date) < 0)
                    {
                        $totalDebit += abs($account->getProductBalance($inital_start_date,$end_date));
                    }else{
                        $totalCredit += abs($account->getProductBalance($inital_start_date,$end_date));
                    }
                    @endphp
                    @endif
                    @elseif($account->account_category_id == $category_id)
                    @if($account->debitCredits($inital_start_date,$end_date) < 0 || $account->debitCredits($inital_start_date,$end_date) > 0)
                    <tr>
                        <td>{{@$account->name}} @if($account->designation) ({{$account->designation}}) @endif</td>
                        {{-- <td>{{@$account->accountCategory->name}}</td> --}}
                        <td>
                            @if($account->getExpenseDebitCredits($inital_start_date,$end_date) < 0)
                            {{abs($account->getExpenseDebitCredits($inital_start_date,$end_date))}}
                            @endif
                        </td>
                        <td>
                            @if($account->getExpenseDebitCredits($inital_start_date,$end_date) > 0)
                            {{$account->getExpenseDebitCredits($inital_start_date,$end_date)}}
                            @endif
                        </td>
                    </tr>
                    @php 
                        if($account->getExpenseDebitCredits($inital_start_date,$end_date) < 0)
                        {
                            $totalDebit += abs($account->getExpenseDebitCredits($inital_start_date,$end_date));
                        }else{
                            $totalCredit += abs($account->getExpenseDebitCredits($inital_start_date,$end_date));
                        }
                    @endphp
                    @endif
                    @elseif($account->name != 'Sale' && ($account->debitCredits($inital_start_date,$end_date) < 0 || $account->debitCredits($inital_start_date,$end_date) > 0))
                    <tr>
                        <td>{{@$account->name}} @if($account->designation) ({{$account->designation}}) @endif</td>
                        {{-- <td>{{@$account->accountCategory->name}}</td> --}}
                        <td>
                            @if($account->name == "Cash in Hand")
                            {{abs(@$lastDayCash->debit)}}
                            @elseif($account->debitCredits($inital_start_date,$end_date) < 0)
                            {{abs($account->debitCredits($inital_start_date,$end_date))}}
                            @endif
                        </td>
                        <td>
                            @if($account->debitCredits($inital_start_date,$end_date) > 0)
                            {{$account->debitCredits($inital_start_date,$end_date)}}
                            @endif
                        </td>
                    </tr>
                    @php 
                    if($account->name == "Cash in Hand")
                    {
                        if(@$lastDayCash->debit < 0)
                        {
                            $totalDebit += @$lastDayCash->debit;
                        }else{
                            $totalDebit += abs(@$lastDayCash->debit);
                        }
        
                    }else{
                        if($account->debitCredits($inital_start_date,$end_date) < 0)
                        {
                            $totalDebit += abs($account->debitCredits($inital_start_date,$end_date));
                        }else{
                            $totalCredit += abs($account->debitCredits($inital_start_date,$end_date));
                        }
                    }
                    if($account->name == "Working Capital")
                    {
                        $is_working_captial = true;
                    }
                    @endphp
                    @endif
                    @endforeach
                    @if($is_working_captial == false && $workingCaptial)
                    <tr>
                        <td>Working Capital</td>
                        {{-- <td>Primary Account</td> --}}
                        <td>
                            
                        <td>
                            {{$workingCaptial->credit}}
                        </td>
                    </tr>
                    @php 
                        if($account->credit < 0)
                        {
                            $totalDebit += abs($workingCaptial->credit);
                        }else{
                            $totalCredit += abs($workingCaptial->credit);
                        }
                    @endphp
                    @endif
                    <tr>
                        <td class="text-center">Total Balance</td>
                        <td>{{$totalDebit}}</td>
                        <td>{{$totalCredit}}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>