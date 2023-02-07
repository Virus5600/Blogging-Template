<!-- TOPBAR -->
<nav class="navbar navbar-expand-md navbar-light navbar-sticky topbar dark-shadow justify-content-between py-0" id="topbarWrapper">
	<a class="navbar-brand text-center" href="{{ route('index') }}" title="{{ $settings['web_name'] }}">
		<img src="{{ $settings['web_logo'] }}" alt="Branding" style="height: 3rem;">
	</a>

	<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#topbarDropdown" title="Toggle Topbar" aria-controls="topbarDropdown" aria-expanded="false" aria-label="Toggle Topbar">
		<span class="navbar-toggler-icon"></span>
	</button>

	{{-- NAVBAR START --}}
	<div class="collapse navbar-collapse flex-grow-0" id="topbarDropdown">
		<ul class="navbar-nav">
			{{-- HOME --}}
			<li class="navbar-item">
				@if (\Request::is('/'))
				<span class="nav-link border-left border-right active">Home</a>
				@else
				<a href="{{ route('index') }}" class="nav-link border-left border-right">Home</a>
				@endif
			</li>

			{{-- BLOGS --}}
			<li class="navbar-item">
				@if (\Request::is('/blogs'))
				<span class="nav-link border-left border-right active">Blogs</a>
				@else
				<a href="{{ route('index') }}" class="nav-link border-left border-right">Blogs</a>
				@endif
			</li>

			{{-- VIDEOS --}}
			<li class="navbar-item">
				@if (\Request::is('/videos'))
				<span class="nav-link border-left border-right active">Videos</a>
				@else
				<a href="{{ route('index') }}" class="nav-link border-left border-right">Videos</a>
				@endif
			</li>

			{{-- ABOUT ME --}}
			<li class="navbar-item">
				@if (\Request::is('/about-me'))
				<span class="nav-link border-left border-right active">About Me</a>
				@else
				<a href="{{ route('index') }}" class="nav-link border-left border-right">About Me</a>
				@endif
			</li>

			{{-- SECRET LOGIN --}}
			<li class="navbar-item" login-link-component data-login-url="{{ route('login') }}" data-login-clicks="5">
				<div class="mx-3"></div>
			</li>
		</ul>
	</div>
	{{-- NAVBAR END --}}
</nav>

<div class="row mx-0">
	<div class="col-12 mx-0">
		<div class="w-100" id="carousel" data-image="{{ route('api.carousel.fetch') }}" data-sp="{{ asset('uploads/settings/carousel') }}" data-arrow="{{ asset('images/settings/carousel/arrow.png') }}"></div>
		<script type="text/javascript" src="{{ asset('js/hooks/carouselHook.js') }}" id="carouselHook"></script>
		<script type="text/javascript" src="{{ asset('js/components/login-page.js') }}"></script>
	</div>
</div>