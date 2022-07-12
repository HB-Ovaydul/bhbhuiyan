<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientprofileSettingsController extends Controller
{
    /**
     * Patient Profile Settings Show Page
     */
    public function ShowPatientProfSettings()
    {
       return view('frontend.patient.profile_settings');
    }
    /**
     * Patient Change Password Show Page
     */
    public function ShowPatientChangePass()
    {
       return view('frontend.patient.password');
    }
    /**
     * Patient Change Passwords
     */
    public function ChangePassword(Request $request)
    {
      $this->validate($request,[
        'old_pass'                   => ['required'],
        'new_password'               => ['required'],
        'password_confirmation'      => ['required'],
      ]);

      // Password Verify
      if(!password_verify($request -> old_pass, Auth::guard('patient') -> user() -> password )){
        return back() -> with('danger', 'Sorry Our Old Password Not Match');
      }

      // Password Confirmation

      if($request -> new_password != $request -> password_confirmation){
        return back() -> with('danger', 'Sorry Confirm Password Is Not Match');
      }

      // Update Password

     $pass_update = patient::findOrfail(Auth::guard('patient') -> user() -> id);

     $pass_update -> update([
        'password'      => Hash::make($request -> new_password)
     ]);

     return redirect() -> route('show.login.page') -> with('success', 'Your Password Changed!');
      

    }
}
