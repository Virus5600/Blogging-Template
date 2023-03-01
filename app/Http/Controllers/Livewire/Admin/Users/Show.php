<?php

namespace App\Http\Controllers\Livewire\Admin\Users;

use Livewire\Component;

use App\Models\User;

class Show extends Component
{
	// PUBLIC PARAMETERS //
	public $username;

	// COMPONENT FUNCTION //
	public function mount($username) {
		$this->username = $username;
	}

	public function render() {
		$user = User::withTrashed()
			->where('username', '=', $this->username)
			->first();

		if ($user == null) {
			session()->flash('has_icon', true);
			session()->flash('flash_info', "User either does not exists or is already deleted");

			$this->redirectRoute('admin.users.index');
		}

		$format = array(
			"birthdate" => "Birthday",
			"email" => "Email",
			"username" => "Username",
			"locked" => "Is Locked",
			"locked_by" => "Locked By",
			"last_auth" => "Last Log In"
		);

		return view('livewire.admin.users.show', [
			'user' => $user,
			'format' => $format
		])
			->extends('layouts.admin')
			->section('content');
	}
}
