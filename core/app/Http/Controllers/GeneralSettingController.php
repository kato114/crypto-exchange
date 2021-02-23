<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\GeneralSettings;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use File;
use Image;


class GeneralSettingController extends Controller
{

	public function __construct(){
		$Gset = GeneralSettings::first();
		$this->sitename = $Gset->sitename;
	}
	public function GenSetting(){
		$data['page_title'] = 'General Settings';
			$data['general'] = GeneralSettings::first();
		return view('admin.general', $data);
	}

	public function UpdateGenSetting(Request $request)
    {
        $request->validate([

            'currency' => 'required',
            'currency_sym' => 'required',
            'sitename' => 'required',
            'decimal' => 'required|integer|min:1',
            'level_one' => 'required|numeric|min:0',
            'level_two' => 'required|numeric|min:0',
            'level_three' => 'required|numeric|min:0',
        ],[
            'currency_sym.required' => 'Currency symbol must not be empty',
            ]);

        $gs = GeneralSettings::first();
        $in = Input::except('_token');
        $in['color'] = ltrim($request->color,'#');
        $in['registration'] = $request->registration == 'on' ? '1' : '0';
        $in['email_verification'] = $request->email_verification == 'on' ? '1' : '0';
        $in['sms_verification'] = $request->sms_verification == 'on' ? '1' : '0';
        $in['email_notification'] = $request->email_notification == 'on' ? '1' : '0';
        $in['sms_notification'] = $request->sms_notification == 'on' ? '1' : '0';
        $res = $gs->fill($in)->save();

			if ($res) {
				return back()->with('success', 'Updated Successfully!');
			}else{
				return back()->with('alert', 'Problem With Updating');
			}
	}


    public function getContact()
    {
        $data['basic'] = GeneralSettings::first();
        $data['page_title'] = "Contact Settings";
        return view('admin.webControl.contact-setting',$data);
    }

    public function putContactSetting(Request $request)
    {
        $basic = GeneralSettings::first();
        $request->validate([
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);
        $in = Input::except('_method','_token');
        $in['location'] = $request->location == 'on' ? '1' : '0';
        $basic->fill($in)->save();

        $notification =  array('message' => 'Contact  Updated Successfully', 'alert-type' => 'success');
        return back()->with($notification);
    }



}
