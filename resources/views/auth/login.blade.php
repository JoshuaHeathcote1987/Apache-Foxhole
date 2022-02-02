@extends('layouts.app')
@section('content')
    <div class="container mt-5 cold-sm-12 col-md-7 col-lg-5">
        <h3>Login |</h3>
        <hr>
        @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::get('fail'))
            <div class="alert alert-danger">
                {{ Session::get('fail') }}
            </div>
        @endif
        <form action="" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                    value="{{ old('email') }}">
                <label for="floatingInput">Email</label>
                <span class="text-danger">@error('email') {{ $message }} @enderror</span>
            </div>
            <div class="form-floating">
                <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
                <span class="text-danger">@error('password') {{ $message }} @enderror</span>
            </div>
            <button type="submit" class="btn btn-success mt-5 w-100" style="height: 50px;">Sign In</button>
            <a href="" style="color: black">I don't have an account!</a>
        </form>
    </div>
@endsection
