<?php

use App\Http\Middleware\CheckAuth;
use App\Http\Middleware\isEmployer;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\isPremiumUser;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PostJobController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JoblistingController;
use App\Http\Controllers\SubcriptionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [JoblistingController::class, 'index']);
Route::get('/jobs/{listing:slug}', [JoblistingController::class, 'show'])->name('job.show');

Route::get('/contact', [ContactController::class, 'index']);
Route::get('/contact/store', [ContactController::class, 'store']);
Route::get('/register/seeker', [UserController::class, 'createSeeker'])->name('create.seeker')->middleware(CheckAuth::class);
Route::post('/register/seeker', [UserController::class, 'storeSeeker'])->name('store.seeker');
Route::get('/register/employer', [UserController::class, 'createEmployer'])->name('create.employer')->middleware(CheckAuth::class);
Route::post('/register/employer', [UserController::class, 'storeEmployer'])->name('store.employer');



Route::get('/login', [UserController::class, 'login'])->name('login')->middleware(CheckAuth::class);
Route::post('/login', [UserController::class, 'postLogin'])->name('login.post');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('user/profile', [UserController::class, 'profile'])->name('user.profile')->middleware('auth');
Route::post('user/profile', [UserController::class, 'update'])->name('user.update.profile')->middleware('auth');
Route::get('user/profile/seeker', [UserController::class, 'seekerProfile'])->name('seeker.profile')->middleware('auth');
Route::post('user/password', [UserController::class, 'changePassword'])->name('user.password')->middleware('auth');
Route::post('upload/resume', [UserController::class, 'uploadResume'])->name('upload.resume')->middleware('auth');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(isPremiumUser::class)->name('dashboard');

Route::get('subscribe', [SubcriptionController::class, 'subscribe'])->name('subscribe');
Route::get('pay/weekly', [SubcriptionController::class, 'initiatePayment'])->name('pay.weekly');
Route::get('pay/monthly', [SubcriptionController::class, 'initiatePayment'])->name('pay.monthly');
Route::get('pay/yearly', [SubcriptionController::class, 'initiatePayment'])->name('pay.yearly');
Route::get('payment/success', [SubcriptionController::class, 'paymentSuccess'])->name('payment.success');
Route::get('payment/cancel', [SubcriptionController::class, 'cancel'])->name('payment.cancel');

Route::get('job/create', [PostJobController::class, 'create'])->name('job.create')->middleware(isPremiumUser::class);
Route::post('job/store', [PostJobController::class, 'store'])->name('job.store')->middleware(isPremiumUser::class);

Route::get('job/{listing}/edit', [PostJobController::class, 'edit'])->name('job.edit');
Route::put('job/{id}/edit', [PostJobController::class, 'update'])->name('job.update');

Route::get('job', [PostJobController::class, 'index'])->name('job.index');

Route::delete('job/{id}/delete', [PostJobController::class, 'destroy'])->name('job.delete');

Route::get('applicants', [ApplicantController::class, 'index'])->name('applicants.index');
Route::get('applicants/{slug}', [ApplicantController::class, 'show'])->name('applicants.show');
Route::post('shortlist/{listingId}/{userId}', [ApplicantController::class, 'shortlist'])->name('applicants.shortlist');