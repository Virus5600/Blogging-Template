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
									<div class="modal-body">
										<img src="{{ $b->getPoster() }}" alt="{{ $b->title }}" class="img img-fluid" />
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-7 d-flex justify-content-between">
						<p>{{ $b->summary }}</p>

						<div class="input-group">
							
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
	</div>
</div>

@section('css')
@livewireStyles
@endsection

@section('scripts')
@livewireScripts
@endsection