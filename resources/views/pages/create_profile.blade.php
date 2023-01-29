@extends('layouts.app')

@section('content')
    </form>
    <h2>Create a user</h2>

    <div class="auth-form">
        <form method="POST" action="create_user" enctype="multipart/form-data">
            @csrf
            <!--Name field-->
            <div class="name-input">
                <label class="form-label mt-4" for="name">Name<span style="color: red">*</span></label>
                <input class="form-control" id="name" type="text" name="name" value="" required>
                @if ($errors->has('name'))
                    <span class="error">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>

            <!--Email field-->
            <div class="email-input">
                <label class="form-label mt-4" for="email">E-Mail Address<span style="color: red">*</span></label>
                <input class="form-control" id="email" type="email" name="email" value="" required>
                @if ($errors->has('email'))
                    <span class="error">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>

            <!--Date of birth field-->
            <div class="date_of_birth-input">
                <label class="form-label mt-4" for="date_of_birth">Birthday<span style="color: red">*</span></label>
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
                <label class="form-label mt-4" for="password">Password<span style="color: red">*</span></label>
                <input class="form-control" id="password" type="password" name="password" value="" required>
                @if ($errors->has('password'))
                    <span class="error">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>


            <label class="form-label mt-4" for="photo">Picture</label>
            <input class="form-control" type="file" id="photo" name="photo" placeholder="example.jpeg">
            @if ($errors->has('photo'))
                <span class="error">
                    {{ $errors->first('photo') }}
                </span>
            @endif

            <button class="btn btn-primary my-4" type="submit">Create user</button>
        </form>
@endsection
