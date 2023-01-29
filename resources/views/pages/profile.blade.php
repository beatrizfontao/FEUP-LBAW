@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    @include('partials.delete_account')
    <div class="row mt-5">
        <div class="col-md-4">
            <img id="profile_picture" src="{{ asset('storage/users/' . $user->getProfilePicture()) }}" class="img-fluid"
                alt="Photo of {{ $user->name }}">
        </div>
        <div class="col-md-5">
            <h2 class="ms-5"> About: </h2>

            <h3 class="ms-5">Name: {{ $user->name }}</h3>
            <h3 class="ms-5">Email: {{ $user->email }}</h3>
            <h3 class="ms-5">Birthday: {{ $user->date_of_birth }}</h3>

            <!-- Edit profile button -->
            <a class="btn btn-primary mt-4 ms-5" href="{{ url('/user/' . $user->id_user . '/edit') }}"> Edit Profile </a>
            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-form"
                class="btn btn-danger mt-4 mx-2">Delete Account</button>
        </div>
        @if (!Auth::user()['is_admin'] || $user->id_user !== Auth::user()['id_user'])
            @include('partials.sidemenu')
        @endif
    </div>
@endsection
