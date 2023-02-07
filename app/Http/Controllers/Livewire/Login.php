<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;

use App\Models\User;

use Auth;
use DB;
use Exception;
use Log;
use Validator;

class Login extends Component
{
	// Fields (models)
	public $username, $password;

	// Validation
	protected $rules = [
		'username' => 'required|string|exists:users,username|max:255',
		'password' => 'required|string|max:255'
	];

	// COMPONENT FUNCTION //
	public function render() {
		return view('livewire.login');
	}

	// FORM FUNCTIONS //
	public function authenticate() {
		$user = User::where('username', '=', $this->username)->first();

		$validator = Validator::make([
			"username" => $this->username,
			"password" => $this->password
		], $this->rules);

		if ($validator->fails()) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "Wrong username/password!"
			]);
			return;
		}

		if ($user == null) {
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => "Wrong username/password!"
			]);
			return;
		}

		$authenticated = false;
		if (!$user->locked) {
			$authenticated = Auth::attempt([
				'username' => $this->username,
				'password' => $this->password
			]);
		}

		if ($authenticated) {
			if ($user) {
				try {
					DB::beginTransaction();
			
					$user->login_attempts = 0;
					$user->last_auth = now()->timezone('Asia/Manila');
					$user->save();
			
					DB::commit();
				} catch (Exception $e) {
					DB::rollback();
					Log::error($e);
				}
			}

			return redirect()
				->intended(route('admin.dashboard'))
				->with('flash_success', 'Logged In!');
		}
		else {
			if ($user) {
				try {
					DB::beginTransaction();

					if ($user->login_attempts < 5) {
						$user->login_attempts = $user->login_attempts + 1;
						$msg = 'Wrong username/password!';
					}
					else {
						if ($user->locked == 0) {
							// DO THE MAILING HERE. THIS IS TO SEND AN EMAIL ONLY ONCE
						}

						$user->locked = 1;
						$user->locked_by = User::getIP();
						$msg = 'Exceeded 5 tries, account locked';
					}
					$user->save();
					
					DB::commit();
				} catch (Exception $e) {
					DB::rollback();
					Log::error($e);
				}
			}

			auth()->logout();
			$this->dispatchBrowserEvent('flash_error', [
				'flash_error' => $msg
			]);
		}
	}
}