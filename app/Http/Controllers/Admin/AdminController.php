<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ForgetPassMail;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Country;
use App\Models\Gender;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator ;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\Rules\Phone;

class AdminController extends Controller
{

    public function adminLogin()
    {
        $datas = Country::all();
        $genders = Gender::all();
        return view('auth.admin.login',compact('datas','genders'));

    }

    public function adminRegistration()
    {
        $datas = Country::all();
        $genders = Gender::all();
        return view('auth.admin.register',compact('datas','genders'));

    }

    public function loadForgetMyPass()
    {
        $datas = Country::all();
        return view('auth.admin.forget',compact('datas'));

    }

    public function findUser(Request $request)
    {
        $countryIso = Country::where('id',18)->first();

        $validated = $request->validate([
            'email_or_phone' => ['bail','required'],
            ],
            [
                'email_or_phone.regex' => 'The phone number must contain only English digits (0-9).',
                'email_or_phone.required' => 'The phone number is required',
            ]
        );

        if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {
            $credential = array("email" => $request->email_or_phone);
        }
        else
        {
            $phoneNumber = validationMobileNumber($request->email_or_phone,$countryIso->iso);
            $credential = array("phone" => $phoneNumber);
            $email = false;
        }

        $admin = Admin::where($credential)->first();

        if ($admin) {
            $toster = array(
                'message' => 'User Found',
                'alert-type' => 'success'
            );

            return redirect()->route('otpLoad')->with('uuid', $admin->id)->with($toster);

        }
        else
        {
            $toster = array(
                'message' => 'User Not Found',
                'alert-type' => 'error'
            );

            return back()->with( $toster);
        }
    }



    public function adminValidateLogin(Request $request)
    {

        $countryIso = Country::where('id',18)->first();

        $validated = $request->validate([
            'email_or_phone' => ['bail','required'],
            'password' => 'required',
            ],
            [
                'email_or_phone.regex' => 'The phone number must contain only English digits (0-9).',
                'email_or_phone.required' => 'The phone number is required',
            ]
        );

        if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {

            $credential = array("email" => $request->email_or_phone, "password" => $request->password);
        }
        else
        {
            $phoneNumber = validationMobileNumber($request->email_or_phone,$countryIso->iso);
            $credential = array("phone" => $phoneNumber, "password" => $request->password);
        }

        if (Auth::guard('admin')->attempt($credential)) {

            $user = Auth::guard('admin')->user();

            if (($user->status == 0)) {

                $toster = array(
                    'message' => 'This account is in black listed',
                    'alert-type' => 'error'
                );

                return back()->with( $toster);
            } else {

                return redirect()->route('admin.dashboard');
            }

        }


        else
        {
            $toster = array(
                'message' => 'Wrong Credential',
                'alert-type' => 'error'
            );

            return back()->with( $toster);

        }
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('adminLogin');
    }


    public function otpLoad(Request $request)
    {
        $uuID = session('uuid') ?? $request->uuid;
        $admin = Admin::find($uuID);

        if (!$admin) {
            return back()->with([
                'message' => 'User Not Found',
                'alert-type' => 'error'
            ]);
        }

        $randCode = rand(100000,999999);
        $toster = array(
            'message' => 'User Found',
            'alert-type' => 'success'
        );
        $status = storeOtp($admin, $randCode);
        $name = $admin->name;
        $messageContent = "Your Reset Code is : {$randCode}";

        // Email Code
        if($admin->email != null && $status == true)
        {
            Mail::to($admin->email)->queue(new ForgetPassMail($name,$messageContent));
        }
        else
        {
            return back()->with([
                'message' => 'Error in otp sending',
                'alert-type' => 'error'
            ]);
        }

        return view('auth.admin.otp', compact('admin'))->with($toster);

    }

    public function validateOtp(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'otp' => 'required|array|size:6',
            'otp.*' => 'required|digits:1',
        ]);



        if ($validator->fails()) {
            $toster = array(
                'message' => 'Wrong OTP',
                'alert-type' => 'error'
            );
            return redirect()->route('loadForgetMyPass')->with( $toster);
        }

        $otp = preg_replace('/\D/', '', implode('', $request->input('otp')));


        $admin = Admin::find($request->uuid);

        // if ($admin->otp == $request->otp && $admin->otp_validate_time > now())
        if ($admin?->otp == $otp)
        {
            return view('auth.admin.confirmpass', compact('admin'));
        }
        else
        {
            $toster = array(
                'message' => 'Wrong OTP',
                'alert-type' => 'error'
            );

            return back()->with( $toster);
        }
    }

    public function updatePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ],
        [
            'password.required' => 'The Password is required',
            'password_confirmation.required' => 'The Confirm Password is required',
            'password_confirmation.same' => 'The Confirm Password and Password must match',
        ]
    );

        if ($validator->fails()) {
            $toster = array(
                'message' => $validator->errors()->first(),
                'alert-type' => 'error'
            );
            return redirect()->route('adminLogin')->with( $toster);
        }


        $admin = Admin::find($request->uuid);
        $admin->password = Hash::make($request->password);
        $admin->save();

        $toster = array(
            'message' => 'Password Updated',
            'alert-type' => 'success'
        );

        return redirect()->route('adminLogin')->with($toster);
    }


    public function adminDocRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'phone' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'bvc_reg_number' => 'required|numeric|unique:admins,bvc_reg_number',
        ]);

        if ($validator->fails()) {
            $toster = array(
                'message' => $validator->errors()->first(),
                'alert-type' => 'error'
            );
            return redirect()->route('adminRegistration')->with($toster);
        }

            $countryID = $request->country_id ?? 18;
            $countryIso = Country::where('id',$countryID)->first();
            $phoneNumber = validationMobileNumber($request->phone,$countryIso->iso);
        // Create the admin user
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $phoneNumber,
            'password' => Hash::make($request->password),
            'bvc_reg_number' => $request->bvc_reg_number,
            'status' => 0,
            'email_verified_at' => Carbon::now(),
            'mobile_verified_at' => Carbon::now(),
        ]);

        $toster = array(
            'message' => 'Doctor Registered Successfully',
            'alert-type' => 'success'
        );
        $admin->assignRole('doctor');
        return redirect()->route('adminLogin')->with($toster);
    }


    public function getAppointment(Request $request)
    {
        $user = Auth::guard('admin')->user();

        if ($user->hasRole('SuperAdmin')) {
            // Show all appointments
            $query = Appointment::with(['pet', 'admin', 'user']);
        } elseif ($user->hasRole('doctor')) {
            // Show only appointments for this doctor
            $query = Appointment::with(['pet', 'admin', 'user'])->where('admin_id', $user->id);
        }

        $data = $query->orderBy('datetime', 'asc')->paginate(20);


        return view('admin::appoinment.index', compact('data'));
    }

}
