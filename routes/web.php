<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\FrontendController;

/**
 * Frontend Routes
 */

 Route::get('/', [ FrontendController::class, 'ShowHomePage' ]) -> name('home.page');
 Route::get('/login-page', [ FrontendController::class, 'ShowLoginPage' ]) -> name('show.login.page');

 /**
  * Patient Routes
  */

  Route::get('/patient-register-page' ,[FrontendController::class,'ShowPatientRegPage'])->name('patient.rag.page');
  Route::get('/patient-deshboard' ,[FrontendController::class,'ShowPatientDeshPage'])->name('patient.deshboard.page');

 /**
  * Doctor Routes
  */

  Route::get('/doctor-register-page' ,[FrontendController::class,'ShowDoctorRegPage'])->name('doctor.rag.page');
  Route::get('/doctor-deshboard' ,[FrontendController::class,'ShowDoctorDeshPage'])->name('doctor.deshboard.page');