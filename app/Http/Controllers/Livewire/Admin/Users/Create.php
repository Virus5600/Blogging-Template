<?php

namespace App\Http\Controllers\Livewire\Admin\Users;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\User;

use DB;
use Exception;
use Image;
use Log;
use Storage;
use Validator;

class Create extends Component
{
	use WithFileUploads;

	// Fields (models)
	public $first_name, $middle_name, $last_name, $suffix, $birthdate, $email, $avatar, $username, $password;

	// Single Initialization Variables
	protected $settings;

	// Validation
	protected function rules() {
		return array(
			'first_name' => array('required', 'string', 'max:255'),
			'middle_name' => array('nullable', 'string', 'max:255'),
			'last_name' => array('required', 'string', 'max:255'),
			'suffix' => array('nullable', 'string', 'max:255'),
			'birthdate' => array('required', 'date', 'before:' . now()->format("Y-m-d")),
			'email' => array('required', 'email', 'string', 'max:255', 'unique:users,email'),
			'avatar' => array('max:5120', 'mimes:jpeg,jpg,png,webp', 'nullable'),
			'username' => array('required', 'string', 'min:3', 'max:255', 'unique:users,username'),
			'password' => array('required', 'string', 'min:8', 'max:255', 'regex:/^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]*$/')
		);
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
		'password.required' => 'Password is required',
		'password.string' => 'Password should be a string of characters',
		'password.min' => 'A minimum of 8 characters is the allowed limit for passwords',
		'password.max' => 'A maximum of 255 characters is the allowed limit for passwords',
		'avatar.max' => 'Image should be below 5MB',
		'avatar.mimes' => 'Selected file doesn\'t match the allowed image formats',
	];

	// COMPONENT FUNCTION //
	public function render() {
		$this->password = str_shuffle(Str::random(25) . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT));

		return view('livewire.admin.users.create')
			->extends('layouts.admin')
			->section('content');
	}

	// FORM FUNCTIONS //
	public function create(Request $req) {
		$validator = Validator::make([
			"first_name" => $this->first_name,
			"middle_name" => $this->middle_name,
			"last_name" => $this->last_name,
			"suffix" => $this->suffix,
			"birthdate" => $this->birthdate,
			"email" => $this->email,
			"avatar" => $this->avatar,
			"username" => $this->username,
			"password" => $this->password
		], $this->rules(), $this->messages);

		if ($validator->fails()) {
			$validator->validate();
			return;
		}

		try {
			DB::beginTransaction();

			// Avatar file handling is done later
			$user = User::create([
				"first_name" => $this->first_name,
				"middle_name" => $this->middle_name,
				"last_name" => $this->last_name,
				"suffix" => $this->suffix,
				"birthdate" => $this->birthdate,
				"email" => $this->email,
				"username" => $this->username,
				"password" => bcrypt($this->password)
			]);

			// File handling
			if ($this->avatar) {
				$destination = "uploads/users/{$user->id}";
				$fileType = $this->avatar->getClientOriginalExtension();
				$image = "{$user->id}-" . uniqid() . ".webp";

				// Change format to WEBP
				if(strtolower($fileType) != "webp") {
					$webpImage = Image::make($this->avatar)->stream("webp", 100);
					Storage::disk("s3")->put("{$destination}/{$image}", $webpImage, 'public');
				}
				else {
					$this->avatar->storePubliclyAs($destination, $image, 'public');
				}
				
				$user->avatar = $image;
				$user->save();
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
			->with('flash_success', "Successfully created a new user");
	}
}
