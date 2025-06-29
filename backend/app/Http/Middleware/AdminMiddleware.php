<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function handle(Request $request, Closure $next)
	{
		if (!auth()->check()) {
			return response()->json([
				'success' => false,
				'message' => 'Unauthenticated'
			], 401);
		}

		if (!auth()->user()->isAdmin()) {
			return response()->json([
				'success' => false,
				'message' => 'Access denied. Admin privileges required.'
			], 403);
		}

		return $next($request);
	}
}
