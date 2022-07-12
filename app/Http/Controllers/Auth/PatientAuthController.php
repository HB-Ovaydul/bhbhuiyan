<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientAuthController extends Controller
{

    /**
     * Patient Register
     */

     public function PatientRegister(Request $request)
     {

    // Data Validation
       $this->validate($request,[
        'first_name'         => ['required'],
        'email'         => ['required'],
        'mobile'        => ['required'],
        
       ]);

    // Data Create & Register
       patient::create([
        'first_name'      => $request -> first_name,
        'email'           => $request -> email,
        'mobile'          => $request -> mobile,
        'password'        => password_hash($request -> password, PASSWORD_DEFAULT),
       ]);

    return redirect() -> route('show.login.page') -> with('success', 'Account Successful, Now Login Please');

     }

     /**
      * Patient Login Process
      */

      public function PatientLogin(Request $request)
      {
       // User Login
       if(Auth::guard('patient') -> attempt([ 'email' => $request -> email, 'password' => $request -> password]) || Auth::guard('patient') -> attempt(['mobile' => $request -> email, 'password' => $request -> password ])){
        return redirect() -> route('patient.deshboard.page');
       }else{
        return redirect() -> route('show.login.page') -> with('danger', 'Sorry Login Faild Please Try Agine');
       }
      }

    /**
     * User Log Out Process
     */

     public function Logout()
     {
       Auth::guard('patient') -> logout();
       return redirect() -> route('show.login.page');
     }

}
