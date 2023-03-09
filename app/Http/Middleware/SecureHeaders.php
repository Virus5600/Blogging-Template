<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Closure;

class SecureHeaders
{
	// Enumerate unwanted headers
	private $unwantedHeaderList = [
		'X-Powered-By',
		'Server',
		'Access-Control-Allow-Origin',
	];

	private $wantedHeaderList = [
		'X-Frame-Options' => 'sameorigin',
		'X-Content-Type-Options' => 'nosniff',
		'X-XSS-Protection' => '1; mode=block',
		'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains;',
		'HSTS' => 'max-age=31536000; includeSubDomains;'
	];

	/**
	 * Handle an incoming request.
	 *
	 * @param  Request  $request
	 * @param  Closure  $next
	 * @return Response
	 */
	public function handle(Request $request, Closure $next) {
		if (!headers_sent()) {
			$response = $next($request);

			// SETTER
			foreach ($this->wantedHeaderList as $header => $value) {
				header("{$header}:{$value}");
				$response->headers->set($header, $value, true);
			}

			// REMOVER
			foreach ($this->unwantedHeaderList as $header)
				header_remove($header);
		}
		
		return $next($request);
	}
}