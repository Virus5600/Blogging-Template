<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use Closure;
use Log;

class Permissions
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next, ...$permissions)
	{
		$response = $next($request);
		
		if (!auth()->check()) 
			return redirect()->intended();

		$user = auth()->user();

		if ($user->hasPermission($permissions)) {
			return $response;
		}

		return redirect()
			->route('admin.dashboard')
			->with('flash_info', 'Access Denied')
			->with('has_icon', 'true')
			->with('message', 'Redirected back to previous page.')
			->with('has_timer')
			->with('duration', '5000');
	}
}
