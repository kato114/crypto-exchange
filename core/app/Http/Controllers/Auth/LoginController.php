<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\UserLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
    public function username()
    {
        return 'username';
    }

    public function authenticated(Request $request, $user)
    {

        if($user->status == 0){
            $this->guard()->logout();
            $notification =  array('message' => 'Sorry Your Account is Block Now.!','alert-type' => 'warning');
            return redirect('/login')->with($notification);
        }

        $user->login_time = Carbon::now();
        $user->save();
        $ul['user_id'] = $user->id;
        $ul['user_ip'] =  request()->ip();
//        $ul['location'] = $city.(" - $area - ").$currency .(" - $code ");
//        $ul['details'] = $browser.' on '.$os_platform;
        UserLogin::create($ul);
    }
    public function logout(Request $request)
    {
        Auth::guard()->logout();
        return redirect('/login')->with('logout','You have been logged out!');
    }


}
