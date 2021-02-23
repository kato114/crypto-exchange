<?php

namespace App\Http\Controllers;

use App\Admin;
use App\BuyMoney;
use App\ExchangeMoney;
use App\Provider;
use App\SellMoney;
use App\Trx;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\GeneralSettings;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use File;
use Image;
class AdminController extends Controller
{
	public function __construct(){
		$Gset = GeneralSettings::first();
		$this->sitename = $Gset->sitename;
		$this->middleware('auth:admin');
	}

    public function exchangeLog()
    {
        $data['exchange'] = ExchangeMoney::where('status', '!=',0)->latest()->paginate(20);
        $data['page_title'] = 'Manage Exchange Log';
        return view('admin.currency.exchange-list', $data);
	}

    public function exchangeInfo($id)
    {
        $get = ExchangeMoney::where('id',$id)->where('status','!=',0)->first();
        if($get)
        {
            $data['exchange'] = $get;
            $data['page_title'] = ' Exchange Log Details';
            return view('admin.currency.exchange-info', $data);
        }
        abort(404);
	}

    public function exchangeAction(Request $request)
    {
        $request->validate([
            'button' => 'required',
            'id' => 'required',
        ]);
        $data = ExchangeMoney::find($request->id);
        if($request->button == "approve")
        {
            $data->status= 2;
        }else{
            $data->status= -2;
        }
        $data->save();

        $notification =  array('message' => 'Saved Successfully !!', 'alert-type' => 'success');
        return back()->with($notification);
	}

    public function buyLog()
    {
        $data['exchange'] = BuyMoney::where('status', '!=',0)->latest()->paginate(20);
        $data['page_title'] = 'Manage Buy Log';
        return view('admin.currency.buy-list', $data);
    }
    public function buyInfo($id)
    {
        $get = BuyMoney::where('id',$id)->where('status','!=',0)->first();
        if($get)
        {
            $data['exchange'] = $get;
            $data['page_title'] = ' Buy Log Details';
            return view('admin.currency.buy-info', $data);
        }
        abort(404);
    }

    public function buyAction(Request $request)
    {
        $request->validate([
            'button' => 'required',
            'id' => 'required',
        ]);
        $data = BuyMoney::find($request->id);
        $basic = GeneralSettings::first();
        if($request->button == "approve")
        {
            $data->status= 2;
        }else{
            if($data->type == 0)
            {
                $user = User::find($data->user_id);
                $user->balance += $data->enter_amount;
                $user->save();

                Trx::create([
                    'user_id' => $user->id,
                    'amount' => $data->enter_amount,
                    'main_amo' => round($user->balance, $basic->decimal),
                    'charge' => 0,
                    'type' => '+',
                    'title' => ' Buy Amount return ' . $data->enter_amount . ' ' . $basic->currency,
                    'trx' =>  rand(000000, 999999) . rand(000000, 999999)
                ]);
                $msg =  ' Buy Amount return ' . $data->enter_amount . ' ' . $basic->currency;
                send_email($user->email, $user->username, 'Buy Amount return ', $msg);
            }
            $data->status= -2;
        }
        $data->save();

        $notification =  array('message' => 'Saved Successfully !!', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function sellLog()
    {
        $data['exchange'] = SellMoney::where('status', '!=',0)->latest()->paginate(20);
        $data['page_title'] = 'Manage Sell Log';
        return view('admin.currency.sell-list', $data);
    }
    public function sellInfo($id)
    {
        $get = SellMoney::where('id',$id)->where('status','!=',0)->first();
        if($get)
        {
            $data['exchange'] = $get;
            $data['page_title'] = ' Sell Log Details';
            return view('admin.currency.sell-info', $data);
        }
        abort(404);
    }

    public function sellAction(Request $request)
    {
        $request->validate([
            'button' => 'required',
            'id' => 'required',
        ]);
        $data = SellMoney::find($request->id);
        $basic = GeneralSettings::first();
        if($request->button == "approve")
        {
            $data->status= 2;
            if($data->type == 0)
            {
                $user = User::find($data->user_id);
                $user->balance += $data->get_amount;
                $user->save();

                Trx::create([
                    'user_id' => $user->id,
                    'amount' => $data->get_amount,
                    'main_amo' => round($user->balance, $basic->decimal),
                    'charge' => 0,
                    'type' => '+',
                    'title' => ' Sell Amount  ' . $data->get_amount . ' ' . $basic->currency,
                    'trx' =>  rand(000000, 999999) . rand(000000, 999999)
                ]);
                $msg =  ' Sell Amount  ' . $data->get_amount . ' ' . $basic->currency;
                send_email($user->email, $user->username, 'Sell Amount  ', $msg);
            }
        }else{
            $data->status= -2;
        }
        $data->save();

        $notification =  array('message' => 'Saved Successfully !!', 'alert-type' => 'success');
        return back()->with($notification);
    }



	public function socialLogin()
    {
        $data['page_title'] = 'Manage Social Login';
        $data['providers'] = Provider::all();
        return view('admin.social-login.index', $data);
    }

    public function socialLoginUpd(Request $request)
    {
        $data =  Provider::find($request->id);
        $data->client_id =  $request->name;
        $data->client_secret =  $request->account;
        $data->save();

        $notification =  array('message' => 'Updated Successfully !!', 'alert-type' => 'success');
        return back()->with($notification);
    }


    public function dashboard()
    {
        $data['page_title'] = 'DashBoard';
        return view('admin.dashboard', $data);
    }


    public function changePassword()
    {
        $data['page_title'] = "Change Password";
        return view('admin.change_password',$data);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $user = Auth::guard('admin')->user();

        $oldPassword = $request->old_password;
        $password = $request->new_password;
        $passwordConf = $request->password_confirmation;

        if (!Hash::check($oldPassword, $user->password) || $password != $passwordConf) {
            $notification =  array('message' => 'Password Do not match !!', 'alert-type' => 'error');
            return back()->with($notification);
        }elseif (Hash::check($oldPassword, $user->password) && $password == $passwordConf)
        {
            $user->password = bcrypt($password);
            $user->save();
            $notification =  array('message' => 'Password Changed Successfully !!', 'alert-type' => 'success');
            return back()->with($notification);
        }
    }


    public function profile()
    {
        $data['admin'] = Auth::user();
        $data['page_title'] = "Profile Settings";
        return view('admin.profile',$data);
    }

    public function updateProfile(Request $request)
    {
        $data = Admin::find($request->id);
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|max:50|unique:admins,email,'.$data->id,
            'mobile' => 'required|regex:/(01)[0-9]{9}/',
        ]);

        $in = Input::except('_method','_token');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'admin_'.time().'.jpg';
            $location = 'assets/admin/img/' . $filename;
            Image::make($image)->resize(300,300)->save($location);
            $path = './assets/admin/img/';
            File::delete($path.$data->image);
            $in['image'] = $filename;
        }
        $data->fill($in)->save();

        $notification =  array('message' => 'Profile Update Successfully', 'alert-type' => 'success');
        return back()->with($notification);
    }





    public function logout()    {
		Auth::guard('admin')->logout();
		session()->flash('message', 'Just Logged Out!');
		return redirect('/admin');
	}

}
