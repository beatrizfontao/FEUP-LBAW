@extends('layouts.app')

@section('content')
    <div class="auth-form">
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <fieldset>

                    <h2 class="text-center ms-5 mt-3">Register</h2>
                    <div class="col-md-12 mt-2">

                        <!--Name field-->
                        <div class="form-group">
                            <label for="name" class="form-label mt-1">Name<span style="color: red">*</span></label>
                            <input class="form-control" id="name" type="text" name="name"
                                value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <span class="error">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>

                        <!--E-mail field-->
                        <div class="form-group">
                            <label for="email" class="form-label mt-4">E-Mail Address<span
                                    style="color: red">*</span></label>
                            <input class="form-control" id="email" type="email" name="email"
                                value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="error">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>

                        <!--Date of birth field-->
                        <div class="form-group">
                            <label for="date_of_birth" class="form-label mt-4">Birthday<span
                                    style="color: red">*</span></label>
                            <input class="form-control" id="date_of_birth" type="date" name="date_of_birth"
                                value="{{ old('date_of_birth') }}" placeholder="yyyy-mm-dd" required>
                            <!--Check if the date is in the right format-->
                            @if ($errors->has('date_of_birth'))
                                <span class="error">
                                    {{ $errors->first('date_of_birth') }}
                                </span>
                            @endif
                        </div>

                        <!--Gender input-->
                        <div class="form-group">
                            <label for="gender" class="form-label mt-4">Gender</label>
                            <select class="form-select" aria-label="gender" id="gender" name="gender">
                                <option value="" selected hidden>Select your option</option>
                                <option value="female">Female</option>
                                <option value="male">Male</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!--Password field-->
                        <div class="form-group">
                            <label for="password" class="form-label mt-4">Password<span style="color: red">*</span></label>
                            <input class="form-control" id="password" type="password" name="password" required>
                            @if ($errors->has('password'))
                                <span class="error">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>

                        <!--Confirm password field-->
                        <div class="form-group">
                            <label for="password-confirm" class="form-label mt-4">Confirm Password<span
                                    style="color: red">*</span></label>
                            <input class="form-control" id="password-confirm" type="password" name="password_confirmation"
                                required>
                        </div>

                        <!--Profile Picture field-->
                        <div class="form-group">
                            <label for="photo" class="form-label mt-4">Profile Pricture</label>
                            <input class="form-control" id="photo" type="file" name="photo" accept=".jpg,.png,.jpeg" />
                            @if ($errors->has('photo'))
                                <span class="error">
                                    {{ $errors->first('photo') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 text-center mt-3">
                        <h5>Already have an account? <a href="/login">Log in</a></h5>
                    </div>
    
                </fieldset>

                <div class="col-md-12 text-center mt-2">
                    <button class="btn btn-primary mt-2" type="submit" style="width: 250px">
                        Register
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
