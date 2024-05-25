@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
    {{-- <hr class="mt-5"> --}}

    <div class="container-md mt-5">

        {{-- SERIES PANE --}}
        <h4 style="font-family: 'Ubuntu sans', sans-serif;" class="mt-5 pt-4">New Series</h4>
        <div class="row">
            @unless (count($series_all) == 0)
                @foreach ($series_all as $series)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                        <a href="{{ url('media/' . $series->originalTitleText) }}" class="text-decoration-none text-reset"><img
                                data-src="{{ $series->imageUrl ? asset($series->imageUrl) : asset('images/No-Image-Placeholder.svg.webp') }}"
                                alt="{{ str_replace(['-', $series->movieId], ' ', $series->originalTitleText) . ' ' . '(' . $series->releaseYear . ')' }}"
                                class="img-fluid blurry-image lazy"
                                style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.315);" loading="lazy"></a>
                        <a href="{{ url('media/' . $series->originalTitleText) }}" class="text-decoration-none text-reset"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            data-bs-title="{{ str_replace(['-', $series->movieId], ' ', $series->originalTitleText) . ' ' . '(' . $series->releaseYear . ')' }}">

                            <h6 class="mt-1 text-truncate" style="font-family: 'Ubuntu sans', sans-serif; font-weight: 500">
                                {{ $series->full_name . ' ' . '(' . $series->releaseYear . ')' }}
                            </h6>
                        </a>
                        @if ($series->genres == 0)
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $series->genres = 'N/A' }}</h6>
                        @elseif ($series->genres == '')
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $series->genres = 'N/A' }}</h6>
                        @else
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $series->genres }}</h6>
                        @endif
                    </div>
                @endforeach
            @endunless
        </div>

        <div class="mt-4 text-center">
            <a href="{{ url('show-more?cartegory=series') }}" class="btn btn-primary" id="show-more">Show More</a>
        </div>
    </div>

    <hr class="mt-5">

    <div class="container-md mt-5">

        {{-- MOVIES PANE --}}
        <h4 style="font-family: 'Ubuntu sans', sans-serif;">New Movies</h4>
        <div class="row">
            @unless (count($movies_all) == 0)
                @foreach ($movies_all as $movies)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                        <a href="{{ url('media/' . $movies->originalTitleText) }}" class="text-decoration-none text-reset"><img
                                data-src="{{ $movies->imageUrl ? asset($movies->imageUrl) : asset('images/no-image.png') }}"
                                alt="{{ str_replace(['-', $movies->releaseYear], ' ', $movies->originalTitleText) . ' ' . '(' . $movies->releaseYear . ')' }}"
                                class="img-fluid blurry-image lazy"
                                style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.315);" loading="lazy"></a>
                        <a href="{{ url('media/' . $movies->originalTitleText) }}" class="text-decoration-none text-reset"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            data-bs-title="{{ $movies->full_name . ' ' . '(' . $movies->releaseYear . ')' }}">

                            <h6 class="mt-1 text-truncate" style="font-family: 'Ubuntu sans', sans-serif; font-weight: 500">
                                {{ $movies->full_name . ' ' . '(' . $movies->releaseYear . ')' }}
                            </h6>
                        </a>
                        @if ($movies->genres == 0)
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $movies->genres = 'N/A' }}</h6>
                        @elseif ($movies->genres == '')
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $movies->genres = 'N/A' }}</h6>
                        @else
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $movies->genres }}</h6>
                        @endif
                    </div>
                @endforeach
            @endunless
        </div>
        <div class="mt-4 text-center">
            <a href="{{ url('show-more?cartegory=movies') }}" class="btn btn-primary" id="show-more">Show More</a>
        </div>
    </div>
@endsection
