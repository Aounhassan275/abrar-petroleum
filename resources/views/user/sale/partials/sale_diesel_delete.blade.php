@if(Auth::user()->haveLastSale($date,$diesel))
<form class="text-right" id="deleteDieselTodaySale">
    <input type="hidden" name="delete_diesel_product_id" value="{{$diesel->id}}">
    <input type="hidden" name="delete_diesel_date" value="{{$date}}">
    <button class="btn btn-danger" type="button" id="submit-diesel-delete-sale">Delete Sale</button>
</form>
@endif