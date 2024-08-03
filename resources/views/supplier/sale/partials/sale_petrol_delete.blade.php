@if(Auth::user()->haveLastSale($date,$petrol))
<form class="text-right" id="deletePetrolTodaySale">
    <input type="hidden" name="delete_petrol_product_id" value="{{$petrol->id}}">
    <input type="hidden" name="delete_petrol_date" value="{{$date}}">
    <button class="btn btn-danger" type="button" id="submit-petrol-delete-sale">Delete Sale</button>
</form>
@endif