@extends('layouts.app')

@section('content')
    <br><br>
    <div class="container">
        <h4 style="float: left">Animation</h4>
        <h6 class="" style="float: right; font-family: 'Robot', sans-serif; font-weight: normal"><span
                style="margin-right: 5px;"><a href="{{ url('/') }} "
                    class="text-decoration-none text-dark text-muted">Home</a></span> <i class="fa fa-arrow-right text-muted"
                style="font-size: 13px" aria-hidden="true"></i> <span style="margin-left: 5px;"
                class="text-muted">Animation</span></h6>
    </div>

    <br><br>
    <hr>
    <div class="container mt-5">
        <div class="row">
            @unless (count($allAnimationMovies) == 0)
                @foreach ($allAnimationMovies as $animation)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                        <a href="{{ url('') }}"><img src="{{ asset($animation->imageUrl) }}"
                                alt="" class="img-fluid" style="height: 400px; object-fit: fill;" loading="lazy"></a>
                        <a href="{{ url('') }}" class="text-decoration-none text-dark">
                            <h6 class="mt-1">{{ $animation->originalTitleText }}</h6>
                        </a>
                        <h6 class="text-truncate" style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">{{ $animation->genres }}</h6>
                    </div>
                @endforeach
            @endunless
        </div>
    </div>
@endsection
