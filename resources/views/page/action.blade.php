@extends('layouts.app')

@section('title')
    Action
@endsection

@section('content')
    <br><br>
    <div class="container">
        <h4 style="float: left">Action</h4>
        <h6 class="" style="float: right; font-family: 'Robot', sans-serif; font-weight: normal"><span
                style="margin-right: 5px; font-size: 14px"><a href="{{ url('/') }} "
                    class="text-decoration-none text-dark text-muted">Home</a></span> <i class="fa fa-arrow-right text-muted"
                style="font-size: 13px" aria-hidden="true"></i> <span style="margin-left: 5px; font-size: 14px"
                class="text-muted">Action</span></h6>
    </div>

    <br><br>
    <hr>
    <div class="container mt-5">
        <div class="row">
            @unless (count($allActionMovies) == 0)
                @foreach ($allActionMovies as $action)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2 mt-3">
                        <a href="{{ url('media/' . $action->originalTitleText . '/' . $action->titleType) }}"><img src="{{ asset($action->imageUrl) }}"
                                alt="" class="img-fluid" style="height: 400px; object-fit: fill;" loading="lazy"></a>
                        <a href="{{ url('media/' . $action->originalTitleText . '/' . $action->titleType) }}" class="text-decoration-none text-dark">
                            <h6 class="mt-1 text-truncate" style="font-family: 'Robot', sans-serif; font-weight: 500">{{ $action->originalTitleText }}</h6>
                        </a>
                        <h6 class="text-truncate" style="font-size: 14px; font-family: 'Roboto', sans-serif; font-weight: 400">{{ $action->genres }}</h6>
                    </div>
                @endforeach
            @endunless
        </div>


        <div class="mt-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
@endsection
