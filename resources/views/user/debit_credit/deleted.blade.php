@extends('user.layout.index')

@section('title')
   Deleted Debit Credits
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Account</th>
                    <th>Product</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Description</th>
                    <th>Deleted At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($debit_credits as $key => $debit_credit)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$debit_credit->sale_date?Carbon\Carbon::parse(@$debit_credit->sale_date)->format('Y-m-d'):''}}</td>
                    <td>{{@$debit_credit->account->name}}</td>
                    <td>{{@$debit_credit ->product->name}}</td>
                    <td>{{$debit_credit->debit}}</td>
                    <td>{{$debit_credit->credit}}</td>
                    <td>{{$debit_credit->description}}</td>
                    <td>{{$debit_credit->deleted_at?Carbon\Carbon::parse(@$debit_credit->deleted_at)->format('Y-m-d'):''}}</td>
                
                    <td>
                        <form action="{{route('user.debit_credit.force_delete',$debit_credit->id)}}" method="POST">
                            @method('DELETE')
                            @csrf
                        <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('scripts')
@endsection