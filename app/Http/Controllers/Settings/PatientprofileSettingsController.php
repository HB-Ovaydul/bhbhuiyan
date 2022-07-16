<?php

namespace App\Http\Controllers\Settings;

use App\Models\patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

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
        'old_pass'                   => 'required',
        'new_password'               => 'required',
        'password_confirmation'      => 'required',
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
  
    /**
     * Edit Patient Profile
     */
    public function EditPatientProf(Request $request)
    {

  
      // Image Upload

      if($request -> hasFile ('old_photo')){
        $img = $request -> file('old_photo');
        $file_name = md5(time().rand()) .'.'. $img -> clientExtension();
        $photo_up = Image::make ($img -> getRealPath()); 
        $photo_up -> save( storage_path('app/public/Patient_photos/') . $file_name );

        // unlink('storage/Patient_photos/' . $request -> old_photo);

        // $img -> move(storage_path('app/public/Patient_photos/'),$file_name);
      }else{
         $file_name = $request ->old_photo;
      }
      // Data Test
      //  dd(Auth::guard('patient')->user());

      // Patient Data Update

       patient::find(Auth::guard('patient')->id())->update([
        'first_name'        => $request ->first_name,
        'last_name'         => $request ->last_name,
        'photo'             => $file_name,
        'adress'            => $request -> adress,
        'blood_group'       => $request -> blood_group,
        'country'           => $request -> country,
        'city'              => $request -> city,
        'location'          => $request -> location,
        'deta_of_birth'     => $request -> deta_of_birth,
        ]);

        return back();

      }


        
    }


