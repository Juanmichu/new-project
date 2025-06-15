<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class WebAuthController extends Controller
{
	/**
	 * Mostrar el formulario de login
	 */
	public function showLoginForm()
	{
		return view('auth.login');
	}

	/**
	 * Procesar el login
	 */
	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required'
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		}

		$credentials = $request->only('email', 'password');
		$remember = $request->boolean('remember');

		if (Auth::attempt($credentials, $remember)) {
			$request->session()->regenerate();

			return redirect()->intended(route('dashboard'))
				->with('success', '¡Bienvenido de vuelta!');
		}

		return back()->withErrors([
			'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
		])->withInput();
	}

	/**
	 * Mostrar el formulario de registro
	 */
	public function showRegisterForm()
	{
		return view('auth.register');
	}

	/**
	 * Procesar el registro
	 */
	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => ['required', 'confirmed', Rules\Password::defaults()],
			'terms' => 'required|accepted'
		]);

		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
		}

		try {
			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => Hash::make($request->password),
				'fitness_level' => 'beginner',
				'goals' => [],
				'preferences' => [],
				'role' => 'user',
				'is_active' => true
			]);

			Auth::login($user);

			return redirect(route('dashboard'))
				->with('success', '¡Cuenta creada exitosamente! Bienvenido a FitCoacher.');

		} catch (\Exception $e) {
			return back()->withErrors([
				'error' => 'Hubo un error al crear tu cuenta. Inténtalo de nuevo.'
			])->withInput();
		}
	}

	/**
	 * Cerrar sesión
	 */
	public function logout(Request $request)
	{
		Auth::logout();

		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect(route('home'))
			->with('success', 'Sesión cerrada exitosamente.');
	}
}
