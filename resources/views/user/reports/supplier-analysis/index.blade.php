@extends('user.layout.index')

@section('title')
   Supplier Analysis Reports
@endsection
@section('css')
<script src="{{asset('admin/global_assets/js/demo_pages/picker_date.js')}}"></script>
<style>
    .green-bg{
        color: green;
    }
    .red-bg{
        color: red;
    }
</style>
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
                <form method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Supplier Account Balance </label>
                            <input type="text" readonly class="form-control {{$balance < 0 ? 'green-bg' : 'red-bg'}}"   name="balance" id="balance" value="{{abs(@$balance)}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Choose Product </label>
                            <select name="product_id" id="product_id" class="form-control select-search">
                                <option value="">Select</option>  
                                @foreach(App\Models\Product::whereIn('name',['HSD','PMG'])->get() as $user_product)    
                                <option value="{{$user_product->id}}">{{$user_product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Product Purchasing Price</label>
                            <input name="price" id="price" type="text" value="{{old('price')}}" class="form-control" placeholder="Enter Product Price" required readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Product Qty</label>
                            <input name="qty" id="qty" type="text" value="{{old('qty')}}" class="form-control" placeholder="Enter Product Quantity" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Product Total Amount</label>
                            <input name="total_amount" id="total_amount" type="text" value="{{old('total_amount')}}" class="form-control" placeholder="Enter Product Total Amount" required readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label>New Supplier Balance</label>
                            <input name="supplier_balance" id="supplier_balance" type="text" class="form-control" placeholder="Supplier Balance" required readonly>
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
<script>
    $(document).ready(function(){
        $('#product_id').change(function(){
            id = this.value;
            $.ajax({
                url: "{{route('user.product.get_price')}}",
                method: 'post',
                data: {
                    id: id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    $('#price').val(response.purchasing_price);
                    if($('#qty').val() > 0)
                    {
                        $('#total_amount').val(response.purchasing_price*$('#qty').val());
                    }
                }
            });
        });
        
        $('#qty').change(function(){
            var qty = parseFloat(this.value); // Parse as float to handle decimal inputs
            var price = parseFloat($('#price').val()); // Parse as float
            var total_amount = price * qty;
            $('#total_amount').val(total_amount.toFixed(0));
            var balance = parseFloat("{{@$balance}}"); // Parse as float
            var supplierBalance = balance + total_amount;
            var formattedSupplierBalance = supplierBalance >= 0 ? supplierBalance.toFixed(0) : (-supplierBalance).toFixed(0);
            $('#supplier_balance').val(formattedSupplierBalance); // Ensure toFixed to display two decimal places
            if(supplierBalance > 0) {
                $('#supplier_balance').addClass('red-bg').removeClass('green-bg');
            } else {
                $('#supplier_balance').addClass('green-bg').removeClass('red-bg');
            }
            
        });
    });
</script>
@endsection