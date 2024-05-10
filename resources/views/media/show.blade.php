@extends('layouts.app')

@section('content')
    <div class="container-xl mt-5">

        @if ($all)
            @if ($all->isNotEmpty())
                <!-- Check if the collection is not empty -->
                @foreach ($all->unique('movieId') as $item)
                    @section('title')
                        {{ $item->originalTitleText }}
                    @endsection
                    <!-- Iterate over each item in the collection -->
                    <h3 class="d-xl-block d-none d-md-block d-sm-block d-lg-block">{{ $item->originalTitleText }}</h3>
                    <div class="row">
                        <div class="col-xl-2 col-sm-4 col-md-3 col-lg-3">
                            <img
                                data-src="{{ asset($item->imageUrl) }}" alt="" class="img-fluid blurry-image lazy"
                                style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.493)" loading="lazy">
                        </div>

                        <div class="col-xl-4 col-sm-8 col-lg-5 mt-xl-4" style="font-size: 15px;">
                            <div style="border-left: 3px solid rgba(0, 0, 0, 0.459); padding-left: 10px">
                                <h4 class="d-xl-none d-block d-md-none d-sm-none d-lg-none mt-3">
                                    {{ $item->originalTitleText }}
                                </h4>
                                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                    {{ isset($item->aggregateRating) ? $item->aggregateRating : 'N/A' }}</h6>
                                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">Release
                                    year:
                                    {{ $item->releaseYear }}</h6>


                                @if ($item->genres == '0')
                                    <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                        Genre:
                                        N/A
                                    </h6>
                                @elseif ($item->genres == '')
                                    <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                        Genre:
                                        N/A
                                    </h6>
                                @else
                                    <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                        Genre: {{ $item->genres }}
                                    </h6>
                                @endif

                                @if ($item->runtime == '0')
                                    <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                        Runtime:
                                        N/A
                                    </h6>
                                @elseif ($item->runtime == '')
                                    <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                        Runtime:
                                        N/A
                                    </h6>
                                @else
                                    <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                        Runtime: {{ $item->runtime }}
                                    </h6>
                                @endif

                                @if ($item->country == '0')
                                    <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                        Country:
                                        N/A
                                    </h6>
                                @elseif ($item->country == '')
                                    <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                        Country:
                                        N/A
                                    </h6>
                                @else
                                    <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                        Country: {{ $item->country }}
                                    </h6>
                                @endif

                                <div class="mt-3">
                                    {{ $item->plotText ? $item->plotText : 'N/A' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 mt-3 mt-xl-0">
                            <iframe
                                src="{{ $item->trailer ? 'https://www.youtube.com/embed/' . explode('?v=', $item->trailer)[1] : 'N/A' }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen style="width: 100%; aspect-ratio: 3/2;">
                            </iframe>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No data found for this title.</p>
            @endif
        @endif


        <hr class="mt-5">
    </div>

    <div class="container-xl">
        @if ($type == 'movie')
            <div class="m-auto text-center">
                <a href="" class="btn btn-success btn-lg"
                    style="font-size: 16px; padding-right: 25px; padding-left: 25px; padding-top: 13px; padding-bottom: 13px">Download
                    Video</a>
            </div>
        @elseif ($type == 'tvSeries')

        @elseif ($type == 'tvMiniSeries')
        @endif
        <div class="row">
            <div class="col-xl-9 col-lg-8 mt-3">
                @if ($type == 'movie')
                    <h4>You may also like: </h4>
                    <div class="row">

                        @foreach ($merged as $more)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 mt-2">
                                <a href="{{ url('media/' . $more->originalTitleText . '/' . $more->titleType) }} "><img
                                    data-src="{{ asset($more->imageUrl) }}" alt="" class="img-fluid blurry-image lazy"
                                    style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.493)" loading="lazy"></a>
                                    
                                <a href="{{ url('media/' . $more->originalTitleText . '/' . $more->titleType) }}"
                                    class="text-decoration-none text-dark">
                                    <h6 class="mt-1" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                        {{ $more->originalTitleText }}</h6>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @elseif ($type == 'series')
                    <div class="row mb-3">

                        @foreach ($seasons as $more)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 mt-2">
                                <a
                                    href="{{ url('download/' . $more->movieName . '/season/' . $more->season_number . '/episode/' . $more->episode_number) }} "><img
                                        data-src="{{ asset($more->imageUrl) }}" alt="" class="img-fluid"
                                        style="width: 100%; aspect-ratio: 3/5; background: rgba(0, 0, 0, 0.493)" loading="lazy"></a>
                                <a href="{{ url('download/' . $more->movieName . '/season/' . $more->season_number . '/episode/' . $more->episode_number) }}"
                                    class="text-decoration-none text-dark">
                                    <h6 class="mt-1" style="font-family: 'Robot', sans-serif; font-weight: 500">Season
                                        {{ $more->season_number }} Episode {{ $more->episode_number }}
                                    </h6>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{ $seasons->onEachSide(1)->links() }}
                @endif

                <div class="mt-4">
                    <h4 class="mb-4">Comment</h4>
                    @if (session('success'))
                        <h6 class="alert alert-success" style="font-weight: normal; font-size: 15px;">{{ session('success') }}</h6>
                    @endif

                    @if (isset($comments) && count($comments) > 0)
                        <div class="container-xl">
                            @foreach ($comments as $comment)
                                <div class="row mt-3 pt-3 pb-3"
                                    style="border-radius: 0px; background: #f9f9f9; border: 1px solid #ccc;">
                                    <div class="col-xl-2">
                                        <h5 style="font-size: 19px">
                                            {{ $comment->commentor }} <span
                                                style="font-size: 13px">[{{ $comment->created_at }}]</span>
                                        </h5>
                                    </div>
                                    <div class="col-xl-6 m-auto">
                                        <p style="font-size: 15px">
                                            {{ $comment->comment }}
                                        </p>
                                    </div>
                                    <div class="col-xl-2">
                                        <p class="d-inline-flex gap-1">
                                            <a class="btn btn-primary btn-sm" data-bs-toggle="collapse"
                                                href="#{{ $comment->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapseExample">
                                                Reply <i class="fa fa-reply" aria-hidden="true"></i>
                                            </a>
                                        </p>

                                    </div>

                                    <div class="mt-2 text-center col-xl-10 m-auto">

                                        @if (count($replies->where('comment_id', $comment->id)) > 0)
                                            <h6 class="text-center">- Replies -</h6>
                                        @endif

                                        @unless (count($replies) == 0)
                                            @foreach ($replies->where('comment_id', $comment->id) as $reply)
                                                <div class="row mt-2 border p-2" style="border-radius: 5px">
                                                    <div class="col-xl-5">
                                                        <h6>{{ $reply->reply_name }} <span
                                                                style="font-family: 'Roboto', sans-serif; font-weight: normal; font-size: 13px">[{{ $reply->created_at }}]</span>
                                                        </h6>
                                                    </div>

                                                    <div class="col-xl-7" style="font-size: 14px">
                                                        {{ $reply->reply_text }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endunless
                                    </div>

                                    <div class="collapse mt-3" id="{{ $comment->id }}">
                                        <div class="card card-body" style="background: #f9f9f9; border-radius: 0px">
                                            <form
                                                action="{{ route('reply', ['name' => $item->originalTitleText, 'type' => $item->titleType]) }}"
                                                method="post">
                                                {{ csrf_field() }}

                                                <input type="hidden" value="{{ $comment->id }}" name="comment_id">
                                                <input type="hidden" value="{{ $item->originalTitleText }}"
                                                    name="movie_name">
                                                <input type="hidden" value="{{ $item->movieId }}" name="movie_id">

                                                <label for="" style="font-size: 15px">Name: </label>
                                                <input type="text" class="form-control" name="reply_name"
                                                    style="border-radius: 0px" required>

                                                <label for="" class="mt-3" style="font-size: 15px">Your
                                                    reply:
                                                </label>
                                                <textarea name="reply_text" id="" cols="30" rows="5" class="form-control"
                                                    style="border-radius: 0px" required></textarea>

                                                <div class="mt-3">
                                                    <button class="btn btn-primary btn-sm"
                                                        style="border-radius: 0px;">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @else
                        <p class="alert alert-danger" style="font-size: 14px">No comments yet for this movie.</p>
                    @endif
                </div>

                <div class="mt-4">
                    <form
                        action="{{ route('comment', ['name' => $item->originalTitleText, 'type' => $item->titleType]) }}"
                        method="post">
                        {{ csrf_field() }}
                        <label for="">Name</label>
                        <input type="hidden" class="form-control pl-3" name="movie_id" style="border-radius: 0px"
                            required value="{{ $item->movieId }}">
                        <input type="hidden" class="form-control pl-3" name="movie_name" style="border-radius: 0px"
                            required value="{{ $item->originalTitleText }}">

                        <input type="text" class="form-control pl-3" name="commentor" style="border-radius: 0px"
                            required>

                        <label for="" class="mt-3">Your comment</label>
                        <textarea name="comment" id="" cols="30" rows="5" class="form-control"
                            style="border-radius: 0px;" required></textarea>

                        <div class="mt-3">
                            <button class="btn btn-primary" style="border-radius: 0px;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 mt-4">
                <h5>Recommended Shows </h5>
                @unless (count($recom) == 0)
                    @foreach ($recom as $recommended)
                        <div class="accordion accordion-flush border"
                            style="box-shadow: none; border: none; border-radius: 3px" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#{{ $recommended->id }}" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                        {{ $recommended->originalTitleText }}
                                    </button>
                                </h2>

                                <div id="{{ $recommended->id }}" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body" style="font-size: 15px">{{ $recommended->plotText }} <a
                                            href="{{ url('media/' . $recommended->originalTitleText . '/' . $recommended->titleType) }} ">More
                                            Details</a></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endunless
            </div>
        </div>
    </div>
@endsection
