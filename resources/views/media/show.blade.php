@extends('layouts.app')

@section('content')
    <div class="container-xl mt-5">

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
                        <img src="{{ asset($item->imageUrl) }}" alt="" class="img-fluid"
                            style="height: 350px; object-fit: fill;" loading="lazy">
                    </div>

                    <div class="col-xl-4 col-sm-8 col-lg-5 mt-xl-4" style="font-size: 15px;">
                        <div style="border-left: 3px solid rgba(0, 0, 0, 0.459); padding-left: 10px">
                            <h4 class="d-xl-none d-block d-md-none d-sm-none d-lg-none mt-3">{{ $item->originalTitleText }}
                            </h4>
                            <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                {{ isset($item->rating->aggregateRating) ? $item->rating->aggregateRating : 'N/A' }}</h6>
                            <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">Release
                                year:
                                {{ $item->releaseYear }}</h6>
                            <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">Genre:
                                {{ $item->genres }}</h6>

                            @if (isset($item->details) && isset($item->details->runtime))
                                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                    Runtime: {{ $item->details->runtime }}
                                </h6>
                            @else
                                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                    Runtime:
                                    N/A
                                </h6>
                            @endif

                            <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                                Country:
                            </h6>

                            <div class="mt-3">
                                {{ $item->plotText ? $item->plotText : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 mt-3 mt-xl-0">
                        <iframe height="400" src="{{ $item->trailer ? $item->trailer : 'N/A' }}"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen width="100%"></iframe>
                    </div>
                </div>
            @endforeach
        @else
            <p>No data found for this title.</p>
        @endif


        <hr class="mt-5">

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
                                            src="{{ asset($more->imageUrl) }}" alt="" class="img-fluid"
                                            style="height: 400px; object-fit: fill;" loading="lazy"></a>
                                    <a href="{{ url('media/' . $more->originalTitleText . '/' . $more->titleType) }}"
                                        class="text-decoration-none text-dark">
                                        <h6 class="mt-1" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                            {{ $more->originalTitleText }}</h6>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @elseif ($type == 'tvMiniSeries')
                        <div class="row">

                            @foreach ($merged as $more)
                                <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 mt-2">
                                    <a href="{{ url('media/' . $more->originalTitleText . '/' . $more->titleType) }} "><img
                                            src="{{ asset($more->imageUrl) }}" alt="" class="img-fluid"
                                            style="height: 400px; object-fit: fill;" loading="lazy"></a>
                                    <a href="{{ url('media/' . $more->originalTitleText . '/' . $more->titleType) }}"
                                        class="text-decoration-none text-dark">
                                        <h6 class="mt-1" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                            {{ $more->originalTitleText }}</h6>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @elseif ($type == 'tvSeries')
                        <div class="row">

                            @foreach ($merged as $more)
                                <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 mt-2">
                                    <a href="{{ url('media/' . $more->originalTitleText . '/' . $more->titleType) }} "><img
                                            src="{{ asset($more->imageUrl) }}" alt="" class="img-fluid"
                                            style="height: 400px; object-fit: fill;" loading="lazy"></a>
                                    <a href="{{ url('media/' . $more->originalTitleText . '/' . $more->titleType) }}"
                                        class="text-decoration-none text-dark">
                                        <h6 class="mt-1" style="font-family: 'Robot', sans-serif; font-weight: 500">
                                            {{ $more->originalTitleText }}</h6>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4">
                        <h4 class="mb-4">Comment</h4>
                        @if (session('success'))
                            <h6 class="alert alert-success">{{ session('success') }}</h6>
                        @endif
                        
                        @if (isset($comments) && count($comments) > 0)
                            <div class="container-xl">
                                @foreach ($comments as $comment)
                                    <div class="row mt-3 pt-3 pb-3"
                                        style="border-radius: 0px; background: #f9f9f9; border: 1px solid #ccc;">
                                        <div class="col-xl-2">
                                            <h5 style="font-family: 'Roboto', sans-serif; font-weight: normal">
                                                {{ 'Username' }}
                                            </h5>
                                        </div>
                                        <div class="col-xl-6">
                                            <p style="font-size: 15px">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel ullam aliquam
                                                labore
                                                asperiores
                                                dicta quo
                                                facilis dolore odit aliquid ratione iste ipsa aspernatur, voluptates
                                                voluptate
                                                sunt
                                                harum
                                                porro
                                                illo
                                                praesentium?
                                            </p>
                                        </div>
                                        <div class="col-xl-2">
                                            <p class="d-inline-flex gap-1">
                                                <a class="btn btn-primary btn-sm" data-bs-toggle="collapse"
                                                    href="#collapseExample" role="button" aria-expanded="false"
                                                    aria-controls="collapseExample">
                                                    Reply <i class="fa fa-reply" aria-hidden="true"></i>
                                                </a>
                                            </p>

                                        </div>
                                        <div class="collapse" id="collapseExample">
                                            <div class="card card-body" style="background: #f9f9f9; border-radius: 0px">
                                                <form action="" method="post">
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
                            action="{{ route('media.show', ['name' => $item->originalTitleText, 'type' => $item->titleType]) }}"
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
                    <div class="row">
                        <div class="col-6 col-sm-4 col-md-3 col-lg-6 col-xl-6">
                            <a href="{{ url('') }} "><img
                                    src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt=""
                                    class="img-fluid"></a>
                            <a href="{{ url('') }}" class="text-decoration-none text-dark">
                                <h6 class="mt-2">Movie name</h6>
                            </a>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-6 col-xl-6">
                            <a href="{{ url('') }} "><img
                                    src="{{ asset('images/NationalGeographic_2572187_square.avif') }}" alt=""
                                    class="img-fluid"></a>
                            <a href="{{ url('') }}" class="text-decoration-none text-dark">
                                <h6 class="mt-2">Movie name</h6>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
