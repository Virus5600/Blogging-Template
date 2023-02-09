@section('title', 'Blogs')

<div class="container-fluid">
	<div wire:poll.visible.60s>
		@if (count($blogs) > 0)
		<div class="card-columns card-columns-lg-5">
			@foreach($blogs as $b)
			<div class="card enlarge-on-hover">
				<img src="{{ $b->getPoster() }}" alt="Poster for {{ $b->title }}" class="card-img card-img-top p-3">

				<div class="card-footer">
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

@section('css')
@livewireStyles
@endsection

@section('scripts')
@livewireScripts
@endsection