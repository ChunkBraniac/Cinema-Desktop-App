@extends('layouts.app')

@section('content')
    {{-- main --}}
    <div class="container mt-5">
        <h4>TOP 10</h4>
        <div class="owl-carousel owl-theme">
            @unless (count($top10) == 0)
                @foreach ($top10 as $item)
                    <div class="item">
                        <a href="{{ url('media/' . $item->originalTitleText . '/' . $item->titleType) }}"><img src="{{ asset($item->imageUrl) }}" alt=""
                                style="height: 400px; object-fit: fill;" loading="lazy"></a>
                        <a href="{{ url('top10/' . $item->id) }}" class="text-decoration-none text-dark">
                            <h6 class="mt-1" style="font-family: 'Robot', sans-serif; font-weight: 500">{{ $item->originalTitleText }}</h6>
                        </a>
                        <h6 style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">{{ $item->genres }}</h6>
                    </div>
                @endforeach
            @endunless
        </div>
    </div>

    <hr class="mt-5">

    <div class="container mt-5">
        <h4>Streaming</h4>
        <div class="row">
            @unless (count($streaming) == 0)
                @foreach ($streaming as $streamed)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                        <a href="{{ url('streaming/' . $streamed->originalTitleText) }}"><img src="{{ asset($streamed->imageUrl) }}" alt=""
                                class="img-fluid" style="height: 400px; object-fit: fill;" loading="lazy"></a>
                        <a href="{{ url('') }}" class="text-decoration-none text-dark">
                            <h6 class="mt-1" style="font-family: 'Robot', sans-serif; font-weight: 500">{{ $streamed->originalTitleText }}</h6>
                        </a>
                        <h6 style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">{{ $streamed->genres }}</h6>
                    </div>
                @endforeach
            @endunless
        </div>

        <div class="mt-4 text-center">
            <a href="{{ url('') }}" class="btn btn-primary" id="show-more">Show More</a>
        </div>
    </div>

    <hr class="mt-5">

    <div class="container mt-5">
        <h4>Popular Movies & Series</h4>
        <div class="row">
            @unless (count($popular) == 0)
                @foreach ($popular as $popularMovies)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                        <a href="{{ url('') }}"><img loading="lazy" src="{{ asset($popularMovies->imageUrl) }}"
                                alt="" class="img-fluid" style="height: 400px; object-fit: fill;"></a>
                        <a href="{{ url('') }}" class="text-decoration-none text-dark">
                            <h6 class="mt-1" style="font-family: 'Robot', sans-serif; font-weight: 500">{{ $popularMovies->originalTitleText }}</h6>
                        </a>
                        <h6 class="text-truncate" style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">{{ $popularMovies->genres }}</h6>
                    </div>
                @endforeach
            @endunless
        </div>
        <div class="mt-4 text-center">
            <a href="{{ url('') }}" class="btn btn-primary" id="show-more">Show More</a>
        </div>
    </div>
@endsection
