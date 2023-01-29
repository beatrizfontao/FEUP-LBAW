@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="row">
    @each('partials.report', $reports, 'report')
</div>
@endsection
