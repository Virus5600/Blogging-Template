@section('title', "Blogs - {$blog->title}")

<div class="container-fluid pb-5">
	<div class="row">
		<div class="col-12 col-md mt-3">
			<div class="row">
				{{-- Header --}}
				<div class="col-12">
					<h1>
						<a href="{{ route('admin.blogs.index') }}" class="text-dark text-decoration-none font-weight-normal">
							<i class="fas fa-chevron-left mr-2"></i>Blogs
						</a>
					</h1>
				</div>
			</div>
		</div>
	</div>

	<hr class="hr-thick">

	<div class="row justify-content-center">
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
					<img src="{{ $blog->getPoster() }}" alt="Poster for {{ $blog->title }}" class="img img-fluid" style="height: 12.5rem;" data-fallback-img="{{ asset('/storage/uploads/blogs/default.png') }}">
				</div>
				
				<div class="card-body text-wrap">
					{!! $blog->content !!}
				</div>

				<div class="card-footer">
					<div class="d-flex flex-row justify-content-center">
						<a href="{{ route('admin.blogs.edit', [$blog->slug]) }}" class="btn btn-primary mx-2">Edit</a>
						<a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary mx-2">Go Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>