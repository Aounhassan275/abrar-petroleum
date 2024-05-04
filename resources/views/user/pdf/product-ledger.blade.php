<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{$user->username}} - Products - {{$product->name}} Ledger</title>
    <meta property="og:locale" content="en_GB" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{$user->username}}  | Products | {{$product->name}} Ledger" />
    <meta property="og:description" content="Its ledger report for ali traders" />
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:site_name" content="ALI TRADERS.COM" />
    <meta property="og:image" content="{{asset($user->image)}}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{$user->username}}  | Products | {{$product->name}} Ledger" />
    {{-- <meta name="twitter:description" content="{!! $user->description !!}" /> --}}
    <meta name="twitter:image" content="{{asset($user->image)}}" />
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
                            <div class="col-md-6 ">
                                <h1><strong>Site Name :</strong> {{$user->username}}</h1>
                                <h1>{{$product->name}} Ledger From {{$start_date->format('M d,Y')}} To {{$end_date->format('M d,Y')}}</h1>
                                <p><b>Opening Stock : {{$user->getOpeningBalance($start_date,$product)}}</b></p>
                                <p><b>Opening Stock Amount : {{round($user->getPurchasePrice($start_date,$product) * $user->getOpeningBalance($start_date,$product))}}</b></p>
                            </div>
                            <div class="col-md-2">
                                <a href="https://wa.me/?text=={{ urlencode(Request::fullUrl()) }}&via=ALITRADERS.COM" class="btn btn-success btn-sm">Share PDF</a>
                            </div>
                        </div>
                    </div>
                    <table class="table" style="font-size:10px;">
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
                                {{-- <th>Revenue</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $totalPurchase = 0;
                            $totalSale = 0;
                            $totalQunatity = $user->getOpeningBalance($start_date,$product);
                            $quantityBalance = $user->getOpeningBalance($start_date,$product);
                            $totalDebit = 0;
                            $totalCredit = 0;
                            $totalRevenue = 0;
                            $totallossGainAmount = 0;
                            $amountBalance = -($user->getPurchasePrice($start_date,$product) * $user->getOpeningBalance($start_date,$product));
                            @endphp
                            @foreach($dates as $key => $date)
                            
                            @if($user->getTodayPurchase($date,$product) > 0 || $user->getTodaySale($date,$product) > 0)
                            @php 
                                $totalPurchase = $totalPurchase + $user->getTodayPurchase($date,$product);
                                $totalQunatity = $totalQunatity + $user->getTodayPurchase($date,$product);
                                $quantityBalance = $quantityBalance + $user->getTodayPurchase($date,$product);
                                $quantityBalance = $quantityBalance - $user->getTodaySale($date,$product);
                                $totalCredit = $totalCredit + $user->getTodaySaleTotalAmount($date,$product);
                                $amountBalance = $amountBalance + $user->getTodaySaleTotalAmount($date,$product);
                                $amountBalance = round($amountBalance - $user->getTodayPurchaseTotalAmount($date,$product));
                                $totalDebit = $totalDebit + $user->getTodayPurchaseTotalAmount($date,$product);
                                $totalSale = $totalSale + $user->getTodaySale($date,$product);
                                $lossGainAmount = $user->productLossGainTranscation($date,$product->id);
                                $rateDifference = $user->getTodaySalePrice($date,$product) - $user->getPurchasePrice($date,$product);
                                $reveune = $user->getTodaySale($date,$product) * $rateDifference;
                                $totalRevenue = $totalRevenue + $reveune;
                                $totallossGainAmount = $totallossGainAmount + $lossGainAmount;
                            @endphp
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$date}}</td>
                                <td>{{$user->getTodayPurchase($date,$product)}} <span class="badge badge-sm badge-success">{{$user->getTodayPurchasePrice($date,$product)}}</span></td>
                                <td>{{@$totalQunatity}}</td>
                                <td>{{$user->getTodaySale($date,$product)}}  <span class="badge badge-sm badge-success">{{$user->getTodaySalePrice($date,$product)}}</span></td>
                                <td>{{$quantityBalance}}</td>
                                <td>{{$user->getTodayPurchaseTotalAmount($date,$product)}}</td>
                                <td>{{$user->getTodaySaleTotalAmount($date,$product)}}</td>
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
                                {{-- <td>{{$reveune}}  <span class="badge badge-sm badge-success">{{$user->getPurchasePrice($date,$product)}}</span></td> --}}
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
