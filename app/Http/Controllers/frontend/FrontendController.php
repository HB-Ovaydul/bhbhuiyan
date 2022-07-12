<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Show Home Page
     */
   public function ShowHomePage()
   {
    return view('frontend.home');
   }
    /**
     * Show Login Page
     */
   public function ShowLoginPage()
   {
    return view('frontend.login');
   }

    /**
     * Show Patient Register Page
     */
   public function ShowPatientRegPage()
   {
    return view('frontend.patient.register');
   }
    /**
     * Show Patient Register Page
     */
   public function ShowPatientDeshPage()
   {
    return view('frontend.patient.deshboard');
   }
    /**
     * Show Doctor Register Page
     */
   public function ShowDoctorRegPage()
   {
    return view('frontend.doctor.register');
   }
    /**
     * Show Doctor Register Page
     */
   public function ShowDoctorDeshPage()
   {
    return view('frontend.doctor.deshboard');
   }
}
