@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <h1 style=" text-align: center "> {{ $category }} <h1>
    <div class="col-md-12 mt-3">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                @each('partials.product', $products, 'product')
            </div>
        </div>
    </div>

@endsection
