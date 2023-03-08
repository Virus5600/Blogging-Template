@section('title', 'Users')

@section('meta')
<meta name="csrf_token" value="{{ csrf_token() }}"/>
@endsection

@php
$settings = [
	'default-avatar' => App\Models\User::getDefaultAvatar()
];
@endphp

<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-md mt-3">
			<div class="row">
				{{-- Header --}}
				<div class="col-12">
					<h1>
						<a href="#" data-confirm-leave="{{ route('admin.users.index') }}" class="text-dark text-decoration-none font-weight-normal">
							<i class="fas fa-chevron-left mr-2"></i>Users
						</a>
					</h1>
				</div>
			</div>
		</div>
	</div>

	<hr class="hr-thick">

	<div class="row">
		<div class="col-12 col-md-8 mx-auto">
			<div class="card dark-shadow mb-5" id="inner-content">
				<div class="card-body">
					<div class="row">
						{{-- AVATAR --}}
						<div class="col-12 col-lg-6 mx-auto">
							<div class="image-input-scope" id="avatar-scope" data-settings="#image-input-settings" data-fallback-img="{{ $settings["default-avatar"] }}">
								{{-- FILE IMAGE --}}
								<div class="form-group text-center image-input collapse show avatar_holder" id="avatar-image-input-wrapper">
									<label class="form-label font-weight-bold" for="avatar">User Image</label><br>
									<div class="hover-cam mx-auto avatar circular-border overflow-hidden">
										<img src="{{ gettype($avatar) == 'string' ? $avatar : $avatar->temporaryUrl() }}" class="hover-zoom img-fluid avatar" id="avatar-file-container" alt="User Avatar" data-default-src="{{ $settings["default-avatar"] }}">
										<span class="icon text-center image-input-float" id="avatar" tabindex="0" wire:loading.class="d-none" wire:target="avatar">
											<i class="fas fa-camera text-white hover-icon-2x"></i>
										</span>

										<span class="icon text-center image-input-float d-none" id="avatar" tabindex="0" wire:loading.class.remove="d-none" wire:target="avatar">
											<i class="fas fa-camera text-white hover-icon-2x"></i>
										</span>
									</div>
									<input type="file" wire:model.lazy="avatar" name="avatar" class="d-none" accept=".jpg,.jpeg,.png,.webp" data-target-image-container="#avatar-file-container" data-target-name-container="#avatar-name" value="{{ gettype($avatar) == 'string' ? $avatar : $avatar->temporaryUrl() }}">
									<h6 id="avatar-name" class="text-truncate w-50 mx-auto" data-default-name="default.png">{{ gettype($avatar) == 'string' ? $avatar : "default.png" }}</h6>
									<small class="text-muted pb-0 mb-0">
										<b>ALLOWED FORMATS:</b>
										<br>JPEG, JPG, PNG, WEBP
									</small><br>
									<small class="text-muted pt-0 mt-0"><b>MAX SIZE:</b> 5MB</small>
								</div>
							</div>

							{{-- LOGO ERROR --}}
							<div class="text-center">
								<span class="text-danger small text-wrap">{{ $errors->first('avatar') }}</span>
							</div>
						</div>

						<div class="col-12 col-lg-6">
							<div class="row">
								{{-- FIRST NAME --}}
								<div class="form-group col-6">
									<label class="form-label" for="first_name">First Name</label>
									<input type="text" id="first_name" wire:model.lazy="first_name" class="form-control" placeholder="First Name" value="{{ $first_name }}" />
									<span class="text-danger small text-wrap">{{ $errors->first('first_name') }}</span>
								</div>

								{{-- MIDDLE NAME --}}
								<div class="form-group col-6">
									<label class="form-label" for="middle_name">Middle Name</label>
									<input type="text" id="middle_name" wire:model.lazy="middle_name" class="form-control" placeholder="Middle Name" value="{{ $middle_name }}" />
									<span class="text-danger small text-wrap">{{ $errors->first('middle_name') }}</span>
								</div>

								{{-- LAST NAME --}}
								<div class="form-group col-6">
									<label class="form-label" for="last_name">Last Name</label>
									<input type="text" id="last_name" wire:model.lazy="last_name" class="form-control" placeholder="Last Name" value="{{ $last_name }}" />
									<span class="text-danger small text-wrap">{{ $errors->first('last_name') }}</span>
								</div>

								{{-- SUFFIX --}}
								<div class="form-group col-6">
									<label class="form-label" for="suffix">Suffix</label>
									<input type="text" id="suffix" wire:model.lazy="suffix" class="form-control" placeholder="Suffix" value="{{ $suffix }}" />
									<span class="text-danger small text-wrap">{{ $errors->first('suffix') }}</span>
								</div>

								{{-- BIRTHDATE --}}
								<div class="form-group col-6">
									<label class="form-label" for="birthdate">Birthdate</label>
									<input type="date" id="birthdate" wire:model.lazy="birthdate" class="form-control" placeholder="Birthdate" value="{{ $birthdate }}" max="{{ now()->format("Y-m-d") }}"/>
									<span class="text-danger small text-wrap">{{ $errors->first('birthdate') }}</span>
								</div>

								{{-- EMAIL --}}
								<div class="form-group col-6">
									<label class="form-label" for="email">Email</label>
									<input type="email" id="email" wire:model.lazy="email" class="form-control" placeholder="Email" value="{{ $email }}" />
									<span class="text-danger small text-wrap">{{ $errors->first('email') }}</span>
								</div>

								{{-- USERNAME --}}
								<div class="form-group col-12">
									<label class="form-label" for="username">Username</label>
									<input type="username" id="username" wire:model.lazy="username" class="form-control" placeholder="Username" value="{{ $username }}" />
									<span class="text-danger small text-wrap">{{ $errors->first('username') }}</span>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-6 mx-auto ml-lg-auto d-flex flex-row">
							<button class="btn btn-success ml-auto" type="button" id="submitButton">Submit</button>
							<button data-confirm-leave="{{route('admin.users.index')}}" class="btn btn-danger ml-3 mr-auto">Cancel</button>

							<button class="d-none" type="hidden" id="actualSubmitButton" wire:click="update"></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/util/image-input.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/util/custom-switch.css') }}" />
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/util/confirm-leave.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/util/disable-on-submit.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/util/image-input.js') }}"></script>
<script type="text/javascript" nonce="{{ csp_nonce() }}">
	$(document).ready(() => {
		$(`#submitButton`).on(`click`, (e) => {
			$(`#actualSubmitButton`).click();
		});
	});
</script>
@endsection