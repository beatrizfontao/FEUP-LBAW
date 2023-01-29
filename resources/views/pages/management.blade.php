@extends('layouts.app')

@section('title', 'Management')

@section('content')

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                role="tab" aria-controls="home" aria-selected="true">Users</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Products</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                role="tab" aria-controls="contact" aria-selected="false">Contact</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
    </div>


    {{--
<section>
  <h1>Management Page</h1>
  <a class="btn btn-primary mt-4 ms-5" href="/product/add"> Add Product </a>
  <h2>Search for a user</h2>
  <form action="/user_search" method="POST" enctype="multipart/form-data">
    @csrf
    
    <input class="form-check-input" type="radio" id="ID" name="option" value="1" checked>
    <label class="form-check-label" for="html">Search by ID</label><br>
    
    <input class="form-check-input" type="radio" id="Mail" name="option" value="2">
    <label class="form-check-label" for="css">Search by E-Mail</label><br>

    <label class="form-label mt-4" for="adr"><i class="fa fa-address-card-o"></i> User ID\E-MAIL</label>
    <input class="form-control" type="text" id="adr" name="id" placeholder="0" required>

    <input class="btn btn-primary my-4" type="submit" value="Search user" class="btn">
  </form>
  <h2>Create a user</h2>

  <div class="auth-form">
    <form method="POST" action="create_user" enctype="multipart/form-data">
        @csrf
        <!--Name field-->
        <div class="name-input">
            <label class="form-label mt-4" for="name">Name</label>
            <input class="form-control" id="name" type="text" name="name" value="" required>
            @if ($errors->has('name'))
                <span class="error">
                    {{ $errors->first('name') }}
                </span> 
            @endif
        </div>

        <!--Email field-->
        <div class="email-input">
            <label class="form-label mt-4" for="email">E-Mail Address</label>
            <input class="form-control" id="email" type="email" name="email" value="" required>
            @if ($errors->has('email'))
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
            @endif
        </div>

        <!--Date of birth field-->
        <div class="date_of_birth-input">
            <label class="form-label mt-4" for="date_of_birth">Birthday</label>
            <input class="form-control" id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" placeholder="yyyy-mm-dd" required>
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
            <select class="form-select" aria-label="gender" id="gender" name="gender" required>
                <option value="" selected hidden>Select your option</option>
                <option value="female">Female</option> 
                <option value="male">Male</option> 
                <option value="other">Other</option> 
            </select>
        </div>
        
        <!--Password field-->
        <div class="password-input">
            <label class="form-label mt-4" for="password">Password</label>
            <input class="form-control" id="password" type="password" name="password" value="" required>
            @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>

        
      <label class="form-label mt-4" for="photo">Picture</label>
      <input class="form-control" type="file" id="photo" name="photo" placeholder="example.jpeg" required>
        @if ($errors->has('photo'))
            <span class="error">
                {{ $errors->first('photo') }}
            </span>
        @endif

        <button class="btn btn-primary my-4" type="submit">Create user</button>
    </form>
</section>
--}}
@endsection
