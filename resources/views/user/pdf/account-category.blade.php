<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>{{Auth::user()->username}} - {{$account_category->name}} - {{$sub_account->name}} Ledger</title>
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
</head>

<body>

	<!-- Page content -->
	<div class="page-content">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{asset('attock-logo.png')}}" alt="">
                            </div>
                            <div class="col-md-8 ">
                                <h3><strong>Account Category :</strong> {{$account_category->name}}</h1>
                                <h3><strong>Account Name :</strong> {{$sub_account->name}}</h3>
                                <p>Ledger From {{$start_date->format('M d,Y')}} To {{$end_date->format('M d,Y')}}</p>
                                @if($account_category->id != 6)
                                <p>Start Balance : {{$account_category->getOldDebitCredits($start_date,$end_date,$sub_account->id,request()->type)}}
                                </p>
                                @endif
                                {{-- <p><b>Opening Stock : {{Auth::user()->getOpeningBalance($start_date,$product)}}</b></p> --}}
                                {{-- <p><b>Opening Stock Amount : {{round(Auth::user()->getPurchasePrice($start_date,$product) * Auth::user()->getOpeningBalance($start_date,$product))}}</b></p> --}}
                            </div>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Account</th>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @php 
                            if($account_category->id != 6)
                                $balance = $account_category->getOldDebitCredits($start_date,$end_date,$sub_account->id,request()->type);
                            else  
                                $balance = 0;
                            @endphp
                            @foreach($account_category->debitCredits($start_date,$end_date,$sub_account_id,request()->type) as $key => $debitCredit)
                            @if($sub_account_id == 24)
                            @include('user.account_category.partials.cash_in_hand')
                            @else
                            @php 
                                $balance = $balance + $debitCredit->credit;
                                $balance = $balance - $debitCredit->debit;
                            @endphp
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$debitCredit->sale_date->format('d M,Y')}}</td>
                                <td>{{@$debitCredit->account->name}}</td>
                                <td>{{@$debitCredit->product->name}}</td>
                                <td>{{$debitCredit->qty}}</td>
                                <td>{{$debitCredit->debit}}</td>
                                <td>{{$debitCredit->credit}}</td>
                                <td>@if($balance > 0) 
                                    ({{abs($balance)}}) Cr 
                                    @else
                                    ({{abs($balance)}}) Dr 
                                    @endif
                                </td>
                                <td>{{$debitCredit->description}}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
	<script src="{{asset('admin/assets/js/toastr.js')}}"></script>
	@toastr_render
    
    <script>
        window.print();
    </script>
</body>
</html>
