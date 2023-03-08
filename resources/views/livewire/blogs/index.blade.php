@section('title', 'Blogs')

<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-lg-2">
			<div class="card h-100">
				<div class="card-body">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search" value="{{ $search }}" wire:model="search">
					</div>

					<hr class="hr-thick">

					<div class="form-group">
						<label class="form-label">Sort By Date</label>

						<div class="form-check">
							<input type="radio" class="form-chech-input" wire:model="dateSort" id="dateSortLatest" value="latest" {{ $dateSort == "latest" ? "selected" : "" }}>
							<label for="dateSortLatest" class="form-check-label">Latest to Oldest</label>
						</div>

						<div class="form-check">
							<input type="radio" class="form-chech-input" wire:model="dateSort" id="dateSortOldest" value="oldest" {{ $dateSort == "oldest" ? "selected" : "" }}>
							<label for="dateSortOldest" class="form-check-label">Oldest to Latest</label>
						</div>
					</div>

					<hr class="hr-thick">

					<div class="form-group">
						<label for="pages" class="form-label">Items per page:</label>
						<input type="number" min="10" class="form-control" wire:model="pages" id="pages" value="{{ $pages }}">
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 col-lg-10" wire:poll.visible.60s>
			@if (count($blogs) > 0)
			<div class="row">
				@foreach($blogs as $b)
				<div class="col-12 col-md-4 col-lg-3 my-3">
					<div class="card enlarge-on-hover h-100">
						<img src="{{ $b->getPoster() }}" alt="Poster for {{ $b->title }}" class="card-img card-img-top p-3">

						<div class="card-footer mt-auto">
							<p class="card-text">{{ $b->summary }}</p>

							<div class="card-text d-flex justify-content-between">
								<small class="text-muted">By {{ $b->user->getName() }}</small>
								<small class="text-muted">{{ $b->getLifetime() }} ago</small>
							</div>
							
							<p class="text-center">
								<a href="{{ route('blogs.show', [$b->slug]) }}">Read Blog</a>
							</p>
						</div>
					</div>
				</div>
				@endforeach
			</div>
			@else
			<div class="card h-100">
				<div class="card-body h-100">
					<h4 class="card-text text-center">There are no posts yet~</h4>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>