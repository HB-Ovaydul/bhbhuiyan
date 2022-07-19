<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\patient;
use App\Notifications\PatientAccountNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientAuthController extends Controller
{

    /**
     * Patient Register
     */

     public function PatientRegister(Request $request)
     {

   //  Data Validation
       $this->validate($request,[
        'first_name'         => 'required',
        'email'              => 'required|email|unique:patients',
        'mobile'             => 'required',
        
       ]);

      //  Create Token

       $token = md5(time().rand());

    // Data Create & Register
    $patient = patient::create([
        'first_name'      => $request -> first_name,
        'email'           => $request -> email,
        'mobile'          => $request -> mobile,
        'access_token'    => $token,
        'password'        => password_hash($request -> password, PASSWORD_DEFAULT),
       ]);

       // Account Acrtivetion link
       $patient -> notify(new PatientAccountNotification($patient));


    return redirect() -> route('show.login.page') -> with('success', 'Account Successful, Now Login Please');

     }

     /**
      * Patient Login Process
      */

      public function PatientLogin(Request $request)
      {
       // User Login
       if(Auth::guard('patient') -> attempt([ 'email' => $request -> email, 'password' => $request -> password]) || Auth::guard('patient') -> attempt(['mobile' => $request -> email, 'password' => $request -> password ])){

        //Login With Check Token
        if(Auth::guard('patient') -> user() -> access_token == null && Auth::guard('patient') -> user() -> status == true){

          return redirect() -> route('patient.deshboard.page');
        }else{

          return redirect() -> route('show.login.page') -> with('info', 'Sorry Your Account Not Activate');
        }

      
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

     /**
      * Patient Activation Link
      */

     public function PatientAccountActiveToken($token = null)
     {
        // Check token

        if(!$token){
            return redirect() -> route('show.login.page') -> with('danger', 'Sorry Your Token Match');
        }

        // Veryfication Token

        if($token){

          // Get Token

          $patient_data = patient::where( 'access_token', $token ) -> first();

          // update Token

        if( $patient_data ){

          $patient_data -> update([

            'access_token'     => null,
            'status'           => true,
           ]);

           return redirect() -> route('show.login.page') -> with('success', 'Your Accout Veryfied, Now log In');
 
        }else{

          return redirect() -> route('show.login.page') -> with('Warning', 'Your Account Not Veryfied');

        }

          

        }



     }

}
