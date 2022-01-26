@extends('layouts.app')
@section('content')
    <div class="container mt-5 cold-sm-12 col-md-7 col-lg-5" style="">
        <h3>Register |</h3>
        <hr>
        @if (Session::get('fail'))
            <div class="alert alert-danger">
                {{ Session::get('fail') }}
            </div>
        @endif
        <form action="/register" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input name="full_name" type="text" class="form-control" id="floatingInput" value="{{ old('full_name') }}">
                <label for="floatingInput">Full Name</label>
                <span class="text-danger">@error('full_name'){{ $message }}@enderror</span>
                </div>
                <div class="form-floating mb-3">
                    <input name="game_name" type="text" class="form-control" id="floatingInput" value="{{ old('game_name') }}">
                    <label for="floatingInput">Game Name</label>
                    <span class="text-danger">@error('game_name'){{ $message }}@enderror</span>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="email" type="email" class="form-control" id="floatingInput" value="{{ old('email') }}">
                        <label for="floatingInput">Email address</label>
                        <span class="text-danger">@error('email'){{ $message }}@enderror</span>
                        </div>
                        <div class="form-floating">
                            <input name="password" type="password" class="form-control" id="floatingPassword">
                            <label for="floatingPassword">Password</label>
                            <span class="text-danger">@error('password'){{ $message }}@enderror</span>
                            </div>
                            <button type="submit" class="btn btn-success mt-5 w-100" style="height: 50px;">Create Account</button>
                            <a href="">I already have an account!</a>
                        </form>
                    </div>
                @endsection
