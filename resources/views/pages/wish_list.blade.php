@extends('layouts.app')

@section('title', 'WishList')

@section('content')
    <div class="row" id="wish_list">
        <h3 class="m-3 text-center">Wish List</h3>
        @each(
            'partials.product',
             $wish_list->products()->orderBy('id_product')->distinct()->get(),
            'product',
        )
    </div>

@endsection
