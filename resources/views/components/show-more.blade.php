@extends('layouts.app')

@php
    $cartegory = $_GET['cartegory'];
@endphp

@if ($cartegory == 'series')
    @section('title')
        TV Series (Page {{ $page }})
    @endsection
@elseif ($cartegory == 'movies')
    @section('title')
        All Movies (Page {{ $page }})
    @endsection
@endif

@section('content')

    <br><br>
    @if ($cartegory == 'series')
        <div class="container">
            <h4 style="float: left; font-family: 'Ubuntu sans', sans-serif;">Series @if ($page == 1)
                @else
                    <span>
                        <h6 style="font-family: 'Roboto', sans-serif; font-weight: normal; font-size: 14px;">Page
                            {{ $page }}</h6>
                    </span>
                @endif
            </h4>

            <h6 class="" style="float: right; font-family: 'Roboto', sans-serif; font-weight: normal"><span
                    style="margin-right: 5px; font-size: 14px"><a href="{{ url('/') }} "
                        class="text-decoration-none text-reset text-muted">Home</a></span> <i
                    class="fa fa-arrow-right text-muted" style="font-size: 13px" aria-hidden="true"></i> <span
                    style="margin-left: 5px; font-size: 14px" class="text-muted">Series</span></h6>
        </div>
    @elseif ($cartegory == 'movies')
        <div class="container">
            <h4 style="float: left; font-family: 'Ubuntu sans', sans-serif;">Movies  @if ($page == 1)
                @else
                    <span>
                        <h6 style="font-family: 'Roboto', sans-serif; font-weight: normal; font-size: 14px;">Page
                            {{ $page }}</h6>
                    </span>
                @endif
            </h4>
            <h6 class="" style="float: right; font-family: 'Roboto', sans-serif; font-weight: normal"><span
                    style="margin-right: 5px; font-size: 14px"><a href="{{ url('/') }} "
                        class="text-decoration-none text-reset text-muted">Home</a></span> <i
                    class="fa fa-arrow-right text-muted" style="font-size: 13px" aria-hidden="true"></i> <span
                    style="margin-left: 5px; font-size: 14px" class="text-muted">Movies</span></h6>
        </div>
    @endif

    <br><br>
    <hr>
    <div class="container mt-5">
        {{-- Series Pane --}}
        @if ($cartegory == 'series')
            <div class="row mb-4">
                @unless (count($more_Series) == 0)
                    @foreach ($more_Series as $action)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                            <a href="{{ url('media/' . $action->originalTitleText) }}" class="text-decoration-none text-reset"><img
                                data-src="{{ $action->imageUrl ? asset($action->imageUrl) : asset('images/no-image.jpg') }}" alt="{{ str_replace('-', ' ', $action->originalTitleText) . ' ' . '(' . $action->releaseYear . ')' }}" class="img-fluid blurry-image lazy"
                                    style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.493);"
                                    loading="lazy"></a>
                            <a href="{{ url('media/' . $action->originalTitleText) }}"
                                class="text-decoration-none text-reset">

                                <h6 class="mt-1 text-truncate" style="font-family: 'Ubuntu sans', sans-serif; font-weight: 500"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    data-bs-title="{{ str_replace(['-', $action->movieId], ' ', $action->originalTitleText) . ' ' . '(' . $action->releaseYear . ')' }}">
                                    {{ str_replace(['-', $action->movieId], ' ', $action->originalTitleText) . ' ' . '(' . $action->releaseYear . ')' }}
                                </h6>
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

            {{ $more_Series->appends(request()->query())->onEachSide(2)->links('vendor.pagination.bootstrap-5') }}

            @if (count($more_Series) == 0)
                {{ abort(404) }}
            @endif

            {{-- Movies Pane --}}
            @elseif ($cartegory == 'movies')
                <div class="row mb-4">
                    @unless (count($more_Movies) == 0)
                        @foreach ($more_Movies as $action)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                                <a href="{{ url('media/' . $action->originalTitleText) }}" class="text-decoration-none text-reset"><img
                                        data-src="{{ asset($action->imageUrl) }}" alt="{{ str_replace('-', ' ', $action->originalTitleText) . ' ' . '(' . $action->releaseYear . ')' }}"
                                        class="img-fluid blurry-image lazy"
                                        style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.493)"
                                        loading="lazy"></a>
                                <a href="{{ url('media/' . $action->originalTitleText) }}"
                                    class="text-decoration-none text-reset">

                                    <h6 class="mt-1 text-truncate"
                                        style="font-family: 'Ubuntu sans', sans-serif; font-weight: 500"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                        data-bs-title="{{ str_replace('-', ' ', $action->originalTitleText) . ' ' . '(' . $action->releaseYear . ')' }}">
                                        {{ str_replace('-', ' ', $action->originalTitleText) . ' ' . '(' . $action->releaseYear . ')' }}
                                    </h6>
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

                {{ $more_Movies->appends(request()->query())->onEachSide(2)->links('vendor.pagination.bootstrap-5') }}

                {{-- @if (count($more_Movies) == 0)
                    {{ abort(404) }}
                @endif --}}
            @endif

    </div>
@endsection
