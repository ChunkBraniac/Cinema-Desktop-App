@extends('layouts.app')

@section('title')
    Search
@endsection

@section('content')
    <br>
    <br>
    <div class="container-sm">
        <h4 style="float: left; font-family: 'Ubuntu sans', sans-serif; font-weight: 600;">Search @if ($page == 1)
            @else
                <span>
                    <h6 style="font-family: 'Roboto', sans-serif; font-weight: normal; font-size: 14px;">Page
                        {{ $page }}</h6>
                </span>
            @endif
        </h4>

        <h6 class="" style="float: right; font-family: 'Robot', sans-serif; font-weight: normal"><span
                style="margin-right: 5px; font-size: 14px"><a href="{{ url('/') }} "
                    class="text-decoration-none text-reset text-muted">Home</a></span> <i class="fa fa-arrow-right text-muted"
                style="font-size: 13px" aria-hidden="true"></i> <span style="margin-left: 5px; font-size: 14px"
                class="text-muted">Search</span></h6>
    </div>

    <br><br>
    <hr>
    <div class="container-sm mt-4">
        <div class="row">
            @if ($paginatedResults->isNotEmpty())
                @unless (count($paginatedResults) == 0)
                    @foreach ($paginatedResults as $search)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                            <a href="{{ route('media.show', ['name'=>$search->originalTitleText]) }}" class="text-decoration-none text-reset"><img
                                    data-src="{{ $search->imageUrl ? asset($search->imageUrl) : asset('images/No-Image-Placeholder.svg.webp') }}" alt="{{ $search->full_name . ' ' . '(' . $search->releaseYear . ')' }}" class="img-fluid blurry-image lazy"
                                    style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.493);" loading="lazy"></a>


                            <a href="{{ route('media.show', ['name'=>$search->originalTitleText]) }}"
                                class="text-decoration-none text-reset" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                data-bs-title="{{ $search->full_name . ' ' . '(' . $search->releaseYear . ')' }}">

                                <h6 class="mt-1 text-truncate" style="font-family: 'Roboto', sans-serif; font-weight: 500; font-weight: bold; font-size: 14px;">
                                    {{ $search->full_name . ' ' . '(' . $search->releaseYear . ')' }}</h6>
                            </a>

                            @if ($search->genres == '0')
                                <h6 style="font-size: 13px; font-family: 'Roboto', sans-serif; font-weight: 400; margin-top: -4px;">
                                    N/A
                                </h6>
                            @elseif ($search->genres == '')
                                <h6 style="font-size: 13px; font-family: 'Roboto', sans-serif; font-weight: 400; margin-top: -4px;">
                                    N/A
                                </h6>
                            @else
                                <h6 class="text-truncate" style="font-size: 13px; font-family: 'Roboto', sans-serif; font-weight: 400; margin-top: -4px;">
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
                {{ $paginatedResults->appends(request()->query())->onEachSide(2)->links('vendor.pagination.bootstrap-5') }}

                {{-- @if (count($paginatedResults) == 0)
                    {{ abort(404) }}
                @endif --}}
            </div>
        </div>

    </div>
@endsection
