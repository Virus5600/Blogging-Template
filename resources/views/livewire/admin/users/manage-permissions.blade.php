@section('title', 'Users')

@section('meta')
<meta name="csrf_token" value="{{ csrf_token() }}"/>
@endsection

<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-md mt-3">
			<div class="row">
				{{-- Header --}}
				<div class="col-12">
					<h1>
						<a href="javascript:void(0);" data-confirm-leave='{{route('admin.users.index')}}' class="text-dark text-decoration-none font-weight-normal">
							<i class="fas fa-chevron-left mr-2"></i>Users
						</a>
					</h1>
				</div>
			</div>
		</div>
	</div>

	<hr class="hr-thick">

	<div class="row">
		<div class="col-12 col-md-11 col-lg-10 mx-auto">
			<div class="card dark-shadow mb-5" id="inner-content">
				<h4 class="card-header">
					{{ $user->getName() }} is {{ $user->isUsingTypePermissions() ? 'using account role permissions (Default)' : 'using user permissions (Custom)' }}
				</h4>

				<div class="card-body">
					<input type="hidden" name="from" value="{{ $from }}"/>

					{{-- GENERAL VALIDATION MESSAGE --}}
					@error("*")
						@foreach($errors->get() as $e)
						<div class="alert alert-danger alert-dismissable fade show text-wrap">
							<button type="buttone" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
							{!! $e !!}
						</div>
						@endforeach
					@enderror

					@php($listed_perms = array())
					@foreach($permissionList as $p)
						@if (!in_array($p->slug, $listed_perms))
						<div class="row my-2">
							<div class="col-12">
								<div class="card">
									<div class="card-body">
										{{-- PERMISSION PARENT --}}
										<div class="form-check col-12">
											<input type="checkbox" name="permissions[]" id="perms_{{ $p->slug }}" data-id="{{ $p->id }}" {{ $user->hasPermission($p->slug) ? 'checked' : '' }} value="{{ $p->id }}" {{ ($pp = $p->parentPermission()) != null ? "data-parent=#perms_{$pp->slug}" : "" }}>
											<label class="form-label font-weight-bold" for="perms_{{ $p->slug }}">
												{{ $p->name }}
												
												@if ($pp != null)
													<span class="badge badge-info">Child of {{ $pp->name }}</span>
												@endif
											</label>
										</div>

										{{-- PERMISSION CHILD --}}
										@foreach($p->childPermissions() as $cp)
											@if (count($cp->childPermissions()) > 0)
												@continue
											@endif

											<div class="form-check col-12 ml-4">
												<input type="checkbox" name="permissions[]" id="perms_{{ $cp->slug }}" data-id="{{ $cp->id }}" {{ $user->hasPermission($cp->slug) ? 'checked' : '' }} value="{{ $cp->id }}" data-parent="#perms_{{ $p->slug }}">
												<label class="form-label" for="perms_{{ $cp->slug }}">{{ $cp->name }}</label>
											</div>
											@php(array_push($listed_perms, $cp->slug))
										@endforeach
									</div>
								</div>
							</div>
							@php(array_push($listed_perms, $p->slug))
						</div>
						@endif
					@endforeach

					<div class="row">
						<div class="col-6 mx-auto ml-lg-auto d-flex flex-row">
							<button class="btn btn-success ml-auto" type="submit" data-action="update" id="submitButton">Submit</button>
							<button data-confirm-leave='revertPermission,{{ $user->username }}' data-confirm-leave-title='Restore Permissions?'  data-confirm-leave-message='Use user type permissions?' data-confirm-leave-livewire="@this" class="btn btn-primary mx-3 di {{ $user->isUsingTypePermissions() ? 'disabled' : '' }}"><i class="fas fa-undo mr-2"></i>Reset Permission</a>
							<button data-confirm-leave="{{$from}}" class="btn btn-danger mr-auto">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@section('scripts')
<script type="text/javascript" src="{{ asset('js/util/confirm-leave.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/util/disable-on-submit.js') }}"></script>
<script type="text/javascript" nonce="{{ csp_nonce() }}">
	$(document).ready(() => {
		$("#submitButton").not(":disabled").on('click', (e) => {
			let perms = [];
			$('input[name="permissions[]"]:checked').each((k, v) => {
				perms.push($(v).val());
			});

			@this.call('update', perms);
		});

		window.addEventListener("update-failed", () => {
			$("[data-action]").prop('disabled', false)
				.removeClass("disabled");
		});

		let pp = [];
		$.each($(`[data-parent]`), (k, v) => {
			let obj = $(v).attr('data-parent');
			if (!pp.includes(obj)) {
				pp.push(obj);

				let parent = $(obj);
				parent.on('click change', (e) => {
					let p = $(e.currentTarget);
					if (!p.prop('checked')) {
						$(`[data-parent="#${p.attr('id')}"]`)
							.prop('checked', false)
							.trigger('change');
					}
				});
			}

			$(v).on('click change', (e) => {
				let p = $(e.currentTarget);
				let target = $(v).attr('data-parent');

				let isThereChecked = false;
				$.each($(`[data-parent="${target}"]`), (kk, vv) => {
					isThereChecked = isThereChecked || $(vv).prop('checked');
				});

				if (!isThereChecked) {
					target = $(target);
					target.prop('checked', false);
					
					if (typeof target.attr('data-parent') != 'undefined') {
						$(target.attr('data-parent')).prop('checked', false);
					}
				}
				else {
					target = $(target);
					target.prop('checked', true);

					if (typeof target.attr('data-parent') != 'undefined') {
						$(target.attr('data-parent')).prop('checked', true);
					}
				}
			});
		});

		window.addEventListener('refresh-inputs', (e) => {
			let permissions = e.detail.permissions;
			let obj = $('input[name="permissions[]"]');
			
			obj.prop('checked', false);
			obj.removeAttr('checked');

			for (i = 0; i < obj.length; i++) {
				let elm = $(obj[i]);
				if (permissions.includes(parseInt(elm.attr('data-id')))) {
					elm.prop('checked', true);
				}
			}
		});
	});
</script>
@endsection