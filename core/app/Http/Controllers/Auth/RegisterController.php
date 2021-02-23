<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;



use App\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Carbon\Carbon;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'user/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric|min:8|unique:users',
            'username' => 'required|min:5|unique:users|regex:/^\S*$/u',
            'password' => 'required|string|min:4|confirmed',
        ],
            [
                'fname.required' => 'First Name  must not be  empty!!',
                'lname.required' => 'Last Name  must not be  empty!!',
                'phone.required' => 'Contact Number is required!!',
                'email.required' => 'Email Address must not be  empty!!',
                'username.required' => 'username must not be  empty!!',
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {


        $basic = GeneralSettings::first();

        if ($basic->email_verification == 1) {
            $email_verify = 0;
        } else {
            $email_verify = 1;
        }

        if ($basic->sms_verification == 1) {
            $phone_verify = 0;
        } else {
            $phone_verify = 1;
        }
        if(isset($data['referBy'])){
            $referUser = User::where('username',$data['referBy'])->first();
        }

        $verification_code  = strtoupper(Str::random(6));
        $sms_code  = strtoupper(Str::random(6));
        $email_time = Carbon::parse()->addMinutes(5);
        $phone_time = Carbon::parse()->addMinutes(5);

        $user = User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => strtolower($data['username']),
            'refer' =>  isset($data['referBy']) ?  $referUser->id : 0,
            'email_verify' => $email_verify,
            'verification_code' => $verification_code,
            'sms_code' => $sms_code,
            'email_time' => $email_time,
            'phone_verify' => $phone_verify,
            'phone_time' => $phone_time,
            'password' => Hash::make($data['password']),
        ]);


        return $user;
    }


    protected function registered(Request $request, $user)
    {
        $basic = GeneralSettings::first();

        if ($basic->email_verification == 1) {
            $email_code = strtoupper(Str::random(6));
            $text = "Your Verification Code Is: <b>$email_code</b>";
            send_email_verification($user->email, $user->username, 'Email verification', $text);

            $user->verification_code = $email_code;
            $user->email_time = Carbon::parse()->addMinutes(5);
            $user->save();
        }
        if ($basic->sms_verification == 1) {
            $sms_code = strtoupper(Str::random(6));
            $txt = "Your phone verification code is: $sms_code";
            $to = $user->phone;
            send_sms_verification($to, $txt);

            $user->sms_code = $sms_code;
            $user->phone_time = Carbon::parse()->addMinutes(5);
            $user->save();
        }
    }

    public function sendSms($to, $text)
    {


        $temp = Etemplate::first();
        $appi =  $temp->smsapi;
        $text = urlencode($text);
        $appi = str_replace("{{number}}", $to, $appi);
        $appi = str_replace("{{message}}", $text, $appi);
        $result = file_get_contents($appi);
    }


}
