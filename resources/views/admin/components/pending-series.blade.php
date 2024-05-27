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
                            <h5 class="card-title">Pending Series</h5>
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
                                        <th>Image</th>
                                        <th>Type</th>
                                        <th>Country</th>
                                        <th>Genres</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @unless (count($pending_series) == 0)
                                        @foreach ($pending_series as $series)
                                            <tr>
                                                <td>{{ $loop->iteration + ($pending_series->currentPage() - 1) * $pending_series->perPage() }}</td>
                                                <td>{{ $series->movieId }}</td>
                                                <td class="text-truncate">{{ $series->full_name }}</td>
                                                <td>
                                                    <img src="{{ $series->imageUrl }}" alt=""
                                                    style="width: 70px; height: 70px;">
                                                </td>
                                                <td>{{ $series->titleType }}</td>
                                                <td>{{ $series->country ? $series->country : 'N/A' }}</td>
                                                <td>{{ $series->genres ? $series->genres : 'N/A'}}</td>
                                                <td>{{ $series->plotText ? $series->plotText : 'N/A'}}</td>
                                                <td>
                                                    <a href="" class="btn btn-outline-success">Edit <i class="fa fa-edit" aria-hidden="true"></i></a>

                                                    <a href="{{ route('delete.series', ['id'=>$series->id]) }}" class="btn btn-outline-danger mt-2">Delete </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endunless
                                </tbody>
                            </table>

                            {{ $pending_series->onEachSide(1)->links() }}
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
