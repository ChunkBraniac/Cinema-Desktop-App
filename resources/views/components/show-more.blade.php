@extends('layouts.app')

@php
    $cartegory = $_GET['cartegory'];
@endphp

@if ($cartegory == 'series')
    @section('title')
        All Series
    @endsection
@elseif ($cartegory == 'movies')
    @section('title')
        All Movies
    @endsection
@endif

@section('content')

    <br><br>
    @if ($cartegory == 'series')
        <div class="container">
            <h4 style="float: left">Series</h4>
            <h6 class="" style="float: right; font-family: 'Roboto', sans-serif; font-weight: normal"><span
                    style="margin-right: 5px; font-size: 14px"><a href="{{ url('/') }} "
                        class="text-decoration-none text-dark text-muted">Home</a></span> <i
                    class="fa fa-arrow-right text-muted" style="font-size: 13px" aria-hidden="true"></i> <span
                    style="margin-left: 5px; font-size: 14px" class="text-muted">Series</span></h6>
        </div>

    @elseif ($cartegory == 'movies')
        <div class="container">
            <h4 style="float: left">Movies</h4>
            <h6 class="" style="float: right; font-family: 'Roboto', sans-serif; font-weight: normal"><span
                    style="margin-right: 5px; font-size: 14px"><a href="{{ url('/') }} "
                        class="text-decoration-none text-dark text-muted">Home</a></span> <i
                    class="fa fa-arrow-right text-muted" style="font-size: 13px" aria-hidden="true"></i> <span
                    style="margin-left: 5px; font-size: 14px" class="text-muted">Movies</span></h6>
        </div>
    @endif

    <br><br>
    <hr>
    <div class="container mt-5">

        {{-- Movies Pane --}}
        @if ($cartegory == 'movies')
            <div class="row mb-4">
                @unless (count($more_Movies) == 0)
                    @foreach ($more_Movies as $action)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                            <a href="{{ url('media/' . $action->originalTitleText . '/' . $action->titleType) }}"><img
                                data-src="{{ asset($action->imageUrl) }}" alt="" class="img-fluid blurry-image lazy"
                                style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.493)" loading="lazy"></a>
                            <a href="{{ url('media/' . $action->originalTitleText . '/' . $action->titleType) }}"
                                class="text-decoration-none text-dark">

                                <h6 class="mt-1 text-truncate" style="font-family: 'Ubuntu sans', sans-serif; font-weight: 500" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ $action->originalTitleText . ' ' . '(' . $action->releaseYear . ')' }}">
                                    {{ $action->originalTitleText . ' ' . '(' . $action->releaseYear . ')'  }}</h6>
                            </a>
                            @if ($action->genres == 0)
                                <h6 class="text-truncate"
                                    style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                    {{ $action->genres = 'N/A' }}</h6>
                            @elseif ($action->genres == '')
                                <h6 class="text-truncate"
                                    style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                    {{ $action->genres = 'N/A' }}</h6>
                            @else
                                <h6 class="text-truncate"
                                    style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                    {{ $action->genres }}</h6>
                            @endif
                        </div>
                    @endforeach
                @endunless
            </div>

            {{ $more_Movies->appends(request()->query())->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}

            @if (count($more_Movies) == 0)
                {{ abort(404) }}
            @endif


        {{-- Series Pane --}}
        @elseif ($cartegory == 'series')
            <div class="row mb-4">
                @unless (count($more_Series) == 0)
                    @foreach ($more_Series as $action)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                            <a href="{{ url('media/' . $action->originalTitleText . '/' . $action->titleType) }}"><img
                                data-src="{{ asset($action->imageUrl) }}" alt="" class="img-fluid blurry-image lazy"
                                style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.493);" loading="lazy"></a>
                            <a href="{{ url('media/' . $action->originalTitleText . '/' . $action->titleType) }}"
                                class="text-decoration-none text-dark">

                                <h6 class="mt-1 text-truncate" style="font-family: 'Ubuntu sans', sans-serif; font-weight: 500" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ $action->originalTitleText . ' ' . '(' . $action->releaseYear . ')' }}">
                                    {{ $action->originalTitleText . ' ' . '(' . $action->releaseYear . ')' }}</h6>
                            </a>
                            @if ($action->genres == 0)
                                <h6 class="text-truncate"
                                    style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                    {{ $action->genres = 'N/A' }}</h6>
                            @elseif ($action->genres == '')
                                <h6 class="text-truncate"
                                    style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                    {{ $action->genres = 'N/A' }}</h6>
                            @else
                                <h6 class="text-truncate"
                                    style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                    {{ $action->genres }}</h6>
                            @endif
                        </div>
                    @endforeach
                @endunless
            </div>

            {{ $more_Series->appends(request()->query())->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}

            @if (count($more_Series) == 0)
                {{ abort(404) }}
            @endif

        @endif

    </div>
@endsection
