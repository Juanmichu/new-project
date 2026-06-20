<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * Aborts with the appropriate HTTP status. Laravel renders an HTML error
	 * page for web requests and a JSON body when the client expects JSON, so
	 * this works for both the Blade admin panel and any API consumer.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 */
	public function handle(Request $request, Closure $next)
	{
		if (!auth()->check()) {
			abort(401, 'Unauthenticated');
		}

		if (!auth()->user()->isAdmin()) {
			abort(403, 'Access denied. Admin privileges required.');
		}

		return $next($request);
	}
}
