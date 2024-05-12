@extends('layouts.app')

@section('title')
    404
@endsection

@section('content')
    <div class="container d-flex flex-column justify-content-center h-100">
        <h1 class="display-1 text-center">404</h1>
        <p class="lead text-center">Oops! Page not found.</p>
        <a href="{{ URL::previous() }}" class="btn btn-primary btn-lg mx-auto">Go Back Home</a>
    </div>
@endsection
