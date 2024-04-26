@extends('layouts.app')

@section('title')
    Action
@endsection

@section('content')
    @php
        $cartegory = $_GET['cartegory'];
    @endphp

    <br><br>
    @if ($cartegory == 'streaming')
        <div class="container">
            <h4 style="float: left">Streaming movies</h4>
            <h6 class="" style="float: right; font-family: 'Robot', sans-serif; font-weight: normal"><span
                    style="margin-right: 5px; font-size: 14px"><a href="{{ url('/') }} "
                        class="text-decoration-none text-dark text-muted">Home</a></span> <i
                    class="fa fa-arrow-right text-muted" style="font-size: 13px" aria-hidden="true"></i> <span
                    style="margin-left: 5px; font-size: 14px" class="text-muted">Streaming movies</span></h6>
        </div>
    @elseif ($cartegory == 'popular')
        <div class="container">
            <h4 style="float: left">Popular movies</h4>
            <h6 class="" style="float: right; font-family: 'Robot', sans-serif; font-weight: normal"><span
                    style="margin-right: 5px; font-size: 14px"><a href="{{ url('/') }} "
                        class="text-decoration-none text-dark text-muted">Home</a></span> <i
                    class="fa fa-arrow-right text-muted" style="font-size: 13px" aria-hidden="true"></i> <span
                    style="margin-left: 5px; font-size: 14px" class="text-muted">Popular movies</span></h6>
        </div>
    @endif

    <br><br>
    <hr>
    <div class="container mt-5">

        @if ($cartegory == 'streaming')
            <div class="row mb-4">
                @unless (count($more_streaming) == 0)
                    @foreach ($more_streaming as $action)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                            <a href="{{ url('media/' . $action->originalTitleText . '/' . $action->titleType) }}"><img
                                    src="{{ asset($action->imageUrl) }}" alt="" class="img-fluid"
                                    style="height: 400px; object-fit: fill;" loading="lazy"></a>
                            <a href="{{ url('media/' . $action->originalTitleText . '/' . $action->titleType) }}"
                                class="text-decoration-none text-dark">
                                <h6 class="mt-1 text-truncate" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                    {{ $action->originalTitleText }}</h6>
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

            {{ $more_streaming->appends(request()->query())->onEachSide(1)->links() }}
        @elseif ($cartegory == 'popular')
            <div class="row mb-4">
                @unless (count($more_popular) == 0)
                    @foreach ($more_popular as $action)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                            <a href="{{ url('media/' . $action->originalTitleText . '/' . $action->titleType) }}"><img
                                    src="{{ asset($action->imageUrl) }}" alt="" class="img-fluid"
                                    style="height: 400px; object-fit: fill;" loading="lazy"></a>
                            <a href="{{ url('media/' . $action->originalTitleText . '/' . $action->titleType) }}"
                                class="text-decoration-none text-dark">
                                <h6 class="mt-1 text-truncate" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                    {{ $action->originalTitleText }}</h6>
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

            {{ $more_popular->appends(request()->query())->onEachSide(1)->links() }}
        @endif

    </div>
@endsection
