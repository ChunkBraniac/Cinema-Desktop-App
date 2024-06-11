@extends('admin.layouts.app')

@section('title')
    Login
@endsection

@section('content')
    @if (Auth::guard('admin')->check())
        @php
            header('Location: ' . route('admin.dashboard'));
            exit();
        @endphp
    @endif
    
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="{{ url('admin') }}" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ url('assets/img/logo.png') }}" alt="">
                                    <span class="d-none d-lg-block">NiceAdmin</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>

                                    <form class="row g-3 needs-validation" action="{{ route('admin.login') }}"
                                        method="post">
                                        {{ csrf_field() }}

                                        @if (session('success'))
                                            <h6 class="alert alert-success text-center" style="font-size: 14px;">{{ session('success') }}</h6>
                                        @endif

                                        @if (session('error'))
                                            <h6 class="alert alert-danger text-center" style="font-size: 14px;">{{ session('error') }}</h6>
                                        @endif

                                        @if (session('stat'))
                                            <h6 class="alert alert-danger text-center" style="font-size: 14px;">{{ session('stat') }}</h6>
                                        @endif
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <input type="email" name="admin_email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="yourUsername" @required(true)>
                                            </div>
                                            @error('admin_email')
                                                <span class="text-danger" style="font-size: 14px;">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="admin_password"
                                                class="form-control @error('admin_password') is-invalid @enderror"
                                                id="yourPassword" @required(true)>

                                            @error('admin_password')
                                                <span class="text-danger" style="font-size: 14px;">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Don't have account? <a
                                                    href="{{ route('admin.home.register') }}">Create an account</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->
@endsection
