@extends('layouts.app')

@section('title')
    Register
@endsection

@section('content')
    <br><br><br>
    <div class="container mt-5">
        <div class="col-xl-4 m-auto border p-4" style="border-radius: 6px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <form action="{{ route('user.register') }}" method="post">
                {{ csrf_field() }}

                <h4 class="text-center mt-4">Register an Account</h4>

                <div>
                    <label for="" class="mt-4">Username<span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control">

                    @error('name')
                        <span class="text-danger" style="font-size: 15px; font-weight: normal;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="" class="mt-3">Email<span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">

                    @error('email')
                        <span class="text-danger" style="font-size: 15px; font-weight: normal;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="" class="mt-3">Password<span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control">

                    @error('password')
                        <span class="text-danger" style="font-size: 15px; font-weight: normal;">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="" class="mt-3">Confirm Password<span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="mt-3 d-grid gap-2">
                    <button class="btn btn-block btn-primary">Register</button>

                    <span style="font-size: 15px">Already have an account? <a href="{{ route('user.login.page') }}"
                            class="text-decoration-none">Log in</a></span>
                </div>
            </form>
        </div>
    </div>
@endsection
