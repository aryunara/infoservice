<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
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

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postLogin'])->name('post.login');
Route::get('register', [AuthController::class, 'registration'])->name('register');
Route::post('register', [AuthController::class, 'postRegistration'])->name('post.register');
Route::get('register-board', [AuthController::class, 'getBoard'])->name('register.board');
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');

Route::get('main', [MainController::class, 'getMain'])->name('main');
Route::post('main', [MainController::class, 'createLead'])->name('lead.create');
Route::get('main-board', [MainController::class, 'getBoard'])->name('main.board');

Route::get('leads', [LeadController::class, 'getLeads'])->name('leads')->middleware('auth');
//Остальные роуты для Lead страницы в routes/api.php

Route::get('profile', [ProfileController::class, 'getProfile'])->name('profile')->middleware('auth');
Route::post('profile', [ProfileController::class, 'update'])->name('update.profile')->middleware('auth');;
Route::get('profile-board', [ProfileController::class, 'getProfileBoard'])->name('profile.board')->middleware('auth');;

Route::get('verifyEmail/{token}', [ProfileController::class, 'verifyEmail'])->name('verify.email');
Route::get('sendConfirmationLetter', [ProfileController::class, 'sendConfirmationLetter'])->name('confirm.email');
Route::get('confirmation-board', [ProfileController::class, 'getConfirmationBoard'])->name('confirmation.board')->middleware('auth');;
