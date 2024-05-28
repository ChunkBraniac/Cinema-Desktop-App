@extends('admin.layouts.app')

@section('title')
    Movies
@endsection

@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Tables</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Data</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Movies</h5>
                            <p>Add lightweight datatables to your project with using the <a
                                    href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple
                                    DataTables</a> library. Just add <code>.datatable</code> class name to any table you
                                wish to conver to a datatable. Check for <a
                                    href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more
                                    examples</a>.</p>

                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Movie Id</th>
                                        <th>
                                            <b>N</b>ame
                                        </th>
                                        <th>Type.</th>
                                        <th>Country</th>
                                        <th>Runtime</th>
                                        <th>Genres</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @unless (count($allmovies) == 0)
                                        @foreach ($allmovies as $movies)
                                            <tr>
                                                <td>{{ $loop->iteration + ($allseries->currentPage() - 1) * $allmovies->perPage() }}</td>
                                                <td>{{ $movies->movieId }}</td>
                                                <td class="text-truncate">{{ $movies->originalTitleText }}</td>
                                                <td>{{ $movies->titleType }}</td>
                                                <td>{{ $movies->country ? $movies->country : 'N/A' }}</td>
                                                <td>{{ $movies->runtime ? $movies->runtime : 'N/A' }}</td>
                                                <td>{{ $movies->genres ? $movies->genres : 'N/A'}}</td>
                                                <td>
                                                    <a href="{{ route('edit.movie', ['id'=>$movies->id]) }}" class="btn btn-outline-success">Edit </a>
                                                </td>
                                            </tr>
                                            </tr>
                                        @endforeach
                                    @endunless
                                </tbody>
                            </table>

                            {{ $allmovies->onEachSide(1)->links() }}
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                    {{-- Streaming movies table --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Series</h5>
                            <p>Add lightweight datatables to your project with using the <a
                                    href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple
                                    DataTables</a> library. Just add <code>.datatable</code> class name to any table you
                                wish to conver to a datatable. Check for <a
                                    href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more
                                    examples</a>.</p>

                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>
                                            <b>N</b>ame
                                        </th>
                                        <th>Type.</th>
                                        <th>Country</th>
                                        <th>Runtime</th>
                                        <th>Genres</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @unless (count($allseries) == 0)
                                        @foreach ($allseries as $movies)
                                            <tr>
                                                <td>{{ $loop->iteration + ($allseries->currentPage() - 1) * $allseries->perPage() }}</td>
                                                <td class="text-truncate">{{ $movies->originalTitleText }}</td>
                                                <td>{{ $movies->titleType }}</td>
                                                <td>{{ $movies->country ? $movies->country : 'N/A' }}</td>
                                                <td>{{ $movies->runtime ? $movies->runtime : 'N/A' }}</td>
                                                <td>{{ $movies->genres ? $movies->genres : 'N/A'}}</td>
                                                <td>
                                                    <a href="" class="btn btn-outline-success">Edit <i class="fa fa-edit" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endunless
                                </tbody>
                            </table>

                            {{ $allseries->onEachSide(1)->links() }}
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
