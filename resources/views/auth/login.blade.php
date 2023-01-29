@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="container">
            <fieldset>

                <h2 class="text-center ms-5 mt-3">Log in</h2>
                <div class="col-md-12 mt-3">
                    <div class="col-md-10 offset-md-1">

                        <!--E-mail field-->
                        <div class="form-group">
                            <label for="email" class="form-label mt-2">E-mail</label>
                            <input class="form-control" id="email" type="email" name="email"
                                value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="error">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>

                        <!--Password field-->
                        <div class="form-group">
                            <label for="password" class="form-label mt-4">Password</label>
                            <input class="form-control" id="password" type="password" name="password" required>
                            @if ($errors->has('password'))
                                <span class="error">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <h5>Forgot your password? <a href="/recover_password">Recover password</a></h5>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <h5>Don't have an account? <a href="/register">Register</a></h5>
                </div>

            </fieldset>
            <div class="col-md-12 text-center mt-2">
                <button class="btn btn-primary mt-2" type="submit" style="width: 250px">
                    Login
                </button>
            </div>
        </div>
    </form>
@endsection
