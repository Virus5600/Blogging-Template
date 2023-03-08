@php
$settings = [
	'web_name' => App\Models\Settings::getValue('web_name'),
	'web_desc' => App\Models\Settings::getValue('web_desc'),
	'web_logo' => App\Models\Settings::getInstance('web_logo')->getImage()
];
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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

		@php
		$nonceKey = "";
		$nonceKeyRaw = "nonce";
		$steps = rand(5, 10);

		foreach (str_split($nonceKeyRaw) as $v)
			$nonceKey .= chr(ord($v) + $steps);
		@endphp
		<meta name="nce" content="{{ csp_nonce() }}" key="{{ $nonceKey }}" value="{{ $steps }}">

		{{-- CSS --}}
		<link href="{{ asset('css/layouts/general.css') }}" rel="stylesheet">
		<link href="{{ asset('css/libs.css') }}" rel="stylesheet">
		<link href="{{ asset('css/style.css') }}" rel="stylesheet">
		<link href="{{ asset('css/login.css') }}" rel="stylesheet">

		{{-- JQUERY / SWEETALERT 2 / SLICK CAROUSEL --}}
		<script type="text/javascript" src="{{ asset('js/libs.js') }}"></script>

		{{-- LIVEWIRE --}}
		@livewireStyles(['nonce' => csp_nonce()])
		@livewireScripts(['nonce' => csp_nonce()])

		{{-- Removes the code that shows up when script is disabled/not allowed/blocked --}}
		<script type="text/javascript" id="for-js-disabled-js" nonce="{{ csp_nonce() }}">$('head').append('<style id="for-js-disabled" nonce={{ csp_nonce() }}>#js-disabled { display: none; }</style>');$(document).ready(function() {$('#js-disabled').remove();$('#for-js-disabled').remove();$('#for-js-disabled-js').remove();});</script>

		{{-- FAVICON --}}
		<link rel="icon" href="{{ $settings['web_logo'] }}">
		<link rel="shortcut icon" href="{{ $settings['web_logo'] }}">
		<link rel="apple-touch-icon" href="{{ $settings['web_logo'] }}">
		<link rel="mask-icon" href="{{ $settings['web_logo'] }}">

		{{-- TITLE --}}
		<title>{{ $settings['web_name'] }} | User Login</title>
	</head>

	<body>
		{{-- SHOWS THIS INSTEAD WHEN JAVASCRIPT IS DISABLED --}}
		{{-- SHOWS THIS INSTEAD WHEN JAVASCRIPT IS DISABLED --}}
		<div id="js-disabled">
			<style type="text/css" nonce="{{ csp_nonce() }}">
				#js-disabled {
					position: absolute;
					height: 100vh;
					width: 100vw;
					background-color: #ccc;
				}

				/* Make the element disappear if JavaScript isn't allowed */
				.js-only {
					display: none!important;
				}
			</style>

			<div class="row h-100">
				<div class="col-12 col-md-4 offset-md-4 py-5 my-auto">
					<div class="card shadow my-auto">
						<h4 class="card-header card-title text-center">Javascript is Disabled</h4>

						<div class="card-body">
							<p class="card-text">This website required <b>JavaScript</b> to run. Please allow/enable JavaScript and refresh the page.</p>
							<p class="card-text">If the JavaScript is enabled or allowed, please check your firewall as they might be the one disabling JavaScript.</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="d-flex flex-column min-vh-100 js-only">
			<main class="content d-flex flex-column flex-grow-1 my-3 my-lg-5" id="content">
				<div class="container-fluid d-flex flex-column flex-grow-1">
					@livewire('login')
				</div>
			</main>

			<!-- SCRIPTS -->
			<script type="text/javascript" src="{{ asset('js/util/password-visibility-toggler.js') }}"></script>
			<script type="text/javascript" src="{{ asset('js/util/livewire-swal.js') }}"></script>
		</div>
	</body>
</html>