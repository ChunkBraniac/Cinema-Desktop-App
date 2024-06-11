@extends('layouts.app')

@section('title')
    All Movies
@endsection

@section('content')

    <br><br>

    <div class="container">
        <h4 style="float: left; font-family: 'Ubuntu sans', sans-serif; font-weight: 600;">Movies @if ($page == 1)
            @else
                <span>
                    <h6 style="font-family: 'Roboto', sans-serif; font-weight: normal; font-size: 14px;">Page
                        {{ $page }}</h6>
                </span>
            @endif
        </h4>
        <h6 class="" style="float: right; font-family: 'Roboto', sans-serif; font-weight: normal"><span
                style="margin-right: 5px; font-size: 14px"><a href="{{ url('/') }} "
                    class="text-decoration-none text-reset text-muted">Home</a></span> <i class="fa fa-arrow-right text-muted"
                style="font-size: 13px" aria-hidden="true"></i> <span style="margin-left: 5px; font-size: 14px"
                class="text-muted">Movies</span></h6>
    </div>

    <br><br>
    <hr>

    <div class="container mt-4">
        {{-- Series Pane --}}
        <div class="row mb-4">
            @unless (count($movies) == 0)
                @foreach ($movies as $action)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                        <a href="{{ route('media.show', ['name' => $action->originalTitleText]) }}"><img
                                data-src="{{ asset('storage/images/' . $action->imageUrl) }}"
                                alt="{{ $action->full_name . ' ' . '(' . $action->releaseYear . ')' }}"
                                class="img-fluid blurry-image lazy"
                                style="background: rgba(0, 0, 0, 0.493);" loading="lazy"></a>


                        <a href="{{ route('media.show', ['name' => $action->originalTitleText]) }}"
                            class="text-decoration-none text-reset">

                            <h6 class="mt-1 text-truncate"
                                style="font-family: 'Roboto', sans-serif; font-weight: 500; font-weight: bold; font-size: 14px;"
                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                data-bs-title="{{ $action->full_name . ' ' . '(' . $action->releaseYear . ')' }}">
                                {{ $action->full_name . ' ' . '(' . $action->releaseYear . ')' }}
                            </h6>
                        </a>
                        @if ($action->genres == 0)
                            <h6 class="text-truncate"
                                style="font-size: 13px; font-family: 'Roboto', sans-serif; font-weight: 400; margin-top: -4px;">
                                {{ $action->genres = 'N/A' }}</h6>
                        @elseif ($action->genres == '')
                            <h6 class="text-truncate"
                                style="font-size: 13px; font-family: 'Roboto', sans-serif; font-weight: 400; margin-top: -4px;">
                                {{ $action->genres = 'N/A' }}</h6>
                        @else
                            <h6 class="text-truncate"
                                style="font-size: 13px; font-family: 'Roboto', sans-serif; font-weight: 400; margin-top: -4px;">
                                {{ $action->genres }}</h6>
                        @endif
                    </div>
                @endforeach
            @endunless
        </div>

        {{ $movies->appends(request()->query())->onEachSide(2)->links('vendor.pagination.bootstrap-5') }}

        {{-- @if (count($movies) == 0)
            {{ abort(404) }}
        @endif --}}

    </div>

@endsection
