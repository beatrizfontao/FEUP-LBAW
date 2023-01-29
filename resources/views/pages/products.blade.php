@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="col-md-12 mt-3">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                @each('partials.product', $products, 'product')
            </div>
        </div>
    </div>

    {{$products->links()}}
    @endsection
