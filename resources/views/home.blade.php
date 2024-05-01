@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
    {{-- main --}}
    {{-- <div class="container mt-5">
        <h4>TOP 10</h4>
        <div class="owl-carousel owl-theme">
            @unless (count($top10) == 0)
                @foreach ($top10 as $item)
                    <div class="item">
                        <a href="{{ url('media/' . $item->originalTitleText . '/' . $item->titleType) }}"><img src="{{ asset($item->imageUrl) }}" alt=""
                                style="height: 400px; object-fit: fill;" loading="lazy"></a>
                        <a href="{{ url('media/' . $item->originalTitleText . '/' . $item->titleType) }}" class="text-decoration-none text-dark">
                            <h6 class="mt-1 text-truncate" style="font-family: 'Robot', sans-serif; font-weight: 500">{{ $item->originalTitleText }}</h6>
                        </a>
                        <h6 style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">{{ $item->genres }}</h6>
                    </div>
                @endforeach
            @endunless
        </div>
    </div> --}}

    {{-- <hr class="mt-5"> --}}

    <div class="container-xl mt-5">
        <h4>Series</h4>
        <div class="row">
            @unless (count($series_all) == 0)
                @foreach ($series_all as $streamed)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                        <a href="{{ url('media/' . $streamed->originalTitleText . '/' . $streamed->titleType) }}"><img
                                src="{{ asset($streamed->imageUrl) }}" alt="" class="img-fluid"
                                style="height: 400px; object-fit: fill;" loading="lazy"></a>
                        <a href="{{ url('media/' . $streamed->originalTitleText . '/' . $streamed->titleType) }}"
                            class="text-decoration-none text-dark">
                            <h6 class="mt-1 text-truncate" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                {{ $streamed->originalTitleText }}</h6>
                        </a>
                        @if ($streamed->genres == 0)
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $streamed->genres = 'N/A' }}</h6>
                        @elseif ($streamed->genres == '')
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $streamed->genres = 'N/A' }}</h6>
                        @else
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $streamed->genres }}</h6>
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

    <div class="container-xl mt-5">
        <h4>Movies</h4>
        <div class="row">
            @unless (count($movies_all) == 0)
                @foreach ($movies_all as $popularMovies)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                        <a href="{{ url('media/' . $popularMovies->originalTitleText . '/' . $popularMovies->titleType) }}"><img
                                loading="lazy" src="{{ asset($popularMovies->imageUrl) }}" alt="" class="img-fluid"
                                style="height: 400px; object-fit: fill;"></a>
                        <a href="{{ url('media/' . $popularMovies->originalTitleText . '/' . $popularMovies->titleType) }}"
                            class="text-decoration-none text-dark">
                            <h6 class="mt-1 text-truncate" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                {{ $popularMovies->originalTitleText }}</h6>
                        </a>
                        @if ($popularMovies->genres == 0)
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $popularMovies->genres = 'N/A' }}</h6>
                        @elseif ($popularMovies->genres == '')
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $popularMovies->genres = 'N/A' }}</h6>
                        @else
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $popularMovies->genres }}</h6>
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
