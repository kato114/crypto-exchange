<?php

namespace App\Http\Controllers;

use App\Trx;
use App\Wallet;
use Illuminate\Http\Request;
use App\WithdrawMethod;
use App\WithdrawLog;
use App\User;
use App\GeneralSettings;
use Illuminate\Support\Facades\Input;

class WithdrawController extends Controller
{
    public function __construct()
    {
    }
    
    public function index()
    {
        $page_title = "Withdraw Methods";
    	$withdarws = WithdrawMethod::latest()->get();
    	return view('admin.withdraw.index', compact('withdarws','page_title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpg,png',
            'duration' => 'required',
            'fix' => 'required|numeric|min:0',
            'percent' => 'required|numeric|min:0',
            'withdraw_max' => 'required|numeric|min:0',
            'withdraw_min' => 'required|numeric|min:0',
        ]);

        $in = Input::except('_token','image');
        if($request->hasFile('image'))
        {
            $in['image'] = uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move('assets/images',$in['image']);
        }

        WithdrawMethod::create($in);

        return back()->with('success', 'Withdraw Settings Updated Successfully!');
    }

    public function withdrawUpdateSettings(Request $request)
    {

        $request->validate([
            'image' => 'nullable|mimes:jpg,png',
            'duration' => 'required',
            'fix' => 'required|numeric|min:0',
            'percent' => 'required|numeric|min:0',
            'withdraw_max' => 'required|numeric|min:0',
            'withdraw_min' => 'required|numeric|min:0',
        ]);
        $data = WithdrawMethod::find($request->id);
        $in = Input::except('_token','image');
        if($request->hasFile('image'))
        {
            $path = 'assets/images/'.$data->image;
            if(file_exists($path)){
                @unlink($path);
            }
            $data['image'] = uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move('assets/images',$data['image']);
        }
        $data->fill($in)->save();
        return back()->with('success', 'Withdraw Settings Updated Successfully!');
    }

    public function requests()
    {
    	$withdrawLog = WithdrawLog::latest()->where('status',1)->paginate(20);
        $page_title = " Withdraw Request";
    	return view('admin.withdraw.requests', compact('withdrawLog','page_title'));
    }

    public function requestsApprove()
    {
        $bits = WithdrawLog::latest()->where('status', 2)->paginate(20);
        $page_title = " Withdraw Approved";
        return view('admin.withdraw.history', compact('bits','page_title'));
    }

    public function requestsRefunded()
    {
        $bits = WithdrawLog::latest()->where('status', -2)->paginate(20);
        $page_title = " Withdraw Refunded";
        return view('admin.withdraw.history', compact('bits','page_title'));
    }

     public function approve(Request $request, $id)
    {
        $basic = GeneralSettings::first();
        $withdr = WithdrawLog::findorFail($id);
        $withdr['status'] = 2;
        $withdr->save();
        return back()->with('success', 'Withdraw Request Approved Successfully!');
    }

    public function refundAmount(Request $request)
    {
        $basic = GeneralSettings::first();
        $withdr = WithdrawLog::findorFail($request->id);
        $withdr['status'] = -2;
        $withdr->save();

        $userWallet = User::find($withdr['user_id']);
        $userWallet->balance += $request->net_amount;
        $userWallet->save();

        $tr = strtoupper(str_random(20));
        $trx = Trx::create([
            'user_id' => $userWallet->id,
            'amount' => $request->net_amount,
            'main_amo' => round($userWallet->balance, $basic->decimal),
            'charge' => 0,
            'type' => '+',
            'title' => 'Withdraw Amount '.$request->net_amount . ' '.$basic->currency .' Refunded.',
            'trx' => $tr,
        ]);


        $msg =  'Your withdraw amount ' . $request->net_amount. ' '.$basic->currency .' refund  successfully ' ;
        send_email($userWallet->email, $userWallet->username, 'Withdraw Amount Refund', $msg);
        send_sms($userWallet->phone, $msg);

        return back()->with('success', 'Withdraw Amount Refund Successfully!');
    }





}
