<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
</head>

<body>

    <div class="container d-flex flex-column justify-content-center h-100">
        <h1 class="display-1 text-center">404</h1>
        <p class="lead text-center">Oops! Page not found.</p>
        <a href="{{ URL::previous() }}" class="btn btn-primary mx-auto">Go Back Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jY38PBHQiwNzxEh7fxXRxwDhwTlRlBQ==" crossorigin="anonymous">
    </script>
</body>

</html>
