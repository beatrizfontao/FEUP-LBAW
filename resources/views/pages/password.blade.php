@extends('layouts.app')

@section('content')
    <form method="POST" action="/send-email"><!--MUDAR A ACTION PARA O CORRETO-->
        @csrf
        <div class="container">
            <fieldset>

                <h2 class="text-center ms-5 mt-3">Recover Password</h2>
                <div class="col-md-12 mt-2">
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
                </div>
            </fieldset>
            <div class="col-md-12 text-center mt-2">
                <button class="btn btn-primary mt-2" type="submit" style="width: 250px">
                    Reset
                </button>
            </div>
        </div>
    </form>
@endsection
