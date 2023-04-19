@extends('admin.layout.index')

@section('title')
    Admin Dashboard
@endsection

@section('content')
<div class="row">
    
    <div class="col-sm-12 col-xl-12">
        <a href="{{route('admin.user.index')}}">
            <div class="card card-body bg-blue-400 has-bg-image">
                <div class="media">

                    <div class="mr-3 align-self-center">
                        <i class="icon-unlink2 icon-3x opacity-75"></i>
                    </div>
                    <div class="media-body text-right">
                    <h3 class="mb-0">{{App\Models\User::count()}}</h3>
                        <span class="text-uppercase font-size-xs">Total Users</span>
                    </div>
                </div>
            </div>
        </a>
    </div>


    <div class="col-sm-6 col-xl-6">
        <a href="{{route('admin.user.index')}}">
            <div class="card card-body bg-success-400 has-bg-image">
                <div class="media">
                    <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{App\Models\User::site()->count()}}</h3>
                        <span class="text-uppercase font-size-xs">Total Sites</span>
                    </div>
                    <div class="ml-3 text-right">
                        <i class="icon-bubbles4 icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-6">
        <a href="{{route('admin.user.index')}}">
            <div class="card card-body bg-warning-400 has-bg-image">
                <div class="media">
                    <div class="mr-3 align-self-center">
                        <i class="icon-stack-picture icon-3x opacity-75"></i>
                    </div>
                    <div class="media-body text-right">
                    <h3 class="mb-0">{{App\Models\User::supplier()->count()}}</h3>
                        <span class="text-uppercase font-size-xs">Total Suppliers</span>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-xl-6">
        <a href="{{route('admin.product.index')}}">
            <div class="card card-body bg-violet-400 has-bg-image">
                <div class="media">
                    <div class="media-body align-self-center ">
                    <h3 class="mb-0">{{App\Models\Product::count()}}</h3>
                        <span class="text-uppercase font-size-xs">Total Products </span>
                    </div>
                    <div class="ml-3 text-right">
                        <i class="icon-bubbles4 icon-3x opacity-75"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-6">
        <a href="{{route('admin.expense_type.index')}}">
            <div class="card card-body bg-danger-400 has-bg-image">
                <div class="media">
                    <div class="mr-3 align-self-center">
                        <i class="icon-stack-picture icon-3x opacity-75"></i>
                    </div>
                    <div class="media-body text-right">
                    <h3 class="mb-0">{{App\Models\ExpenseType::count()}}</h3>
                        <span class="text-uppercase font-size-xs">Total Expense Type</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection