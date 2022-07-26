<?php

namespace App\Http\Controllers\Auth;

use passwords;
use Carbon\Carbon;
use App\Models\patient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\password_reset;
use App\Models\patient_reset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ForgotPassword;
use App\Notifications\PatientAccountNotification;

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


     /**
     * Forget Password Method
     */

    public function ForgetPassword()
    {
      return view('frontend.forget_pass');
    }

/**
 * Forget Password Get Link And Reset System
 */
public function passwordForgetCheck(Request $request)
{ 
  // Email Valitade 
  $request -> validate([
      'email'=>'required|email|exists:patients,email',
    ]);

    // Create token

    // $token = str::random(60);
    $token = md5(time().rand());
    patient_reset::create([
      'email' => $request -> email,
      'token' => $token,
    ]);
    // Create forget Data
  

    // Forget Notification send Massage
    // $reset_token -> notify(new ForgotPassword($reset_token));
    
    // checking Notify
    // if($reset_token){
    //   return back() -> with('success', 'Notify Done');
    // }else{
    //   return back() -> with('danger', 'Notify Failed');
    // }
  }

/**
 * Token Get Method in Url
 */
public function passwordResetpage(Request $request, $token,$email)
{
  return view('frontend.reset_page')->with([ 'token'=>$token, 'email'=>$request->email ]);
}

/**
 * Password Reset page & Change Password
 */
// public function passwordreset(Request $request)
// {
//   // Validate 
//     $this->validate($request,[
//       'email' => 'required|email|exists:patients,email',
//       'password' => 'password|confirmed',
//       'password_confirmation' => 'required',
//     ]);

// // Token check

// $check_token = Reset_password::where([ 'email' => $request -> email, 'token'  => $request -> token ])->first();

// // Checking reset Token

// if(!$check_token){
//     return back() -> with("danger", "Your Email Did't Match");
// }else{
//   patient::where('email', $request -> email)->update([

//     'password' => Hash::make($request -> password)

//   ]);
// }


// Reset_password::where([
//   'email' => $request -> email,
// ])->delete();

// return redirect() -> route('show.login.page') -> with('success', 'Youre password Reset Done, Now Log In');
}


