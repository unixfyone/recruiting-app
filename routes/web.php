<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Api\v1\ProfileController;
use App\Http\Controllers\Api\v1\EducationController;
use App\Http\Controllers\Api\v1\ExperienceController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\SkillController;
use App\Http\Controllers\Api\v1\ProminentController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified',])->group(
    function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');})->name('dashboard');
        Route::get('/profiles', function(){
            return Inertia::render('Profile');})->name('profiles');
        Route::post('/registro', function(){
            return Inertia::render('NewProfile');})->name('newprofile');
        Route::get('/showProfile/{idProfile}', function(){
            return Inertia::render('Profiles/ShowProfile',['idProfile' => request()->idProfile]);})->name('showProfile');
});

Route::group(['prefix' => 'api/v1'], function () {
    Route::apiResource('profiles', ProfileController::class);
    Route::apiResource('educations', EducationController::class);
    Route::apiResource('experiences', ExperienceController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('skills', SkillController::class);
    Route::apiResource('prominents', ProminentController::class);

    //Profile custom routes GET
    Route::get('profile_max', [ProfileController::class,'profile_max']);
    Route::get('profileByUser/{user_id}', [ProfileController::class, 'profileByUser']);
    Route::get('profilePdfData/{profile_id}', [ProfileController::class, 'profilePdfData']);
    Route::get('profileSendMail/{profile_id}', [ProfileController::class, 'profileSendMail']);
    Route::get('profilesByFilter/{area?}/{statu?}', [ProfileController::class, 'profilesByFilter']);

    //Profile custom routes POST
    Route::post('profileUploadFile', [ProfileController::class, 'profileUploadFile']);

    //Education custom routes GET
    Route::get('educationByProfile/{profile_id}', [EducationController::class, 'educationByProfile']);

    //Experience custom routes GET
    Route::get('experienceByProfile/{profile_id}', [ExperienceController::class, 'experienceByProfile']);

    //Skills custom routes GET
    Route::get('skillByProfile/{profile_id}', [SkillController::class, 'skillByProfile']);

    //Prominent custom routes GET
    Route::get('prominentByProfile/{profile_id}', [ProminentController::class, 'prominentByProfile']);

    //List users custom routes GET
    Route::get('getListUsers', [UserController::class, 'getListUsers']);
});

Route::post('/registro', 'ProfileController@store');





