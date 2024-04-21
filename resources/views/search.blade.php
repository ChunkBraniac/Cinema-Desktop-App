@extends('layouts.app')

@section('title')
    Search
@endsection

@section('content')
    <br><br>
    <div class="container">
        <h4 style="float: left">Search</h4>
        <h6 class="" style="float: right; font-family: 'Robot', sans-serif; font-weight: normal"><span
                style="margin-right: 5px; font-size: 14px"><a href="{{ url('/') }} "
                    class="text-decoration-none text-dark text-muted">Home</a></span> <i class="fa fa-arrow-right text-muted"
                style="font-size: 13px" aria-hidden="true"></i> <span style="margin-left: 5px; font-size: 14px"
                class="text-muted">Search</span></h6>
    </div>

    <br><br>
    <hr>
    <div class="container mt-5">
        <div class="row">
            @if ($top10Results->isNotEmpty())
                @unless (count($top10Results) == 0)
                    @foreach ($top10Results as $search)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                            <a href="{{ url('media/' . $search->originalTitleText . '/' . $search->titleType) }}"><img
                                    src="{{ asset($search->imageUrl) }}" alt="" class="img-fluid"
                                    style="height: 400px; object-fit: fill;" loading="lazy"></a>
                            <a href="{{ url('') }}" class="text-decoration-none text-dark">
                                <h6 class="mt-1 text-truncate" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                    {{ $search->originalTitleText }}</h6>
                            </a>
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $search->genres }}</h6>
                        </div>
                    @endforeach
                @endunless
            @else
                {{-- <p>No results found in Top 10.</p> --}}
            @endif

            @if ($streamingResults->isNotEmpty())
                @unless (count($streamingResults) == 0)
                    @foreach ($streamingResults as $search)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                            <a href="{{ url('media/' . $search->originalTitleText . '/' . $search->titleType) }}"><img
                                    src="{{ asset($search->imageUrl) }}" alt="" class="img-fluid"
                                    style="height: 400px; object-fit: fill;" loading="lazy"></a>
                            <a href="{{ url('') }}" class="text-decoration-none text-dark">
                                <h6 class="mt-1 text-truncate" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                    {{ $search->originalTitleText }}</h6>
                            </a>
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $search->genres }}</h6>
                        </div>
                    @endforeach
                @endunless
            @else
                {{-- <p>No results found for Streaming</p> --}}
            @endif

            @if ($popularResults->isNotEmpty())
                @unless (count($popularResults) == 0)
                    @foreach ($popularResults as $search)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                            <a href="{{ url('media/' . $search->originalTitleText . '/' . $search->titleType) }}"><img
                                    src="{{ asset($search->imageUrl) }}" alt="" class="img-fluid"
                                    style="height: 400px; object-fit: fill;" loading="lazy"></a>
                            <a href="{{ url('') }}" class="text-decoration-none text-dark">
                                <h6 class="mt-1 text-truncate" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                    {{ $search->originalTitleText }}</h6>
                            </a>
                            <h6 class="text-truncate"
                                style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">
                                {{ $search->genres }}</h6>
                        </div>
                    @endforeach
                @endunless
            @else
                {{-- <p>No results found for Streaming</p> --}}
            @endif

            @if (!$top10Results->isNotEmpty() && !$streamingResults->isNotEmpty() && !$popularResults->isNotEmpty())
                <p class="alert alert-danger">No result found</p>
            @else
                <nav aria-label="Page navigation" style="margin-top: 20px">
                    <ul class="pagination m-auto text-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>

    </div>
@endsection
