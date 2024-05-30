{{-- @extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found')) --}}


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Font -->
	<link href="{{ url('https://fonts.googleapis.com/css?family=Open+Sans:400,600%7CUbuntu:300,400,500,700') }}" rel="stylesheet"> 

	<!-- CSS -->
	<link rel="stylesheet" href="{{ url('flix/css/bootstrap-reboot.min.css') }}">
	<link rel="stylesheet" href="{{ url('flix/css/bootstrap-grid.min.css') }}">
	<link rel="stylesheet" href="{{ url('flix/css/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ url('flix/css/jquery.mCustomScrollbar.min.css') }}">
	<link rel="stylesheet" href="{{ url('flix/css/nouislider.min.css') }}">
	<link rel="stylesheet" href="{{ url('flix/css/ionicons.min.css') }}">
	<link rel="stylesheet" href="{{ url('flix/css/plyr.css') }}">
	<link rel="stylesheet" href="{{ url('flix/css/photoswipe.css') }}">
	<link rel="stylesheet" href="{{ url('flix/css/default-skin.css') }}">
	<link rel="stylesheet" href="{{ url('flix/css/main.css') }}">

	<!-- Favicons -->

	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Dmitry Volkov">
	<title>Not Found</title>

</head>
<body class="body">

	<!-- page 404 -->
	<div class="page-404 section--bg" data-bg="img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="page-404__wrap">
						<div class="page-404__content">
							<h1 class="page-404__title">404</h1>
							<p class="page-404__text">The page you are looking for is not available!</p>
							<a href="{{ url('/') }}" class="page-404__btn">go home</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end page 404 -->

	<!-- JS -->
	<script src="{{ url('flix/js/jquery-3.3.1.min.js') }}"></script>
	<script src="{{ url('flix/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ url('flix/js/owl.carousel.min.js') }}"></script>
	<script src="{{ url('flix/js/jquery.mousewheel.min.js') }}"></script>
	<script src="{{ url('flix/js/jquery.mCustomScrollbar.min.js') }}"></script>
	<script src="{{ url('flix/js/wNumb.js') }}"></script>
	<script src="{{ url('flix/js/nouislider.min.js') }}"></script>
	<script src="{{ url('flix/js/plyr.min.js') }}"></script>
	<script src="{{ url('flix/js/jquery.morelines.min.js') }}"></script>
	<script src="{{ url('flix/js/photoswipe.min.js') }}"></script>
	<script src="{{ url('flix/js/photoswipe-ui-default.min.js') }}"></script>
	<script src="{{ url('flix/js/main.js') }}"></script>
</body>

</html>