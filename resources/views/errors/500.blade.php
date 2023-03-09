@php
$settings = [
	'web_name' => App\Models\Settings::getValue('web_name'),
	'web_desc' => App\Models\Settings::getValue('web_desc'),
	'web_logo' => App\Models\Settings::getInstance('web_logo')->getImage()
];
@endphp

<!DOCTYPE html>
<html lang="en">
	<head>
		{{-- META DATA --}}
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		{{-- SITE META --}}
		<meta name="type" content="website">
		<meta name="title" content="{{ $settings['web_name'] }}">
		<meta name="description" content="{{ $settings['web_desc'] }}">
		<meta name="image" content="{{ asset('images/meta-banner.jpg') }}">
		<meta name="keywords" content="{{ env('APP_KEYW') }}">
		<meta name="application-name" content="{{ $settings['web_name'] }}">

		{{-- TWITTER META --}}
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="{{ $settings['web_name'] }}">
		<meta name="twitter:description" content="{{ $settings['web_desc'] }}">
		<meta name="twitter:image" content="{{ asset('/images/meta-banner.jpg') }}">

		{{-- OG META --}}
		<meta name="og:url" content="{{ Request::url() }}">
		<meta name="og:type" content="website">
		<meta name="og:title" content="{{ $settings['web_name'] }}">
		<meta name="og:description" content="{{ $settings['web_desc'] }}">
		<meta name="og:image" content="{{ asset('/images/meta-banner.jpg') }}">

		{{-- CSS --}}
		<link href="{{ asset('css/libs.css') }}" rel="stylesheet">
		<link href="{{ asset('css/layouts/general.css') }}" rel="stylesheet">
		<link href="{{ asset('css/style.css') }}" rel="stylesheet">
		<link href="{{ asset('css/admin.css') }}" rel="stylesheet">

		{{-- JQUERY / SWEETALERT 2 / SLICK CAROUSEL / FONTAWESOME 6 --}}
		<script type="text/javascript" src="{{ asset('js/libs.js') }}"></script>

		{{-- FAVICON --}}
		<link rel="icon" href="{{ $settings['web_logo'] }}">
		<link rel="shortcut icon" href="{{ $settings['web_logo'] }}">
		<link rel="apple-touch-icon" href="{{ $settings['web_logo'] }}">
		<link rel="mask-icon" href="{{ $settings['web_logo'] }}">

		{{-- Title --}}
		<title>{{ $settings['web_name'] }} | Internal Server Error</title>
	</head>
	
	<body>
		<div class="container-fluid d-flex flex-d-col">
			<div class="container-fluid my-auto mx-0 p-0">
				<div class="row">
					<div class="col-12 col-lg-6 offset-lg-3 text-center">
						<i class="far fa-frown fa-10x"></i>
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