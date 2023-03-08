@section('title', 'Blogs')

<div class="d-flex flex-column">
	{{-- HEADER --}}
	<div class="row">
		<div class="col-4 col-lg-8">
			<h2 class="align-middle">Blogs</h2>
		</div>

		<div class="col-8 col-lg-4 d-flex">
			{{-- ADD --}}
			<a href="{{ route('admin.blogs.create') }}" class="btn btn-success my-auto mx-1">
				<i class="fas fa-plus-circle mr-2"></i>Add Blog
			</a>

			{{-- SEARCH --}}
			<div class="input-group my-auto mx-1">
				<input type="text" class="form-control" placeholder="Press / to search" accesskey="/" wire:model.lazy="search" data-input-focus="/" data-input-focused-placeholder="Search...">

				<div class="input-group-append">
					<button type="button" class="btn btn-secondary" wire:click="render">
						<i class="fas fa-magnifying-glass" title="Search"></i>
					</button>
				</div>
			</div>
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
							<th class="text-center">Status</th>
							<th class="text-center"></th>
						</tr>
					</thead>

					<tbody>
						@forelse ($blogs as $b)
						<tr class="enlarge-on-hover">
							<td class="text-center align-middle">
								<img src="{{ $b->getPoster() }}" class="img img-fluid" style="max-height: 2.5rem;" data-fallback-img="{{ asset("storage/uploads/blogs/default.png") }}">
							</td>

							<td class="text-center align-middle font-weight-bold">{{ $b->title }}</td>
							<td class="text-center align-middle">{{ $b->summary }}</td>
							
							<td class="text-center align-middle">
								@if ($b->trashed())
								<i class="fas fa-circle text-danger mr-2"></i>Deleted
								@else
									@if ($b->is_draft)
									<i class="fas fa-circle text-info mr-2"></i>Draft
									@else
									<i class="fas fa-circle text-success mr-2"></i>Published
									@endif
								@endif
							</td>

							<td class="text-center align-middle">
								<div class="dropdown">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions</button>
									
									<div class="dropdown-menu dropdown-menu-right">
										{{-- SHOW --}}
										<a href="{{ route('admin.blogs.show', [$b->slug]) }}" class="dropdown-item">
											<i class="fas fa-eye mr-2"></i>View
										</a>

										{{-- EDIT --}}
										<a href="{{ route('admin.blogs.edit', [$b->slug]) }}" class="dropdown-item">
											<i class="fas fa-pencil mr-2"></i>Edit
										</a>
										
										{{-- DRAFT --}}
										@if ($b->is_draft)
										<button class="dropdown-item" wire:click="publish({{ $b->id }})">
											<i class="fas fa-upload mr-2"></i>Publish
										</a>
										@else
										<button class="dropdown-item" wire:click="draft({{ $b->id }})">
											<i class="fas fa-note-sticky mr-2"></i>Draft
										</a>
										@endif
										
										{{-- DELETE --}}
										@if ($b->trashed())
										<button class="dropdown-item" wire:click="restore({{ $b->id }})">
											<i class="fas fa-recycle mr-2"></i>Restore
										</a>
										@else
										<button class="dropdown-item" wire:click="delete({{ $b->id }})">
											<i class="fas fa-trash mr-2"></i>Delete
										</a>
										@endif
									</div>
								</div>
							</td>
						</tr>
						@empty
						<tr class="enlarge-on-hover">
							<td colspan="5" class="text-center align-middle">Nothing to show~</td>
						</tr>
						@endforelse
					</tbody>

					<tfoot>
						<tr>
							<td colspan="5">
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