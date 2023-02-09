<div class="container-fluid">
	<div wire:poll.visible.60s>
		@forelse($blogs as $b)
		<div class="card w-lg-75 mx-auto my-3">
			<h3 class="card-header">{{ $b->title }}</h3>

			<div class="card-body">
				<div class="row">
					<div class="col-5">
						{{-- POSTER IMAGE --}}
						<img src="{{ $b->getPoster() }}" alt="{{ $b->title }}" class="img img-fluid enlarge-on-hover cursor-pointer" style="max-height: 10rem;" draggable="false" data-toggle="modal" data-target="#{{ $b->slug }}">
						
						{{-- MODAL --}}
						<div class="modal fade" tabindex="-1" aria-label="Poster for {{ $b->title }}" aria-hidden="true" id="{{ $b->slug }}">
							<div class="modal-dialog modal-xl">
								<div class="modal-content">
									<div class="modal-body justify-content-center d-flex">
										<img src="{{ $b->getPoster() }}" alt="{{ $b->title }}" class="img img-fluid" draggable="false" />
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-7 d-flex flex-column justify-content-between">
						<p>{{ $b->summary }}</p>

						<div class="input-group justify-content-end">
							<a href="{{-- route("", [$b->slug]) --}}" class="btn btn-light mx-1">Read More...</a>
							<div class="dropdown mx-1">
								<button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
									<i class="fas fa-share-from-square mr-2"></i>Share
								</button>

								<div class="dropdown-menu dropdown-menu-right">
									<button class="dropdown-item" type="button" data-social-type="facebook" data-social-share="{{ "google.com" }}">
										<i class="fab fa-facebook mr-2"></i>Facebook
									</button>
									
									<button class="dropdown-item" type="button" data-social-type="twitter" data-social-share="{{ "google.com" }}">
										<i class="fab fa-twitter mr-2"></i>Twitter
									</button>

									<button class="dropdown-item" type="button" data-social-type="whatsapp" data-social-share="{{ "google.com" }}">
										<i class="fab fa-whatsapp mr-2"></i>WhatsApp
									</button>
									
									<button class="dropdown-item" type="button" data-copy-text="{{ route("blogs.index", [$b->slug]) }}">
										<i class="fas fa-link mr-2"></i>Copy Link
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@empty
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-12 text-center h3">No posts yet~</div>
				</div>
			</div>
		</div>
		@endforelse

		@if ($blogs)
		<div class="w-100 d-flex">
			<a href="{{ route('blogs.index') }}" class="btn btn-light mx-auto">See more...</a>
		</div>
		@endif
	</div>
</div>

@section('css')
@livewireStyles
@endsection

@section('scripts')
@livewireScripts
@endsection