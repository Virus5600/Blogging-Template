{{-- Navigation Bar (TOP) --}}
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top dark-shadow py-0 px-3" style="z-index: 100;">
	<div class="container-fluid">
		<div class="d-flex flex-row flex-fill justify-content-between">
			{{-- Navbar Toggler --}}
			<button class="sidebar-toggler" type="button" data-toggle="sidebar-collapse" data-target="#sidebar" aria-controls="sidebar" aria-label="Toggle Sidebar">
				<span class="navbar-toggler-icon"></span>
			</button>

			{{-- Navbar contents --}}
			<div class="d-flex align-items-center ml-auto">
				<img src="{{ $user->getAvatar() }}" class="circular-border" draggable='false' alt="{{ $user->getName() }}" style="height: 2.5rem;" data-fallback-img="{{ $user->getDefaultAvatar() }}"/>
				<label>
					<div class="dropdown">
						<a href='#' role="button" class="nav-link dropdown-toggle text-dark dynamic-size-lg-h6" style="font-size: 1.25rem;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							{{ $user->getName() }}
						</a>

						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="{{ route('index') }}">View Page</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('logout') }}">Sign out</a>
						</div>
					</div>
				</label>
			</div>
		</div>
	</div>
</nav>