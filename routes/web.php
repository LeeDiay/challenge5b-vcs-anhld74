<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExerciseController;
            

Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/home', function () {return redirect('dashboard');})->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify'); 
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');



Route::group(['middleware' => 'auth'], function () {
	Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
	Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
	Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');

	// exercise route
	Route::get('exercises-management', [ExerciseController::class, 'index'])->name('exercises-management');
	Route::get('/exercise/{id}', [ExerciseController::class, 'show'])->name('exercise.detail');
	Route::post('/exercises-store', [ExerciseController::class, 'store'])->name('exercises.store');
	Route::post('/exercises-update', [ExerciseController::class, 'update'])->name('exercises.update');
	Route::post('/exercises-submit', [ExerciseController::class, 'submit'])->name('exercises.submit');
	// Route::post('exercises-management', [ExerciseController::class, 'submit'])->name('exercises.submit');

	Route::delete('/exercises-delete', [ExerciseController::class, 'destroy'])->name('exercises.delete');
	Route::get('/total-exercises-count', [ExerciseController::class, 'getTotalExercisesCount']);

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');

	// user route
	Route::get('user-management', [ProfileController::class, 'index'])->name('user-management');
	Route::get('user-profile', function () {
		return view('pages.laravel-examples.user-profile');
	})->name('user-profile');
	Route::post('/store', [UserController::class, 'store'])->name('store');
	Route::post('/update', [UserController::class, 'update'])->name('update');
	Route::delete('/delete', [UserController::class, 'destroy'])->name('delete');
	Route::get('change-password', function () {
		return view('pages.laravel-examples.change-password');
	})->name('change-password');
	Route::post('/change-password', [UserController::class, 'changePassword']);
	Route::get('/new-users-count', [UserController::class, 'getNewUsersCount']);
	Route::get('/total-users-count', [UserController::class, 'getTotalUsersCount']);

});