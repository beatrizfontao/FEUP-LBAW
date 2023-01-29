@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="row mt-4">
        <div class="col-md-10">
            {{-- @each('partials.order', $orders, 'order') --}}
            @foreach ($orders as $order)
                @include('partials.order', ['order' => $order, 'user' => $user])
            @endforeach
        </div>

        @include('partials.sidemenu')
    </div>
@endsection
