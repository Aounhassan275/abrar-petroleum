
<script>
    function petrolCurrentReading(index)
    {
        var previous_reading = $('#petrol_previous_reading_' + index).val();
        var current_reading = $('#petrol_current_reading_' + index).val();
        if(isNaN(current_reading))
        {
            alert('Please Right Correct Figure');
            $('#current_reading_' + index).val();
        }else{
            current_reading = parseFloat(current_reading);
            previous_reading = parseFloat(previous_reading);
            if(current_reading > previous_reading)
            {
                var qty = current_reading - previous_reading;
                $('#petrol_qty_' + index).val(qty);
                var price = $('#petrol_price_' + index).val();
                total_amount = parseFloat(price*qty);
                $('#petrol_total_amount_' + index).val(total_amount.toFixed(2));
                var petrol_sales = $('#petrol_sales').html();
                petrol_sales = parseFloat(petrol_sales);
                petrol_sales_qty = petrol_sales + qty;
                $('#petrol_sales').html(petrol_sales_qty);
            }else{
                alert('Current Reading is Less than Previous Reading');
                $('#petrol_current_reading_' + index).val();
            }
        }
    }
    function miscQuantity(index)
    {
        var qty = $('#misc_qty_' + index).val();
        var stock = $('#misc_stock_' + index).val();
        if(isNaN(qty))
        {
            alert('Please Right Correct Figure');
            $('#misc_qty_' + index).val('');
        }else{
            stock = parseFloat(stock);
            qty = parseFloat(qty);
            // if(qty > stock)
            // {
            //     alert('Quantity is greater than stock');
            //     $('#misc_qty_' + index).val('');
            //     $('#misc_total_amount_' + index).val('');
            // }else{
                var price = $('#misc_price_' + index).val();
                total_amount = parseFloat(price*qty);
                $('#misc_total_amount_' + index).val(total_amount.toFixed(2));
            // }
        }
    }
    function saleDetailPrice(index)
    {
        var qty = $('#change_sale_quantity_' + index).html();
        var test_qty = $('#test_sale_quantity_' + index).html();
        var price = $('#change_sale_rate_' + index).val();
        price = parseFloat(price);
        qty = parseFloat(qty);
        test_qty = parseFloat(test_qty);
        total_amount = parseFloat(price*qty);
        $('#change_sale_amount_' + index).html(total_amount.toFixed(0));
        total_qty = parseFloat(test_qty+qty);
        total_cummulative_amount = parseFloat(price*total_qty);
        $('#cummulative_sale_amount_'+ index).html(total_cummulative_amount.toFixed(0));
        $('#change_sale_rate_button').show();
    }
    function dieselCurrentReading(index)
    {
        var previous_reading = $('#diesel_previous_reading_' + index).val();
        var current_reading = $('#diesel_current_reading_' + index).val();
        if(isNaN(current_reading))
        {
            alert('Please Right Correct Figure');
            $('#diesel_reading_' + index).val();
        }else{
            current_reading = parseFloat(current_reading);
            previous_reading = parseFloat(previous_reading);
            if(current_reading > previous_reading)
            {
                var qty = current_reading - previous_reading;
                $('#diesel_qty_' + index).val(qty);
                var price = $('#diesel_price_' + index).val();
                total_amount = parseFloat(price*qty);
                $('#diesel_total_amount_' + index).val(total_amount.toFixed(2));
                var diesel_sales = $('#diesel_sales').html();
                diesel_sales = parseFloat(diesel_sales);
                diesel_sales_qty = diesel_sales + qty;
                $('#diesel_sales').html(diesel_sales_qty);
            }else{
                alert('Current Reading is Less than Previous Reading');
                $('#diesel_current_reading_' + index).val();
            }
        }
    }
    function deleteMiscSale(id)
    {
        $.ajax({
            url: "{{route('user.sale.delete_sale_for_misc')}}",
            method: 'post',
            data: {
                id: id,
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response){
                window.location.reload();
            }
        });
    }
    jQuery(document).ready(function ($) {
        $('#save-petrol-sale').on('click', function (event) {
            event.preventDefault();
            $('#save-petrol-sale').attr('disabled',true).text('Please wait...');
            $('#petrolSaleForm').submit();
        });
        $('#update-petrol-sale').on('click', function (event) {
            event.preventDefault();
            $('#update-petrol-sale').attr('disabled',true).text('Please wait...');
            $('#petrolSaleUpdateForm').submit();
        });
        $('#update-diesel-sale').on('click', function (event) {
            event.preventDefault();
            $('#update-diesel-sale').attr('disabled',true).text('Please wait...');
            $('#dieselSaleUpdateForm').submit();
        });
        $('#save-diesel-sale').on('click', function (event) {
            event.preventDefault();
            $('#save-diesel-sale').attr('disabled',true).text('Please wait...');
            $('#dieselSaleForm').submit();
        });
        $('#save-misc-sale').on('click', function (event) {
            event.preventDefault();
            $('#save-misc-sale').attr('disabled',true).text('Please wait...');
            $('#miscSaleForm').submit();
        });
        $('#update-misc-sale').on('click', function (event) {
            event.preventDefault();
            $('#update-misc-sale').attr('disabled',true).text('Please wait...');
            $('#miscSaleUpdateForm').submit();
        });
    });
    $(document).ready(function(){
        $('#testing_quantity').change(function(){
            qty = parseFloat(this.value);
            var diesel_sales = $('#diesel_sales').html();
            diesel_sales = parseFloat(diesel_sales);
            diesel_sales_qty = diesel_sales - qty;
            $('#diesel_sales').html(diesel_sales_qty);
        });
        $('#diesel_testing_quantity').change(function(){
            qty = parseFloat(this.value);
            var diesel_sales = $('#diesel_sales').html();
            diesel_sales = parseFloat(diesel_sales);
            diesel_sales_qty = diesel_sales - qty;
            $('#diesel_sales').html(diesel_sales_qty);
        });
        $('#petrol_testing_quantity').change(function(){
            qty = parseFloat(this.value);
            var petrol_sales = $('#petrol_sales').html();
            petrol_sales = parseFloat(petrol_sales);
            petrol_sales_qty = petrol_sales - qty;
            $('#petrol_sales').html(petrol_sales_qty);
        });
        $('#petrol_testing_quantity_update').change(function(){
            qty = parseFloat(this.value);
            var petrol_sales = $('#petrol_sales').html();
            petrol_sales = parseFloat(petrol_sales);
            petrol_sales_qty = petrol_sales - qty;
            $('#petrol_sales').html(petrol_sales_qty);
        });
        $('#testing').change(function(){
            if (this.checked) {
                $('#testing_fields').show();
            }else{
                $('#testing_fields').hide();
            }
        });
        $('#petrol_testing').change(function(){
            if (this.checked) {
                $('#petrol_testing_fields').show();
            }else{
                $('#petrol_testing_fields').hide();
            }
        });
        $('#petrol_whole_sale').change(function(){
            if (this.checked) {
                $('#petrol_whole_sale_fields').show();
            }else{
                $('#petrol_whole_sale_fields').hide();
            }
        });
        $('#diesel_whole_sale').change(function(){
            if (this.checked) {
                $('#diesel_whole_sale_fields').show();
            }else{
                $('#diesel_whole_sale_fields').hide();
            }
        });
        $('#customer_id').change(function(){
            id = this.value;
            $.ajax({
                url: "{{route('user.customer.get_customer_vehicle')}}",
                method: 'post',
                data: {
                    id: id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    vehicles = response.vehicles;
                    $('.customer_fields').show();
                    $('#customer_vehicle_id').empty();
                    $('#customer_vehicle_id').append('<option disabled>Select Vendor Terminals</option>');
                    for (i=0;i<vehicles.length;i++){
                        $('#customer_vehicle_id').append('<option value="'+vehicles[i].id+'">'+vehicles[i].name+'-'+vehicles[i].reg_number+'</option>');
                    }
                }
            });
        });
        
        $('#submit-diesel-delete-sale').click(function(){
            data = $('#deleteDieselTodaySale').serialize();
            $.ajax({
                url: "{{route('user.sale.delete_sale')}}",
                method: 'post',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    location.reload();
                }
            });
        });
        $('#submit-petrol-delete-sale').click(function(){
            data = $('#deletePetrolTodaySale').serialize();
            $.ajax({
                url: "{{route('user.sale.delete_sale')}}",
                method: 'post',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    location.reload();
                }
            });
        });
        
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
                    $('#price').val(response.selling_price);
                }
            });
        });
        $('#qty').change(function(){
            qty = this.value;
            price = $('#price').val();
            total_amount = parseFloat(price*qty);
            $('#total_amount').val(total_amount.toFixed(2));
        });
        $('#petrol_wholesale_quantity').change(function(){
            qty = parseFloat(this.value);
            price = $('#petrol_wholesale_price').val();
            total_amount = parseFloat(price*qty);
            $('#petrol_wholesale_total_amount').val(total_amount.toFixed(2));
            var petrol_sales = $('#petrol_sales').html();
            petrol_sales = parseFloat(petrol_sales);
            petrol_sales_qty = petrol_sales + qty;
            $('#petrol_sales').html(petrol_sales_qty);
        });
        $('#petrol_wholesale_price').change(function(){
            price = this.value;
            qty = $('#petrol_wholesale_quantity').val();
            total_amount = parseFloat(price*qty);
            $('#petrol_wholesale_total_amount').val(total_amount.toFixed(2));
        });
        $('#diesel_wholesale_quantity').change(function(){
            qty = parseFloat(this.value);
            price = $('#diesel_wholesale_price').val();
            total_amount = parseFloat(price*qty);
            $('#diesel_wholesale_total_amount').val(total_amount.toFixed(2));
            var diesel_sales = $('#diesel_sales').html();
            diesel_sales = parseFloat(diesel_sales);
            diesel_sales_qty = diesel_sales + qty;
            $('#diesel_sales').html(diesel_sales_qty);
        });
        $('#diesel_wholesale_price').change(function(){
            price = this.value;
            qty = $('#diesel_wholesale_quantity').val();
            total_amount = parseFloat(price*qty);
            $('#diesel_wholesale_total_amount').val(total_amount.toFixed(2));
        });
        $('#purchase_product_id').change(function(){
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
                    $('#purchase_price').val(response.purchasing_price);
                }
            });
        });
        $('#purchase_qty').change(function(){
            qty = this.value;
            price = $('#purchase_price').val();
            total_amount = parseFloat(price*qty);
            $('#purchase_total_amount').val(total_amount.toFixed(2));
        });
        $('#access').change(function(){
            qty = this.value;
            price = $('#purchase_price').val();
            total_amount = parseFloat(price*qty);
            $('#access_total_amount').val(total_amount.toFixed(2));
        });
        $('#vendor_id').change(function(){
            id = this.value;
            $.ajax({
                url: "{{route('user.vendor.get_vendor_terminals')}}",
                method: 'post',
                data: {
                    id: id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(result){
                    vendor_terminals = result.vendor_terminals;
                    $('#vendor_terminal_id').empty();
                    $('#vendor_terminal_id').append('<option disabled>Select Vendor Terminals</option>');
                    for (i=0;i<vendor_terminals.length;i++){
                        $('#vendor_terminal_id').append('<option value="'+vendor_terminals[i].id+'">'+vendor_terminals[i].name+'</option>');
                    }
                    vendor_accounts = result.vendor_accounts;
                    $('#vendor_account_id').empty();
                    $('#vendor_account_id').append('<option disabled>Select Vendor Accounts</option>');
                    for (i=0;i<vendor_accounts.length;i++){
                        $('#vendor_account_id').append('<option value="'+vendor_accounts[i].id+'">'+vendor_accounts[i].title+'</option>');
                    }
                }
            });
        });
        $('.add-purchase-btn').click(function(){
            let product_id = $(this).attr('product_id');
            let product_name = $(this).attr('product_name');
            $('#purchase_product_id').val(product_id);
            $('#product_name').val(product_name);
            $.ajax({
                url: "{{route('user.product.get_price')}}",
                method: 'post',
                data: {
                    id: product_id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    $('#purchase_price').val(response.purchasing_price);
                }
            });
        });
        $('#change_sale_rate_button').click(function(){
            data = $('#changeProductSalePriceForm').serialize();
            $.ajax({
                url: "{{route('user.sale.update_sale_rate')}}",
                method: 'post',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    var url = "{{route('user.sale.index')}}"+"?date="+response.date+"&active_tab=sale_detail";
                    location.href = url;
                }
            });
        });
        $('#sale_detail_date').change(function(){
            let date = $(this).val();
            var url = "{{route('user.sale.index')}}"+"?date="+date+"&active_tab=sale_detail";
            location.href = url;
            // $('#sale-detail').html('');
            // $.ajax({
            //     url: "{{route('user.sale.getSaleDetails')}}",
            //     method: 'post',
            //     data: {
            //         date: date,
            //     },
            //     headers: {
            //         'X-CSRF-TOKEN': "{{ csrf_token() }}"
            //     },
            //     success: function(response){
            //         $('#sale-detail').html(response.html);
            //     }
            // });
        });
        $('#date').change(function(){
            let date = $(this).val();
            var url = "{{route('user.sale.index')}}"+"?date="+date+"&active_tab=petrol";
            location.href = url;
        });
        $('#diesel_date').change(function(){
            let date = $(this).val();
            var url = "{{route('user.sale.index')}}"+"?date="+date+"&active_tab=diesel";
            location.href = url;
        });
        $('#misc-date').change(function(){
            let date = $(this).val();
            var url = "{{route('user.sale.index')}}"+"?date="+date+"&active_tab=misc";
            location.href = url;
        });
        $('#debit_credit_date').change(function(){
            let date = $(this).val();
            var url = "{{route('user.sale.index')}}"+"?date="+date+"&active_tab=debit_credit";
            location.href = url;
        });
    });
</script>