
<script>
    getTotalPetrolSale();
    getTotalDieselSale();
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
                getTotalPetrolSale();
            }else{
                alert('Current Reading is Less than Previous Reading');
                $('#petrol_current_reading_' + index).val('');
            }
        }
    }
    function getTotalPetrolSale()
    {
        var sum = 0;
        var total_quantity = 0;
        $('.petrol_sale_quantity').each(function(){
            if($.isNumeric($(this).val()))
            {
                sum += parseFloat($(this).val()); 
            }
        });
        total_quantity = sum;
        if($.isNumeric($('#petrol_wholesale_quantity').val())){
            petrol_wholesale_quantity = parseFloat($('#petrol_wholesale_quantity').val());
            total_quantity = petrol_wholesale_quantity + total_quantity;
        }
        if($.isNumeric($('#petrol_testing_quantity').val())){
            petrol_testing_quantity = parseFloat($('#petrol_testing_quantity').val());
            total_quantity =  total_quantity - petrol_testing_quantity;
        }
        if(total_quantity == 0)
        {
            $('#petrol_sales').html(sum);
        }else{
            $('#petrol_sales').html(total_quantity);
        }
        $('#petrol_total_sale').val(sum);
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
        var wholeSale = 0;
        var wholeSalePrice = 0;
        var wholeSaleTotalAmount = 0;
        if(index == 'diesel')
        {
            wholeSale = "{{$diesel->totalWholeSale($date)}}";
            wholeSalePrice = "{{$diesel->getWholeSaleRate($date)}}";
            wholeSaleTotalAmount = parseFloat(wholeSale) * parseFloat(wholeSalePrice);
        }else if(index == 'petrol')
        {
            wholeSale = "{{$petrol->totalWholeSale($date)}}";
            wholeSalePrice = "{{$petrol->getWholeSaleRate($date)}}";
            wholeSaleTotalAmount = parseFloat(wholeSale) * parseFloat(wholeSalePrice);
        }
        var test_qty = $('#test_sale_quantity_' + index).html();
        var price = $('#change_sale_rate_' + index).val();
        wholeSale = parseFloat(wholeSale);
        price = parseFloat(price);
        qty = parseFloat(qty) - wholeSale;
        test_qty = parseFloat(test_qty);
        total_amount = parseFloat(price*qty) + wholeSaleTotalAmount;
        $('#change_sale_amount_' + index).html(total_amount.toFixed(0));
        total_qty = parseFloat(test_qty+qty);
        total_cummulative_amount = parseFloat(price*total_qty) + wholeSaleTotalAmount;
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
                getTotalDieselSale();
            }else{
                alert('Current Reading is Less than Previous Reading');
                $('#diesel_current_reading_' + index).val('');
            }
        }
    }
    function getTotalDieselSale()
    {
        var sum = 0;
        var total_quantity = 0;
        $('.diesel_sale_quantity').each(function(){
            if($.isNumeric($(this).val()))
            {
                sum += parseFloat($(this).val()); 
            }
        });
        total_quantity = sum;
        if($.isNumeric($('#diesel_wholesale_quantity').val())){
            diesel_wholesale_quantity = parseFloat($('#diesel_wholesale_quantity').val());
            total_quantity = diesel_wholesale_quantity + total_quantity;
        }
        if($.isNumeric($('#diesel_testing_quantity').val())){
            diesel_testing_quantity = parseFloat($('#diesel_testing_quantity').val());
            total_quantity =  total_quantity - diesel_testing_quantity;
        }
        if(total_quantity == 0)
        {
            $('#diesel_sales').html(sum);
        }else{
            $('#diesel_sales').html(total_quantity);
        }
        $('#diesel_total_sale').val(sum);
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
        $('#diesel_testing_quantity').change(function(){
            getTotalDieselSale();
        });
        $('#petrol_testing_quantity').change(function(){
            getTotalPetrolSale();
        });
        $('#diesel_supply_sale').change(function(){
            qty = parseFloat(this.value);
            var sales = $('#diesel_total_sale').val();
            sales = parseFloat(sales);
            if(sales > 0)
            {
                var diesel_retail_sale = parseFloat($('#diesel_retail_sale').val());
                diesel_sales_qty = diesel_retail_sale + qty;
                var night_diesel_total_sale = parseFloat($('#night_diesel_total_sale').val());
                var totalSales = night_diesel_total_sale + diesel_sales_qty;
                if(totalSales > sales)
                {
                    $('#diesel_supply_sale').val(0);
                    $('#day_diesel_total_sale').val(diesel_retail_sale);
                    $("#supply-sale-response").html("Sum of day and night sale is greater than total sale");
                    setTimeout(() => {
                        $("#supply-sale-response").html("");
                    }, 3000);
                }else{
                    $('#day_diesel_total_sale').val(diesel_sales_qty);
                }
            }else{
                $('#diesel_supply_sale').val(0);
                $("#supply-sale-response").html("Supply Sale is greater than total sale");
                setTimeout(() => {
                    $("#supply-sale-response").html("");
                }, 3000);
            }
        });
        $('#diesel_retail_sale').change(function(){
            qty = parseFloat(this.value);
            var sales = $('#diesel_total_sale').val();
            sales = parseFloat(sales);
            if(sales > 0)
            {
                var diesel_supply_sale = parseFloat($('#diesel_supply_sale').val());
                diesel_sales_qty = diesel_supply_sale + qty;
                var night_diesel_total_sale = parseFloat($('#night_diesel_total_sale').val());
                var totalSales = night_diesel_total_sale + diesel_sales_qty;
                if(totalSales > sales)
                {
                    $('#diesel_retail_sale').val(0);
                    $('#day_diesel_total_sale').val(diesel_supply_sale);
                    $("#supply-sale-response").html("Sum of day and night sale is greater than total sale");
                    setTimeout(() => {
                        $("#supply-sale-response").html("");
                    }, 3000);
                }else{
                    $('#day_diesel_total_sale').val(diesel_sales_qty);
                }

            }else{
                $('#diesel_retail_sale').val(0);
                $("#supply-sale-response").html("Supply Sale is greater than total sale");
                setTimeout(() => {
                    $("#supply-sale-response").html("");
                }, 3000);
            }
        });
        $('#night_diesel_supply_sale').change(function(){
            qty = parseFloat(this.value);
            var sales = $('#diesel_total_sale').val();
            sales = parseFloat(sales);
            if(sales > 0)
            {
                var night_diesel_retail_sale = parseFloat($('#night_diesel_retail_sale').val());
                sales_qty = night_diesel_retail_sale + qty;
                var day_diesel_total_sale = parseFloat($('#day_diesel_total_sale').val());
                var totalSales = day_diesel_total_sale + sales_qty;
                if(totalSales > sales)
                {
                    $('#night_diesel_supply_sale').val(0);
                    $('#night_diesel_total_sale').val(night_diesel_retail_sale);
                    $("#night-diesel-supply-sale-response").html("Sum of day and night sale is greater than total sale");
                    setTimeout(() => {
                        $("#night-diesel-supply-sale-response").html("");
                    }, 3000);
                }else{
                    $('#night_diesel_total_sale').val(sales_qty);  
                }
            }else{
                $('#night_diesel_supply_sale').val(0);
                $("#night-diesel-supply-sale-response").html("Supply Sale is greater than total sale");
                setTimeout(() => {
                    $("#night-diesel-supply-sale-response").html("");
                }, 3000);
            }
        });
        $('#night_diesel_retail_sale').change(function(){
            qty = parseFloat(this.value);
            var sales = $('#diesel_total_sale').val();
            sales = parseFloat(sales);
            if(sales > 0)
            {
                var night_diesel_supply_sale = parseFloat($('#night_diesel_supply_sale').val());
                diesel_sales_qty = night_diesel_supply_sale + qty;
                var day_diesel_total_sale = parseFloat($('#day_diesel_total_sale').val());
                var totalSales = day_diesel_total_sale + diesel_sales_qty;
                if(totalSales > sales)
                {
                    $('#night_diesel_retail_sale').val(0);
                    $('#night_diesel_total_sale').val(night_diesel_supply_sale);
                    $("#night-diesel-supply-sale-response").html("Sum of day and night sale is greater than total sale");
                    setTimeout(() => {
                        $("#night-diesel-supply-sale-response").html("");
                    }, 3000);
                }else{
                    $('#night_diesel_total_sale').val(diesel_sales_qty);  
                }
            }else{
                $('#night_diesel_retail_sale').val(0);
                $("#night-diesel-supply-sale-response").html("Supply Sale is greater than total sale");
                setTimeout(() => {
                    $("#night-diesel-supply-sale-response").html("");
                }, 3000);
            }
        });
        $('#petrol_supply_sale').change(function(){
            qty = parseFloat(this.value);
            var sales = $('#petrol_total_sale').val();
            sales = parseFloat(sales);
            if(sales > 0)
            {
                var petrol_retail_sale = parseFloat($('#petrol_retail_sale').val());
                petrol_sales_qty = petrol_retail_sale + qty;
                var night_petrol_total_sale = parseFloat($('#night_petrol_total_sale').val());
                var totalSales = night_petrol_total_sale + petrol_sales_qty;
                if(totalSales > sales)
                {
                    $('#petrol_supply_sale').val(0);
                    $('#day_petrol_total_sale').val(petrol_retail_sale);
                    $("#petrol-supply-sale-response").html("Sum of day and night sale is greater than total sale");
                    setTimeout(() => {
                        $("#petrol-supply-sale-response").html("");
                    }, 3000);
                }else{
                    $('#day_petrol_total_sale').val(petrol_sales_qty);
                }
            }else{
                $('#petrol_supply_sale').val(0);
                $("#petrol-supply-sale-response").html("Supply Sale is greater than total sale");
                setTimeout(() => {
                    $("#petrol-supply-sale-response").html("");
                }, 3000);
            }
        });
        $('#petrol_retail_sale').change(function(){
            qty = parseFloat(this.value);
            var sales = $('#petrol_total_sale').val();
            sales = parseFloat(sales);
            if(sales > 0)
            {
                var petrol_supply_sale = parseFloat($('#petrol_supply_sale').val());
                petrol_sales_qty = petrol_supply_sale + qty;
                var night_petrol_total_sale = parseFloat($('#night_petrol_total_sale').val());
                var totalSales = night_petrol_total_sale + petrol_sales_qty;
                if(totalSales > sales)
                {
                    $('#petrol_retail_sale').val(0);
                    $('#day_petrol_total_sale').val(petrol_supply_sale);
                    $("#petrol-supply-sale-response").html("Sum of day and night sale is greater than total sale");
                    setTimeout(() => {
                        $("#petrol-supply-sale-response").html("");
                    }, 3000);
                }else{
                    $('#day_petrol_total_sale').val(petrol_sales_qty);
                }

            }else{
                $('#petrol_retail_sale').val(0);
                $("#petrol-supply-sale-response").html("Supply Sale is greater than total sale");
                setTimeout(() => {
                    $("#petrol-supply-sale-response").html("");
                }, 3000);
            }
        });
        $('#night_petrol_supply_sale').change(function(){
            qty = parseFloat(this.value);
            var sales = $('#petrol_total_sale').val();
            sales = parseFloat(sales);
            if(sales > 0)
            {
                var petrol_retail_sale = parseFloat($('#night_petrol_retail_sale').val());
                petrol_sales_qty = petrol_retail_sale + qty;
                var day_petrol_total_sale = parseFloat($('#day_petrol_total_sale').val());
                var totalSales = day_petrol_total_sale + petrol_sales_qty;
                if(totalSales > sales)
                {
                    $('#night_petrol_supply_sale').val(0);
                    $('#night_petrol_total_sale').val(petrol_retail_sale);
                    $("#night-petrol-supply-sale-response").html("Sum of day and night sale is greater than total sale");
                    setTimeout(() => {
                        $("#night-petrol-supply-sale-response").html("");
                    }, 3000);
                }else{
                    $('#night_petrol_total_sale').val(petrol_sales_qty);  
                }
            }else{
                $('#night_petrol_supply_sale').val(0);
                $("#petrol-supply-sale-response").html("Supply Sale is greater than total sale");
                setTimeout(() => {
                    $("#petrol-supply-sale-response").html("");
                }, 3000);
            }
        });
        $('#night_petrol_retail_sale').change(function(){
            qty = parseFloat(this.value);
            var sales = $('#petrol_total_sale').val();
            sales = parseFloat(sales);
            if(sales > 0)
            {
                var petrol_supply_sale = parseFloat($('#night_petrol_supply_sale').val());
                petrol_sales_qty = petrol_supply_sale + qty;
                var day_petrol_total_sale = parseFloat($('#day_petrol_total_sale').val());
                var totalSales = day_petrol_total_sale + petrol_sales_qty;
                if(totalSales > sales)
                {
                    $('#night_petrol_retail_sale').val(0);
                    $('#night_petrol_total_sale').val(petrol_supply_sale);
                    $("#night-petrol-supply-sale-response").html("Sum of day and night sale is greater than total sale");
                    setTimeout(() => {
                        $("#night-petrol-supply-sale-response").html("");
                    }, 3000);
                }else{
                    $('#night_petrol_total_sale').val(petrol_sales_qty);  
                }
            }else{
                $('#petrol_retail_sale').val(0);
                $("#night-petrol-supply-sale-response").html("Supply Sale is greater than total sale");
                setTimeout(() => {
                    $("#night-petrol-supply-sale-response").html("");
                }, 3000);
            }
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
            getTotalPetrolSale();
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
            getTotalDieselSale();
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
<script>
    $(document).ready(function(){
        $('#misc_product_id').change(function(){
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
                    $('#misc_purchase_price').val(response.purchasing_price);
                    $('#misc_purchase_price').attr('readonly',false);
                    $('#misc_selling_price').val(response.selling_price);
                    $('#misc_selling_price').attr('readonly',false);
                }
            });
        });
        $('#misc_purchase_qty').change(function(){
            qty = this.value;
            price = $('#misc_purchase_price').val();
            $('#misc_purchase_total_amount').val(price*qty);
        });
        $('#misc_vendor_id').change(function(){
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
                    $('#misc_vendor_terminal_id').empty();
                    $('#misc_vendor_terminal_id').append('<option disabled>Select Vendor Terminals</option>');
                    for (i=0;i<vendor_terminals.length;i++){
                        $('#misc_vendor_terminal_id').append('<option value="'+vendor_terminals[i].id+'">'+vendor_terminals[i].name+'</option>');
                    }
                }
            });
        });
    });
</script>