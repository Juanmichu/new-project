<?php

return [
// Bug: In case this project will be used in production, these lines will do the trick. But currently, they are making to fail building project
//	'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
//		'%s%s',
//		'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
//		Illuminate\Support\Str::startsWith(app()->environment(), 'local') ? ',localhost:3000,127.0.0.1:3000' : ''
//	))),

	'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
		'%s%s',
		'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',',localhost:3000,127.0.0.1:3000'))),

	'guard' => ['web'],

	'expiration' => null,

	'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

	'middleware' => [
		'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
		'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
		'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
	],
];
