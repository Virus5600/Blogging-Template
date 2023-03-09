<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use Closure;

class SecureHeaders
{
	// Enumerate unwanted headers
	private $unwantedHeaderList = [
		'X-Powered-By',
		'Server',
	];

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 */
	public function handle(Request $request, Closure $next) {
		$response = $next($request);

		// SETTER
		$response->headers->set('X-Content-Type-Options', 'nosniff');
		$response->headers->set('X-XSS-Protection', '1; mode=block');
		$response->headers->set('Strict-Transport-Security', 'max-age:31536000; includeSubDomains');

		// REMOVER
		foreach ($this->unwantedHeaderList as $header)
			header_remove($header);
		
		return $response;
	}
}