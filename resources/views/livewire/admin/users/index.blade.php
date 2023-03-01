@section('title', 'Users')

<div class="d-flex flex-column" livewire-component>
	{{-- HEADER --}}
	<div class="row">
		<div class="col-4 col-lg-8">
			<h2 class="align-middle">Users</h2>
		</div>

		<div class="col-8 col-lg-4 d-flex">
			{{-- ADD --}}
			<a href="{{ route('admin.users.create') }}" class="btn btn-success my-auto mx-1">
				<i class="fas fa-plus-circle mr-2"></i>Add User
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
							<th class="text-center">Avatar</th>
							<th class="text-center">Name</th>
							<th class="text-center">email</th>
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
										<a href="{{ route('admin.users.edit', [$u->username]) }}" class="dropdown-item">
											<i class="fas fa-pencil mr-2"></i>Edit
										</a>
										
										{{-- CHANGE PASSWORD --}}
										<a href="javascript:void(0);" class="dropdown-item change-password" id="scp-{{ $u->id }}" data='{"preventDefault": true, "name": "{{ $u->getName() }}",}'>
											<i class="fas fa-lock mr-2"></i>Change Password
											<script type="text/javascript">
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
										</a>
										
										{{-- STATUS --}}
										@if ($u->id != 1)
											@if ($u->trashed())
											<a href="javascript:void(0);" class="dropdown-item" onclick="confirmLeave(`activate,{{ $u->username }}`, undefined, `{{ auth()->user()->id == $u->id ? "This will re-activate your account once more, allowing you to log back in using your account" : "This will re-activate the account once more, allowing the user to log back in using their account" }}`, true, @this);">
												<i class="fas fa-toggle-on mr-2"></i>Re-Activate
											</a>
											@else
											<a href="javascript:void(0);" class="dropdown-item" onclick="confirmLeave(`deactivate,{{ $u->username }}`, undefined, `{{ auth()->user()->id == $u->id ? "This will deactivate your account, logging you out forcibly and prevent you from accessing this account while deactivated" : "This will deactivate the account, logging them out forcibly on their next action and prevents them from accessing their account while deactivated" }}`, true, @this);">
												<i class="fas fa-toggle-off mr-2"></i>Deactivate
											</a>
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

					<tfoot>
						<tr>
							<td colspan="5">
								{{ $users->links() }}
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
<script type="text/javascript" src="{{ asset('js/util/confirm-leave.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/util/swal-change-password.js') }}"></script>
@endsection