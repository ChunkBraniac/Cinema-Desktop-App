@extends('admin.layouts.app')

@section('title')
    NiceAdmin - Movies
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
                                        <th>Commentor</th>
                                        <th>
                                            Comment
                                        </th>
                                        <th>Movie Id</th>
                                        <th>Movie Name</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @unless (count($all_comments) == 0)
                                        @foreach ($all_comments as $comment)
                                            <tr>
                                                <td>{{ $loop->iteration + ($all_comments->currentPage() - 1) * $all_comments->perPage() }}</td>
                                                <td>{{ $comment->commentor }}</td>
                                                <td class="text-truncate">{{ $comment->comment }}</td>
                                                <td>{{ $comment->movie_id }}</td>
                                                <td>{{ $comment->movie_name ? $comment->movie_name : 'N/A' }}</td>
                                                <td>{{ $comment->created_at ? $comment->created_at : 'N/A' }}</td>
                                                <td>{{ $comment->update_at ? $comment->update_at : 'N/A'}}</td>
                                                
                                                <td>
                                                    <button class="btn btn-danger">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endunless
                                </tbody>
                            </table>

                            {{ $all_comments->onEachSide(1)->links() }}
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
