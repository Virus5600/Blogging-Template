{{-- LOGIN FORM START --}}
<div class="card w-100 w-sm-75 w-md-50 w-lg-25 m-auto">
	<h4 class="card-header text-center">LOGIN</h4>

	<form class="card-body" wire:submit.prevent="authenticate">
		{{ csrf_field() }}
		
		<div class="form-group">
			<label class="form-label" for="username">Username</label>
			<input class="form-control border-secondary" type="text" name="username" value="{{ old('username') }}" aria-label="Username" placeholder="Username" wire:model.lazy="username" />
		</div>

		<div class="form-group">
			<label class="form-label" for="password">Password</label>
			<div class="input-group">
				<input class="form-control border-secondary border-right-0" type="password" name="password" id="password" aria-label="Password" aria-describedby="toggle-show-password" placeholder="Password" wire:model.lazy="password" />
				<div class="input-group-append">
					<button type="button" class="btn bg-white border-secondary border-left-0" id="toggle-show-password" aria-label="Show Password" data-target="#password">
						<i class="fas fa-eye d-none" id="show"></i>
						<i class="fas fa-eye-slash" id="hide"></i>
					</button>
				</div>
			</div>
		</div>

		<div class="form-group text-center">
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
</div>
{{-- LOGIN FORM END --}}