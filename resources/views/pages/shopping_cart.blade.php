@extends('layouts.app')

@section('title', 'ShoppingCart')

@section('content')
    <div class="col-md-12 mt-3">
        <div class="col-md-10 offset-md-1">
            <div class="row" id="shopping_cart">
                <h3 class="m-3 text-center">Shopping Cart</h3>
                @each(
                    'partials.product_shopping_cart',
                    $shopping_cart->products()->orderBy('id_product')->distinct()->get(),
                    'product'
                )
                <p>Total Price :</p>
                <p id="price">{{ number_format((float) $shopping_cart->total_price, 2, '.', '') }} €</p>
                <a class="button btn btn-primary mt-4" href="{{ url('/checkout') }}">Checkout</a>
            </div>
        </div>
    </div>


@endsection
