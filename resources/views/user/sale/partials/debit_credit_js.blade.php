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
                    total_amount = parseFloat(price*qty);
                    $('#credit_debit_debit_' + index).val(total_amount.toFixed(2));
                }
            });
        }
    }
    function deleteDebitCredit(id)
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
    jQuery(document).ready(function ($) {
        $('#store-debit-credit-sale').on('click', function (event) {
            event.preventDefault();
            $('#store-debit-credit-sale').attr('disabled',true).text('Please wait...');
            $('#debitCreditForm').submit();
        });
        $('#update-debit-credit-sale').on('click', function (event) {
            event.preventDefault();
            $('#update-debit-credit-sale').attr('disabled',true).text('Please wait...');
            $('#debitCreditUpdateForm').submit();
        });
    });
</script>