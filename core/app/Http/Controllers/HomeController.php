<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BuyMoney;
use App\Currency;
use App\Deposit;
use App\ExchangeMoney;
use App\Gateway;
use App\GeneralSettings;
use App\SellMoney;
use App\Trx;
use App\WithdrawLog;
use App\WithdrawMethod;
use Illuminate\Http\Request;
use Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Session;
use Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = "Dashboard";
        $user = Auth::user();
        $data['sellCurrency'] = SellMoney::whereUser_id($user->id)->where('status', '!=', 0)->latest()->take(15)->get();
        $data['buyMoney'] = BuyMoney::whereUser_id($user->id)->where('status', '!=', 0)->latest()->take(15)->get();
        $data['exchange'] = ExchangeMoney::whereUser_id($user->id)->where('status', '!=', 0)->latest()->take(20)->get();
        return view('home', $data);
    }


    public function authCheck()
    {
        if (Auth()->user()->status == '1' && Auth()->user()->email_verify == '1' && Auth()->user()->sms_verify == '1') {
            return redirect()->route('home');
        } else {
            $data['page_title'] = "Authorization";
            return view('user.authorization', $data);
        }
    }

    public function sendVcode(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if (Carbon::parse($user->phone_time)->addMinutes(1) > Carbon::now()) {
            $time = Carbon::parse($user->phone_time)->addMinutes(1);
            $delay = $time->diffInSeconds(Carbon::now());
            $delay = gmdate('i:s', $delay);
            session()->flash('danger', 'You can resend Verification Code after ' . $delay . ' minutes');
        } else {
            $code = strtoupper(Str::random(6));
            $user->phone_time = Carbon::now();
            $user->sms_code = $code;
            $user->save();
            send_sms($user->phone, 'Your Verification Code is ' . $code);

            session()->flash('success', 'Verification Code Send successfully');
        }
        return back();
    }

    public function smsVerify(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($user->sms_code == $request->sms_code) {
            $user->phone_verify = 1;
            $user->save();
            session()->flash('success', 'Your Profile has been verfied successfully');
            return redirect()->route('home');
        } else {
            session()->flash('danger', 'Verification Code Did not matched');
        }
        return back();
    }

    public function sendEmailVcode(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if (Carbon::parse($user->email_time)->addMinutes(1) > Carbon::now()) {
            $time = Carbon::parse($user->email_time)->addMinutes(1);
            $delay = $time->diffInSeconds(Carbon::now());
            $delay = gmdate('i:s', $delay);
            session()->flash('danger', 'You can resend Verification Code after ' . $delay . ' minutes');
        } else {
            $code = strtoupper(Str::random(6));
            $user->email_time = Carbon::now();
            $user->verification_code = $code;
            $user->save();
            send_email($user->email, $user->username, 'Verificatin Code', 'Your Verification Code is ' . $code);
            session()->flash('success', 'Verification Code Send successfully');
        }
        return back();
    }

    public function postEmailVerify(Request $request)
    {

        $user = User::find(Auth::user()->id);
        if ($user->verification_code == $request->email_code) {
            $user->email_verify = 1;
            $user->save();
            session()->flash('success', 'Your Profile has been verfied successfully');
            return redirect()->route('home');
        } else {
            session()->flash('danger', 'Verification Code Did not matched');
        }
        return back();
    }


    public function editProfile()
    {
        $auth = Auth::user();
        $data['page_title'] = "Edit Profile";
        $data['user'] = User::findOrFail($auth->id);
        return view('user.edit-profile', $data);
    }

    public function submitProfile(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|min:10|unique:users,phone,' . $user->id,
//            'username' => 'required|min:5||regex:/^\S*$/u|unique:users,username,' . $user->id,
            'image' => 'mimes:png,jpg,jpeg'
        ], [
            'fname.required' => 'First Name must not be empty',
            'lname.required' => 'Last Name must not be empty',
        ]);
        $in = Input::except('_method', '_token');
        $in['reference'] = $request->username;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $request->username . '.jpg';
            $location = 'assets/images/user/' . $filename;
            $in['image'] = $filename;
            if ($user->image != 'user-default.png') {
                $path = './assets/images/user/';
                $link = $path . $user->image;
                if (file_exists($link)) {
                    @unlink($link);
                }
            }
            Image::make($image)->resize(800, 800)->save($location);
        }
        $user->fill($in)->save();
        return back()->with('success', 'Profile Updated Successfully.');

    }

    public function changePassword()
    {
        $data['page_title'] = "Change Password";
        $auth = Auth::user();

        return view('user.change-password', $data);
    }

    public function submitPassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {
            $c_password = Auth::user()->password;
            $c_id = Auth::user()->id;
            $user = User::findOrFail($c_id);
            if (Hash::check($request->current_password, $c_password)) {

                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();

                return back()->with('success', 'Password Changes Successfully.');
            } else {
                return back()->with('danger', 'Current Password Not Match');
            }

        } catch (\PDOException $e) {
            return back()->with('danger', $e->getMessage());
        }
    }


    public function deposit()
    {
        $data['page_title'] = " Payment Methods";
        $data['gates'] = Gateway::whereStatus(1)->get();
        return view('user.deposit', $data);
    }

    public function depositDataInsert(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:1',
            'gateway' => 'required',
        ]);

        if ($request->amount <= 0) {
            return back()->with('danger', 'Invalid Amount');
        } else {
            $gate = Gateway::findOrFail($request->gateway);

            if (isset($gate)) {
                if ($gate->minamo <= $request->amount && $gate->maxamo >= $request->amount) {
                    $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
                    $usdamo = ($request->amount + $charge) / $gate->rate;


                    $depo['user_id'] = Auth::id();
                    $depo['gateway_id'] = $gate->id;
                    $depo['amount'] = $request->amount;
                    $depo['charge'] = $charge;
                    $depo['usd'] = round($usdamo, 2);
                    $depo['btc_amo'] = 0;
                    $depo['btc_wallet'] = "";
                    $depo['trx'] = str_random(16);
                    $depo['try'] = 0;
                    $depo['status'] = 0;
                    Deposit::create($depo);

                    Session::put('Track', $depo['trx']);

                    return redirect()->route('user.deposit.preview');

                } else {
                    return back()->with('danger', 'Please Follow Deposit Limit');
                }
            } else {
                return back()->with('danger', 'Please Select Deposit gateway');
            }
        }
    }

    public function depositPreview()
    {

        $track = Session::get('Track');
        $data = Deposit::where('status', 0)->where('trx', $track)->first();
        $page_title = "Deposit Preview";
        $auth = Auth::user();
        return view('user.payment.preview', compact('data', 'page_title'));
    }


    public function withdrawMoney()
    {
        $data['withdrawMethod'] = WithdrawMethod::whereStatus(1)->get();
        $data['page_title'] = "Withdraw Money";
        return view('user.withdraw-money', $data);
    }

    public function requestPreview(Request $request)
    {
        $this->validate($request, [
            'method_id' => 'required|numeric',
            'amount' => 'required|numeric'
        ]);
        $basic = GeneralSettings::first();
        $bal = User::findOrFail(Auth::user()->id);

        $method = WithdrawMethod::findOrFail($request->method_id);
        $ch = $method->fix + round(($request->amount * $method->percent) / 100, $basic->decimal);
        $reAmo = $request->amount + $ch;
        if ($reAmo < $method->withdraw_min) {
            return back()->with('alert', 'Your Request Amount is Smaller Then Withdraw Minimum Amount.');
        }
        if ($reAmo > $method->withdraw_max) {
            return back()->with('alert', 'Your Request Amount is Larger Then Withdraw Maximum Amount.');
        }
        if ($reAmo > $bal->balance) {
            return back()->with('alert', 'Your Request Amount is Larger Then Your Current Balance.');
        } else {

            $tr = strtoupper(str_random(20));
            $w['amount'] = $request->amount;
            $w['method_id'] = $request->method_id;
            $w['charge'] = $ch;
            $w['transaction_id'] = $tr;
            $w['net_amount'] = $reAmo;
            $w['user_id'] = Auth::user()->id;
            $trr = WithdrawLog::create($w);
            $data['withdraw'] = $trr;
            Session::put('wtrx', $trr->transaction_id);

            $data['method'] = $method;
            $data['balance'] = Auth::user();

            $data['page_title'] = "Withdraw Preview";
            return view('user.withdraw-preview', $data);
        }
    }


    public function requestSubmit(Request $request)
    {
        $basic = GeneralSettings::first();
        $this->validate($request, [
            'withdraw_id' => 'required|numeric',
            'send_details' => 'required'
        ]);

        $ww = WithdrawLog::findOrFail($request->withdraw_id);
        $ww->send_details = $request->send_details;
        $ww->message = $request->message;
        $ww->status = 1;
        $ww->save();

        $user = Auth::user();
        $user->balance = $user->balance - $ww->net_amount;
        $user->save();

        $trx = Trx::create([
            'user_id' => $user->id,
            'amount' => $ww->amount,
            'main_amo' => round($user->balance, $basic->decimal),
            'charge' => $ww->charge,
            'type' => '-',
            'title' => 'Withdraw Via ' . $ww->method->name,
            'trx' => $ww->transaction_id
        ]);

        $text = $ww->amount . " - " . $basic->currency . " Withdraw Request Send via " . $ww->method->name . ". <br> Transaction ID Is : <b>#$ww->transaction_id</b>";
        notify($user, 'Withdraw Via ' . $ww->method->name, $text);
        return redirect()->route('withdraw.money')->with('success', 'Withdraw request Successfully Submitted. Wait For Confirmation.');
    }



    public function activity()
    {
        $user = Auth::user();
        $data['invests'] = Trx::whereUser_id($user->id)->latest()->paginate(15);
        $data['page_title'] = "Transaction Log";
        return view('user.trx', $data);
    }

    public function depositLog()
    {
        $user = Auth::user();

        $data['page_title'] = "Deposit Log";
        $data['invests'] = Deposit::whereUser_id($user->id)->whereStatus(1)->latest()->paginate(15);
        return view('user.deposit-log', $data);
    }
    public function withdrawLog()
    {
        $user = Auth::user();
        $data['invests'] = WithdrawLog::whereUser_id($user->id)->where('status', '!=', 0)->latest()->paginate(15);
        $data['page_title'] = "Withdraw Log";
        return view('user.withdraw-log', $data);
    }





    public function buy(Request $request)
    {
        $this->validate($request, [
            'enter_amount' => 'required|numeric|min:0',
            'get_amount' => 'required|numeric|min:0',
            'currency_id' => 'required',
            'radio' => 'required',
        ], [
            'radio.required' => 'Please select a method to payment '
        ]);

        $auth = Auth::user();
        $basic = GeneralSettings::first();

        $currency = Currency::whereId($request->currency_id)->first();
        $charge = ($request->enter_amount * $currency->buy) / 100;
        $chargeFromEnterAmo = ($request->enter_amount - $charge);
        $getAmo = round(($chargeFromEnterAmo * $currency->price), 8);


        if ($request->radio == "pay_bank") {

            $buy['currency_id'] = $currency->id;
            $buy['enter_amount'] = round($request->enter_amount, 8);
            $buy['get_amount'] = $request->get_amount;
            $buy['buy_charge'] = round($charge, $basic->decimal);
            $buy['buy_price'] = $currency->price;

            $buy['user_id'] = Auth::id();
            $buy['type'] = 1;
            $buy['trx'] = rand(000000, 999999) . rand(000000, 999999);
            $data = BuyMoney::create($buy)->trx;

            return redirect()->route('buy.buyPreview', $data);
        } elseif ($request->radio == "pay_wallet") {

            if ($auth->balance >= $request->enter_amount) {

                if ($currency->available_balance >= $request->enter_amount) {

                    $buy['currency_id'] = $currency->id;
                    $buy['enter_amount'] = round($request->enter_amount, 8);
                    $buy['get_amount'] = $request->get_amount;
                    $buy['buy_charge'] = round($charge, $basic->decimal);
                    $buy['buy_price'] = $currency->price;

                    $buy['user_id'] = Auth::id();
                    $buy['trx'] = rand(000000, 999999) . rand(000000, 999999);
                    $data = BuyMoney::create($buy)->trx;

                    return redirect()->route('buy.buyPreview', $data);
                }
                return back()->with("alert", "Insufficient Reserve Balance in $currency->symbol ");
            }
            return back()->with('alert', 'Insufficient Balance \n You need deposit your account');

        }

    }

    public function buyPreview($trx)
    {
        $auth = Auth::user();
        $buy = BuyMoney::where('trx', $trx)->where('user_id', $auth->id)->whereStatus(0)->first();
        $data['page_title'] = "Buy Currency";
        $data['banks'] = Bank::all();
        $data['buy'] = $buy;

        if ($buy->type == 0) {
            return view('user.buy-preview', $data);
        } elseif ($buy->type == 1) {
            return view('user.buy-preview-bank', $data);
        }
        abort(404);
    }

    public function buyConfirm(Request $request)
    {
        $this->validate($request, [
            'info' => 'required',
            'account' => 'required',
        ]);

        $auth = Auth::user();
        $buy = BuyMoney::where('trx', $request->trx)->where('user_id', $auth->id)->whereStatus(0)->first();
        $basic = GeneralSettings::first();

        if ($buy) {

            $availableBalance = $buy->currency->available_balance;
            $buy->get_amount;

            if ($auth->balance >= $buy->enter_amount) {
                if ($availableBalance >= $buy->get_amount) {
                    $buy->account = $request->account;
                    $buy->info = $request->info;
                    $buy->status = 1;
                    $buy->save();

                    $user = User::find($buy->user_id);
                    $user->balance = round(($user->balance - $buy->enter_amount), $basic->decimal);
                    $user->save();


                    Trx::create([
                        'user_id' => $user->id,
                        'amount' => $buy->enter_amount,
                        'main_amo' => round($user->balance, $basic->decimal),
                        'charge' => 0,
                        'type' => '-',
                        'title' => ' Buy Amount ' . $buy->get_amount . ' ' . $buy->currency->symbol,
                        'trx' => $buy->trx
                    ]);
                    $txt = $buy->get_amount . ' ' . $buy->currency->symbol . ' Buy Amount  ';
                    send_email($user->email, $user->username, 'Buy Amount', $txt);
                    return redirect()->route('buy')->with("success", "  Your Request Successful Send");
                }
                return back()->with("alert", "Insufficient Reserve Balance in " . $buy->currency->symbol);
            }
            return back()->with('alert', 'Insufficient Balance \n You need deposit your account');
        }
        abort(404);
    }

    public function buyConfirmSlip(Request $request)
    {
        $this->validate($request,
            [
                'trx' => 'required',
                'info' => 'required',
                'account' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg',
            ], [
                'image.required' => 'Transcation Screenshot is required.',
                'info.required' => 'Transcation Details  is required.'
            ]);

        $auth = Auth::user();
        $buy = BuyMoney::where('trx', $request->trx)->where('user_id', $auth->id)->whereStatus(0)->first();
        $basic = GeneralSettings::first();

        if ($buy) {

            $availableBalance = $buy->currency->available_balance;
            $buy->get_amount;

            if ($availableBalance >= $buy->get_amount) {
                $buy->account = $request->account;
                $buy->info = $request->info;

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $filename = $buy->trx . '.jpg';
                    $location = 'assets/images/exchange/' . $filename;
                    $buy->image = $filename;

                    Image::make($image)->save($location);
                }

                $buy->status = 1;
                $buy->save();

                return redirect()->route('buy')->with("success", "  Your Request Successful Send");
            }
            return back()->with("alert", "Insufficient Reserve Balance in " . $buy->currency->symbol);

        }
        abort(404);
    }


    public function sell(Request $request)
    {
        $this->validate($request, [
            'enter_amount' => 'required|numeric|min:0',
            'get_amount' => 'required|numeric|min:0',
            'currency_id' => 'required',
            'radio' => 'required',
        ], [
            'radio.required' => 'Please select a method to cash in '
        ]);

        $auth = Auth::user();
        $basic = GeneralSettings::first();

        $currency = Currency::whereId($request->currency_id)->first();
        $charge = ($request->enter_amount * $currency->sell) / 100;
        $chargeFromEnterAmo = ($request->enter_amount - $charge);
        $getAmo = round(($chargeFromEnterAmo * $currency->price), 8);


        if ($request->radio == "pay_bank") {

            $buy['currency_id'] = $currency->id;
            $buy['enter_amount'] = $request->get_amount;
            $buy['get_amount'] = round($request->enter_amount, 8);
            $buy['sell_charge'] = round($charge, $basic->decimal);
            $buy['sell_price'] = $currency->price;

            $buy['user_id'] = Auth::id();
            $buy['type'] = 1;
            $buy['trx'] = rand(000000, 999999) . rand(000000, 999999);
            $data = SellMoney::create($buy)->trx;

            return redirect()->route('sell.preview', $data);
        } elseif ($request->radio == "pay_wallet") {
            if ($currency->available_balance >= $request->enter_amount) {
                $buy['currency_id'] = $currency->id;
                $buy['enter_amount'] =  $request->get_amount;
                $buy['get_amount'] = round($request->enter_amount, 8);
                $buy['sell_charge'] = round($charge, $basic->decimal);
                $buy['sell_price'] = $currency->price;
                $buy['user_id'] = Auth::id();
                $buy['trx'] = rand(000000, 999999) . rand(000000, 999999);
                $data = SellMoney::create($buy)->trx;
                return redirect()->route('sell.preview', $data);
            }
            return back()->with("alert", "Insufficient Reserve Balance in $currency->symbol ");
        }
    }


    public function sellPreview($trx)
    {
        $auth = Auth::user();
        $sell = SellMoney::where('trx', $trx)->where('user_id', $auth->id)->whereStatus(0)->first();
        $data['page_title'] = "Sell Currency";
        $data['banks'] = Bank::all();
        $data['buy'] = $sell;
        if ($sell->type == 0) {
            return view('user.sell-preview', $data);
        } elseif ($sell->type == 1) {
            return view('user.sell-preview-bank', $data);
        }
        abort(404);
    }

    public function sellConfirm(Request $request)
    {
        $this->validate($request, [
            'account' => 'required',
            'image' => 'required',
        ], [
            'image.required' => 'Transaction screenshot is required',
            'account.required' => 'Transaction number is required',
        ]);

        $auth = Auth::user();
        $sell = SellMoney::where('trx', $request->trx)->where('user_id', $auth->id)->whereStatus(0)->first();
        $basic = GeneralSettings::first();

        if ($sell) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = $sell->trx . '.jpg';
                $location = 'assets/images/exchange/' . $filename;
                $sell->image = $filename;
                Image::make($image)->save($location);
            }
            $sell->account = $request->account;
            $sell->info = $request->info;
            $sell->status = 1;
            $sell->save();
            return redirect()->route('sell')->with("success", "  Your Request Successful Send");
        }
        abort(404);
    }
    public function sellConfirmBank(Request $request)
    {
        $this->validate($request, [
            'account' => 'required',
            'image' => 'required',
            'info' => 'required',
        ], [
            'image.required' => 'Transaction screenshot is required',
            'account.required' => 'Transaction number is required',
            'info.required' => 'Enter your account information ',
        ]);

        $auth = Auth::user();
        $sell = SellMoney::where('trx', $request->trx)->where('user_id', $auth->id)->whereStatus(0)->first();
        $basic = GeneralSettings::first();

        if ($sell) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = $sell->trx . '.jpg';
                $location = 'assets/images/exchange/' . $filename;
                $sell->image = $filename;
                Image::make($image)->save($location);
            }
            $sell->account = $request->account;
            $sell->info = $request->info;
            $sell->status = 1;
            $sell->save();
            return redirect()->route('sell')->with("success", "  Your Request Successful Send");
        }
        abort(404);
    }

    public function exchange(Request $request)
    {
        $this->validate($request,
            [
                'from_amount' => 'required|numeric|min:0',
                'from_currency_id' => 'required',
                'receive_amount' => 'required|numeric|min:0',
                'receive_currency_id' => 'required',
            ]);

        $enterAmount = $request->from_amount;
        $fromCurrency = Currency::whereId($request->from_currency_id)->first();
        $fromAmountPrice = $fromCurrency->price;
        $fromAmountExchangeCharge = $fromCurrency->exchange;


        $receiveAmountPrice = $request->receive_amount;
        $receiveCurrency = Currency::whereId($request->receive_currency_id)->first();
        $receiveAmountPrice = $receiveCurrency->price;
        $receiveAmountExchangeCharge = $receiveCurrency->exchange;


        $getAmountTotal = (($receiveAmountPrice / $fromAmountPrice) * $enterAmount);
        $chargeFromTotalAmoFromEnter = (($getAmountTotal * $receiveAmountExchangeCharge) / 100);
        $getAmountInput = ($getAmountTotal - $chargeFromTotalAmoFromEnter);

        $data['user_id'] = Auth::id();
        $data['trx'] = rand(000000, 999999) . rand(000000, 999999);
        $data['from_amount'] = $request->from_amount;
        $data['from_amount_charge'] = round($chargeFromTotalAmoFromEnter, 6);
        $data['from_currency_id'] = $fromCurrency->id;
        $data['receive_amount'] = round($getAmountInput, 6);
        $data['receive_currency_id'] = $receiveCurrency->id;
        $getTrx = ExchangeMoney::create($data)->trx;

        return redirect()->route('exchange.preview', $getTrx);
    }

    public function exchangePreview($trx)
    {
        $auth = Auth::user();
        $exchange = ExchangeMoney::where('trx', $trx)->where('user_id', $auth->id)->whereStatus(0)->first();
        if ($exchange) {
            $data['page_title'] = "Exchange Preview";
            $data['exchange'] = $exchange;
            return view('user.exchange-preview', $data);
        }
        abort(404);
    }

    public function exchangeConfirm(Request $request)
    {
        $this->validate($request,
            [
                'image' => 'required|mimes:png,jpg,jpeg|max:1024',
                'trx' => 'required',
                'transaction_number' => 'required',
                'user_payment_id' => 'required'
            ], [
                'transaction_number.required' => 'Transaction / Slip number is required.',
                'user_payment_id.required' => 'Enter Your Account Number',
                'image.required' => 'Transaction ScreenShoot is required.'
            ]);

        $auth = Auth::user();
        $data = ExchangeMoney::where('trx', $request->trx)->where('user_id', $auth->id)->whereStatus(0)->first();
        if ($data) {

            $in = Input::except('_method', '_token', 'enter_amount', 'get_amount');
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.jpg';
                $location = 'assets/images/exchange/' . $filename;
                $in['image'] = $filename;
                Image::make($image)->save($location);
            }
            $in['status'] = 1;
            $data->fill($in)->save();


            return redirect()->route('main')->with('success', 'Your Request has been Successful');
        }

        abort(404);
    }

    public function referenceBonus()
    {
        $auth = Auth::user();
        $data['page_title'] = "Reference Bonus";
        $data['trx']=  Trx::where('user_id', $auth->id)->where('reffer',1)->latest()->paginate(20);

        return view('user.refferal',$data);

    }

}
