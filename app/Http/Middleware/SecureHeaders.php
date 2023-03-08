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

		$response->headers->set('X-Content-Type-Options', 'nosniff');
		$response->headers->set('X-XSS-Protection', '1; mode=block');
		$response->headers->set('Strict-Transport-Security', 'max-age:31536000; includeSubDomains');
		$this->removeUnwantedHeaders($this->unwantedHeaderList);
		
		return $response;
	}

	/**
	 * Removes unwanted headers.
	 * 
	 * @param $headerList
	 */
	private function removeUnwantedHeaders($headerList) {
		foreach ($headerList as $header)
			header_remove($header);
	}
}