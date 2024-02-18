<script>
    $(document).ready(function(){
        var key_value = 1;
        $(document).keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '93'){
                $.ajax({
                    url: "{{route('user.debit_credit.get_credit_fields')}}",
                    method: 'post',
                    data: {
                        key : key_value,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response){
                        key_value = key_value + 1;
                        $('#debit_credit_field').append(response.html);
                        $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    }
                });
            }
        });
        $('.add-more-fields').click(function(){
            $.ajax({
                url: "{{route('user.debit_credit.get_credit_fields')}}",
                method: 'post',
                data: {
                    key : key_value,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    key_value = key_value + 1;
                    $('#debit_credit_field').append(response.html);
                    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                }
            });
        });
        
        $('.calcluate-debit-credit-values').click(function(){
            $.ajax({
                url: "{{route('user.debit_credit.calculate_debit_credit_values')}}",
                method: 'post',
                data: $('#debitCreditForm').serialize(),
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                success: function(response){
                    $('#cash_debit_values').val(response.difference);
                    $('.total_debit_amount').val(response.totalDebit);
                    $('.total_credit_amount').val(response.totalCredit);
                }
            });
        });
        $('.calcluate-debit-credit-values-for-updates').click(function(){
            $.ajax({
                url: "{{route('user.debit_credit.calculate_debit_credit_values')}}",
                method: 'POST',
                data: $('#debitCreditUpdateForm').serialize(),
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    $('.cash_debit_values').val(response.difference);
                    $('.total_debit_amount').val(response.totalDebit);
                    $('.total_credit_amount').val(response.totalCredit);
                }
            });
        });
    });
    
    function removeFields(index)
    {
        $('#remove-'+index).remove();
    }
    function checkColor(index)
    {
        var account_id = $('#credit_debit_account_' + index).val();
        $.ajax({
            url: "{{route('user.debit_credit.get_color')}}",
            method: 'post',
            data: {
                id : account_id,
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response){
                $('#credit_debit_account_' + index).attr('style','color:'+response.color+'!important;');
                $('#credit_debit_product_' + index).attr('style','color:'+response.color+'!important;');
                $('#credit_debit_qty_' + index).attr('style','color:'+response.color+'!important;');
                $('#credit_debit_debit_' + index).attr('style','color:'+response.color+'!important;');
                $('#credit_debit_credit_' + index).attr('style','color:'+response.color+'!important;');
                $('#credit_debit_description_' + index).attr('style','color:'+response.color+'!important;');
            }
        });
    }
    function debitQuantity(index)
    {
        var qty = $('#credit_debit_qty_' + index).val();
        var product_id = $('#credit_debit_product_' + index).val();
        if(isNaN(qty))
        {
            alert('Please Right Correct Figure');
            $('#credit_debit_qty_' + index).val('');
        }else if(product_id){
            qty = parseFloat(qty);
            $.ajax({
                url: "{{route('user.product.get_price')}}",
                method: 'post',
                data: {
                    id : product_id,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    var price = response.selling_price;
                    total_amount = Math.round(parseFloat(price*qty));
                    $('#credit_debit_debit_' + index).val(total_amount.toFixed(2));
                }
            });
        }
    }
    function deleteDebitCredit(id)
    {
        $("#delete_debit_credit_id").val(id);
        $('#deletePopup').modal('show');
    }
    function deleteEntry(id)
    {
        $.ajax({
            url: "{{route('user.debit_credit.delete')}}",
            method: 'post',
            data: {
                id : id,
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response){
                window.location.reload();
            }
        });
    }
    function debitCreditAccount(key,is_append)
    {
        let account_id = '';
        if(is_append == 1)
        {
            account_id = $('#credit_debit_account_'+key).val();
        }else{
            account_id = $('#credit_debit_account_id_'+key).val();
        }
        $.ajax({
            url: "{{route('user.debit_credit.get_customer_vehicle')}}",
            method: 'post',
            data: {
                account_id : account_id,
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response){
                vehicles = response.vehicles;
                if(is_append == 1)
                {
                    account = 'credit_debit_vehicle_'+key;
                }else{
                    account = 'credit_debit_vehicle_id_'+key;
                }
                $('#'+account).empty();
                $('#'+account).append('<option>Select Vehicle</option>');
                if(vehicles.length > 0)
                {
                    $('#'+account).attr('readonly',false);
                    for (i=0;i<vehicles.length;i++){
                        $('#'+account).append('<option value="'+vehicles[i].id+'">'+vehicles[i].name+'</option>');
                    }
                }else{
                    $('#'+account).attr('readonly',true);
                }
            }
        });
    }
    jQuery(document).ready(function ($) {
        $('#store-debit-credit-sale').on('click', function (event) {
            event.preventDefault();
            $('.error-fields').hide();
            $('#error-message-reponse').html("");
            $('#store-debit-credit-sale').attr('disabled',true).text('Please wait...');
            data = $('#debitCreditForm').serialize();
            $.ajax({
                url: "{{route('user.debit_credit.store')}}",
                method: 'post',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    console.log(response);
                    if(response.success == true && response.totalEmptyAccount == 0)
                    {
                        window.location.href = response.url;
                    }else{
                        $('#error-message-reponse').html(missingText);
                        $('#store-debit-credit-sale').attr('disabled',false).text('Post');
                    }
                },
                error: function(xhr) {
                    var errorMessages = 'An error occurred while processing your request.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            key_array = field.split(".");
                            $('#error-'+key_array[0]+'-'+key_array[1]).show();
                        });   
                        errorMessages = Object.values(errors).join('<br>');
                    }
                    $('#error-message-reponse').html(errorMessages);
                    $('#store-debit-credit-sale').attr('disabled',false).text('Post');
                }
            });
        });
        $('#update-debit-credit-sale').on('click', function (event) {
            event.preventDefault();
            $('.error-fields').hide();
            $('#error-message-reponse').html("");
            $('#update-debit-credit-sale').attr('disabled',true).text('Please wait...');
            data = $('#debitCreditUpdateForm').serialize();
            $.ajax({
                url: "{{route('user.debit_credit.update_form')}}",
                method: 'post',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    console.log(response);
                    if(response.success == true && response.totalEmptyAccount == 0)
                    {
                        window.location.href = response.url;
                    }else{
                        $('#error-message-reponse').html(missingText);
                        $('#update-debit-credit-sale').attr('disabled',false).text('Post');
                    }
                },
                error: function(xhr) {
                    var errorMessages = 'An error occurred while processing your request.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            key_array = field.split(".");
                            $('#error-'+key_array[0]+'-'+key_array[1]).show();
                        });   
                        errorMessages = Object.values(errors).join('<br>');
                    }
                    $('#error-message-reponse').html(errorMessages);
                    $('#update-debit-credit-sale').attr('disabled',false).text('Post');
                }
            });
            $('#update-debit-credit-sale').attr('disabled',true).text('Please wait...');
        });
    });
</script>