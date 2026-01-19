<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuidelineController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\PersonalityTestController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\GuestController;
use App\Models\Guest;
use Kreait\Firebase\Factory;
use App\Http\Middleware\FirebaseAuthMiddleware;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Homepage
Route::get('/', function () {
    return redirect()->route('login');
});

// 🔐 Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// 🧭 Dashboards (based on user roles)
Route::get('/dashboard/student', [AuthController::class, 'studentDashboard'])->name('student.dashboard');
Route::get('/coordinator/dashboard', [AuthController::class, 'coordinatorDashboard'])
    ->name('coordinator.dashboard');
Route::get('/dashboard/admin', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');

// 👤 ADMIN - CREATE COORDINATOR
Route::get('/admin/coordinators/create', [AuthController::class, 'showCreateCoordinatorForm'])
    ->name('admin.coordinators.create');
Route::post('/admin/coordinators/store', [AuthController::class, 'storeCoordinator'])
    ->name('admin.coordinators.store');

Route::get('/guest', [RecommendationController::class, 'guestDashboard'])->name('dashboard.guest');

// === Profile routes ===
// Student: view own profile + update
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'myProfile'])
    ->name('profile.index'); 
Route::get('/profile/edit', [ProfileController::class, 'edit'])
    ->name('profile.edit');
Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'updateMyProfile'])
    ->name('profile.update');
// Coordinator: view all students + single student
Route::get('/coordinator/students', [App\Http\Controllers\ProfileController::class, 'allStudents'])
    ->name('coordinator.students');
Route::get('/coordinator/students/{uid}', [App\Http\Controllers\ProfileController::class, 'viewStudent'])
    ->name('coordinator.students.view');

// Admin: list + view + update + delete
Route::get('/admin/students', [App\Http\Controllers\ProfileController::class, 'adminList'])
    ->name('admin.students');
Route::get('/admin/students/{uid}', [App\Http\Controllers\ProfileController::class, 'adminView'])
    ->name('admin.students.view');
Route::post('/admin/students/update/{uid}', [App\Http\Controllers\ProfileController::class, 'adminUpdate'])
    ->name('admin.students.update');
Route::delete('/admin/students/delete/{uid}', [App\Http\Controllers\ProfileController::class, 'adminDelete'])
    ->name('admin.students.delete');

// 📘 GUIDELINE MANAGEMENT (Admin or Coordinator)
Route::get('guidelines', [GuidelineController::class, 'index'])->name('guidelines.index');
Route::get('guidelines/create', [GuidelineController::class, 'create'])->name('guidelines.create');
Route::post('guidelines', [GuidelineController::class, 'store'])->name('guidelines.store');
Route::get('guidelines/{id}/edit', [GuidelineController::class, 'edit'])->name('guidelines.edit');
Route::put('guidelines/{id}', [GuidelineController::class, 'update'])->name('guidelines.update');
Route::delete('guidelines/{id}', [GuidelineController::class, 'destroy'])->name('guidelines.destroy');

// 🧠 PERSONALITY ASSESSMENT MANAGEMENT - STUDENT
Route::prefix('assessments')->group(function () {
    Route::get('/', [PersonalityTestController::class, 'index'])
        ->name('assessments.index');    
    Route::get('/start', [PersonalityTestController::class, 'start'])
        ->name('assessments.start');
    Route::post('/submit', [PersonalityTestController::class, 'submit'])
        ->name('assessments.submit');
});

// 🧠 PERSONALITY ASSESSMENT MANAGEMENT - ADMIN & COORDINATOR
Route::prefix('personality/manage')->name('personality.')->group(function () {
    Route::get('/', [PersonalityTestController::class, 'adminIndex'])
        ->name('index');
    Route::get('/create', [PersonalityTestController::class, 'adminCreate'])
        ->name('create');
    Route::post('/store', [PersonalityTestController::class, 'adminStore'])
        ->name('store');
    Route::get('/edit/{id}', [PersonalityTestController::class, 'adminEdit'])
        ->name('edit');
    Route::post('/update/{id}', [PersonalityTestController::class, 'adminUpdate'])
        ->name('update');
    Route::delete('/delete/{id}', [PersonalityTestController::class, 'adminDelete'])
        ->name('delete');
});


// 💼 INTERNSHIP RECOMMENDATION MANAGEMENT
// List (student / admin / coordinator)
Route::get('/recommendations/matched', 
    [RecommendationController::class, 'matchedOpportunities']
)->name('recommendations.matched');
Route::get('/recommendations', 
    [RecommendationController::class, 'index']
)->name('recommendations.index');
// View single recommendation (admin/coordinator approve here)
Route::get('/recommendations/{id}', 
    [RecommendationController::class, 'show']
)->name('recommendations.show');
// Approve (POST)
Route::post('/recommendations/{id}/approve',
    [RecommendationController::class, 'approve']
)->name('recommendations.approve');
// Reject (POST)
Route::post('/recommendations/{id}/reject',
    [RecommendationController::class, 'reject']
)->name('recommendations.reject');


// 🧾 FALLBACK PAGE (optional, for undefined routes)
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::get('/test-firebase', function () {
    $firebase = (new Factory)
        ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
        ->withDatabaseUri(config('firebase.database.url'));

    $database = $firebase->createDatabase();
    return $database->getReference('/')->getValue();
});

// Guest
Route::get('/guest/form', [GuestController::class, 'create'])->name('guest.form');
Route::post('/guest/store', [GuestController::class, 'store'])->name('guest.store');
Route::get('/dashboard/guest', [GuestController::class, 'dashboard'])->name('dashboard.guest');