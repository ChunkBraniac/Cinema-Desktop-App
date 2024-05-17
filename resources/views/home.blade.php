@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
    {{-- <hr class="mt-5"> --}}

    <div class="container-md mt-xl-3 pt-xl-5 mt-5 pt-0">
        <form action="{{ route('movie.search') }}" class="mb-xl-5 mb-4 d-block d-xl-none d-sm-block d-md-block d-lg-none">
            @method('get')
            <input type="search" class="form-control pt-2 pb-2" style="border-radius: 0px; box-shadow: none" placeholder="Enter keyword" name="search" @required(true)>
        </form>

        <h4>Series</h4>
        <div class="row">
            @unless (count($series_all) == 0)
                @foreach ($series_all as $series)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                        <a href="{{ url('media/' . $series->originalTitleText . '/' . $series->titleType) }}" class="text-decoration-none text-dark"><img
                                data-src="{{ asset($series->imageUrl) }}" alt="{{ $series->originalTitleText . ' ' . '(' . $series->releaseYear . ')' }}" class="img-fluid blurry-image lazy"
                                style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.493);" loading="lazy"></a>
                        <a href="{{ url('media/' . $series->originalTitleText . '/' . $series->titleType) }}"
                            class="text-decoration-none text-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ $series->originalTitleText . ' ' . '(' . $series->releaseYear . ')' }}">

                            <h6 class="mt-1 text-truncate" style="font-family: 'Ubuntu sans', sans-serif; font-weight: 500">
                                {{ $series->originalTitleText . ' ' . '(' . $series->releaseYear . ')' }}</h6>
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
        <h4>Movies</h4>
        <div class="row">
            @unless (count($movies_all) == 0)
                @foreach ($movies_all as $movies)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                        <a href="{{ url('media/' . $movies->originalTitleText . '/' . $movies->titleType) }}"><img
                            data-src="{{ asset($movies->imageUrl) }}" alt="{{ $movies->originalTitleText . ' ' . '(' . $movies->releaseYear . ')' }}" class="img-fluid blurry-image lazy"
                            style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.493);" loading="lazy"></a>
                        <a href="{{ url('media/' . $movies->originalTitleText . '/' . $movies->titleType) }}"
                            class="text-decoration-none text-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ $movies->originalTitleText . ' ' . '(' . $movies->releaseYear . ')' }}">

                            <h6 class="mt-1 text-truncate" style="font-family: 'Ubuntu sans', sans-serif; font-weight: 500">
                                {{ $movies->originalTitleText . ' ' . '(' . $movies->releaseYear . ')' }}</h6>
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
