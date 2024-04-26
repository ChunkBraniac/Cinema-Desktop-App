@extends('layouts.app')

@section('content')
    
    <div class="container">
        @unless (count($db1) == 0)
            
        @endunless
        <button class="btn btn-primary btn-md centered-button" style="font-size: 23px; padding-left: 30px; padding-right: 30px; font-family: 'Roboto', sans-serif; font-weight: normal">Download <i class="fa fa-download" aria-hidden="true"></i></button>
    </div>
@endsection
