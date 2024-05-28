@extends('layouts.app')


@section('content')
    <style>

        .form-container {
            max-width: 500px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 10px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="form-container mt-5">
        <form action="{{ route('send.request') }}" method="post">
            {{ csrf_field() }}
            <h2 class="text-center mb-4">Request a Movie</h2>

            @if (session('success'))
                <h6 class="alert alert-success text-center" style="font-weight: normal; font-size: 13px;">{{ session('success') }}</h6>
            @endif

            <div class="mb-3">
                <label for="movieName" class="form-label">Name</label>
                <input type="text" class="form-control" id="movieName" required name="name">
            </div>
            <div class="mb-3">
                <label for="movieName" class="form-label">Email</label>
                <input type="text" class="form-control" id="movieName" required name="email">
            </div>
            <div class="mb-3">
                <label for="movieName" class="form-label">Movie Title</label>
                <input type="text" class="form-control" id="movieName" required name="movie_title">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Comment</label>
                <textarea class="form-control" id="message" rows="3" required name="comment"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Request</button>
        </form>
    </div>
@endsection
