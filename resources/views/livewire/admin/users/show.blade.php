@section('title', "User - @{$user->username}")

@php
$auth = auth()->user();

$authLvl = $auth->userType->authority_level;
$isOwner = $authLvl == 1;

$editAllowed = $auth->hasPermission('users_tab_access', 'users_tab_edit');
@endphp

<div class="container-fluid pb-5">
	<div class="row">
		<div class="col-12 col-md mt-3">
			<div class="row">
				{{-- Header --}}
				<div class="col-12">
					<h1>
						<a href="{{ route('admin.users.index') }}" class="text-dark text-decoration-none font-weight-normal">
							<i class="fas fa-chevron-left mr-2"></i>Users
						</a>
					</h1>
				</div>
			</div>
		</div>
	</div>

	<hr class="hr-thick">

	<div class="row justify-content-center">
		<div class="col-12 col-md-10 col-lg-8 mx-auto">
			<div class="card floating-title mt-4 border-secondary">
				<h3 class="card-title text-left m-0 p-2">{{ $user->getName()  }}</h3>
				
				<div class="card-body">
					<img src="{{ $user->getAvatar() }}" alt="{{ $user->username }}'s avatar" class="img img-thumbnail w-50 w-md-25 mx-auto d-block mb-3" draggable="false" data-toggle="modal" data-target="#avatar-modal" id="avatar">

					<ul class="list-group">
						@foreach($format as $k => $v)
						<li class="list-group-item">
							<div class="d-flex flex-row flex-wrap">
								<div class="text-left px-2 font-weight-bold mr-auto">{{ $v }}</div>
								
								<div class="text-right px-2 ml-auto">
									@if (in_array($k, ["locked"]))
									{{ $user->$k == 0 ? "False" : "True" }}
									@elseif (in_array($k, ["last_auth"]))
									{{ $user->$k }}
									@else
									{!! $user->$k ? $user->$k : "<i class='text-muted'>(N/A)</i>" !!}
									@endif
								</div>
							</div>
						</li>
						@endforeach
					</ul>
				</div>

				<div class="card-footer text-right">
					@if (($editAllowed || $user->id == $auth->id) && (($user->userType->authority_level >= $authLvl) || $isOwner))
					<a href="{{ route('admin.users.edit', [$user->username]) }}" class="btn btn-primary">Edit</a>
					@endif
					<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Go Back</a>
				</div>
			</div>
		</div>
	</div>
</div>

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/components.css') }}">
@endsection

@section('modals')
<div id="avatar-modal" class="modal fade" tabindex="-1" aria-labelledby="avatar" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="avatar">{{ $user->username }}'s Avatar</h5>
				
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="fas fa-times"></i></span>
				</button>
			</div>
			
			<div class="modal-body">
				<img src="{{ $user->getAvatar() }}" alt="{{ $user->username }}'s avatar" class="img img-fluid" draggable="false">
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endsection