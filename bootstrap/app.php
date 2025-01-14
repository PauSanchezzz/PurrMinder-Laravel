<?php

use App\Http\Controllers\AdoptionApplications;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\catsController;
use App\Http\Controllers\MedicalController;
use App\Http\Controllers\select_formsController;
use App\Http\Controllers\DeathController;
use App\Http\Controllers\ReinstateController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
    //api: __DIR__.'/../routes/api.php',
        using: function () {
            Route::group([

                'middleware' => 'api',
                'prefix' => 'auth'

            ], function ($router) {

                Route::post('login', [AuthController::class, 'login'])->name('login');
                Route::post('logout', [AuthController::class, 'logout']);
                Route::post('refresh', [AuthController::class, 'refresh']);
                Route::post('register', [AuthController::class, 'register']);
            });
            Route::group([
                'middleware' => 'api',
                'prefix' => 'users'
            ], function ($router) {
                Route::get('profile', [AuthController::class, 'profile']);
            });
            Route::group([
                'middleware' => 'api',
                'prefix' => 'cats'
            ], function ($router) {
                Route::get('catsAdoption', [CatsController::class, 'catsAdoption'])->name('catsAdoption');
                Route::get('catsNotAvailable', [CatsController::class, 'catsNotAvailable'])->name('catsNotAvailable');
                Route::get('catsAdopted', [CatsController::class, 'catsAdopted'])->name('catsAdopted');
                Route::post('catRegister', [CatsController::class, 'catRegister'])->name('catRegister');
                Route::post('deathRegister', [DeathController::class, 'deathRegister'])->name('deathRegister');
                Route::post('medicalRegister', [MedicalController::class, 'medicalRegister'])->name('medicalRegister');
                Route::post('createReinstate', [ReinstateController::class, 'createReinstate'])->name('createReinstate');
                Route::patch('changeAvailability_Health/{id}', [ReinstateController::class, 'changeAvailability_Health'])->name('changeAvailability_Health');
                Route::get('allCats', [CatsController::class, 'allCats'])->name('allCats');
                Route::get('catById/{id}', [CatsController::class, 'catById'])->name('catById');
                Route::post('findCat', [CatsController::class, 'findCat'])->name('findCat');
                Route::post('catEdit/{id}', [CatsController::class, 'catEdit'])->name('catEdit');
                Route::get('deathList', [DeathController::class, 'deathList'])->name('deathList');
                Route::get('medicalList' , [MedicalController::class, 'medicalList'])->name('medicalList');
                Route::get('reinstateList' , [ReinstateController::class, 'reinstateList'])->name('reinstateList');
                Route::patch('updateDeathRegister/{id}' , [DeathController::class, 'updateDeathRegister'])->name('updateDeathRegister');
                Route::post('updateMedicalRegister/{id}' , [MedicalController::class, 'updateMedicalRegister'])->name('updateMedicalRegister');
                Route::patch('updateReinstate/{id}' , [ReinstateController::class, 'updateReinstate'])->name('updateReinstate');
                Route::get('deathById/{id}' , [DeathController::class, 'deathById'])->name('deathById');
                Route::get('medicalById/{id}', [MedicalController::class, 'medicalById'])->name('medicalById');
                Route::get('reinstateById/{id}', [ReinstateController::class, 'reinstateById'])->name('reinstateById');


            });
            Route::group([
                'middleware' => 'api',
                'prefix' => 'select'
            ], function ($router) {
                Route::get('select_typeDocument', [select_formsController::class, 'select_typeDocument'])->name('select_typeDocument');
                Route::get('select_city', [select_formsController::class, 'select_city'])->name('select_city');
                Route::get('select_occupation', [select_formsController::class, 'select_occupation'])->name('select_occupation');
                Route::get('select_calendar', [select_formsController::class, 'select_calendar'])->name('select_calendar');
                Route::get('select_sex', [select_formsController::class, 'select_sex'])->name('select_sex');
                Route::get('select_personality', [select_formsController::class, 'select_personality'])->name('select_personality');
                Route::get('select_catHealth', [select_formsController::class, 'select_catHealth'])->name('select_catHealth');
                Route::get('select_specialCondition', [select_formsController::class, 'select_specialCondition'])->name('select_specialCondition');
                Route::get('select_typeMedicalProcedure', [select_formsController::class, 'select_typeMedicalProcedure'])->name('select_typeMedicalProcedure');
                Route::get('select_cat', [select_formsController::class, 'select_cat'])->name('select_cat');
                Route::get('select_reasonOfDeath', [select_formsController::class, 'select_reasonOfDeath'])->name('select_reasonOfDeath');
                Route::get('select_adoptedCats', [select_formsController::class, 'select_adoptedCats'])->name('select_adoptedCats');

            });
            Route::group([
                'middleware' => 'api',
                'prefix' => 'AdoptionApplications'
            ], function ($router) {
                Route::get('catRequested', [AdoptionApplications::class, 'catRequested'])->name('catRequested');
                Route::get('getQuestionsAndAnswers/{applicationId}', [AdoptionApplications::class, 'getQuestionsAndAnswers'])->name('getQuestionsAndAnswers');
                Route::get('getUserByApplication/{applicationId}', [AdoptionApplications::class, 'getUserByApplicationId'])->name('getUserByApplicationId');
                Route::get('getCatByApplication/{applicationId}', [AdoptionApplications::class, 'getCatByApplicationId'])->name('getCatByApplicationId');
                Route::post('createResponseAdoption', [AdoptionApplications::class, 'createResponseAdoption'])->name('createResponseAdoption');
                Route::patch('updateResponseEvaluation/{application_id}', [AdoptionApplications::class, 'updateResponseEvaluation'])->name('updateResponseEvaluation');
                Route::get('detailAdoptions', [AdoptionApplications::class, 'detailAdoptions'])->name('detailAdoptions');
                Route::post('detailAdoptionsFilter', [AdoptionApplications::class, 'detailAdoptionsFilter'])->name('detailAdoptionsFilter');
            });
        },
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

