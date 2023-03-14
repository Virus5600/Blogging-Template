@section('title', 'Users')

@php
$user = auth()->user();

$authLvl = $user->userType->authority_level;
$isOwner = $authLvl == 1;

$ownerAllow = $user->hasPermission('change_owner');
$createAllowed = $user->hasPermission('users_tab_access', 'users_tab_create');
$editAllowed = $user->hasPermission('users_tab_access', 'users_tab_edit');
$permissionAllowed = $user->hasPermission('users_tab_access', 'users_tab_permissions');
$deleteAllowed = $user->hasPermission('users_tab_access', 'users_tab_delete');
@endphp

<div class="d-flex flex-column" livewire-component>
	{{-- HEADER --}}
	<div class="row">
		<div class="col-4 col-lg-8">
			<h2 class="align-middle">Users</h2>
		</div>

		<div class="col-8 col-lg-4 d-flex">
			{{-- ADD --}}
			@if ($createAllowed)
			<a href="{{ route('admin.users.create') }}" class="btn btn-success my-auto mx-1">
				<i class="fas fa-plus-circle mr-2"></i>Add User
			</a>
			@endif

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
							<th class="text-center">Avatar</th>
							<th class="text-center">Name</th>
							<th class="text-center">Email</th>
							<th class="text-center">Status</th>
							<th class="text-center"></th>
						</tr>
					</thead>

					<tbody>
						@forelse ($users as $u)
						<tr class="enlarge-on-hover">
							<td class="text-center align-middle">
								<img src="{{ $u->getAvatar() }}" class="img img-fluid" style="max-height: 2.5rem;" data-fallback-img="{{ asset("storage/uploads/users/default.png") }}" alt="{{ $u->getName() }}'s Avatar">
							</td>

							<td class="text-center align-middle font-weight-bold">
								{{ $u->getName() }}
							</td>

							<td class="text-center align-middle">
								<a href="mailto:{{ $u->email }}" title="Send an email to {{ $u->email }}">
									{{ $u->email }}
								</a>
							</td>
							
							<td class="text-center align-middle">
								@if ($u->trashed())
								<i class="fas fa-circle text-danger mr-2"></i>Inactive
								@else
									@if ($u->locked)
									<i class="fas fa-circle text-danger mr-2"></i>Locked
									@else
									<i class="fas fa-circle text-success mr-2"></i>Active
									@endif
								@endif
							</td>

							<td class="text-center align-middle">
								<div class="dropdown">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Actions</button>
									
									<div class="dropdown-menu dropdown-menu-right">
										{{-- SHOW --}}
										<a href="{{ route('admin.users.show', [$u->username]) }}" class="dropdown-item">
											<i class="fas fa-eye mr-2"></i>View
										</a>

										{{-- EDIT --}}
										@if (($editAllowed || $u->id == $user->id) && (($u->userType->authority_level >= $authLvl) || $isOwner))
										<a href="{{ route('admin.users.edit', [$u->username]) }}" class="dropdown-item">
											<i class="fas fa-pencil mr-2"></i>Edit
										</a>
										@endif

										{{-- PERMISSIONS --}}
										@if ($permissionAllowed && (($u->userType->authority_level > $authLvl) || $isOwner || $u->id == $user->id))
										<a href="{{ route('admin.users.manage-permissions', [$u->username]) }}" class="dropdown-item">
											<i class="fas fa-user-lock mr-2"></i>Manage Permissions
										</a>
										@endif
										
										{{-- CHANGE PASSWORD --}}
										@if ((($editAllowed || $isOwner) && ($u->userType->authority_level > $authLvl)) || $u->id == $user->id)
										<button class="dropdown-item change-password" id="scp-{{ $u->id }}" data='{"preventDefault": true, "name": "{{ $u->getName() }}",}'>
											<i class="fas fa-lock mr-2"></i>Change Password
											<script type="text/javascript" nonce="{{ csp_nonce() }}">
												$(document).ready(() => {
													let data = `{
														"preventDefault": true,
														"name": "{{ $u->getName() }}",
														"targetURI": "changePassword,{{ $u->username }}",
														"notify": false,
														"show_notify": false,
														"for": "#tr-{{ $u->id }}",
														"isLivewire": true,
														"livewireComponent": "@this"
													}`;
													$('#scp-{{ $u->id }}').attr("data-scp", data);
													$('#scp-{{ $u->id }}').find('script').remove();
												});
											</script>
										</button>
										@endif
										
										{{-- STATUS --}}
										@if (($deleteAllowed || $u->id == $user->id || $isOwner) && ($u->userType->authority_level > $authLvl))
											@if ($u->id != 1)
												@if ($u->trashed())
												<button class="dropdown-item" data-confirm-leave="activate,{{ $u->username }}" data-confirm-leave-message="{{ auth()->user()->id == $u->id ? "This will re-activate your account once more, allowing you to log back in using your account" : "This will re-activate the account once more, allowing the user to log back in using their account" }}" data-confirm-leave-livewire="@this">
													<i class="fas fa-toggle-on mr-2"></i>Re-Activate
												</button>
												@else
												<button class="dropdown-item" data-confirm-leave="deactivate,{{ $u->username }}" data-confirm-leave-message="{{ auth()->user()->id == $u->id ? "This will deactivate your account, logging you out forcibly and prevent you from accessing this account while deactivated" : "This will deactivate the account, logging them out forcibly on their next action and prevents them from accessing their account while deactivated" }}" data-confirm-leave-livewire="@this">
													<i class="fas fa-toggle-off mr-2"></i>Deactivate
												</button>
												@endif
											@endif
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
				</table>

				<div id="table-paginate" class="w-100 d-flex align-middle my-3">
					{{ $users->onEachSide(2)->links() }}
				</div>
			</div>
		</div>
	</div>
</div>

@section('scripts')
<script type="text/javascript" src="{{ asset('js/util/input-focus.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/util/confirm-leave.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/util/swal-change-password.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/util/password-visibility-toggler.js') }}"></script>
@endsection