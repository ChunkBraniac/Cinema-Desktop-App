@extends('layouts.app')

@section('title')
    Sci-Fi
@endsection

@section('content')
    <br><br>
    <div class="container">
        <h4 style="float: left;">Sci-Fi</h4>
        <h6 class="" style="float: right; font-family: 'Roboto', sans-serif; font-weight: normal"><span
                style="margin-right: 5px; font-size: 14px"><a href="{{ url('/') }} "
                    class="text-decoration-none text-dark text-muted">Home</a></span> <i class="fa fa-arrow-right text-muted"
                style="font-size: 13px" aria-hidden="true"></i> <span style="margin-left: 5px; font-size: 14px"
                class="text-muted">Sci-Fi</span></h6>
    </div>

    <br><br>
    <hr>
    <div class="container mt-5">
        <div class="row">
            @unless (count($paginatedResults) == 0)
                @foreach ($paginatedResults as $scifi)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                        <a href="{{ url('media/' . $scifi->originalTitleText . '/' . $scifi->titleType) }}"><img data-src="{{ asset($scifi->imageUrl) }}"
                                alt="" class="img-fluid" style="width: 100%; aspect-ratio: 3/5;" loading="lazy"></a>
                        <a href="{{ url('media/' . $scifi->originalTitleText . '/' . $scifi->titleType) }}" class="text-decoration-none text-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{{ $scifi->originalTitleText . ' ' . '(' . $scifi->releaseYear . ')' }}">

                            <h6 class="mt-1 text-truncate" style="font-family: 'Ubuntu sans', sans-serif; font-weight: 500">{{ $scifi->originalTitleText . ' ' . '(' . $scifi->releaseYear . ')' }}</h6>
                        </a>
                        <h6 class="text-truncate" style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">{{ $scifi->genres }}</h6>
                    </div>
                @endforeach
            @endunless
        </div>

        <div class="mt-3">
            {{ $paginatedResults->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
@endsection
