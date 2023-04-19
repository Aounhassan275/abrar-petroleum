
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
                }
            });
        });
        $('#qty').change(function(){
            qty = this.value;
            price = $('#price').val();
            $('#total_amount').val(price*qty);
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
    });
</script>