@extends('layouts.app')

@section('title', 'Checkout')

@section('content')


<section>
    <div class="container">
        <form action="/verify/" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <div class="col-50">
                <h3>Billing Address</h3>
                <!-- <h4>Previous addresses</h4>
                <?php
                use App\Models\Address;
                $id = Auth::User()->id_user;
                $add = DB::table('customer_address')->where('id_user', $id)->get()->first();
                $addresses = DB::table('address')->where('id_address', $add->id_address)->get();
                ?>
                @each('partials.checkout', $addresses, 'address')
                <br>
                <input type="radio" id="Other" name="option" value="-1" selected>
                <label for="Other">Other</label><br> -->

                <label class="form-label mt-4" for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                <input class="form-control" type="text" id="adr" name="address" placeholder="542 W. 15th Street" required>

                <label class="form-label mt-4" for="city"><i class="fa fa-institution"></i> City</label>
                <input class="form-control" type="text" id="city" name="city" placeholder="New York" required>

                <label class="form-label mt-4" for="country"><i class="fa fa-institution"></i> Country</label>
                <input class="form-control" type="text" id="country" name="country" placeholder="United States" required>

                <label class="form-label mt-4" for="door"><i class="fa fa-institution"></i> Door number</label>
                <input class="form-control" type="number" id="door" name="door" placeholder="131" required>

                <div class="row">
                <div class="col-50">

                    <label class="form-label mt-4" for="state">State</label>
                    <input class="form-control" type="text" id="state" name="state" placeholder="NY" required>

                </div>
                <div class="col-50">

                    <label class="form-label mt-4" for="zip">Zip</label>
                    <input class="form-control" type="number" id="zip" name="zip" placeholder="1003201" required>

                </div>
                </div>
                <h3>Payment</h3>
                <label for="fname">Accepted Cards</label>
                <div class="icon-container">
                <i class="fa fa-cc-visa" style="color:navy;"></i>
                <i class="fa fa-cc-amex" style="color:blue;"></i>
                <i class="fa fa-cc-mastercard" style="color:red;"></i>
                <i class="fa fa-cc-discover" style="color:orange;"></i>
                </div>

                <label class="form-label mt-4" for="cname">Name on Card</label>
                <input class="form-control" type="text" id="cname" name="cardname" placeholder="John More Doe" required>

                <label class="form-label mt-4" for="ccnum">Credit card number</label>
                <input class="form-control" type="number" id="ccnum" name="cardnumber" placeholder="1111222233334444" required>

                <label class="form-label mt-4" for="expmonth">Exp Month</label>
                <input class="form-control" type="text" id="expmonth" name="expmonth" placeholder="September" required>


                <div class="row">
                <div class="col-50">

                    <label class="form-label mt-4" for="expyear">Exp Year</label>
                    <input class="form-control" type="number" id="expyear" name="expyear" placeholder="2018" required>

                </div>
                <div class="col-50">

                    <label class="form-label mt-4" for="cvv">CVV</label>
                    <input class="form-control" type="number" id="cvv" name="cvv" placeholder="352" required>

                </div>
                </div>
            </div>

            </div>
            <input type="submit" class="btn btn-primary" value="Continue to checkout" class="btn">
        </form>
    </div>
</section>

@endsection
