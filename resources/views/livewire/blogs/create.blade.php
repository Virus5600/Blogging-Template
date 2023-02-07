@section('title', 'Blogs')

<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-md mt-3">
			<div class="row">
				{{-- Header --}}
				<div class="col-12">
					<h1>
						<a href="javascript:void(0);" onclick="confirmLeave('{{ route('admin.blogs.index') }}');" class="text-dark text-decoration-none font-weight-normal">
							<i class="fas fa-chevron-left mr-2"></i>Blogs
						</a>
					</h1>
				</div>
			</div>
		</div>
	</div>

	<hr class="hr-thick">

	<div class="d-flex flex-column">
		<form wire:submit.prevent="create">
			{{ csrf_field() }}

			{{-- POSTER --}}
			<div class="row">
				<div class="col-12 col-lg-6">
					<div class="form-group text-center text-lg-left w-100" style="max-height: 20rem;">
						<label for="image" class="h5">Blog Poster</label><br>
						<img src="{{ $poster ? $poster->temporaryUrl() : asset('uploads/blogs/default.png') }}" alt="Blog Poster" class="img-fluid cursor-pointer border" style="border-width: 0.25rem!important; max-height: 16.25rem;" id="image" data-img-fallback="{{ asset('uploads/blogs/default.png') }}">
						<input type="file" name="image" wire:model="poster" class="d-none" accept=".jpg,.jpeg,.png,.webp"><br>
						<small class="text-muted pt-0 mt-0"><b>ALLOWED FORMATS:</b> JPEG, JPG, PNG, WEBP</small><br>
						<small class="text-muted pt-0 mt-0"><b>MAX SIZE:</b> 10MB</small><br>
						@error('poster')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
				</div>

				<div class="col-12 col-lg-6">
					{{-- TITLE --}}
					<div class="form-group">
						<label for="title" class="h5">Title</label>
						<input type="text" class="form-control" wire:model="title">
						@error('title')
						<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>

					{{-- SUMMARY --}}
					<div class="form-group">
						<label for="summary" class="h5">Summary</label>
						<textarea rows="4" class="form-control not-resizable text-counter-input" wire:model="summary" data-max="255"></textarea>
					</div>

					{{-- DRAFT --}}
					<div class="form-group my-auto">
						<div class="custom-control custom-switch custom-switch-md">
							<input type="checkbox" class="custom-control-input" id="is-draft" wire:model="is_draft">
							<label for="is-draft" class="custom-control-label pt-1 pl-3">Mark as Draft?</label>
						</div>
					</div>
				</div>
			</div>

			<hr class="hr-thick">

			<div class="row">
				<div class="col" wire:ignore>
					<label for="content" class="h5">Content</label>
					<textarea rows="5" class="summernote" id="content">{!! $content !!}</textarea>
				</div>
			</div>

			<div class="row py-3">
				<div class="col">
					<button class="btn btn-success ml-auto" type="submit">Submit</button>
					<a href="javascript:void(0);" onclick="confirmLeave('{{ route('admin.blogs.index') }}')" class="btn btn-danger ml-3 mr-auto">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/util/custom-switch.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/util/text-counter.css') }}" />
<style type="text/css">
	.note-toolbar {
		display: flex;
		flex-wrap: wrap;
		align-content: center;
	}
</style>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/util/text-counter.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/util/confirm-leave.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// Profile Image Changing
		$("#image").on("click", function() { $(`[name="${$(this).attr("id")}"]`).trigger("click"); });

		// Summernote
		$('.summernote').summernote({
			minHeight: 128,
			maxHeight: 384,
			height: 256,
			dialogsInBody: true,
			placeholder: 'Content goes here...',
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'underline', 'clear']],
				['fontname', ['fontname', 'fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['link', 'hr', 'picture', 'video']],
				['view', ['fullscreen', 'codeview', 'help']],
				['history', ['undo', 'redo']]
			],
			popover: {
				image: [
					['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
					['float', ['floatLeft', 'floatRight', 'floatNone']],
					['remove', ['removeMedia']]
				],
				air: [
					['insert', ['link']],
				],
				link: [
					['link', ['linkDialogShow', 'unlink']]
				]
			},
			callbacks: {
				onChange: (content, editable) => {
					@this.set('content', content);
				}
			},
		});
	});
</script>
@endsection