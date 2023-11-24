<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(UserController::class)->group(function () {
    Route::post("/sign-in", 'signIn');
    Route::post("/forgot-password", 'forgotPassword');
    Route::post("/login", 'login');
    Route::post("/otp-verification", 'otpVerification')->middleware("auth:api");
});

Route::middleware(["auth:api","verified_api"])->group(function () {
    
    Route::post("/upload", [UploadController::class, 'index']);



    Route::controller(UserController::class)->group(function () {
        Route::post("/edit-profile", 'editProfile');
        Route::post("/edit-password", 'editPassword');
    });
    
    
    Route::controller(UniversityController::class)->prefix("university")->group(function () {
        Route::post("/", 'store');
        Route::get("/", 'index');
        Route::get("/{university}", 'show');
        Route::delete("/{university}", 'destroy')->middleware("user_role:admin");
        Route::put("/{university}", 'update')->middleware("user_role:admin");
    });
    Route::controller(CourseController::class)->prefix("course")->group(function () {
        Route::post("/", 'store');
        Route::get("/", 'index');
        Route::get("/{course}", 'show');
        Route::delete("/{course}", 'destroy')->middleware("user_role:admin");
        Route::put("/{course}", 'update')->middleware("user_role:admin");
    });
    Route::controller(SemesterController::class)->prefix("semester")->group(function () {
        Route::post("/", 'store');
        Route::get("/", 'index');
        Route::get("/{semester}", 'show');
        Route::delete("/{semester}", 'destroy')->middleware("user_role:admin");
        Route::put("/{semester}", 'update')->middleware("user_role:admin");
    });
    Route::controller(SubjectController::class)->prefix("subject")->group(function () {
        Route::post("/", 'store');
        Route::get("/", 'index');
        Route::get("/{subject}", 'show');
        Route::delete("/{subject}", 'destroy')->middleware("user_role:admin");
        Route::put("/{subject}", 'update')->middleware("user_role:admin");
    });
    Route::controller(PaperController::class)->prefix("paper")->group(function () {
        Route::post("/", 'store');
        Route::get("/", 'index');
        Route::get("/{paper}", 'show');
        Route::delete("/{paper}", 'destroy')->middleware("user_role:admin");
        Route::put("/{paper}", 'update')->middleware("user_role:admin");
    });
});
