@extends('layouts.app')

@section('title', 'My Addresses')

@section('content')

<div class="row mt-5">
  <section class="col-lg-10" id="addresses">
    @each('partials.address', $addresses, 'address')
  </section>
  @include('partials.sidemenu')
</div>

@endsection