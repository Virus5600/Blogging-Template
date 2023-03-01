@php
$settings = [
	'web_name' => App\Models\Settings::getValue('web_name'),
	'web_desc' => App\Models\Settings::getValue('web_desc'),
	'web_logo' => App\Models\Settings::getInstance('web_logo')->getImage(),
	'default-avatar' => App\Models\User::getDefaultAvatar()
];
$user = Auth::user();
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
		<meta name="twitter:image" content="{{asset('/images/meta-banner.jpg')}}">

		{{-- OG META --}}
		<meta name="og:url" content="{{Request::url()}}">
		<meta name="og:type" content="website">
		<meta name="og:title" content="{{ $settings['web_name'] }}">
		<meta name="og:description" content="{{ $settings['web_desc'] }}">
		<meta name="og:image" content="{{asset('/images/meta-banner.jpg')}}">

		@yield('meta')

		{{-- CSS --}}
		<link href="{{ asset('css/util/custom-scrollbar.css') }}" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/style.css') }}" rel="stylesheet">
		<link href="{{ asset('css/admin.css') }}" rel="stylesheet">

		@yield('css')

		{{-- JQUERY / SWEETALERT 2 / SLICK CAROUSEL / FONTAWESOME 6 / SUMMERNOTE --}}
		<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

		{{-- LIVEWIRE --}}
		@livewireStyles
		@livewireScripts

		{{-- Removes the code that shows up when script is disabled/not allowed/blocked --}}
		<script type="text/javascript" id="for-js-disabled-js">$('head').append('<style id="for-js-disabled">#js-disabled { display: none; }</style>');$(document).ready(function() {$('#js-disabled').remove();$('#for-js-disabled').remove();$('#for-js-disabled-js').remove();});</script>

		{{-- FAVICON --}}
		<link rel="icon" href="{{ $settings['web_logo'] }}">
		<link rel="shortcut icon" href="{{ $settings['web_logo'] }}">
		<link rel="apple-touch-icon" href="{{ $settings['web_logo'] }}">
		<link rel="mask-icon" href="{{ $settings['web_logo'] }}">

		{{-- TITLE --}}
		<title>{{ $settings['web_name'] }} | @yield('title')</title>
	</head>

	<body class="custom-scrollbar" style="height: 100vh;">
		{{-- SHOWS THIS INSTEAD WHEN JAVASCRIPT IS DISABLED --}}
		<div style="position: absolute; height: 100vh; width: 100vw; background-color: #ccc;" id="js-disabled">
			<style type="text/css">
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

		<div class="d-flex flex-row flex-fill min-vh-100 js-only">
			{{-- SIDEBAR --}}
			@include('components.admin.sidebar')

			<!-- CONTENTS -->
			<main class="content-fluid d-flex flex-column flex-fill m-0 w-lg-75" style="z-index: 0;" id="content">
				@include('components.admin.header')

				<div class="content container-fluid py-3 flex-fill" style="overflow-y: hidden;">
					@yield('content')
				</div>
			</main>

			<!-- SCRIPTS -->
			<script type="text/javascript">const fiFallbackImage = '{{ $settings["default-avatar"] }}';</script>
			<script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
			<script type="text/javascript" src="{{ asset('js/util/fallback-image.js') }}"></script>
			<script type="text/javascript" src="{{ asset('js/util/livewire-swal.js') }}"></script>
			<script type="text/javascript">
				@if (Session::has('flash_error'))
				Swal.fire({
					{!! Session::has('has_icon') ? "icon: `error`," : "" !!}
					title: `{!! Session::get('flash_error') !!}`,
					{!! Session::has('message') ? 'html: `' . Session::get('message') . '`,' : '' !!}
					position: {!! Session::has('position') ? '`' . Session::get('position') . '`' : '`top`' !!},
					showConfirmButton: false,
					toast: {!! Session::has('is_toast') ? Session::get('is_toast') : true !!},
					{!! Session::has('has_timer') ? (Session::get('has_timer') ? (Session::has('duration') ? ('timer: ' . Session::get('duration')) . ',' : `timer: 10000,`) : '') : `timer: 10000,` !!}
					background: `#dc3545`,
					customClass: {
						title: `text-white`,
						content: `text-white`,
						popup: `px-3`
					},
				});
				@elseif (Session::has('flash_info'))
				Swal.fire({
					{!! Session::has('has_icon') ? "icon: `info`," : "" !!}
					title: `{!! Session::get('flash_info') !!}`,
					{!! Session::has('message') ? 'html: `' . Session::get('message') . '`,' : '' !!}
					position: {!! Session::has('position') ? '`' . Session::get('position') . '`' : '`top`' !!},
					showConfirmButton: false,
					toast: {!! Session::has('is_toast') ? Session::get('is_toast') : true !!},
					{!! Session::has('has_timer') ? (Session::get('has_timer') ? (Session::has('duration') ? ('timer: ' . Session::get('duration')) . ',' : `timer: 10000,`) : '') : `timer: 10000,` !!}
					background: `#17a2b8`,
					customClass: {
						title: `text-white`,
						content: `text-white`,
						popup: `px-3`
					},
				});
				@elseif (Session::has('flash_success'))
				Swal.fire({
					{!! Session::has('has_icon') ? "icon: `success`," : "" !!}
					title: `{!! Session::get('flash_success') !!}`,
					{!! Session::has('message') ? 'html: `' . Session::get('message') . '`,' : '' !!}
					position: {!! Session::has('position') ? '`' . Session::get('position') . '`' : '`top`' !!},
					showConfirmButton: false,
					toast: {!! Session::has('is_toast') ? Session::get('is_toast') : true !!},
					{!! Session::has('has_timer') ? (Session::get('has_timer') ? (Session::has('duration') ? ('timer: ' . Session::get('duration')) . ',' : `timer: 10000,`) : '') : `timer: 10000,` !!}
					background: `#28a745`,
					customClass: {
						title: `text-white`,
						content: `text-white`,
						popup: `px-3`
					},
				});
				@endif

				$(document).ready(function(){
					$(".col-a").click(function(){
						$('.collapse.show').collapse('hide');
					});
				});
			</script>
			@yield('scripts')
		</div>
	</body>
</html>