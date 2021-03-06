<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PatientAuthController;
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\Settings\PatientprofileSettingsController;

/**
 * Frontend Routes
 */

 Route::get('/', [ FrontendController::class, 'ShowHomePage' ]) -> name('home.page');
 Route::get('/login-page', [ FrontendController::class, 'ShowLoginPage' ]) -> name('show.login.page') -> middleware('Admin.Redirect');

 /**
  * Patient Routes
  */

  Route::get('/patient-register-page' ,[FrontendController::class,'ShowPatientRegPage'])->name('patient.rag.page');
  Route::get('/patient-deshboard' ,[FrontendController::class,'ShowPatientDeshPage'])->name('patient.deshboard.page') -> middleware('patient');
  Route::post('/patient-register' ,[PatientAuthController::class,'PatientRegister'])->name('patient.register');
  Route::post('/patient-login' ,[PatientAuthController::class,'PatientLogin'])->name('patient.login');
  Route::get('/patient-logout' ,[PatientAuthController::class,'Logout'])->name('patient.logout');
  Route::get('/patient_access_account/{token?}' ,[PatientAuthController::class,'PatientAccountActiveToken'])->name('patient.access.account');
  /**
   * Forget Password Routs
   */
  Route::get('/forget-password' ,[PatientAuthController::class,'ForgetPassword'])->name('forget.password') -> middleware('patient');
  Route::post('/reset-password' ,[PatientAuthController::class,'passwordForgetCheck'])->name('password.forget.check'); 
  Route::get('/patient-password-reset-page/{email}/' ,[PatientAuthController::class,'passwordResetpage'])->name('password.reset.token'); 
  Route::post('/patient-password-reset' ,[PatientAuthController::class,'passwordreset'])->name('password.reset.page'); 
 

  /**
   * Patient Profile Sidbar routes
   */
  Route::get('/patient-Profile-settings' ,[PatientprofileSettingsController::class,'ShowPatientProfSettings'])->name('patient.prof.settings') -> middleware('patient');
  Route::get('/patient-change-password' ,[PatientprofileSettingsController::class,'ShowPatientChangePass']) ->name('patient.change.pass') -> middleware('patient');
  Route::post('/change-password' ,[PatientprofileSettingsController::class,'ChangePassword'])->name('change.password') -> middleware('patient');
  Route::post('/edit-profile' ,[PatientprofileSettingsController::class,'EditPatientProf'])->name('edit.profile') -> middleware('patient');


  


 /**
  * Doctor Routes
  */

  Route::get('/doctor-register-page' ,[FrontendController::class,'ShowDoctorRegPage'])->name('doctor.rag.page');
  Route::get('/doctor-deshboard' ,[FrontendController::class,'ShowDoctorDeshPage'])->name('doctor.deshboard.page');