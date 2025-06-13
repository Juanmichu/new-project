<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Página de inicio pública
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
	Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
	Route::post('/login', [AuthenticatedSessionController::class, 'store']);
	Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
	Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
	Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

	// Dashboard (solo para usuarios autenticados)
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	// Perfil de usuario
	Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
	Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de ejercicios (públicas y privadas)
Route::controller(ExerciseController::class)->group(function () {
	// Rutas públicas
	Route::get('/exercises', 'index')->name('exercises.index');
	Route::get('/exercises/{exercise}', 'show')->name('exercises.show');

	// Rutas protegidas (solo usuarios autenticados)
	Route::middleware('auth')->group(function () {
		Route::get('/exercises/create', 'create')->name('exercises.create');
		Route::post('/exercises', 'store')->name('exercises.store');
		Route::get('/exercises/{exercise}/edit', 'edit')->name('exercises.edit');
		Route::patch('/exercises/{exercise}', 'update')->name('exercises.update');
		Route::delete('/exercises/{exercise}', 'destroy')->name('exercises.destroy');

		// Funcionalidades adicionales
		Route::post('/exercises/{exercise}/favorite', 'toggleFavorite')->name('exercises.favorite');
		Route::get('/exercises/{exercise}/start-workout', 'startWorkout')->name('exercises.start-workout');
	});
});

// Rutas del blog (públicas)
Route::controller(BlogController::class)->group(function () {
	Route::get('/blog', 'index')->name('blog.index');
	Route::get('/blog/{slug}', 'show')->name('blog.show');
	Route::get('/blog/category/{category}', 'category')->name('blog.category');
	Route::get('/blog/author/{author}', 'author')->name('blog.author');

	// Rutas administrativas del blog (solo para usuarios autenticados)
	Route::middleware('auth')->group(function () {
		Route::get('/blog/create', 'create')->name('blog.create');
		Route::post('/blog', 'store')->name('blog.store');
		Route::get('/blog/{slug}/edit', 'edit')->name('blog.edit');
		Route::patch('/blog/{slug}', 'update')->name('blog.update');
		Route::delete('/blog/{slug}', 'destroy')->name('blog.destroy');
	});
});

// Rutas adicionales de utilidad
Route::middleware('auth')->group(function () {
	// API endpoints para funcionalidades AJAX
	Route::prefix('api')->group(function () {
		Route::get('/exercises/search', [ExerciseController::class, 'search'])->name('api.exercises.search');
		Route::get('/user/stats', [DashboardController::class, 'getStats'])->name('api.user.stats');
		Route::post('/user/activity', [DashboardController::class, 'logActivity'])->name('api.user.activity');
	});

	// Rutas de configuración
	Route::get('/settings', function () {
		return view('settings.index');
	})->name('settings');
});

// Rutas de páginas estáticas
Route::get('/about', function () {
	return view('pages.about');
})->name('about');

Route::get('/contact', function () {
	return view('pages.contact');
})->name('contact');

Route::get('/privacy', function () {
	return view('pages.privacy');
})->name('privacy');

Route::get('/terms', function () {
	return view('pages.terms');
})->name('terms');

// Redirección para compatibilidad
Route::redirect('/home', '/dashboard');


// Route for testing MongoDB connection
Route::get('/test-mongo', function () {
	try {
		$connection = DB::connection('mongodb');
		$collection = $connection->getCollection('test');
		$collection->insertOne(['test' => 'Hello MongoDB!']);
		return 'MongoDB connection successful!';
	} catch (Exception $e) {
		return 'MongoDB connection failed: ' . $e->getMessage();
	}
});
