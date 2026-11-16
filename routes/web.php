<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;

/*
|-------------------------------------------------------------
| Web Routes
|-------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Remove or comment out the welcome route
// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

// Add unprotected home route
Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/ecoknights/home', [HomeController::class, 'index'])->name('home');

// Sign up
Route::get('/ecoknights/sign-up', [SignupController::class, 'getSignup'])->name('get-sign-up');
Route::post('/ecoknights/sign-up', [SignupController::class, 'postSignup'])->name('post-sign-up');

// Log in
Route::get('/ecoknights/log-in', [LoginController::class, 'getLogin'])->name('get-log-in');
Route::post('/ecoknights/log-in', [LoginController::class, 'postLogin'])->name('post-log-in')
    ->middleware('throttle:5,1'); // max 5 attempts per minute per IP
Route::post('/ecoknights/log-out', [LoginController::class, 'postLogout'])->name('post-log-out');

// Protected user area
Route::middleware('simple.authentication')->group(function () {
    
    // Remove the home route from here since it should be accessible to everyone
    // Route::get('/ecoknights/home', [HomeController::class, 'index'])->name('home');
    
    // Profile
    Route::get('/ecoknights/profile/update', [ProfileController::class, 'getUpdateProfile'])->name('get-update-profile');
    Route::put('/ecoknights/profile/update', [ProfileController::class, 'putUpdateProfile'])->name('post-update-profile');

    // Volunteer
    Route::get('/ecoknights/volunteer/create', [VolunteerController::class, 'getCreateVolunteer'])->name('get-create-volunteer');
    Route::post('/ecoknights/volunteer/create/{eventId}', [VolunteerController::class, 'postCreateVolunteer'])->name('post-create-volunteer');

    // Feedback
    Route::get('/ecoknights/feedback/create', [FeedbackController::class, 'getCreateFeedback'])->name('get-create-feedback');
    Route::post('/ecoknights/feedback/create', [FeedbackController::class, 'postCreateFeedback'])->name('post-create-feedback');

    // Administrator routes
    Route::middleware('administrator.only')->group(function () {
        // Generated project documentation
        Route::get('docs/{filename}', [DocumentController::class, 'show'])->where('filename', '[A-Za-z0-9_-]+');

        // Profile
        Route::get('/ecoknights/profile/read', [ProfileController::class, 'getReadProfile'])->name('get-read-profile');
        Route::get('/ecoknights/profile/create', [ProfileController::class, 'getCreateProfile'])->name('get-create-profile');
        Route::post('/ecoknights/profile/create', [ProfileController::class, 'postCreateProfile'])->name('post-create-profile');
        Route::get('/ecoknights/profile/update/{id}', [ProfileController::class, 'getUpdateProfile'])->name('get-administrator-update-profile');
        Route::put('/ecoknights/profile/update/{id}', [ProfileController::class, 'putUpdateProfile'])->name('post-administrator-update-profile');
        Route::get('/ecoknights/profile/delete/{id}', [ProfileController::class, 'getDeleteProfile'])->name('get-delete-profile');
        Route::delete('/ecoknights/profile/delete/{id}', [ProfileController::class, 'deleteProfile'])->name('post-delete-profile');

        // Volunteer
        Route::get('/ecoknights/volunteer/read', [VolunteerController::class, 'getReadVolunteer'])->name('get-read-volunteer');
        Route::get('/ecoknights/volunteer/update/{participationId}', [VolunteerController::class, 'getUpdateVolunteer'])->name('get-update-volunteer');
        Route::put('/ecoknights/volunteer/update/{participationId}', [VolunteerController::class, 'putUpdateVolunteer'])->name('post-update-volunteer');
        Route::get('/ecoknights/volunteer/delete/{participationId}', [VolunteerController::class, 'getDeleteVolunteer'])->name('get-delete-volunteer');
        Route::delete('/ecoknights/volunteer/delete/{participationId}', [VolunteerController::class, 'deleteVolunteer'])->name('post-delete-volunteer');

        // Feedback
        Route::get('/ecoknights/feedback/read', [FeedbackController::class, 'getReadFeedback'])->name('get-read-feedback');
        Route::get('/ecoknights/feedback/update/{feedbackId}', [FeedbackController::class, 'getUpdateFeedback'])->name('get-update-feedback');
        Route::put('/ecoknights/feedback/update/{feedbackId}', [FeedbackController::class, 'putUpdateFeedback'])->name('post-update-feedback');
        Route::get('/ecoknights/feedback/delete/{feedbackId}', [FeedbackController::class, 'getDeleteFeedback'])->name('get-delete-feedback');
        Route::delete('/ecoknights/feedback/delete/{feedbackId}', [FeedbackController::class, 'deleteFeedback'])->name('post-delete-feedback');
    });
});