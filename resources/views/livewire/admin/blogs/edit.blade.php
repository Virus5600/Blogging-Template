@section('title', 'Blogs')

@section('meta')
<meta name="csrf_token" value="{{ csrf_token() }}"/>
@endsection

<div class="container-fluid pb-5">
	<div class="row">
		<div class="col-12 col-md mt-3">
			<div class="row">
				{{-- Header --}}
				<div class="col-12">
					<h1>
						<a href="#" data-confirm-leave="{{ route('admin.blogs.index') }}" class="text-dark text-decoration-none font-weight-normal">
							<i class="fas fa-chevron-left mr-2"></i>Blogs
						</a>
					</h1>
				</div>
			</div>
		</div>
	</div>

	<hr class="hr-thick">

	<div class="d-flex flex-column">
		{{-- POSTER --}}
		<div class="row">
			<div class="col-12 col-lg-6">
				<div class="form-group text-center text-lg-left w-100" style="max-height: 22.5rem;">
					<label for="image" class="h5">Blog Poster</label><br>
					<img src="{{ $poster ? $poster->temporaryUrl() : $blog->getPoster() }}" alt="Blog Poster" class="img-fluid cursor-pointer border" style="border-width: 0.25rem!important; max-height: 16.25rem;" id="image" data-img-fallback="{{ asset('uploads/blogs/default.png') }}">
					<input type="file" name="image" wire:model.lazy="poster" class="d-none" accept=".jpg,.jpeg,.png,.webp"><br>
					<small class="text-muted pt-0 mt-0"><b>ALLOWED FORMATS:</b> JPEG, JPG, PNG, WEBP</small><br>
					<small class="text-muted pt-0 mt-0"><b>MAX SIZE:</b> 10MB</small><br>
					@if ($errors->has('poster'))
					<span class="text-danger text-wrap">{{ $errors->first('poster') }}</span>
					@endif
				</div>
			</div>

			<div class="col-12 col-lg-6">
				{{-- TITLE --}}
				<div class="form-group">
					<label for="title" class="h5 important">Title</label>
					<input type="text" class="form-control" wire:model.lazy="title" value="{{ $title }}">
					@if ($errors->has('title'))
					<span class="text-danger text-wrap">{{ $errors->first('title') }}</span>
					@endif
				</div>

				{{-- SUMMARY --}}
				<div class="form-group text-counter-parent">
					<label for="summary" class="h5">Summary</label>
					<textarea rows="4" class="form-control not-resizable text-counter-input" wire:model.lazy="summary" data-max="255">{{ $summary }}</textarea>
					<span class="text-counter small" wire:ignore>255</span>
					@if ($errors->has('summary'))
					<span class="text-danger text-wrap">{{ $errors->first('summary') }}</span>
					@endif
				</div>

				{{-- DRAFT --}}
				<div class="form-group my-auto">
					<div class="custom-control custom-switch custom-switch-md">
						<input type="checkbox" class="custom-control-input" id="is-draft" wire:model.lazy="is_draft" {{ $is_draft ? "checked" : "" }}>
						<label for="is-draft" class="custom-control-label pt-1 pl-3">Mark as Draft?</label>
					</div>
					
					@if ($errors->has('is_draft'))
					<span class="text-danger text-wrap">{{ $errors->first('is_draft') }}</span>
					@endif
				</div>
			</div>
		</div>

		<hr class="hr-thick">

		<div class="row">
			<div class="col">
				<div wire:ignore>
					<label for="content" class="h5 important">Content</label>
					<textarea rows="5" class="summernote" id="content" wire:model.lazy="content">{!! $content !!}</textarea>
				</div>
				@if ($errors->has('content'))
				<span class="text-danger text-wrap">{{ $errors->first('content') }}</span>
				@endif
			</div>
		</div>

		<div class="row py-3">
			<div class="col">
				<button class="btn btn-success ml-auto" type="button" id="submitButton">Update</button>
				<button data-confirm-leave="{{ route('admin.blogs.index') }}" class="btn btn-danger ml-3 mr-auto">Cancel</a>

				<button class="d-none" type="hidden" id="actualSubmitButton" wire:click="update"></button>
			</div>
		</div>
	</div>
</div>

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/util/custom-switch.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/util/text-counter.css') }}" />
<style type="text/css" nonce="{{ csp_nonce() }}">
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
<script type="text/javascript" nonce="{{ csp_nonce() }}">
	/* Source: https://davidwalsh.name/javascript-debounce-function
	 * Returns a function, that, as long as it continues to be invoked, will not
	 * be triggered. The function will be called after it stops being called for
	 * N milliseconds. If `immediate` is passed, trigger the function on the
	 * leading edge, instead of the trailing.
	 */
	const debounce = (func, wait, immediate) => {
		var timeout;
		return function() {
			var context = this, args = arguments;
			var later = function() {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	};

	$(document).ready(function() {
		// Profile Image Changing
		$("#image").on("click", function() { $(`[name="${$(this).attr("id")}"]`).trigger("click"); });

		// Summernote
		$('textarea#content.summernote').summernote({
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
				['view', ['codeview', 'help']],
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
					let fn = debounce(function(content) {
						@this.set('content', content);
					}, 250);

					fn(content);
				}
			}
		});

		$(`#submitButton`).on(`click`, (e) => {
			let content = $(`textarea#content.summernote`);
			$(`#actualSubmitButton`).click();
		});
	});
</script>
@endsection