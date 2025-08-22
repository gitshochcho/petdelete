<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPassMail;
use App\Models\Country;
use App\Models\Gender;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Appointment;
use Modules\Admin\Models\Pet;
use App\Models\Admin;
use Illuminate\Http\Request;
use Propaganistas\LaravelPhone\PhoneNumber;
use Propaganistas\LaravelPhone\Rules\Phone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{

    public function home(Request $request)
    {

        return view('frontend.pages.home');
    }

    public function dashboard(Request $request)
    {

        return view('user.dashboard');
    }

    public function login()
    {
        $datas = Country::all();
        $genders = Gender::all();
        return view('auth.login', compact('datas', 'genders'));
    }




    public function registration()
    {
        $datas = Country::all();
        $genders = Gender::all();
        return view('auth.register', compact('datas', 'genders'));
    }


    public function validateLogin(Request $request)
    {
        $countryIso = Country::where('id', 18)->first();

        $validated = $request->validate(
            [
                // 'email_or_phone' => ['bail','required','regex:/^[0-9+]+$/',(new Phone)->country([$countryIso->iso])],
                'email_or_phone' => ['bail', 'required'],

                'password' => 'required',
            ],
            [
                'email_or_phone.regex' => 'The phone number must contain only English digits (0-9).',
                'email_or_phone.required' => 'The phone number is required',
            ]
        );


        $password = $request->input('password');

        if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email_or_phone)
                // ->orWhere('phone', $phoneNumber)
                ->first();
        } else {
            $phoneNumber = validationMobileNumber($request->email_or_phone, $countryIso->iso);
            $user = User::where('email', $request->email_or_phone)
                ->orWhere('phone', $phoneNumber)
                ->first();
        }



        if ($user) {
            if (Hash::check($password, $user->password)) {

                if (($user->status == 0)) {


                    $toster = array(
                        'message' => "This account is in black listed",
                        'alert-type' => 'error'
                    );
                    return back()->with($toster);
                } else {

                    if ($request->has('remember')) {
                        Auth::guard('web')->login($user, true);
                    } else {
                        Auth::guard('web')->login($user);
                    }
                    $toster = array(
                        'message' => "Wlecome to Dashboard, " . $user->name,
                        'alert-type' => 'success'
                    );

                    return redirect()->route('user.dashboard')->with($toster);
                }
            } else {
                return back()->with('fail', 'Wrong Credential');
            }
        } else {
            $toster = array(
                'message' => "User Not Found",
                'alert-type' => 'error'
            );

            return back()->with($toster);
        }
    }

    
    public function storRegistrationAsGuest(Request $request)
    {
        $code = rand(100000, 999999);
        $countryID = $request->country_id ?? 18;
        $countryIso = Country::where('id', $countryID)->first();

        $validated = $request->validate(
            [
                'name' => 'required',
                'email' => 'unique:users',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required|same:password',
                'phone' => ['required', 'unique:users', 'regex:/^[0-9+]+$/', (new Phone)->country([$countryIso->iso] ?? ['BD']),],
                
            ],
            [
                'phone.regex' => 'The phone number must contain only English digits (0-9).',
                'phone.required' => 'The phone number is required',
            ]
        );

        $phoneNumber = validationMobileNumber($request->phone, $countryIso->iso);

        $user = DB::transaction(function () use ($request, $code, $phoneNumber) {
            $userCreate = array(
                "name" => $request->name,
                "email" => $request->email ?? null,
                "password" => Hash::make($request->password),
                "phone" => $phoneNumber,
                "otp" => $code,
                "status" => 1,

            );

            $newuser = User::create($userCreate);

            $userdetail = array(
                "user_id" => $newuser->id,
                "division_id" => $request->division_id ?? null,
                "district_id" => $request->district_id ?? null,
                "upazila_id" => $request->upazila_id ?? null,
                "union_id" => $request->union_id ?? null,
                "education_type_id" => $request->education_type_id ?? null,
                "profession_id" => $request->profession_id ?? null,
                "gender_id" => $request->gender_id ?? 1,
                "country_id" => $request->country_id ?? null,
                "religion_id" => $request->religion_id ?? null,
            );
            $userDetail = UserDetail::create($userdetail);

            return $newuser;
        });

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User created successfully as guest'
        ], 201);
    }




    public function storRegistration(Request $request)
    {
        $code = rand(100000, 999999);
        $countryID = $request->country_id ?? 18;
        $countryIso = Country::where('id', $countryID)->first();


        $validated = $request->validate(
            [
                'name' => 'required',
                'email' => 'unique:users',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required|same:password',
                // 'education_type_id' => 'required',
                'phone' => ['required', 'unique:users', 'regex:/^[0-9+]+$/', (new Phone)->country([$countryIso->iso] ?? ['BD']),],
                // 'upazila_id' => 'required',
                // 'district_id' => 'required',
                // 'division_id' => 'required',
                // 'gender_id' => 'required',
                // 'country_id' => 'required',
            ],
            [
                'phone.regex' => 'The phone number must contain only English digits (0-9).',
                'phone.required' => 'The phone number is required',
            ]
        );


        $phoneNumber = validationMobileNumber($request->phone, $countryIso->iso);

        $user = DB::transaction(function () use ($request, $code, $phoneNumber) {
            $userCreate = array(
                "name" => $request->name,
                "email" => $request->email ?? null,
                "password" => Hash::make($request->password),
                "phone" => $phoneNumber,
                "otp" => $code,
                "status" => 1,

            );

            $newuser = User::create($userCreate);

            $userdetail = array(
                "user_id" => $newuser->id,
                "division_id" => $request->division_id ?? null,
                "district_id" => $request->district_id ?? null,
                "upazila_id" => $request->upazila_id ?? null,
                "union_id" => $request->union_id ?? null,
                "education_type_id" => $request->education_type_id ?? null,
                "profession_id" => $request->profession_id ?? null,
                "gender_id" => $request->gender_id ?? 1,
                "country_id" => $request->country_id ?? null,
                "religion_id" => $request->religion_id ?? null,
            );
            $userDetail = UserDetail::create($userdetail);

            return $newuser;
        });

        if ($user->status == 1) {
            $toster = array(
                'message' => "Registration Successfull",
                'alert-type' => 'success'
            );
            return redirect()->route('login')->with($toster);
        } else {

            $toster = array(
                'message' => "Registration Fail",
                'alert-type' => 'error'
            );
            return redirect()->route('registration')->with($toster);
        }
    }


    public function googleOauthLoad()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleOauthCallBack()
    {
        $user = Socialite::driver('google')->user();
        dd($user);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::route('login');
    }

    public function loadForgetMyPass()
    {
        $datas = Country::all();
        return view('auth.forgetpass', compact('datas'));
    }

    public function searchUser(Request $request)
    {
        $countryIso = Country::where('id', 18)->first();

        $validated = $request->validate(
            [
                'email_or_phone' => ['bail', 'required'],
            ],
            [
                'email_or_phone.regex' => 'The phone number must contain only English digits (0-9).',
                'email_or_phone.required' => 'The phone number is required',
            ]
        );

        if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {
            $credential = array("email" => $request->email_or_phone);
        } else {
            $phoneNumber = validationMobileNumber($request->email_or_phone, $countryIso->iso);
            $credential = array("phone" => $phoneNumber);
            $email = false;
        }

        $user = User::where($credential)->first();

        if ($user) {
            $toster = array(
                'message' => 'User Found',
                'alert-type' => 'success'
            );

            return redirect()->route('userOtpLoad')->with('uuid', $user->id)->with($toster);
        } else {
            $toster = array(
                'message' => 'User Not Found',
                'alert-type' => 'error'
            );

            return back()->with($toster);
        }
    }


    public function userOtpLoad(Request $request)
    {
        $uuID = session('uuid') ?? $request->uuid;
        $user = User::find($uuID);

        if (!$user) {
            return back()->with([
                'message' => 'User Not Found',
                'alert-type' => 'error'
            ]);
        }

        $randCode = rand(100000, 999999);
        $toster = array(
            'message' => 'User Found',
            'alert-type' => 'success'
        );
        $status = storeOtp($user, $randCode);
        $name = $user->name;
        $messageContent = "Your Reset Code is : {$randCode}";

        // Email Code
        if ($user->email != null && $status == true) {
            Mail::to($user->email)->queue(new ForgetPassMail($name, $messageContent));
        } else {
            return back()->with([
                'message' => 'Error in otp sending',
                'alert-type' => 'error'
            ]);
        }

        return view('auth.userotp', compact('user'))->with($toster);
    }


    public function validateUserOtp(Request $request)
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
            return redirect()->route('forgetMyPass')->with($toster);
        }

        $otp = preg_replace('/\D/', '', implode('', $request->input('otp')));


        $user = User::find($request->uuid);

        // if ($admin->otp == $request->otp && $admin->otp_validate_time > now())
        if ($user?->otp == $otp) {
            $toster = array(
                'message' => 'Otp Matched',
                'alert-type' => 'success'
            );
            return view('auth.passconfirm', compact('user'))->with($toster);
        } else {
            $toster = array(
                'message' => 'Wrong OTP',
                'alert-type' => 'error'
            );

            return redirect()->route('userOtpLoad')->with('uuid', $user->id)->with($toster);
            // return view('auth.userotp', compact('user'))->with($toster);

        }
    }



    public function updateUserPassword(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
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
            return redirect()->route('login')->with($toster);
        }


        $user = User::find($request->uuid);
        $user->password = Hash::make($request->password);
        $user->save();

        $toster = array(
            'message' => 'Password Updated',
            'alert-type' => 'success'
        );

        return redirect()->route('login')->with($toster);
    }

    // ====================================
    // APPOINTMENT API METHODS
    // ====================================

    /**
     * Get all appointments for the authenticated user
     */
    public function getAppointments(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $appointments = Appointment::with(['admin', 'pet'])
                ->where('user_id', $user->id)
                ->orderBy('datetime', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $appointments,
                'message' => 'Appointments retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving appointments: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new appointment
     */
    public function createAppointment(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'doctor_id' => 'required|exists:admins,id',
                'datetime' => 'required|date|after:now',
                'amount' => 'required|numeric|min:0',
                'notes' => 'nullable|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $user = $request->user_id;

            if ($user) {
                // Authenticated user - use pet_id
                // $validator = Validator::make($request->all(), [
                //     'pet_id' => 'required|exists:pets,id'
                // ]);
                
                // if ($validator->fails()) {
                //     return response()->json([
                //         'success' => false,
                //         'message' => 'Pet ID is required for authenticated users',
                //         'errors' => $validator->errors()
                //     ], 422);
                // }

                // Check if pet belongs to user (only if pet_id is provided)
                if ($request->pet_id) {
                    $pet = Pet::find($request->pet_id);
                    if (!$pet || $pet->user_id != $user->id) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Pet does not belong to this user'
                        ], 403);
                    }
                }
            } else {
                // Non-authenticated user - use pet_name and other details
                $validator = Validator::make($request->all(), [
                    'pet_name' => 'required|string|max:255',
                    'owner_name' => 'required|string|max:255',
                    'phone_number' => 'required|string|max:20',
                    'email' => 'nullable|email'
                ]);
                
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Required fields missing for non-authenticated users',
                        'errors' => $validator->errors()
                    ], 422);
                }
            }

            $appointment = Appointment::create([
                'user_id' => $user ?? null,
                'owner_name' => $request->owner_name ?? null,
                'phone_number' => $request->phone_number ?? null,
                'email' => $request->email ?? null,
                'admin_id' => $request->doctor_id,
                'pet_id' => $request->pet_id ?? null,
                'pet_name' => $request->pet_name ?? null,
                'datetime' => $request->datetime,
                'type' => $request->type ?? 1, // Default to Chamber if not provided
                'home_address' => $request->home_address ?? null,
                'amount' => $request->amount,
                'notes' => $request->notes,
                'status' => 1 // Pending
            ]);

            return response()->json([
                'success' => true,
                'data' => $appointment,
                'message' => 'Appointment created successfully'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating appointment: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Get available doctors/admins
     */
    public function getAvailableDoctors(Request $request)
    {
        try {

            $query = Admin::role('doctor');

            if ($request->has('doctor_id')) {
                $query->where('id', $request->doctor_id);
            }

            $doctors = $query->where('status', 1)->get()->map(function ($doctor) {
                $doctor->profile = $doctor->getFirstMediaUrl('avatar') ?: null;
                return $doctor;
            });

            return response()->json([
                'success' => true,
                'data' => $doctors,
                'message' => 'Available doctors retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving doctors: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's pets
     */
    public function getUserPets(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        try {
            $user = User::find($request->user_id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $pets = Pet::where('user_id', $user->id)->with(['user', 'petCategory', 'petSubcategory', 'petBreed'])
                ->where('status', 1)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $pets,
                'message' => 'User pets retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving pets: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getNormalUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_or_mobile' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $emailOrMobile = $request->input('email_or_mobile');
        $user = null;

        if (filter_var($emailOrMobile, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $emailOrMobile)->first();
        } else {
            $countryIso = Country::where('id', 18)->first();
            $phoneNumber = validationMobileNumber($emailOrMobile, $countryIso->iso);
            $user = User::where('phone', $phoneNumber)->first();
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
        if ($user) {
            $user->profile = $user->getFirstMediaUrl('avatar') ?: null;
        }
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'User found'
        ]);
    }

    /**
     * Get doctors list
    */

    public function getDoctors (Request $request) {
        try {
            $doctors = Admin::role('doctor')
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($doctor) {
                    $doctor->profile = $doctor->getFirstMediaUrl('avatar') ?: null;
                    return $doctor;
                });

            return response()->json([
                'success' => true,
                'data' => $doctors,
                'message' => 'Doctors retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving doctors: ' . $e->getMessage()
            ], 500);
        }


    }
}
