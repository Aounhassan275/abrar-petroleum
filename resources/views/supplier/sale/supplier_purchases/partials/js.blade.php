<script>
       $(document).ready(function(){
        var supplierPurchaseCount = "{{$supplierPurchases->count()}}";
        if(supplierPurchaseCount > 0)
        {
            var purchase_key_value = parseFloat(supplierPurchaseCount)+1;
        }else{
            var purchase_key_value = 2;
        }
        $(document).keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == '93'){
                $.ajax({
                    url: "{{route('supplier.sale.get_purchases_fields')}}",
                    method: 'post',
                    data: {
                        key : purchase_key_value,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response){
                        purchase_key_value = purchase_key_value + 1;
                        $('#productPurchasesFields').append(response.html);
                        $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                    }
                });
            }
        });
        $('.add-more-fields-for-purchases').click(function(){
            $.ajax({
                url: "{{route('supplier.sale.get_purchases_fields')}}",
                method: 'post',
                data: {
                    key : purchase_key_value,
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response){
                    purchase_key_value = purchase_key_value + 1;
                    $('#productPurchasesFields').append(response.html);
                    $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
                }
            });
        });
    });
    function purchaseQuantity(index)
    {
        var qty = parseFloat($('#purchase_qty_' + index).val());
        var price = parseFloat($('#purchase_price_' + index).val());
        total_amount = parseFloat(price*qty);
        $('#purchase_total_amount_' + index).val(total_amount.toFixed(2));
        // var diesel_sales = $('#diesel_sales').html();
        // diesel_sales = parseFloat(diesel_sales);
        // diesel_sales_qty = diesel_sales + qty;
        // $('#diesel_sales').html(diesel_sales_qty);
            
    }
    
    function purchaseAccess(index)
    {
        var qty = parseFloat($('#purchase_access_' + index).val());
        var price = parseFloat($('#purchase_price_' + index).val());
        total_amount = parseFloat(price*qty);
        $('#purchase_access_total_amount_' + index).val(total_amount.toFixed(2));
    }
    function purchaseShortage(index)
    {
        var qty = parseFloat($('#purchase_shortage_' + index).val());
        var price = parseFloat($('#purchase_price_' + index).val());
        total_amount = parseFloat(price*qty);
        $('#purchase_shortage_total_amount_' + index).val(total_amount.toFixed(2));
    }
    
    function purchaseRemoveField(index)
    {
        $('#purchase-remove-'+index).remove();
    }
    function getPurchasingRates(index)
    {
        var id = parseFloat($('#purchase_product_id_' + index).val());
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
                $('#purchase_price_' + index).val(response.supplier_purchasing_price);
            }
        });
            
    }
    jQuery(document).ready(function ($) {
        $('#save-product-purchase').on('click', function (event) {
            event.preventDefault();
            
            $('#save-product-purchase').html('Please Wait!!');
            $('#save-product-purchase').attr('disabled',true);
            $.ajax({
                url: "{{ route('supplier.purchase.save') }}",
                data: $('#purchaseForm').serialize(),
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
                        $('#purchase-product-response').addClass('response_error');
                        $( '#purchase-product-response' ).html( errorsHtml );
                    }else{
                        $('#purchase-product-response').addClass('response_error');
                        $('#purchase-product-response').html(errors.responseJSON.message);
                    }setTimeout(function() {
                        $('#purchase-product-response').removeClass('response_error');
                        $('#purchase-product-response').html('');
                    }, 5000);
                    $('#save-product-purchase').html('Post');
                    $('#save-product-purchase').attr('disabled',false);
                },
                type: 'POST'
            });
        });
    });
    
    $(document).ready(function(){
        $('#purchase_date').change(function(){
            let date = $(this).val();
            var url = "{{route('supplier.sale.index')}}"+"?date="+date+"&active_tab=product_purchase";
            location.href = url;
        });
    });
</script>