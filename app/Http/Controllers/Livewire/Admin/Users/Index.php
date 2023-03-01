<?php

namespace App\Http\Controllers\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;

use DB;
use Exception;
use Log;
use Validator;

class Index extends Component
{
	use WithPagination;

	// Fields (models)
	public $search = "";
	public $password = "";
	public $password_confirmation = "";
	public $notify_user = false;

	// Validation
	protected $rules = ['search' => 'string|max:255'];

	// Configurations
	protected $paginationTheme = 'bootstrap';

	// COMPONENT FUNCTION //
	public function render() {
		$validator = Validator::make(["search" => $this->search], $this->rules);

		if ($validator->fails()) {
			Log::debug($validator->messages());
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "Invalid search input"
			]);

			return;
		}
		$this->resetPage('blogsPage');

		$search = "%{$this->search}%";
		$users = User::withTrashed()
			->where("first_name", "LIKE", $search)
			->orWhere("middle_name", "LIKE", $search)
			->orWhere("last_name", "LIKE", $search)
			->orWhere("email", "LIKE", $search)
			->orWhere("username", "LIKE", $search)
			->paginate(10, ["*"], 'usersPage');

		return view('livewire.admin.users.index', [
			'users' => $users
		])
			->extends('layouts.admin')
			->section('content');
	}

	// CLICK FUNCTIONS //
	public function deactivate($username) {
		$user = User::withTrashed()
			->where('username', '=', $username)
			->first();

		if ($user == null) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "The user either does not exists or is already deleted"
			]);

			return;
		}

		try {
			DB::beginTransaction();

			$user->delete();
			$user->save();

			// Log off the user if it is them
			if (auth()->user()->id == $user->id) {
				redirect()
					->route('index')
					->with('flash_info', "You've been logged out")
					->with('has_icon', "true")
					->with('message', "You've deactivated your account and was logged out due to this. You must request an admin to re-activate your account to gain access once more")
					->with('has_timer', "false");
			}

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "Something went wrong, please try again later"
			]);
			return;
		}

		$this->dispatchBrowserEvent('flash_success', [
			'flash_success' => "Successfully deactivated account of \"{$user->getName()}\""
		]);
	}

	public function activate($username) {
		$user = User::withTrashed()
			->where('username', '=', $username)
			->first();

		if ($user == null) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "The blog either does not exists or is already deleted"
			]);

			return;
		}

		try {
			DB::beginTransaction();

			$user->restore();
			$user->save();

			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "Something went wrong, please try again later"
			]);
			return;
		}

		$this->dispatchBrowserEvent('flash_success', [
			'flash_success' => "Successfully reactivated account of  \"{$user->getName()}\""
		]);
	}

	public function changePassword($username) {
		// PRIORITIZE REMOVING TRACES OF THE PASSWORD
		$fields = array(
			"password" => $this->password,
			"password_confirmation" => $this->password_confirmation
		);
		$this->password = "";
		$this->password_confirmation = "";
		$this->notify_user = false;

		$user = User::withTrashed()
			->where('username', '=', $username)
			->first();

		if ($user == null) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "The user either does not exists or is already deleted"
			]);

			return;
		}

		$validator = Validator::make($fields, [
			'password' => array('required', 'regex:/([a-z]*)([0-9])*/i', 'min:8', 'confirmed'),
			'password_confirmation' => 'required'
		], [
			'password.required' => 'The new password is required',
			'password.regex' => 'Password must contain at least 1 letter and 1 number',
			'password.min' => 'Password should be at least 8 characters',
			'password.confirmed' => 'You must confirm your password first',
			'password_confirmation.required' => 'You must confirm your password first'
		]);

		if ($validator->fails()) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => $validator->messages()->first()
			]);
			return;
		}

		try {
			DB::beginTransaction();

			$user->password = bcrypt($fields["password"]);
			$user->save();


			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			Log::error($e);

			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "Something went wrong, please try again later"
			]);
			return;
		}

		$this->dispatchBrowserEvent('flash_success', [
			'flash_success' => "Succesfully updated password for \"{$user->getName()}\""
		]);
	}
}