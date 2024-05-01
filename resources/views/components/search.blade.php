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
            @if ($SeriesResults->isNotEmpty())
                @unless (count($SeriesResults) == 0)
                    @foreach ($SeriesResults as $search)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                            <a href="{{ url('media/' . $search->originalTitleText . '/' . $search->titleType) }}"><img
                                    src="{{ asset($search->imageUrl) }}" alt="" class="img-fluid"
                                    style="height: 400px; object-fit: fill;" loading="lazy"></a>
                            <a href="{{ url('') }}" class="text-decoration-none text-dark">
                                <h6 class="mt-1 text-truncate" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                    {{ $search->originalTitleText }}</h6>
                            </a>
                            
                            @if ($search->genres == '0')
                                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                    N/A
                                </h6>
                            @elseif ($search->genres == '')
                                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                    N/A
                                </h6>
                            @else
                                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                    {{ $search->genres }}
                                </h6>
                            @endif
                        </div>
                    @endforeach
                @endunless
            @else
                {{-- <p>No results found in Top 10.</p> --}}
            @endif

            @if ($MoviesResults->isNotEmpty())
                @unless (count($MoviesResults) == 0)
                    @foreach ($MoviesResults as $search)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                            <a href="{{ url('media/' . $search->originalTitleText . '/' . $search->titleType) }}"><img
                                    src="{{ asset($search->imageUrl) }}" alt="" class="img-fluid"
                                    style="height: 400px; object-fit: fill;" loading="lazy"></a>
                            <a href="{{ url('') }}" class="text-decoration-none text-dark">
                                <h6 class="mt-1 text-truncate" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                    {{ $search->originalTitleText }}</h6>
                            </a>

                            @if ($search->genres == '0')
                                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                    N/A
                                </h6>
                            @elseif ($search->genres == '')
                                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                    N/A
                                </h6>
                            @else
                                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                    {{ $search->genres }}
                                </h6>
                            @endif
                        </div>
                    @endforeach
                @endunless
            @else
                {{-- <p>No results found for Streaming</p> --}}
            @endif

            @if (!$SeriesResults->isNotEmpty() && !$MoviesResults->isNotEmpty())
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
