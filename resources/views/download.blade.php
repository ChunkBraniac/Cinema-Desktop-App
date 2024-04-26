@extends('layouts.app')

@section('content')
    @unless (count($db1) == 0)
        
    @endunless
    <div class="container">
        <button class="btn btn-primary btn-lg centered-button" style="font-size: 30px">Download <i class="fa fa-download" aria-hidden="true"></i></button>
    </div>
@endsection
