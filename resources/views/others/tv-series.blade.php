@extends('layouts.app')

@section('title')
    TV Shows
@endsection

@section('content')

    <div class="container mt-5">
        {{-- Series Pane --}}
        <div class="row mb-4">
            @unless (count($tv_series) == 0)
                @foreach ($tv_series as $action)
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

        {{ $tv_series->appends(request()->query())->onEachSide(2)->links('vendor.pagination.bootstrap-5') }}

        @if (count($tv_series) == 0)
            {{ abort(404) }}
        @endif

    </div>

@endsection
