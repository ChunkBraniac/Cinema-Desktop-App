@extends('layouts.app')

@section('title')
    Search
@endsection

@section('content')
    <br>
    <br>
    <div class="container-xl">
        <h4 style="float: left">Search @if ($page == 1)
            @else
                <span>
                    <h6 style="font-family: 'Roboto', sans-serif; font-weight: normal; font-size: 14px;">Page
                        {{ $page }}</h6>
                </span>
            @endif
        </h4>

        <h6 class="" style="float: right; font-family: 'Robot', sans-serif; font-weight: normal"><span
                style="margin-right: 5px; font-size: 14px"><a href="{{ url('/') }} "
                    class="text-decoration-none text-dark text-muted">Home</a></span> <i class="fa fa-arrow-right text-muted"
                style="font-size: 13px" aria-hidden="true"></i> <span style="margin-left: 5px; font-size: 14px"
                class="text-muted">Search</span></h6>
    </div>

    <br><br>
    <hr>
    <div class="container-xl mt-5">
        <div class="row">
            @if ($paginatedResults->isNotEmpty())
                @unless (count($paginatedResults) == 0)
                    @foreach ($paginatedResults as $search)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                            <a href="{{ url('media/' . $search->originalTitleText . '/' . $search->titleType) }}" class="text-decoration-none text-dark"><img
                                    data-src="{{ asset($search->imageUrl) }}" alt="{{ str_replace('-', ' ', $search->originalTitleText) . ' ' . '(' . $search->releaseYear . ')' }}" class="img-fluid blurry-image lazy"
                                    style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.493);" loading="lazy"></a>
                            <a href="{{ url('media/' . $search->originalTitleText . '/' . $search->titleType) }}"
                                class="text-decoration-none text-dark" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                data-bs-title="{{ str_replace('-', ' ', $search->originalTitleText) . ' ' . '(' . $search->releaseYear . ')' }}">

                                <h6 class="mt-1 text-truncate" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                    {{ str_replace('-', ' ', $search->originalTitleText) . ' ' . '(' . $search->releaseYear . ')' }}</h6>
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
                                <h6 style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400;">
                                    {{ $search->genres }}
                                </h6>
                            @endif
                        </div>
                    @endforeach
                @endunless

                
            @else
                <p class="alert alert-danger">No results found for '{{ $searchWord }}'</p>

                <script>
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "No result found",
                    });
                </script>
            @endif

            <div class="mt-3">
                {{ $paginatedResults->appends(request()->query())->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}

                @if (count($paginatedResults) == 0)
                    {{ abort(404) }}
                @endif
            </div>
        </div>

    </div>
@endsection
