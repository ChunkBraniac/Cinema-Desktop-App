<!DOCTYPE html>
<html>

<head>
    <title>Edit series Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container col-xl-5">
        <h2>Edit series Details</h2>
        @unless ($series == null)
            <form action="{{ route('update.series', ['id' => $series->id]) }}" method="post">

                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xl-6 mt-3">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" value="{{ $series->full_name }}"
                                placeholder="Enter series title" name="edit_name">
                        </div>
                    </div>

                    <div class="col-xl-6 mt-3">
                        <div class="form-group">
                            <label for="director">Image:</label>
                            <input type="text" class="form-control" id="director" value="{{ $series->imageUrl }}"
                                placeholder="Enter image url" name="edit_image">
                        </div>
                    </div>

                    <div class="col-xl-6 mt-3">
                        <div class="form-group">
                            <label for="director">Country:</label>
                            <input type="text" class="form-control" id="director" value="{{ $series->country }}"
                                placeholder="Enter image url" name="edit_country">
                        </div>
                    </div>

                    <div class="col-xl-6 mt-3">
                        <div class="form-group">
                            <label for="director">Description:</label>
                            <input type="text" class="form-control" id="director" value="{{ $series->plotText }}"
                                placeholder="Enter image url" name="edit_plotText">
                        </div>
                    </div>

                    <div class="col-xl-6 mt-3">
                        <div class="form-group">
                            <label for="releaseDate">Release Date:</label>
                            <input type="text" class="form-control" id="releaseDate" value="{{ $series->releaseDate }}"
                                placeholder="Enter image url" name="edit_releaseDate">
                        </div>
                    </div>

                    <div class="col-xl-6 mt-3">
                        <div class="form-group">
                            <label for="releaseDate">Genres:</label>
                            <input type="text" class="form-control" id="releaseDate" value="{{ $series->genres }}"
                                placeholder="Enter image url" name="edit_genres">
                        </div>
                    </div>

                    <div class="col-xl-6 mt-3">
                        <div class="form-group">
                            <label for="genre">Trailer:</label>
                            <input type="text" class="form-control" id="genre" placeholder="Enter genre"
                                value="{{ $series->trailer }}" name="edit_trailer">
                        </div>
                    </div>
                </div>


                <div class="mt-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        @endunless
    </div>
</body>

</html>
