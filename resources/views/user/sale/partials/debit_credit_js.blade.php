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
                }
            });
        });
    });
    
    function removeFields(index)
    {
        $('#remove-'+index).remove();
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