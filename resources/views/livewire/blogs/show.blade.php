@section('title', "Blogs - {$blog->title}")

<div class="row">
	{{-- BREADCRUMBS --}}
	<div class="col-12">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item py-2"><a href="{{ route('blogs.index') }}">Blogs</a></li>
				<li class="breadcrumb-item py-2 active" aria-current="page">{{ $blog->title }}</li>
				<a href="{{ route('blogs.index') }}" class="btn btn-light ml-auto"><i class="fas fa-rotate-left mr-2"></i>Go Back</a>
			</ol>
		</nav>
	</div>

	<div class="col-12 col-md-9">
		<div class="card">
			<div class="card-header d-flex flex-column flex-lg-row justify-content-between">
				{{-- BLOG TITLE AND AUTHOR --}}
				<div class="d-flex flex-column text-center text-lg-left my-2 my-lg-auto">
					<h3>{{ $blog->title }}</h3>
					
					<small class="text-muted">
						<i>by {{ $blog->user->getName() }}</i>
					</small>
				</div>
				
				{{-- DATE POSTED AND IF EDITED --}}
				<div class="d-flex flex-column text-center text-lg-right my-2 my-lg-auto">
					<h5>{{ $blog->created_at->format('M d, Y') }}</h5>
					<small class="text-muted"><i>{{ $blog->updated_at ? "(Edited)" : "" }}</i></small>
				</div>
			</div>

			<div class="card-img card-img-top position-relative text-center my-3" style="max-height: 12.5rem;">
				<img src="{{ $blog->getPoster() }}" alt="Poster for {{ $blog->title }}" class="img img-fluid" style="height: 12.5rem;">
			</div>
			
			<div class="card-body">
				{!! $blog->content !!}
			</div>
		</div>
	</div>

	<div class="col-md-3 d-none d-md-block">
		<div class="border rounded border-muted">
			@if ($otherBlogs)
			<h4 class="text-center my-3">Other Latest Blogs</h4>
			<hr class="hr-thick">

			@foreach ($otherBlogs as $b)
			<a href="{{ route('blogs.show', [$b->slug]) }}" class="position-relative d-flex flex-column m-3 border rounded">
				<div class="d-flex rounded">
					<img src="{{ $b->getPoster() }}" alt="Poster for {{ $b->title }}" class="img img-fluid mx-auto" style="max-height: 12.5rem;">
				</div>

				<div class="position-absolute visible-on-hover w-100 h-100">
					<div class="position-absolute bg-dark w-100 h-100 rounded" style="z-index: 0; opacity: 75%;"></div>
					<div class="position-relative p-2 text-light rounded" style="z-index: 1;">
						<h2>{{ $b->title }}</h2>
						<hr class="hr-thick border-light">

						<p class="text-truncate-6">{{ $b->summary }}</p>
					</div>
				</div>
			</a>
			@endforeach
			@else
			<h4 class="text-center my-3">There are currently no other blogs aside from this.</h4>
			@endif
		</div>
	</div>
</div>

@section('css')
@livewireStyles
@endsection