<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>{{$product->name}} Ledger From {{$start_date->format('M d,Y')}} To {{$end_date->format('M d,Y')}}</title>
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
                            <div class="col-md-12 text-center">
                                <h1>{{$product->name}} Ledger From {{$start_date->format('M d,Y')}} To {{$end_date->format('M d,Y')}}</h1>
                            </div>
                        </div>
                        <p><b>Opening Stock : {{Auth::user()->getOpeningBalance($start_date,$product)}}</b></p>
                        <p><b>Opening Stock Amount : {{round(Auth::user()->getPurchasePrice($start_date,$product) * Auth::user()->getOpeningBalance($start_date,$product))}}</b></p>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Purchase</th>
                                <th>Total</th>
                                <th>Sale</th>
                                <th>Balance</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                                <th>Profit / Loss</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $totalPurchase = 0;
                            $totalSale = 0;
                            $totalQunatity = Auth::user()->getOpeningBalance($start_date,$product);
                            $quantityBalance = Auth::user()->getOpeningBalance($start_date,$product);
                            $totalDebit = 0;
                            $totalCredit = 0;
                            $totalRevenue = 0;
                            $totallossGainAmount = 0;
                            $amountBalance = -(Auth::user()->getPurchasePrice($start_date,$product) * Auth::user()->getOpeningBalance($start_date,$product));
                            @endphp
                            @foreach($dates as $key => $date)
                            
                            @if(Auth::user()->getTodayPurchase($date,$product) > 0 || Auth::user()->getTodaySale($date,$product) > 0)
                            @php 
                                $totalPurchase = $totalPurchase + Auth::user()->getTodayPurchase($date,$product);
                                $totalQunatity = $totalQunatity + Auth::user()->getTodayPurchase($date,$product);
                                $quantityBalance = $quantityBalance + Auth::user()->getTodayPurchase($date,$product);
                                $quantityBalance = $quantityBalance - Auth::user()->getTodaySale($date,$product);
                                $totalCredit = $totalCredit + Auth::user()->getTodaySaleTotalAmount($date,$product);
                                $amountBalance = $amountBalance + Auth::user()->getTodaySaleTotalAmount($date,$product);
                                $amountBalance = round($amountBalance - Auth::user()->getTodayPurchaseTotalAmount($date,$product));
                                $totalDebit = $totalDebit + Auth::user()->getTodayPurchaseTotalAmount($date,$product);
                                $totalSale = $totalSale + Auth::user()->getTodaySale($date,$product);
                                $lossGainAmount = Auth::user()->productLossGainTranscation($date,$product->id);
                                $rateDifference = Auth::user()->getTodaySalePrice($date,$product) - Auth::user()->getPurchasePrice($date,$product);
                                $reveune = Auth::user()->getTodaySale($date,$product) * $rateDifference;
                                $totalRevenue = $totalRevenue + $reveune;
                                $totallossGainAmount = $totallossGainAmount + $lossGainAmount;
                            @endphp
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$date}}</td>
                                <td>{{Auth::user()->getTodayPurchase($date,$product)}} <span class="badge badge-sm badge-success">{{Auth::user()->getTodayPurchasePrice($date,$product)}}</span></td>
                                <td>{{@$totalQunatity}}</td>
                                <td>{{Auth::user()->getTodaySale($date,$product)}}  <span class="badge badge-sm badge-success">{{Auth::user()->getTodaySalePrice($date,$product)}}</span></td>
                                <td>{{$quantityBalance}}</td>
                                <td>{{Auth::user()->getTodayPurchaseTotalAmount($date,$product)}}</td>
                                <td>{{Auth::user()->getTodaySaleTotalAmount($date,$product)}}</td>
                                <td>
                                    @if($amountBalance > 0) 
                                    ({{abs($amountBalance)}}) Cr 
                                    @else
                                    ({{abs($amountBalance)}}) Dr 
                                    @endif
                                </td>
                                <td>
                                    @if($lossGainAmount ==  0)
                                    0
                                    @else
                                    @if($lossGainAmount > 0) 
                                    ({{abs($lossGainAmount)}}) Cr 
                                    @else
                                    ({{abs($lossGainAmount)}}) Dr 
                                    @endif
                                    @endif
                                </td>
                                <td>{{$reveune}}  <span class="badge badge-sm badge-success">{{Auth::user()->getPurchasePrice($date,$product)}}</span></td>
                            </tr>
                            @php 
                                $totalQunatity = $quantityBalance;
                            @endphp
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    
                    <div class="col-sm-4 col-xl-4">
                        <div class="card card-body bg-blue-400 has-bg-image">
                            <div class="media">

                                <div class="mr-3 align-self-center">
                                    <i class="icon-unlink2 icon-3x opacity-75"></i>
                                </div>
                                <div class="media-body text-right">
                                <h3 class="mb-0">{{$totalPurchase}}</h3>
                                    <span class="text-uppercase font-size-xs">Total Purchases</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-4 col-xl-4">
                        <div class="card card-body bg-success-400 has-bg-image">
                            <div class="media">
                                <div class="media-body align-self-center ">
                                    <h3 class="mb-0">{{$totalSale}}</h3>
                                    <span class="text-uppercase font-size-xs">Total Sale</span>
                                </div>
                                <div class="ml-3 text-right">
                                    <i class="icon-bubbles4 icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xl-4">
                        <div class="card card-body bg-violet-400 has-bg-image">
                            <div class="media">
                                <div class="media-body align-self-center ">
                                    <h3 class="mb-0">{{$totalDebit}}</h3>
                                    <span class="text-uppercase font-size-xs">Total Debit</span>
                                </div>
                                <div class="ml-3 text-right">
                                    <i class="icon-bubbles4 icon-3x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xl-4">
                        <div class="card card-body bg-warning-400 has-bg-image">
                            <div class="media">
                                <div class="mr-3 align-self-center">
                                    <i class="icon-stack-picture icon-3x opacity-75"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3 class="mb-0">{{$totalCredit}}</h3>
                                    <span class="text-uppercase font-size-xs">Total Credit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xl-4">
                        <div class="card card-body bg-teal-400 has-bg-image">
                            <div class="media">
                                <div class="mr-3 align-self-center">
                                    <i class="icon-stack-picture icon-3x opacity-75"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3 class="mb-0">{{$totalRevenue}}</h3>
                                    <span class="text-uppercase font-size-xs">Total Revenue</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xl-4">
                        <div class="card card-body bg-danger-400 has-bg-image">
                            <div class="media">
                                <div class="mr-3 align-self-center">
                                    <i class="icon-stack-picture icon-3x opacity-75"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3 class="mb-0">{{$totallossGainAmount}}</h3>
                                    <span class="text-uppercase font-size-xs">Gross Revenue</span>
                                </div>
                            </div>
                        </div>
                    </div>

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
