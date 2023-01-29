<div class="address">
    <input type="radio" id="html" name="option" value="{{ $address->id_address }}">
    <label for="html">{{ $address->street . ' ' . $address->door_number }}<br>
    {{ $address->zipcode . ' ' . $address->city . ', ' . $address->country }}
    </label><br>
</div>