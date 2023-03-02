<?php

namespace App\Http\Controllers\Livewire\Admin\Users;

use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\User;

use Carbon\Carbon;

use DB;
use Exception;
use Image;
use Log;
use Storage;
use Validator;;

class Edit extends Component
{
	use WithFileUploads;

	// Fields (models)
	public $first_name, $middle_name, $last_name, $suffix, $birthdate, $email, $avatar, $username, $password;

	// Holder fields
	public $currentUsername;

	// Single Initialization Variables
	protected $settings;

	// Validation
	protected function rules($id) {
		return array(
			'first_name' => array('required', 'string', 'max:255'),
			'middle_name' => array('nullable', 'string', 'max:255'),
			'last_name' => array('required', 'string', 'max:255'),
			'suffix' => array('nullable', 'string', 'max:255'),
			'birthdate' => array('required', 'date', 'before:' . now()->format("Y-m-d")),
			'email' => array('required', 'email', 'string', 'max:255', Rule::unique('users', 'email')->ignore($id)),
			'avatar' => array('max:5120', 'mimes:jpeg,jpg,png,webp', 'nullable'),
		);
			'username' => array('required', 'string', 'min:3', 'max:255', Rule::unique('users', 'username')->ignore($id)),
	}

	protected $messages = [
		'first_name.required' => 'The first or given name is required',
		'first_name.string' => 'First names are only composed of string',
		'first_name.max' => 'First names must not exceed 255 characters',
		'middle_name.string' => 'Middle names are only composed of string',
		'middle_name.max' => 'Middle names must not exceed 255 characters',
		'last_name.required' => 'The last name is required',
		'last_name.string' => 'Last names are only composed of string',
		'last_name.max' => 'Last names must not exceed 255 characters',
		'middle_name.string' => 'Suffix should only be composed of string',
		'middle_name.max' => 'Suffix must not exceed 255 characters',
		'birthdate.required' => 'A birthdate is required',
		'birthdate.date' => 'Please provide a proper date value (yyyy-MM-dd)',
		'birthdate.before' => 'Cannot create an account for someone who isn\'t born yet, can we?',
		'email.required' => 'The email for this user is required',
		'email.email' => 'Invalid email address',
		'email.string' => 'Inavlid email address',
		'email.max' => 'Emails must not exceed 255 characters',
		'email.unique' => 'Email already registered',
		'username.required' => 'Username is required',
		'username.string' => 'Username should be a string',
		'username.min' => 'Username should at least be 3 characters long',
		'username.max' => 'Username should not exceed 255 characters',
		'username.unique' => 'Username already exists, please select another username',
		'avatar.max' => 'Image should be below 5MB',
		'avatar.mimes' => 'Selected file doesn\'t match the allowed image formats',
	];

	// COMPONENT FUNCTION //
	public function mount($username) {
		$this->currentUsername = $username;
		
		$user = User::withTrashed()
			->where('username', '=', $username)
			->first();

		$this->first_name = $user->first_name;
		$this->middle_name = $user->middle_name;
		$this->last_name = $user->last_name;
		$this->suffix = $user->suffix;
		$this->birthdate = Carbon::parse($user->birthdate)->format("Y-m-d");
		$this->email = $user->email;
		$this->avatar = $user->getAvatar();
		$this->username = $user->username;
	}

	public function render() {
		return view('livewire.admin.users.edit')
			->extends('layouts.admin')
			->section('content');
	}

	// FORM FUNCTIONS //
	public function update(Request $req) {
		$user = User::withTrashed()
			->where('username', '=', $this->currentUsername)
			->first();

		if ($user == null) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "The user either does not exists or is already deleted"
			]);

			return;
		}

		$validator = Validator::make([
			"first_name" => $this->first_name,
			"middle_name" => $this->middle_name,
			"last_name" => $this->last_name,
			"suffix" => $this->suffix,
			"birthdate" => $this->birthdate,
			"email" => $this->email,
			"avatar" => $this->avatar,
			"username" => $this->username,
		], $this->rules($user->id), $this->messages);

		if ($validator->fails()) {
			$validator->validate();
			return;
		}

		try {
			DB::beginTransaction();

			// Avatar file handling is done later
			$user->first_name = $this->first_name;
			$user->middle_name = $this->middle_name;
			$user->last_name = $this->last_name;
			$user->suffix = $this->suffix;
			$user->birthdate = $this->birthdate;
			$user->email = $this->email;
			$user->username = $this->username;
			$user->save();

			// Removes the old image if it has. (Part 1)
			$forRemoval = false;
			if ($user->avatar != null && $this->avatar != null) {
				$forRemoval = true;
				$oldAvatar = $user->avatar;
			}

			// File handling
			if ($this->avatar) {
				$destination = "uploads/users/{$user->id}";
				$fileType = $this->avatar->getClientOriginalExtension();
				$image = "{$user->id}-" . uniqid() . ".webp";

				// Change format to WEBP
				if(strtolower($fileType) != "webp") {
					$webpImage = Image::make($this->avatar)->stream("webp", 100);
					Storage::put("{$destination}/{$image}", $webpImage, 'public');
				}
				else {
					$this->avatar->storePubliclyAs($destination, $image, 's3');
				}
				
				$user->avatar = $image;
				$user->save();
			}

			// Removes the old image if it has. (Part 2)
			if ($forRemoval) {
				$forRemoval = false;
				Storage::disk("s3")->delete("uploads/users/{$user->id}/{$oldAvatar}");
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

		return redirect()
			->route('admin.users.index')
			->with('flash_success', "Successfully updated @{$user->username}");
	}
}
