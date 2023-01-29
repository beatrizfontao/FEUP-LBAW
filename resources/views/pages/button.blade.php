@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<form method="POST">
    @csrf
    <button type="submit">PUSH</button>
</form>
@endsection