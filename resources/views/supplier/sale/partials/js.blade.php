
<script>
    
    $(document).ready(function(){
        var purchaseCount = "{{$purchases->count()}}";
        if(purchaseCount > 0)
        {
            var key_value = parseFloat(purchaseCount)+1;
        }else{
            var key_value = 2;
        }
        $(document).keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '93'){
                $.ajax({
                    url: "{{route('supplier.sale.get_product_fields')}}",
                    method: 'post',
                    data: {
                        key : key_value,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response){
                        key_value = key_value + 1;
                        $('#siteSaleFields').append(response.html);
                        $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    }
                });
            }
        });
        $('.add-more-fields').click(function(){
            $.ajax({
                url: "{{route('supplier.sale.get_product_fields')}}",
                method: 'post',
                data: {
                    key : key_value,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    key_value = key_value + 1;
                    $('#siteSaleFields').append(response.html);
                    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                }
            });
        });
    });
    function productQuantity(index)
    {
        var qty = parseFloat($('#site_qty_' + index).val());
        var price = parseFloat($('#site_price_' + index).val());
        total_amount = parseFloat(price*qty);
        $('#site_total_amount_' + index).val(total_amount.toFixed(2));
        // var diesel_sales = $('#diesel_sales').html();
        // diesel_sales = parseFloat(diesel_sales);
        // diesel_sales_qty = diesel_sales + qty;
        // $('#diesel_sales').html(diesel_sales_qty);
            
    }
    
    function removeField(index)
    {
        $('#remove-'+index).remove();
    }
    function getRates(index)
    {
        var id = parseFloat($('#product_id_' + index).val());
        $.ajax({
            url: "{{route('supplier.product.get_price')}}",
            method: 'post',
            data: {
                id: id,
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response){
                $('#site_price_' + index).val(response.purchasing_price);
            }
        });
            
    }
    jQuery(document).ready(function ($) {
        $('#save-product-sale').on('click', function (event) {
            event.preventDefault();
            
            $('#save-product-sale').html('Please Wait!!');
            $('#save-product-sale').attr('disabled',true);
            $.ajax({
                url: "{{ route('supplier.sale.store') }}",
                data: $('#productSaleForm').serialize(),
                success: function(response) {
                    window.location.href = response.url;
                },
                error: function(errors) {
                    if( errors.status === 422 ) {
                        // $errors = errors.responseJSON.errors;
                        // $.each( $errors, function( key, value ) {
                        //     let parts = key.split('.');
                        //     $('#'+parts[0]+'-response-'+parts[1]).addClass('response_error');
                        //     $('#'+parts[0]+'-response-'+parts[1]).html('Field Required!');
                        // });
                        //process validation errors here.
                        $errors = errors.responseJSON.errors; //this will get the errors response data.
                        errorsHtml = '<ul>';
                        $.each( $errors, function( key, value ) {
                            errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                        });
                        errorsHtml += '</ul>';
                        $('#product-sale-response').addClass('response_error');
                        $( '#product-sale-response' ).html( errorsHtml );
                    }else{
                        $('#product-sale-response').addClass('response_error');
                        $('#product-sale-response').html(errors.responseJSON.message);
                    }setTimeout(function() {
                        $('#product-sale-response').removeClass('response_error');
                        $('#product-sale-response').html('');
                    }, 5000);
                    $('#save-product-sale').html('Post');
                    $('#save-product-sale').attr('disabled',false);
                },
                type: 'POST'
            });
        });
    });
    $(document).ready(function(){
        $('#date').change(function(){
            let date = $(this).val();
            var url = "{{route('supplier.sale.index')}}"+"?date="+date+"&active_tab=product";
            location.href = url;
        });
        $('#debit_credit_date').change(function(){
            let date = $(this).val();
            var url = "{{route('supplier.sale.index')}}"+"?date="+date+"&active_tab=debit_credit";
            location.href = url;
        });
    });
</script>