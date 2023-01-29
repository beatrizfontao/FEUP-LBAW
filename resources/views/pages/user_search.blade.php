@extends('layouts.app')

@section('title', 'Products')

@section('content')

<section>
  <h1>User search</h1>
  <div class="profile">
        <div class="profile-picture">
            <img id="profile_picture" class="image" src="{{ asset('storage/users/' . $customer->photo) }}"
                alt="Photo of {{ $customer->name }}">
        </div>
        <div class="user-personalinfo">

            <h3 id="user_name">{{ $customer->name }}</h3>
            <h4 id="user_email">{{ $customer->email }}</h4>
            <h4 id="user_birthday">{{ $customer->date_of_birth }}</h4>
            <h4 id="user_birthday">{{ $customer->gender }}</h4>

            <!-- Edit profile button -->
        </div>
    </div>
  <h1>Edit user</h1>
  <div class="auth-form">
    <form method="POST" action="edit_profile_admin" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!--Name field-->
        <div class="name-input">
            <label class="form-label mt-4" for="name">Name</label>
            <input class="form-control" id="name" type="text" name="name" value="">
            @if ($errors->has('name'))
                <span class="error">
                    {{ $errors->first('name') }}
                </span> 
            @endif
        </div>

        <!--Email field-->
        <div class="email-input">
            <label class="form-label mt-4" for="email">E-Mail Address</label>
            <input class="form-control" id="email" type="email" name="email" value="">
            @if ($errors->has('email'))
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
            @endif
        </div>

        <!--Date of birth field-->
        <div class="date_of_birth-input">
            <label class="form-label mt-4" for="date_of_birth">Birthday</label>
            <input class="form-control" id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" placeholder="yyyy-mm-dd">
            <!--Check if the date is in the right format-->
            @if ($errors->has('date_of_birth'))
                <span class="error">
                    {{ $errors->first('date_of_birth') }}
                </span>
            @endif
        </div>

        <!--Gender input-->
        <div class="gender-input">
            <label class="form-label mt-4" for="gender">Gender</label>
            <select aria-label="gender" id="gender" name="gender">
                <option value="" selected hidden>Select your option</option>
                <option value="female">Female</option> 
                <option value="male">Male</option> 
                <option value="other">Other</option> 
            </select>
        </div>
        
        <!--Password field-->
        <div class="password-input">
            <label class="form-label mt-4" for="password">Password</label>
            <input class="form-control" id="password" type="password" name="password" value="">
            @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>

        <input id="id" type="hidden" name="id" value = {{$customer->id_user}}>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
</section>

@endsection
