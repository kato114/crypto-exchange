<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\GeneralSettings;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Password;
use DB;
use App\PasswordReset;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/login';

    public function showResetForm(Request $request, $token)
    {
        $data['page_title'] = "Change Password";
         $tk =PasswordReset::where('token',$token)->first();
        
         if(is_null($tk))
         {
            return redirect()->route('user.password.request')->with('danger','Token Not Found!!');
         }else{
            $email = $tk->email;
            return view('auth.passwords.reset',$data)->with(
                ['token' => $token, 'email' => $email]
            );
         }
    }


    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());
        $tk =PasswordReset::where('token',$request->token)->first();
        $user = User::whereEmail($tk->email)->first();
        if(!$user)
        {
            return redirect()->back()->with('danger','Email don\'t match!!');
        }
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('/login')->with('success','Successfully Password Reset.');
    }
}
