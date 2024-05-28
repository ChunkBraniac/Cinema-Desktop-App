@extends('layouts.app')

@section('title')
    @foreach ($download_series as $item)
        {{ $item->movieName }} Season {{ $item->season_number }} Episode {{ $item->episode_number }}
    @endforeach
@endsection

@section('content')

    <div class="container mt-5">
        @unless (count($download_series) == 0)
            @foreach ($download_series as $item)
                <div class="col-xl-7 m-auto">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ str_replace(['-', $item->movieId], ' ', $item->movieName) }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted ">Season {{ $item->season_number }} Episode {{ $item->episode_number }}</h6>
                            
                            <button class="btn btn-primary btn-lg mt-4" style="font-size: 17px; text-transform: uppercase" id="show-more">Download</button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endunless


    </div>
@endsection
