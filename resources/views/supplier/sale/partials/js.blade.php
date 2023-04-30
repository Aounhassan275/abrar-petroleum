
<script>
    $(document).ready(function(){
        $('#product_id').change(function(){
            id = this.value;
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
                    $('#price').val(response.purchasing_price);
                    $('#stocks').html(response.stocks);
                }
            });
        });
        $('#qty').change(function(){
            qty = this.value;
            price = $('#price').val();
            $('#total_amount').val(price*qty);
        });
    });
</script>