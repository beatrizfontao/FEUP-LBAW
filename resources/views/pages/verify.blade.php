@extends('layouts.app')

@section('title', 'Order')

@section('content')

<section>
    <h1>Order sent</h1>
    <p>address - {{  $input["address"] }}</p>
    <p>city - {{  $input["city"] }}</p>
    <p>state - {{  $input["state"] }}</p>
    <p>zip - {{  $input["zip"] }}</p>
    <p>cardname - {{  $input["cardname"] }}</p>
    <p>cardnumber - {{  $input["cardnumber"] }}</p>
    <p>expmonth - {{  $input["expmonth"] }}</p>
    <p>expyear - {{  $input["expyear"] }}</p>
    <p>cvv - {{  $input["cvv"] }}</p>
    
</section>

@endsection
