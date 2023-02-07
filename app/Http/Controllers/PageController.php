<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Auth;
use DB;
use Exception;
use Log;
use Validator;

class PageController extends Controller
{
	// AUTHENTICATION
	protected function login() {
		return view('login');
	}

	protected function logout() {
		if (Auth::check()) {
			auth()->logout();
			
			return redirect(route('index'))
				->with('flash_success', 'Logged out!');
		}

		return redirect()
			->back()
			->with('flash_error', 'Something went wrong, please try again.');
	}

	// GUEST SIDE
	protected function home() {
		return view('index');
	}

	// ADMIN SIDE
	protected function redirectDashboard() {
		return redirect()
			->route('admin.dashboard');
	}

	protected function dashboard() {
		return view('admin.dashboard');
	}
}