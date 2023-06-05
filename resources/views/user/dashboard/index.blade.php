@extends('user.layout.index')

@section('title')
    {{Auth::user()->type}} Dashboard
@endsection

@section('content')
<div class="row">
    
    <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-blue-400 has-bg-image">
            <div class="media">

                <div class="mr-3 align-self-center">
                    <i class="icon-stack2 icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                <h3 class="mb-0">{{App\Models\Product::where('name','PMG')->first()->availableStock()}}</h3>
                    <span class="text-uppercase font-size-xs">Petrol Available Stock</span>
                </div>
            </div>
        </div>
    </div>


    <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-success-400 has-bg-image">
            <div class="media">
                <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{App\Models\Product::where('name','HSD')->first()->availableStock()}}</h3>
                    <span class="text-uppercase font-size-xs">Diesel Available Stock</span>
                </div>
                <div class="ml-3 text-right">
                    <i class="icon-cart-add icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-violet-400 has-bg-image">
            <div class="media">
                <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{App\Models\Product::where('name','PMG')->first()->totalSales()}}</h3>
                    <span class="text-uppercase font-size-xs">Petrol Total Sales </span>
                </div>
                <div class="ml-3 text-right">
                    <i class="icon-cash icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-warning-400 has-bg-image">
            <div class="media">
                <div class="mr-3 align-self-center">
                    <i class="icon-cash2 icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                    <h3 class="mb-0">{{App\Models\Product::where('name','HSD')->first()->totalSales()}}</h3>
                    <span class="text-uppercase font-size-xs">Diesel Total Sales</span>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    
    <div class="col-sm-6 col-xl-6">
        <div class="card card-body bg-teal-400 has-bg-image">
            <div class="media">

                <div class="mr-3 align-self-center">
                    <i class="icon-stack3 icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                <h3 class="mb-0">{{App\Models\Product::where('name','PMG')->first()->totaPurchasesQty()}}</h3>
                    <span class="text-uppercase font-size-xs">Petrol Total Purchase</span>
                </div>
            </div>
        </div>
    </div> 


    {{-- <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-brown-400 has-bg-image">
            <div class="media">
                <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{App\Models\Product::where('name','PMG')->first()->totaPurchasesAmount()}}</h3>
                    <span class="text-uppercase font-size-xs">Petrol Total Purchase Amount</span>
                </div>
                <div class="ml-3 text-right">
                    <i class="icon-cash3 icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-sm-6 col-xl-6">
        <div class="card card-body bg-danger-400 has-bg-image">
            <div class="media">
                <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{App\Models\Product::where('name','HSD')->first()->totaPurchasesQty()}}</h3>
                        <span class="text-uppercase font-size-xs">Diesel Total Purchase</span>
                </div>
                <div class="ml-3 text-right">
                    <i class="icon-cart5 icon-3x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-sm-3 col-xl-3">
        <div class="card card-body bg-primary-400 has-bg-image">
            <div class="media">
                <div class="mr-3 align-self-center">
                    <i class="icon-cash4 icon-3x opacity-75"></i>
                </div>
                <div class="media-body text-right">
                    <h3 class="mb-0">{{App\Models\Product::where('name','HSD')->first()->totaPurchasesAmount()}}</h3>
                    <span class="text-uppercase font-size-xs">Diesel Total Purchase Amount</span>
                </div>
            </div>
        </div>
    </div> --}}

</div>
@endsection
@section('scripts')
@endsection