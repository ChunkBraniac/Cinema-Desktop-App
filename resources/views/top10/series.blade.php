@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3 class="d-xl-block d-none d-md-block d-sm-block d-lg-block">{{ $series->originalTitleText }}</h3>
        <div class="row">
            <div class="col-xl-3">
                <img src="{{ asset($series->imageUrl ) }}" alt="" class="img-fluid">
            </div>

            <div class="col-xl-4 mt-xl-4">
                <h4 class="d-xl-none d-block d-md-none d-sm-none d-lg-none mt-3">{{ $series->originalTitleText }}</h4>
                <h6 style="font-family: 'Roboto', sans-serif; font-weight: normal">{{ $series->aggregateRating }}</h6>
                <h6 style="font-family: 'Roboto', sans-serif; font-weight: normal">Release year: {{ $series->releaseYear }}</h6>
                <h6 style="font-family: 'Roboto', sans-serif; font-weight: normal">Running time: {{ $series->runtime }}</h6>
                <h6 style="font-family: 'Roboto', sans-serif; font-weight: normal">Country: </h6>
                
                <div class="mt-3">
                    {{ $series->plotText }}
                </div>
            </div>

            <div class="col-xl-5">
                <iframe height="365" src="{{ $series->trailer }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen style="width: 100%;"></iframe>
            </div>
        </div>
    </div>

    <hr class="mt-5">

    <div class="container">
        <div class="row">
            <div class="col-xl-9 border-end">
                <div class="row">
                    <div class="col-xl-3 mt-2">
                        <a href="{{ url('') }} "><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                        <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-2">Movie name</h6></a>
                    </div>
                    <div class="col-xl-3 mt-2">
                        <a href="{{ url('') }} "><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                        <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-2">Movie name</h6></a>
                    </div>
                    <div class="col-xl-3 mt-2">
                        <a href="{{ url('') }} "><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                        <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-2">Movie name</h6></a>
                    </div>
                    <div class="col-xl-3 mt-2">
                        <a href="{{ url('') }} "><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                        <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-2">Movie name</h6></a>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 mt-2">
                <div class="row">
                    <div class="col-xl-6">
                        <a href="{{ url('') }} "><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                        <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-2">Movie name</h6></a>
                    </div>
                    <div class="col-xl-6">
                        <a href="{{ url('') }} "><img src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt="" class="img-fluid"></a>
                        <a href="{{ url('') }}" class="text-decoration-none text-dark"><h6 class="mt-2">Movie name</h6></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="mt-5">

    <div class="container">
        <h4>Comment</h4>
    </div>
@endsection