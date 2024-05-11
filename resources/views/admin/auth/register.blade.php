@extends('admin.layouts.app')


@section('content')
    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="{{ url('index.html') }}" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ url('assets/img/logo.png') }}" alt="">
                                    <span class="d-none d-lg-block">NiceAdmin</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                        <p class="text-center small">Enter your personal details to create account</p>
                                    </div>

                                    <form class="row g-3 needs-validation" action="{{ route('register.admin') }}"
                                        method="post">
                                        {{ csrf_field() }}

                                        <div class="col-12">
                                            <label for="yourName" class="form-label">Admin Name</label>
                                            <input type="text" name="admin_name"
                                                class="form-control @error('admin_name') is-invalid @enderror"
                                                id="yourName">

                                            @error('admin_name')
                                                <span class="text-danger" style="font-size: 14px;">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Admin Email</label>
                                            <input type="email" name="admin_email" value="{{ old('admin_email') }}"
                                                class="form-control @error('admin_email')
                                                is-invalid
                                            @enderror"
                                                id="yourEmail">

                                            @error('admin_email')
                                                <span class="text-danger" style="font-size: 14px;">
                                                    {{ $message }}
                                                </span>
                                            @enderror

                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="admin_password" class="form-control"
                                                id="yourPassword">

                                            @error('admin_password')
                                                <span class="text-danger" style="font-size: 14px;">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Confirm Password</label>
                                            <input type="password" name="admin_password_confirmation" class="form-control"
                                                id="yourPassword">

                                            @error('admin_password_confirmation')
                                                <span class="text-danger" style="font-size: 14px;">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Create Account</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Already have an account? <a
                                                    href="{{ route('admin.home.login') }}">Log in</a></p>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>

            </section>

        </div>
    </main><!-- End #main -->
@endsection
