<?php

namespace App\Http\Controllers\Livewire\Admin\Users;

use Livewire\Component;

use App\Models\Permission;
use App\Models\User;

use DB;
use Exception;
use Log;
use Validator;

class ManagePermissions extends Component
{
	
	// Fields (models)
	public $permissions = array(), $from;

	// Holder fields
	public $username, $permissionList;

	// VALIDATION
	protected function rules() {
		return array(
			'permissions' => array('array'),
			'permissions.*' => array('sometimes', 'numeric', 'exists:permissions,id')
		);
	}

	// COMPONENT FUNCTION //
	public function mount($username) {
		$this->username = $username;
		$this->permissionList = Permission::get();
		$this->from = request()->from ? request()->from : route('admin.users.index');

		$user = User::withTrashed()
			->where('username', '=', $this->username)
			->first();

		$u = $user->userPerms()->pluck('id')->toArray();
		$u = empty($u) ? $user->userType->permissions()->pluck('id')->toArray() : $u;
		$p = Permission::pluck('id')->toArray();
		for ($i = 0; $i < $this->permissionList->count(); $i++) {
			if (in_array($p[$i], $u))
				$this->permissions[$i] = $p[$i];
		}
	}

	public function render() {
		$user = User::withTrashed()
			->where('username', '=', $this->username)
			->first();

		if ($user == null) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "The user either does not exists or is already deleted"
			]);

			return;
		}

		return view('livewire.admin.users.manage-permissions', [
			'user' => $user,
			'permissionList' => $this->permissionList,
			'from' => $this->from
		])
			->extends('layouts.admin')
			->section('content');
	}

	// FORM FUNCTIONS //
	public function update($permissions) {
		$this->permissions = $permissions;

		$user = User::withTrashed()
			->where('username', '=', $this->username)
			->first();

		if ($user == null) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "The user either does not exists or is already deleted"
			]);

			$this->dispatchBrowserEvent('update-failed');

			return;
		}

		$validator = Validator::make([
			'permissions' => $this->permissions
		], $this->rules(), [
			'permissions.*' => 'Malformed data, please refresh and resubmit',
			'permissions.*.numeric' => 'Malformed data, please refresh and resubmit',
			'permissions.*.exists' => 'A selected permission does not exists. Please refresg and resubmit'
		]);

		if ($validator->fails()) {
			$validator->validate();
			return;
		}

		try {
			DB::beginTransaction();
			
			$userPerms = ($user->userPerms == null ? array() : $user->userPerms()->pluck('id')->toArray());
			$typePerms = ($user->userType->permissions == null ? array() : $user->userType->permissions()->pluck('id')->toArray());

			sort($userPerms);
			sort($typePerms);

			if ($userPerms == $typePerms)
				$user->userPerms()->detach();
			else
				$user->userPerms()->sync($this->permissions);

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "Something went wrong, please try again later"
			]);

			$this->dispatchBrowserEvent("update-failed");

			return;
		}

		$this->dispatchBrowserEvent('flash_success', [
			'flash_success' => 'Successfully updated ' . trim($user->getName()) . '\'s permissions'
		]);
		$this->dispatchBrowserEvent("update-failed");
	}

	public function revertPermission($username) {
		$user = User::withTrashed()
			->where('username', '=', $this->username)
			->first();

		if ($user == null) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "The user either does not exists or is already deleted"
			]);

			return;
		}

		try {
			DB::beginTransaction();

			$user->userPerms()->detach();

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "Something went wrong, please try again later"
			]);

			return;
		}

		$this->mount($this->username);
		$this->render();

		$this->dispatchBrowserEvent('refresh-inputs', [
			'permissions' => $this->permissions
		]);
		$this->dispatchBrowserEvent('flash_success', [
			'flash_success' => "Successfully reverted back to user-type permissions"
		]);
	}
}