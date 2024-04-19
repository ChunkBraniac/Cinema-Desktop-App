@extends('layouts.app')

@section('content')
    {{-- main --}}
    <div class="container mt-5">
        <h4>TOP 10</h4>
        <div class="owl-carousel owl-theme">
            <div class="item">
                <img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="">
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="item">
                <img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="">
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="item">
                <img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="">
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="item">
                <img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="">
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="item">
                <img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="">
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="item">
                <img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="">
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="item">
                <img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="">
            </div>
            <div class="item">
                <img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="">
            </div>
            <div class="item">
                <img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="">
            </div>
        </div>
    </div>

    <hr class="mt-5">

    <div class="container mt-5">
        <h4>Streaming</h4>
        <div class="row">
            <div class="col-xl-2">
                <a href="{{ url('') }}"><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="col-xl-2">
                <a href="{{ url('') }}"><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="col-xl-2">
                <a href="{{ url('') }}"><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="col-xl-2">
                <a href="{{ url('') }}"><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="col-xl-2">
                <a href="{{ url('') }}"><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="col-xl-2">
                <a href="{{ url('') }}"><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ url('') }}" class="btn btn-primary" id="show-more">Show More</a>
        </div>
    </div>

    <hr class="mt-5">

    <div class="container mt-5">
        <h4>Popular Movies & Series</h4>
        <div class="row">
            <div class="col-xl-2">
                <a href="{{ url('') }}"><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="col-xl-2">
                <a href="{{ url('') }}"><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="col-xl-2">
                <a href="{{ url('') }}"><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="col-xl-2">
                <a href="{{ url('') }}"><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="col-xl-2">
                <a href="{{ url('') }}"><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
            <div class="col-xl-2">
                <a href="{{ url('') }}"><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-1">Movie Name</h6></a>
            </div>
        </div>
        <div class="mt-4 text-center">
            <a href="{{ url('') }}" class="btn btn-primary" id="show-more">Show More</a>
        </div>
    </div>
@endsection
    

