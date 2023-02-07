@section('title', 'Blogs')

<div class="d-flex flex-column">
	{{-- HEADER --}}
	<div class="row">
		<div class="col-12 col-lg-8">
			<h2 class="align-middle">Blogs</h2>
		</div>

		<div class="col-12 col-lg-4 d-flex">
			{{-- ADD --}}
			<a href="{{ route('admin.blogs.create') }}" class="btn btn-success my-auto mx-1">
				<i class="fas fa-plus-circle mr-2"></i>Add Blog
			</a>

			{{-- SEARCH --}}
			<form class="input-group my-auto mx-1" wire:submit.prevent="search">
				<input type="text" class="form-control" placeholder="Press / to search" accesskey="/" wire:model="search" data-input-focus="/" data-input-focused-placeholder="Search...">

				<div class="input-group-append">
					<button type="submit" class="btn btn-secondary">
						<i class="fas fa-magnifying-glass" title="Search"></i>
					</button>
				</div>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card shadow m-3">
				<table class="table table-stripped">
					<thead>
						<tr>
							<th class="text-center">Poster</th>
							<th class="text-center">Title</th>
							<th class="text-center">Summary</th>
							<th class="text-center"></th>
						</tr>
					</thead>

					<tbody>
						@forelse ($blogs as $b)
						<tr class="enlarge-on-hover">
							<td class="text-center align-middle">
								<img src="{{ $b->getPoster() }}" class="img img-fluid" style="max-height: 2.5rem;">
							</td>

							<td class="text-center align-middle font-weight-bold">{{ $b->title }}</td>
							<td class="text-center align-middle">{{ $b->summary }}</td>

							<td class="text-center align-middle">
								<div class="dropdown">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions</button>
								</div>

								<div class="dropdown-menu">
									{{-- EDIT --}}
									<a href="#" class="dropdown-item">
										<i class="fas fa-pencil mr-2"></i>Edit
									</a>
									
									{{-- DRAFT --}}
									@if ($b->is_draft)
									<a href="#" class="dropdown-item">
										<i class="fas fa-upload mr-2"></i>Publish
									</a>
									@else
									<a href="#" class="dropdown-item">
										<i class="fas fa-note-sticky mr-2"></i>Draft
									</a>
									@endif
									
									{{-- DELETE --}}
									@if ($b->isTrashed())
									<a href="#" class="dropdown-item">
										<i class="fas fa-recycle mr-2"></i>Restore
									</a>
									@else
									<a href="#" class="dropdown-item">
										<i class="fas fa-trash mr-2"></i>Delete
									</a>
									@endif
								</div>
							</td>
						</tr>
						@empty
						<tr class="enlarge-on-hover">
							<td colspan="4" class="text-center align-middle">Nothing to show~</td>
						</tr>
						@endforelse
					</tbody>

					<tfoot>
						<tr>
							<td colspan="4">
								{{ $blogs->links() }}
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

@section('scripts')
<script type="text/javascript" src="{{ asset('js/util/input-focus.js') }}"></script>
@endsection