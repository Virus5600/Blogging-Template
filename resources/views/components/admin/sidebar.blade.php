@php
$user = auth()->user();
$authLvl = $user->userType->authority_level;
$isOwner = $authLvl == 1;

$blogsAllow = $user->hasPermission('blogs_tab_access');
$videosAllow = $user->hasPermission('videos_tab_access');
$aboutAllow = $user->hasPermission('about_tab_access');

$usersAllow = $user->hasPermission('users_tab_access');
@endphp

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
		@if ($blogsAllow)
			@if (request()->is('admin/blogs'))
			<span class="bg-secondary text-white"><i class="fas fa-comment mr-2"></i>Blogs</span>
			@elseif (request()->is('admin/blogs/*'))
			<a class="text-decoration-none aria-link bg-secondary text-white" href="{{ route('admin.blogs.index') }}" aria-hidden="false" aria-label="Blogs"><i class="fas fa-comment mr-2"></i>Blogs</a>
			@else
			<a class="text-decoration-none aria-link text-dark" href="{{ route('admin.blogs.index') }}" aria-hidden="false" aria-label="Blogs"><i class="fas fa-comment mr-2"></i>Blogs</a>
			@endif
		@endif

		{{-- VIDEOS --}}
		@if ($videosAllow)
			@if (request()->is('admin/videos'))
			@elseif (request()->is('admin/videos/*'))
			@else
			@endif
		@endif

		{{-- ABOUT ME --}}
		@if ($aboutAllow)
			@if (request()->is('admin/about-me'))
			@elseif (request()->is('admin/about-me/*'))
			@else
			@endif
		@endif

		<hr class="w-100 custom-hr">

		{{-- USER --}}
		@if ($usersAllow)
			@if (request()->is('admin/users'))
			<span class="bg-secondary text-white"><i class="fas fa-users mr-2"></i>Users</span>
			@elseif (request()->is('admin/users/*'))
			<a class="text-decoration-none aria-link bg-secondary text-white" href="{{ route('admin.users.index') }}" aria-hidden="false" aria-label="Users"><i class="fas fa-users mr-2"></i>Users</a>
			@else
			<a class="text-decoration-none aria-link text-dark" href="{{ route('admin.users.index') }}" aria-hidden="false" aria-label="Users"><i class="fas fa-users mr-2"></i>Users</a>
			@endif
		@endif

		<hr class="w-100 custom-hr">

		{{-- LOGOUT --}}
		<a class="text-decoration-none aria-link text-dark" href="{{ route('logout') }}" aria-hidden="false" aria-label="Logout"><i class="fas fa-sign-out-alt mr-2"></i>Sign Out</a>
	</div>
</div>