<?php

use App\Http\Controllers\CapabilityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StakeholderController;
use App\Http\Controllers\SubcapabilityController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use App\Models\Subcapability;
use App\Models\Survey;
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

$controller_path = 'App\Http\Controllers';

Route::get('/', $controller_path . '\pages\HomePage@index')->name('pages-home')->middleware('auth');
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

Route::get('/page-2', $controller_path . '\pages\Page2@index')->name('pages-page-2');
Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');
Route::get('/survey', [SurveyController::class, 'survey'])->name('survey');
Route::get('/landing-page', function() {
	return view('pages.landing-page');
})->name('landing');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
	Route::prefix('resource')->group(function() {
		Route::resource('users', UserController::class);
		Route::resource('schools', SchoolController::class);
		Route::resource('subcapabilities/{subcapability}/indicators', IndicatorController::class);
		Route::resource('capabilities/{capability}/subcapabilities', SubcapabilityController::class);
		Route::post('capabilities/updateWeights', [CapabilityController::class, 'updateWeights']);
		Route::post('subcapabilities/updateWeights', [SubcapabilityController::class, 'updateWeights']);
		Route::resource('capabilities', CapabilityController::class);
		Route::resource('stakeholders', StakeholderController::class);
		Route::resource('surveys', SurveyController::class);
	});
	Route::get('/users', [UserController::class, 'UserManagement'])->name('users');
	Route::get('/stakeholders', [StakeholderController::class, 'StakeholderManagement'])->name('stakeholders');
	Route::get('/schools', [SchoolController::class, 'SchoolManagement'])->name('schools');
	Route::get('/capabilities/{capability}/subcapabilities', [SubcapabilityController::class, 'SubcapabilitiesManagement'])->name('subcapabilities');
	Route::get('/subcapabilities/{subcapability}/indicators', [IndicatorController::class, 'IndicatorsManagement'])->name('indicators');
	Route::get('/capabilities', [CapabilityController::class, 'CapabilityManagement'])->name('capabilities');
	Route::get('/surveys/send', [SurveyController::class, 'sendPage'])->name('surveySend');
	Route::post('/surveys/send', [SurveyController::class, 'send'])->name('sendSurvey');
	Route::get('/surveys', [SurveyController::class, 'SurveyManagement'])->name('surveys');
	Route::get('/', DashboardController::class)->name('dashboard');
});
