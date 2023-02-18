<div class="sidebar collapse-vertical d-flex flex-row dark-shadow position-absolute position-lg-sticky sticky-top w-100 w-lg-auto" style="overflow: hidden;" id="sidebar" aria-expanded="false">
	{{-- Navigation Bar (SIDE) --}}
	<div class="sidebar-content w-100 dark-shadow custom-scroll d-flex flex-column pb-3 py-lg-3 px-0 overflow-y-auto bg-white">
		<i class="fas fa-bars fa-2x text-dark border rounded border-dark py-2 m-1 d-block d-lg-none" data-toggle="sidebar-collapse" data-target="#sidebar" aria-controls="sidebar" aria-label="Toggle Sidebar"></i>

		<hr class="w-100 custom-hr d-block d-lg-none">

		{{-- Branding --}}
		<a class="navbar-brand m-0 py-0 d-flex justify-content-center position-relative" href="{{route('admin.dashboard')}}" style="height: auto;">
			<img src="{{ $settings['web_logo'] }}" style="max-height: 3.25rem;" class="m-0 p-0" alt="Website Logo" data-fallback-img="{{ asset('uploads/departments/default.png') }}" />
			<span class="text-dark text-decoration-none text-wrap d-flex d-lg-none my-auto mx-2">{{ $settings['web_name'] }}</span>
		</a>

		<hr class="w-100 custom-hr">

		{{-- DASHBOARD --}}
		@if (\Request::is('admin/dashboard'))
		<span class="bg-secondary text-white"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</span>
		@elseif (\Request::is('admin/dashboard/*'))
		<a class="text-decoration-none aria-link bg-secondary text-white" href="{{ route('admin.dashboard') }}" aria-hidden="false" aria-label="Dashboard"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
		@else
		<a class="text-decoration-none aria-link text-dark" href="{{ route('admin.dashboard') }}" aria-hidden="false" aria-label="Dashboard"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a>
		@endif

		{{-- BLOGS --}}
		@if (request()->is('admin/blogs'))
		<span class="bg-secondary text-white"><i class="fas fa-comment mr-2"></i>Blogs</span>
		@elseif (request()->is('admin/blogs/*'))
		<a class="text-decoration-none aria-link bg-secondary text-white" href="{{ route('admin.blogs.index') }}" aria-hidden="false" aria-label="Blogs"><i class="fas fa-comment mr-2"></i>Blogs</a>
		@else
		<a class="text-decoration-none aria-link text-dark" href="{{ route('admin.blogs.index') }}" aria-hidden="false" aria-label="Blogs"><i class="fas fa-comment mr-2"></i>Blogs</a>
		@endif

		{{-- VIDEOS --}}
		@if (request()->is('admin/videos'))
		@elseif (request()->is('admin/videos/*'))
		@else
		@endif

		{{-- ABOUT ME --}}
		@if (request()->is('admin/about-me'))
		@elseif (request()->is('admin/about-me/*'))
		@else
		@endif

		<hr class="w-100 custom-hr">

		{{-- LOGOUT --}}
		<a class="text-decoration-none aria-link text-dark" href="{{ route('logout') }}" aria-hidden="false" aria-label="Logout"><i class="fas fa-sign-out-alt mr-2"></i>Sign Out</a>
	</div>
</div>