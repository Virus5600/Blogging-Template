<!-- TOPBAR -->
<nav class="navbar navbar-expand-md navbar-light navbar-sticky topbar dark-shadow justify-content-between py-0" id="topbarWrapper">
	<a class="navbar-brand text-center d-flex flex-row w-75 w-lg-auto" href="{{ route('index') }}" title="{{ $settings['web_name'] }}">
		<img src="{{ $settings['web_logo'] }}" alt="Branding" style="height: 3rem;" class="my-auto">
		<h5 class="text-dark text-decoration-none my-auto mx-2 font-weight-bold text-wrap">{{ $settings['web_name'] }}</h5>
	</a>

	<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#topbarDropdown" title="Toggle Topbar" aria-controls="topbarDropdown" aria-expanded="false" aria-label="Toggle Topbar">
		<span class="navbar-toggler-icon"></span>
	</button>

	{{-- NAVBAR START --}}
	<div class="collapse navbar-collapse flex-grow-0" id="topbarDropdown">
		<ul class="navbar-nav">
			{{-- HOME --}}
			<li class="navbar-item border-lg-left border-lg-right">
				@if (request()->is('/'))
				<span class="nav-link px-2 active">Home</a>
				@else
				<a href="{{ route('index') }}" class="nav-link px-2">Home</a>
				@endif
			</li>

			{{-- BLOGS --}}
			<li class="navbar-item border-lg-left border-lg-right">
				@if (request()->is('blogs'))
				<span class="nav-link px-2 active">Blogs</span>
				@elseif (request()->is('blogs/*'))
				<a href="{{ route('blogs.index') }}" class="nav-link px-2 active">Blogs</a>
				@else
				<a href="{{ route('blogs.index') }}" class="nav-link px-2">Blogs</a>
				@endif
			</li>

			{{-- VIDEOS --}}
			<li class="navbar-item border-lg-left border-lg-right">
				@if (request()->is('videos'))
				<span class="nav-link px-2 active">Videos</span>
				@elseif (request()->is('videos/*'))
				<a href="{{ route('index') }}" class="nav-link px-2 active">Videos</a>
				@else
				<a href="{{ route('index') }}" class="nav-link px-2">Videos</a>
				@endif
			</li>

			{{-- ABOUT ME --}}
			<li class="navbar-item border-lg-left border-lg-right">
				@if (request()->is('about-me'))
				<span class="nav-link px-2 active">About Me</span>
				@else
				<a href="{{ route('index') }}" class="nav-link px-2">About Me</a>
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