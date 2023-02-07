<!DOCTYPE html>
<html lang="en">
	<head>
		{{-- META DATA --}}
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="{{ env('APP_DESC') }}">

		{{-- SITE META --}}
		<meta name="type" content="website">
		<meta name="title" content="{{ env('APP_NAME') }}">
		<meta name="description" content="{{ env('APP_DESC') }}">
		<meta name="image" content="{{ asset('images/meta-banner.jpg') }}">
		<meta name="keywords" content="{{ env('APP_KEYW') }}">
		<meta name="application-name" content="{{ env('APP_NAME') }}">

		{{-- TWITTER META --}}
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="{{ env('APP_NAME') }}">
		<meta name="twitter:description" content="{{ env('APP_DESC') }}">
		<meta name="twitter:image" content="{{asset('/images/meta-banner.jpg')}}">

		{{-- OG META --}}
		<meta name="og:url" content="{{Request::url()}}">
		<meta name="og:type" content="website">
		<meta name="og:title" content="{{ env('APP_NAME') }}">
		<meta name="og:description" content="{{ env('APP_DESC') }}">
		<meta name="og:image" content="{{asset('/images/meta-banner.jpg')}}">

		{{-- CSS --}}
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/style.css') }}" rel="stylesheet">
		<link href="{{ asset('css/admin.css') }}" rel="stylesheet">

		{{-- JQUERY / SWEETALERT 2 / SLICK CAROUSEL / FONTAWESOME 6 --}}
		<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

		{{-- Title --}}
		<title>Internal Server Error - Municipality of Taytay, Rizal</title>
	</head>
	
	<body style="height: 100vh;">
		<div class="container-fluid d-flex flex-d-col" style="height: -webkit-fill-available;">
			<div class="container-fluid my-auto mx-0 p-0">
				<div class="row">
					<div class="col-12 col-lg-6 offset-lg-3 text-center">
						<i class="far fa-frown" style="height: 12.5rem"></i>
					</div>
				</div>

				<div class="row">
					<div class="col-12 col-lg-6 offset-lg-3 text-center">
						<h1 class="text-center">Something went wrong, please retry or contact and inform the webmaster.</h1>
						<a href="{{ url()->current() == url()->previous() ? route('index') : url()->previous() }}" class="btn btn-secondary">Go Back</a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>