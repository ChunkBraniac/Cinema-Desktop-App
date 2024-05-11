@extends('layouts.app')

@section('title')
    Login
@endsection

@section('content')
    <br><br><br>
    <div class="container mt-5">
        <div class="col-xl-4 m-auto border p-4" style="border-radius: 6px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <form action="" method="post">
                <h4 class="text-center mt-4">Log into Your Account</h4>
                @if (session('success'))
                    <div class="alert alert-success mt-3 m-auto text-center">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error mt-3">
                        {{ session('error') }}
                    </div>
                @endif

                <div>
                    <label for="" class="mt-3">Email</label>
                    <input type="text" name="email" class="form-control">
                </div>

                <div>
                    <label for="" class="mt-3">Password</label>
                    <input type="text" name="password" class="form-control">
                </div>

                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="" name="remember" />
                    <label class="form-check-label" for=""> Remember me </label>
                </div>
                
                <div class="mt-3 d-grid gap-2">
                    <button class="btn btn-block btn-primary">Login</button>

                    <span style="font-size: 15px">Don't have an account? <a href="{{ route('user.register.page') }}" class="text-decoration-none">Create an account</a></span>

                    <span style="font-size: 15px"><a href="" class="text-decoration-none">Reset password</a></span>
                </div>
            </form>
        </div>

        <div class="m-auto text-center mt-3">
            <a href="/" class="text-decoration-none">Home</a>
        </div>
    </div>
@endsection
