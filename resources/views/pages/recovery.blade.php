@extends('layouts.app')

@section('content')
    <form method="POST" action="/send-email">
        @csrf
        <div class="container">
            <fieldset>

                <h2 class="text-center ms-5 mt-3">Recover Password</h2>
                <div class="col-md-12 mt-2">
                    <!--E-mail field-->
                    <div class="form-group">
                        <label for="email" class="form-label mt-2">E-mail</label>
                        <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}"
                            required autofocus>
                        @if ($errors->has('email'))
                            <span class="error">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                </div>

            </fieldset>
            <div class="col-md-12 text-center mt-2">
                <button class="btn btn-primary mt-2" type="submit" style="width: 250px">
                    Recover
                </button>
            </div>
        </div>
    </form>
@endsection
