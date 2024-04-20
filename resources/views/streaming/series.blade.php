@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h3 class="d-xl-block d-none d-md-block d-sm-block d-lg-block">{{ $streaming->originalTitleText }}</h3>
        <div class="row">
            <div class="col-xl-2">
                <img src="{{ asset($streaming->imageUrl) }}" alt="" class="img-fluid"
                    style="height: 350px; object-fit: fill;" loading="lazy">
            </div>

            <div class="col-xl-4 mt-xl-4" style="font-size: 15px">
                <h4 class="d-xl-none d-block d-md-none d-sm-none d-lg-none mt-3">{{ $streaming->originalTitleText }}</h4>
                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">
                    {{ $streaming->aggregateRating }}</h6>
                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">Release year:
                    {{ $streaming->releaseYear }}</h6>
                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">Running time:
                    {{ $streaming->runtime }}</h6>
                <h6 style="font-size: 15px; font-family: 'Roboto', sans-serif; font-weight: normal;">Country: </h6>

                <div class="mt-3">
                    {{ $streaming->plotText }}
                </div>
            </div>

            <div class="col-xl-6">
                <iframe height="365" src="{{ $streaming->trailer }}" title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen style="width: 100%;"></iframe>
            </div>
        </div>
    </div>

    <hr class="mt-5">

    <div class="container-xl">
        <div class="row">
            <div class="col-xl-9 col-lg-8 mt-3">
                <h4>You may also like: </h4>
                <div class="row">
                    @foreach ($moreTop10 as $more)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3 mt-2">
                            <a href="{{ url('streaming/' . $more->originalTitleText) }} "><img
                                    src="{{ asset($more->imageUrl) }}" alt=""
                                    class="img-fluid" style="height: 400px; object-fit: fill;" loading="lazy"></a>
                            <a href="{{ url('streaming/' . $more->originalTitleText) }}" class="text-decoration-none text-dark">
                                <h6 class="mt-1" style="font-family: 'Robot', sans-serif; font-weight: 500">{{ $more->originalTitleText }}</h6>
                            </a>
                        </div>
                    @endforeach
                </div>

                <hr>

                <div class="mt-4">
                    <h4 class="mb-4">Comment</h4>

                    <div class="container-xl">
                        <div class="row mt-3 pt-3 pb-3"
                            style="border-radius: 0px; background: #f9f9f9; border: 1px solid #ccc;">
                            <div class="col-xl-2">
                                <h5 style="font-family: 'Roboto', sans-serif; font-weight: normal">{{ 'Username' }}</h5>
                            </div>
                            <div class="col-xl-6">
                                <p style="font-size: 15px">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Vel ullam aliquam labore
                                    asperiores
                                    dicta quo
                                    facilis dolore odit aliquid ratione iste ipsa aspernatur, voluptates voluptate sunt
                                    harum
                                    porro
                                    illo
                                    praesentium?
                                </p>
                            </div>
                            <div class="col-xl-2">
                                <p class="d-inline-flex gap-1">
                                    <a class="btn btn-primary btn-sm" data-bs-toggle="collapse" href="#collapseExample"
                                        role="button" aria-expanded="false" aria-controls="collapseExample">
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

                                        <label for="" class="mt-3" style="font-size: 15px">Your reply: </label>
                                        <textarea name="reply_text" id="" cols="30" rows="5" class="form-control" style="border-radius: 0px"
                                            required></textarea>

                                        <div class="mt-3">
                                            <button class="btn btn-primary btn-sm"
                                                style="border-radius: 0px;">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <form action="" method="post">
                        <label for="">Name</label>
                        <input type="text" class="form-control pl-3" name="name" style="border-radius: 0px" required>

                        <label for="" class="mt-3">Your comment</label>
                        <textarea name="" id="" cols="30" rows="5" class="form-control" style="border-radius: 0px;"
                            required></textarea>

                        <div class="mt-3">
                            <button class="btn btn-primary" style="border-radius: 0px;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 mt-4">
                <hr class="d-block d-xl-none d-lg-none">
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
