<?php

namespace App\Http\Controllers;

use App\Country;
use App\Deposit;
use App\GeneralSettings;
use App\Trx;
use App\User;
use App\UserLogin;
use App\WithdrawLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserManageController extends Controller
{
    public function users()
    {
        $data['page_title'] = "User Manage";
        $data['users'] = User::latest()->paginate(20);
        return view('admin.users.index', $data);
    }

    public function userSearch(Request $request)
    {
        $this->validate($request,
            [
                'search' => 'required',
            ]);
        $data['users'] = User::where('username', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%')->orWhere('fname', 'like', '%' . $request->search . '%')->orWhere('lname', 'like', '%' . $request->search . '%')->get();
        $data['page_title'] = "Search User";
        return view('admin.users.search', $data);
    }

    public function singleUser($id)
    {
        $user = User::findorFail($id);

        $data['page_title'] = "User Manage";
        $data['user'] = $user;
        $data['last_login'] = UserLogin::whereUser_id($user->id)->orderBy('id', 'desc')->first();
        return view('admin.users.single', $data);
    }

    public function userPasschange(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate($request,
            [
                'password' => 'required|string|min:5|confirmed'
            ]);
        if ($request->password == $request->password_confirmation) {
            $user->password = bcrypt($request->password);
            $user->save();
            $msg = 'Password Changed By Admin. New Password is: ' . $request->password;
            send_email($user->email, $user->username, 'Password Changed', $msg);
            $notification = array('message' => 'Password Changed!', 'alert-type' => 'success');
            return back()->with($notification);
        } else {
            $notification = array('message' => 'Password Not Matched', 'alert-type' => 'danger');
            return back()->with($notification);
        }
    }


    public function statupdate(Request $request, $id)
    {

        $user = User::find($id);
        $this->validate($request, [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:255|unique:users,phone,' . $user->id,
        ],[
            'fname.required' => 'First Name must not be empty!',
            'lname.required' => 'Last Name must not be empty!',
        ]);
        $in = Input::except('_token', '_method');
        $user['status'] = $request->status == "1" ? 1 : 0;
        $user['email_verify'] = $request->email_verify == "1" ? 1 : 0;
        $user['phone_verify'] = $request->phone_verify == "1" ? 1 : 0;
        $user->fill($in)->save();

        $msg = 'Your Profile Updated by Admin';
        //send_email($user->email, $user->username, 'Profile Updated', $msg);

        $notification = array('message' => 'User Profile Updated Successfuly!', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function userEmail($id)
    {
        $data['user'] = User::findorFail($id);
        $data['page_title'] = "Send  Email To User";
        return view('admin.users.email', $data);
    }

    public function sendemail(Request $request)
    {

        $this->validate($request,
            [
                'emailto' => 'required|email',
                'reciver' => 'required',
                'subject' => 'required',
                'emailMessage' => 'required'
            ]);
        $to = $request->emailto;
        $name = $request->reciver;
        $subject = $request->subject;
        $message = $request->emailMessage;

        send_email($to, $name, $subject, $message);
        $notification = array('message' => 'Mail Sent Successfuly!', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function banusers()
    {
        $data['page_title'] = "Banned User";
        $data['users'] = User::where('status', '0')->orderBy('id', 'desc')->paginate(10);
        return view('admin.users.banned', $data);
    }

    public function loginLogsByUsers($id)
    {
        $user =  User::find($id);
        $logs = UserLogin::where('user_id', $id)->orderBy('id', 'DESC')->paginate(30);
        $page_title = 'Login Information';
        return view('admin.users.login-logs-by-users', compact('logs', 'page_title','user'));
    }
    public function ManageBalanceByUsers($id)
    {
        $user =  User::find($id);
        $page_title = "ADD / SUBSTRUCT BALANCE";
        return view('admin.users.balance-manage', compact('user', 'page_title'));
    }

    public function saveBalanceByUsers(Request $request)
    {
        $basic = GeneralSettings::first();

        $user = User::find($request->id);
        $this->validate($request, [
            'amount' => 'required|numeric|min:0',
            'message' => 'required'
        ]);

        if($request->operation == "on")
        {
            $user->balance += $request->amount;
            $user->save();

            $txt = $request->amount . ' ' . $basic->currency . ' credited in your account.' .'<br>'.  $request->message;
            notify($user, 'Credited our Account', $txt);
        }else{
            if(($user->balance >0) && ($request->amount < $user->balance) )
            {
                $user->balance -= $request->amount;
                $user->save();

                $txt = $request->amount . ' ' . $basic->currency . ' credited in your account.' .'<br>'. $request->message;
                notify($user, 'Debited Your Account', $txt);

            }else{
                return back()->with('alert', 'Insufficient Balance To Substract!');
            }
        }

        return back()->with('success', 'Deposit Successfully Completed!');
    }


    public function loginLogs($user = 0)
    {
        $user = User::find($user);
        if ($user) {
            $logs = UserLogin::where('user_id', $user->id)->orderBy('id', 'DESC')->paginate(20);
            $page_title = 'Login Logs Of ' . $user->name;
        } else {
            $logs = UserLogin::orderBy('id', 'DESC')->paginate(20);
            $page_title = 'User Login Logs';
        }
        return view('admin.users.login-logs', compact('logs', 'page_title'));
    }


    public function userTrans($id)
    {
        $user = User::find($id);
        $page_title = "$user->username - All Transaction";
        $deposits = Trx::whereUser_id($id)->paginate(30);
        return view('admin.users.user-trans', compact('deposits', 'page_title'));
    }
    public function userDeposit($id)
    {
        $user = User::find($id);
        $page_title = "$user->username - All Deposit";
        $deposits = Deposit::whereUser_id($id)->whereStatus(1)->latest()->paginate(30);
        return view('admin.users.user-deposit-log', compact('deposits', 'page_title'));
    }
    public function userWithdraw($id)
    {
        $user = User::find($id);
        $page_title = "$user->username - All Withdraw Request";
        $deposits = WithdrawLog::whereUser_id($id)->where('status','!=',0)->latest()->paginate(30);
        return view('admin.users.user-withdraw', compact('deposits', 'page_title'));
    }
}
