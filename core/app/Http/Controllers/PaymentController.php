<?php

namespace App\Http\Controllers;

use App\Deposit;

use App\Trx;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Gateway;
use App\GeneralSettings;

use Session;
use Stripe\Stripe;
use Stripe\Token;
use Stripe\Charge;
use App\Lib\coinPayments;
use App\Lib\BlockIo;
use App\Lib\CoinPaymentHosted;

class PaymentController extends Controller
{

    public function userDataUpdate($data)
    {

        $gnl = GeneralSettings::first();
        if ($data->status == 0) {
            $data['status'] = 1;
            $data->update();

            $user = User::find($data->user_id);
            $user['balance'] = $user->balance + $data->amount;


            $levelCount = User::where('refer', $user->id)->get();
            if (count($levelCount) == 1){
                $user['level'] = 1;
            }elseif(count($levelCount) == 2){
                $user['level'] = 2;
            }elseif(count($levelCount) >= 3){
                $user['level'] = 3;
            }

            if($user->refer!=0)
            {
                $refer = User::find($user->refer);


                if($refer->level == 1)
                {
                    $commision = ($data->amount * $gnl->level_one)/100;
                }elseif ($refer->level == 2){
                    $commision = ($data->amount * $gnl->level_two)/100;
                }elseif ($refer->level == 3){
                    $commision = ($data->amount * $gnl->level_three)/100;
                }

                $refer['balance'] = round(($refer->balance + $commision),$gnl->decimal);
                $refer->update();

                Trx::create([
                    'user_id' => $refer->id,
                    'amount' => round($commision,$gnl->decimal),
                    'main_amo' => round($refer->balance,$gnl->decimal),
                    'charge' => 0,
                    'type' => '+',
                    'reffer' => 1,
                    'title' => 'Referral Commission  from '. $user->username ,
                    'trx' => str_random(16)
                ]);


                $msg = $commision . ' '. $gnl->currency . ' Referral Commission  from '. $user->username ;
                send_email($refer->email, $refer->username, 'Referral Commission', $msg);
                send_sms($refer->phone, $msg);
            }

            $user->update();


            Trx::create([
                'user_id' => $user->id,
                'amount' => $data->amount,
                'main_amo' => round($user->balance,$gnl->decimal),
                'charge' => 0,
                'type' => '+',
                'title' => 'Deposit Via ' . $data->gateway->name,
                'trx' => $data->trx
            ]);

            $txt = $data->amount . ' ' . $gnl->currency . ' Deposited Successfully Via ' . $data->gateway->name;

            send_email($user->email, $user->username, 'Deposit Successful', $txt);

            send_sms($user->phone, $txt);

        }

    }

    public function depositConfirm(Request $request)
    {
        $gnl = GeneralSettings::first();
        $track = Session::get('Track');
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        if (is_null($data)) {
            return redirect()->route('deposit')->with('danger', 'Invalid Deposit Request');
        }
        if ($data->status != 0) {
            return redirect()->route('deposit')->with('danger', 'Invalid Deposit Request');
        }

        $gatewayData = Gateway::where('id', $data->gateway_id)->first();


        if ($data->gateway_id == 101) {
            $page_title = $gatewayData->name;
            $paypal['amount'] = $data->usd;
            $paypal['sendto'] = $gatewayData->val1;
            $paypal['track'] = $track;
            return view('user.payment.paypal', compact('paypal', 'gnl', 'page_title'));

        } elseif ($data->gateway_id == 102) {
            $page_title = $gatewayData->name;
            $perfect['amount'] = $data->usd;
            $perfect['value1'] = $gatewayData->val1;
            $perfect['value2'] = $gatewayData->val2;
            $perfect['track'] = $track;
            return view('user.payment.perfect', compact('perfect', 'gnl', 'page_title'));
        } elseif ($data->gateway_id == 103) {
            $page_title = $gatewayData->name;
            return view('user.payment.stripe', compact('track', 'page_title'));
        } elseif ($data->gateway_id == 104) {
            $page_title = $gatewayData->name;
            return view('user.payment.skrill', compact('page_title', 'gnl', 'gatewayData', 'data'));
        }
        elseif ($data->gateway_id == 105)
        {
            $page = $gatewayData->name;
            $post_params = [
                'MID' => $gatewayData->val1,
                'WEBSITE' => $gatewayData->val3,
                'CHANNEL_ID' =>  $gatewayData->val5,
                'INDUSTRY_TYPE_ID' => $gatewayData->val4,
                'ORDER_ID' => $data->id,
                'TXN_AMOUNT' => $data->usd,
                'CUST_ID' => $data->user->id,
                'CALLBACK_URL' => route('ipn.paytm')
            ];
            $post_params["CHECKSUMHASH"] = getChecksumFromArray($post_params, $gatewayData->val2);
            $form_action = $gatewayData->val6 . "?orderid=" . $data->id;
            return view('user.payment.paytm', compact('page','post_params', 'form_action', 'gnl'));
        }
        elseif ($data->gateway_id == 106)
        {
            $page = $gatewayData->name;
            $payeer_url = 'https://payeer.com/merchant';

            $m_shop	= $gatewayData->val1;
            $m_orderid = $data->id;
            $m_amount = $data->usd;
            $m_curr	= 'USD';
            $m_desc = base64_encode('Buy ICO');
            $m_key = $gatewayData->val2;

            $arHash = [$m_shop, $m_orderid, $m_amount, $m_curr, $m_desc, $m_key];

            $sign = strtoupper(hash('sha256', implode(":", $arHash)));

            return view('user.payment.payeer',compact('page', 'gnl','payeer_url','m_shop','m_orderid','m_amount','m_curr','m_desc','sign'));
        }

        elseif ($data->gateway_id == 501) {
            $page_title = $gatewayData->name;

            $all = file_get_contents("https://blockchain.info/ticker");
            $res = json_decode($all);
            $btcrate = $res->USD->last;

            $usd = $data->usd;
            $btcamount = $usd / $btcrate;
            $btc = round($btcamount, 8);

            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {
                $blockchain_root = "https://blockchain.info/";
                $blockchain_receive_root = "https://api.blockchain.info/";
                $mysite_root = url('/');
                $secret = "ABIR";
                $my_xpub = $gatewayData->val2;
                $my_api_key = $gatewayData->val1;

                $invoice_id = $track;
                $callback_url = $mysite_root . "/ipnbtc?invoice_id=" . $invoice_id . "&secret=" . $secret;

                $resp = @file_get_contents($blockchain_receive_root . "v2/receive?key=" . $my_api_key . "&callback=" . urlencode($callback_url) . "&xpub=" . $my_xpub);

                if (!$resp) {
                    return redirect()->route('deposit')->with('alert', 'BLOCKCHAIN API HAVING ISSUE. PLEASE TRY LATER');
                }

                $response = json_decode($resp);
                $sendto = $response->address;

                $data['btc_wallet'] = $sendto;
                $data['btc_amo'] = $btc;
                $data->update();
            }
            $DepositData = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();

            $bitcoin['amount'] = $DepositData->btc_amo;
            $bitcoin['sendto'] = $DepositData->btc_wallet;

            $var = "bitcoin:$DepositData->btc_wallet?amount=$DepositData->btc_amo";
            $bitcoin['code'] = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$var&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.blockchain', compact('bitcoin', 'page_title'));
        } elseif ($data->gateway_id == 502) {
            $method = Gateway::find(502);
            $apiKey = $method->val1;
            $version = 2;
            $pin = $method->val2;
            $block_io = new BlockIo($apiKey, $pin, $version);
            $btcdata = $block_io->get_current_price(array('price_base' => 'USD'));
            if ($btcdata->status != 'success') {
                return back()->with('danger', 'Failed to Process');
            }
            $btcrate = $btcdata->data->prices[0]->price;

            $usd = $data->usd;
            $bcoin = round($usd / $btcrate, 8);

            if ($data->btc_amo == 0 || $data->btc_wallet == "") {
                $ad = $block_io->get_new_address();

                if ($ad->status == 'success') {
                    $blockad = $ad->data;
                    $wallet = $blockad->address;
                    $data['btc_wallet'] = $wallet;
                    $data['btc_amo'] = $bcoin;
                    $data->update();
                } else {
                    return back()->with('danger', 'Failed to Process');
                }
            }

            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = "Deposit Via " .$gatewayData->name;
            $varb = "bitcoin:" . $wallet . "?amount=" . $bcoin;
            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8\" title='' style='width:300px;' />";

            return view('user.payment.blockbtc', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 503) {
            $method = Gateway::find(503);
            $apiKey = $method->val1;
            $version = 2;
            $pin = $method->val2;
            $block_io = new BlockIo($apiKey, $pin, $version);
            $btcdata = $block_io->get_current_price(array('price_base' => 'USD'));
            if ($btcdata->status != 'success') {
                return back()->with('danger', 'Failed to Process');
            }
            $btcrate = $btcdata->data->prices[0]->price;

            $usd = $data->usd;
            $bcoin = round($usd / $btcrate, 8);


            if ($data->btc_wallet == "") {
                $ad = $block_io->get_new_address();

                if ($ad->status == 'success') {
                    $blockad = $ad->data;
                    $wallet = $blockad->address;
                    $data['btc_wallet'] = $wallet;
                    $data['btc_amo'] = $bcoin;
                    $data->update();
                } else {
                    return back()->with('danger', 'Failed to Process');
                }
            }

            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = "Deposit Via ".$method->name;
            $varb = "litecoin:" . $wallet;
            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8\" title='' style='width:300px;' />";

            return view('user.payment.blocklite', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 504) {
            $method = Gateway::find(504);
            $apiKey = $method->val1;
            $version = 2;
            $pin = $method->val2;
            $block_io = new BlockIo($apiKey, $pin, $version);

            $dogeprice = file_get_contents("https://api.coinmarketcap.com/v1/ticker/dogecoin");
            $dresult = json_decode($dogeprice);
            $doge_usd = $dresult[0]->price_usd;

            $usd = $data->usd;
            $bcoin = round($usd / $doge_usd, 8);

            if ($data->btc_amo == 0 || $data->btc_wallet == "") {
                $ad = $block_io->get_new_address();

                if ($ad->status == 'success') {
                    $blockad = $ad->data;
                    $wallet = $blockad->address;
                    $data['btc_wallet'] = $wallet;
                    $data['btc_amo'] = $bcoin;
                    $data->update();
                } else {
                    return back()->with('danger', 'Failed to Process');
                }
            }

            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = "Deposit via ".$method->name;
            $varb = $wallet;

            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8\" title='' style='width:300px;' />";

            return view('user.payment.blockdog', compact('bcoin', 'wallet', 'qrurl', 'page_title'));
        } elseif ($data->gateway_id == 505) {
            $method = Gateway::find(505);
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {
                $cps = new CoinPaymentHosted();
                $cps->Setup($method->val2, $method->val1);
                $callbackUrl = route('ipn.coinPay.btc');

                $req = array(
                    'amount' => $data->usd,
                    'currency1' => 'USD',
                    'currency2' => 'BTC',
                    'custom' => $data->trx,
                    'ipn_url' => $callbackUrl,
                );

                $result = $cps->CreateTransaction($req);
                if ($result['error'] == 'ok') {

                    $bcoin = sprintf('%.08f', $result['result']['amount']);
                    $sendadd = $result['result']['address'];

                    $data['btc_amo'] = $bcoin;
                    $data['btc_wallet'] = $sendadd;
                    $data->update();

                } else {
                    return back()->with('danger', 'Failed to Process');
                }

            }
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = "Deposit via  ".$method->name;


            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=bitcoin:$wallet&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.coinpaybtc', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 506) {
            $method = Gateway::find(506);
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {
                $cps = new CoinPaymentHosted();
                $cps->Setup($method->val2, $method->val1);
                $callbackUrl = route('ipn.coinPay.eth');
                $req = array(
                    'amount' => $data->usd,
                    'currency1' => 'USD',
                    'currency2' => 'ETH',
                    'custom' => $data->trx,
                    'ipn_url' => $callbackUrl,
                );

                $result = $cps->CreateTransaction($req);
                if ($result['error'] == 'ok') {
                    $bcoin = sprintf('%.08f', $result['result']['amount']);
                    $sendadd = $result['result']['address'];

                    $data['btc_amo'] = $bcoin;
                    $data['btc_wallet'] = $sendadd;
                    $data->update();
                } else {
                    return back()->with('alert', 'Failed to Process');
                }
            }
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title =  "Deposit via  ".$method->name;

            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8\" title='' style='width:300px;' />";

            return view('user.payment.coinpayeth', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 507) {
            $method = Gateway::find(507);
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {
                $cps = new CoinPaymentHosted();
                $cps->Setup($method->val2, $method->val1);
                $callbackUrl = route('ipn.coinPay.bch');

                $req = array(
                    'amount' => $data->usd,
                    'currency1' => 'USD',
                    'currency2' => 'BCH',
                    'custom' => $data->trx,
                    'ipn_url' => $callbackUrl,
                );
                $result = $cps->CreateTransaction($req);
                if ($result['error'] == 'ok') {
                    $bcoin = sprintf('%.08f', $result['result']['amount']);
                    $sendadd = $result['result']['address'];

                    $data['btc_amo'] = $bcoin;
                    $data['btc_wallet'] = $sendadd;
                    $data->update();
                } else {
                    return back()->with('danger', 'Failed to Process');
                }
            }
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = "Deposit via  ".$method->name;
            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8\" title='' style='width:300px;' />";

            return view('user.payment.coinpaybch', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 508) {
            $method = Gateway::find(508);
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {
                $cps = new CoinPaymentHosted();
                $cps->Setup($method->val2, $method->val1);
                $callbackUrl = route('ipn.coinPay.dash');

                $req = array(
                    'amount' => $data->usd,
                    'currency1' => 'USD',
                    'currency2' => 'DASH',
                    'custom' => $data->trx,
                    'ipn_url' => $callbackUrl,
                );
                $result = $cps->CreateTransaction($req);

                if ($result['error'] == 'ok') {
                    $bcoin = sprintf('%.08f', $result['result']['amount']);
                    $sendadd = $result['result']['address'];

                    $data['btc_amo'] = $bcoin;
                    $data['btc_wallet'] = $sendadd;
                    $data->update();
                } else {
                    return back()->with('danger', 'Failed to Process');
                }

            }
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = "Deposit via ". $method->name;

            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8\" title='' style='width:300px;' />";

            return view('user.payment.coinpaydash', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 509) {

            $method = Gateway::find(509);
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {

                $cps = new CoinPaymentHosted();
                $cps->Setup($method->val2, $method->val1);
                $callbackUrl = route('ipn.coinPay.doge');

                $req = array(
                    'amount' => $data->usd,
                    'currency1' => 'USD',
                    'currency2' => 'DOGE',
                    'custom' => $data->trx,
                    'ipn_url' => $callbackUrl,
                );

                $result = $cps->CreateTransaction($req);
                if ($result['error'] == 'ok') {
                    $bcoin = sprintf('%.08f', $result['result']['amount']);
                    $sendadd = $result['result']['address'];

                    $data['btc_amo'] = $bcoin;
                    $data['btc_wallet'] = $sendadd;
                    $data->update();
                } else {
                    return back()->with('danger', 'Failed to Process');
                }

            }
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = "Deposit via ".$method->name;

            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.coinpaydoge', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 510) {

            $method = Gateway::find(510);
            if ($data->btc_amo == 0 || $data->btc_wallet == "") {

                $cps = new CoinPaymentHosted();
                $cps->Setup($method->val2, $method->val1);
                $callbackUrl = route('ipn.coinPay.ltc');

                $req = array(
                    'amount' => $data->usd,
                    'currency1' => 'USD',
                    'currency2' => 'LTC',
                    'custom' => $data->trx,
                    'ipn_url' => $callbackUrl,
                );

                $result = $cps->CreateTransaction($req);
                if ($result['error'] == 'ok') {

                    $bcoin = sprintf('%.08f', $result['result']['amount']);
                    $sendadd = $result['result']['address'];

                    $data['btc_amo'] = $bcoin;
                    $data['btc_wallet'] = $sendadd;
                    $data->update();

                } else {
                    return back()->with('danger', 'Failed to Process');
                }
            }
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $wallet = $data['btc_wallet'];
            $bcoin = $data['btc_amo'];
            $page_title = "Deposit via " .$method->name;

            $qrurl = "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8\" title='' style='width:300px;' />";
            return view('user.payment.coinpayltc', compact('bcoin', 'wallet', 'qrurl', 'page_title'));

        } elseif ($data->gateway_id == 512) {

            $method = Gateway::find(512);

            $usd = $data->usd;

            \CoinGate\CoinGate::config(array(
                'environment'               => 'sandbox', // sandbox OR live
                'auth_token'                => $method->val1
            ));


            $post_params = array(
                'order_id'          => $data->trx,
                'price_amount'      => $usd,
                'price_currency'    => 'USD',
                'receive_currency'  => 'USD',
                'callback_url'      => route('ipn.coingate'),
                'cancel_url'        => route('deposit'),
                'success_url'       => route('deposit'),
                'title'             => 'Deposit' . $data->trx,
                'description'       => 'Deposit'
            );

            $order = \CoinGate\Merchant\Order::create($post_params);

            if ($order)
            {

                return redirect($order->payment_url);
                exit();

            }
            else
            {
                return redirect()->route('deposit')->with('danger','Unexpected Error! Please Try Again');
                exit();
            }


        } elseif ($data->gateway_id == 513) {
            $all = file_get_contents("https://blockchain.info/ticker");
            $res = json_decode($all);
            $btcrate = $res->USD->last;
            $amon = $data->amount;
            $usd = $data->usd;
            $bcoin = round($usd / $btcrate, 8);
            $method = Gateway::find(513);

            $callbackUrl = route('ipn.coinpay');
            $CP = new coinPayments();
            $CP->setMerchantId($method->val1);
            $CP->setSecretKey($method->val2);
            $ntrc = $data->trx;

            $form = $CP->createPayment('Purchase Coin', 'BTC', $bcoin, $ntrc, $callbackUrl);
            $page_title = $method->name;
            return view('user.payment.coinpay', compact('bcoin', 'form', 'page_title', 'amon'));
        }


    }


    //IPN Functions //////

    public function ipnpaypal()
    {

        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        $paypalURL = "https://ipnpb.paypal.com/cgi-bin/webscr?";
        $callUrl = $paypalURL . $req;
        $verify = file_get_contents($callUrl);
        if ($verify == "VERIFIED") {
            //PAYPAL VERIFIED THE PAYMENT
            $receiver_email = $_POST['receiver_email'];
            $mc_currency = $_POST['mc_currency'];
            $mc_gross = $_POST['mc_gross'];
            $track = $_POST['custom'];

            //GRAB DATA FROM DATABASE!!
            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $gatewayData = Gateway::find(101);
            $amount = $data->usd;

            if ($receiver_email == $gatewayData->val1 && $mc_currency == "USD" && $mc_gross == $amount && $data->status == '0') {
                //Update User Data
                $this->userDataUpdate($data);
            }
        }

    }

    public function ipnperfect()
    {
        $gatewayData = Gateway::find(102);
        $passphrase = strtoupper(md5($gatewayData->val2));

        define('ALTERNATE_PHRASE_HASH', $passphrase);
        define('PATH_TO_LOG', '/somewhere/out/of/document_root/');
        $string =
            $_POST['PAYMENT_ID'] . ':' . $_POST['PAYEE_ACCOUNT'] . ':' .
            $_POST['PAYMENT_AMOUNT'] . ':' . $_POST['PAYMENT_UNITS'] . ':' .
            $_POST['PAYMENT_BATCH_NUM'] . ':' .
            $_POST['PAYER_ACCOUNT'] . ':' . ALTERNATE_PHRASE_HASH . ':' .
            $_POST['TIMESTAMPGMT'];

        $hash = strtoupper(md5($string));
        $hash2 = $_POST['V2_HASH'];

        if ($hash == $hash2) {

            $amo = $_POST['PAYMENT_AMOUNT'];
            $unit = $_POST['PAYMENT_UNITS'];
            $track = $_POST['PAYMENT_ID'];

            $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
            $gnl = GeneralSettings::first();

            if ($_POST['PAYEE_ACCOUNT'] == $gatewayData->val1 && $unit == "USD" && $amo == $data->usd && $data->status == '0') {
                //Update User Data
                $this->userDataUpdate($data);
            }
        }

    }

    public function ipnstripe(Request $request)
    {
        $track = Session::get('Track');
        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();

        $this->validate($request,
            [
                'cardNumber' => 'required',
                'cardExpiry' => 'required',
                'cardCVC' => 'required',
            ]);

        $cc = $request->cardNumber;
        $exp = $request->cardExpiry;
        $cvc = $request->cardCVC;

        $exp = $pieces = explode("/", $_POST['cardExpiry']);
        $emo = trim($exp[0]);
        $eyr = trim($exp[1]);
        $cnts = round($data->usd, 2) * 100;

        $gatewayData = Gateway::find(103);
        $gnl = GeneralSettings::first();

        Stripe::setApiKey($gatewayData->val1);

        try {
            $token = Token::create(array(
                "card" => array(
                    "number" => "$cc",
                    "exp_month" => $emo,
                    "exp_year" => $eyr,
                    "cvc" => "$cvc"
                )
            ));

            try {
                $charge = Charge::create(array(
                    'card' => $token['id'],
                    'currency' => 'USD',
                    'amount' => $cnts,
                    'description' => 'item',
                ));

                if ($charge['status'] == 'succeeded') {
                    //Update User Data
                    $this->userDataUpdate($data);
                    return redirect()->route('deposit')->with('success', 'Payment Successfull ');
                }
            } catch (Exception $e) {
                return redirect()->route('deposit')->with('danger', $e->getMessage());
            }

        } catch (Exception $e) {
            return redirect()->route('deposit')->with('danger', $e->getMessage());
        }

    }

    public function skrillIPN()
    {
		 $track = Session::get('Track');
        $skrill = Gateway::find(104);
        $concatFields = $_POST['merchant_id']
            . $_POST['transaction_id']
            . strtoupper(md5($skrill->val2))
            . $_POST['mb_amount']
            . $_POST['mb_currency']
            . $_POST['status'];

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $gnl = GeneralSettings::first();

        if (strtoupper(md5($concatFields)) == $_POST['md5sig'] && $_POST['status'] == 2 && $_POST['pay_to_email'] == $skrill->val1 && $data->status = '0') {
            //Update User Data
            $this->userDataUpdate($data);

        }
    }

    public function ipnPayTm(Request $request)
    {
        $gateway = Gateway::find(105);

        $paytm_merchant_key = $gateway->val2;
        $paytm_merchant_id = $gateway->val1;
        $transaction_status_url = $gateway->val7;

        if(verifychecksum_e($_POST, $paytm_merchant_key, $_POST['CHECKSUMHASH']) === "TRUE") {

            if($_POST['RESPCODE'] == "01"){
                // Create an array having all required parameters for status query.
                $requestParamList = array("MID" => $paytm_merchant_id, "ORDERID" => $_POST['ORDERID']);
                // $_POST['ORDERID'] = substr($_POST['ORDERID'], strpos($_POST['ORDERID'], "-") + 1); // just for testing
                $StatusCheckSum = getChecksumFromArray($requestParamList, $paytm_merchant_key);
                $requestParamList['CHECKSUMHASH'] = $StatusCheckSum;
                $responseParamList = callNewAPI($transaction_status_url, $requestParamList);
                if($responseParamList['STATUS'] == 'TXN_SUCCESS' && $responseParamList['TXNAMOUNT'] == $_POST['TXNAMOUNT']) {
                    $ddd = Deposit::where('trx',$_POST['ORDERID'])->orderBy('id', 'DESC')->first();
                    $this->userDataUpdate($ddd);
                    $t = 'success';
                    $m = 'Transaction has been successful';
                } else  {
                    $t = 'alert';
                    $m = 'It seems some issue in server to server communication. Kindly connect with administrator';
                }
            } else {
                $t = 'alert';
                $m = $_POST['RESPMSG'];
            }
        } else {
            $t = 'alert';
            $m = "Security error!";
        }
        return redirect()->route('deposit')->with($t, $m);
    }

    public function ipnPayEer(Request $request)
    {

        if (isset($_GET['payeer']) && $_GET['payeer'] == 'result')
        {
            if (isset($_POST["m_operation_id"]) && isset($_POST["m_sign"]))
            {
                $err = false;
                $message = '';

                $gateway = Gateway::find(106);

                $sign_hash = strtoupper(hash('sha256', implode(":", array(
                    $_POST['m_operation_id'],
                    $_POST['m_operation_ps'],
                    $_POST['m_operation_date'],
                    $_POST['m_operation_pay_date'],
                    $_POST['m_shop'],
                    $_POST['m_orderid'],
                    $_POST['m_amount'],
                    $_POST['m_curr'],
                    $_POST['m_desc'],
                    $_POST['m_status'],
                    $gateway->val2
                ))));

                if ($_POST["m_sign"] != $sign_hash)
                {
                    $message .= " - do not match the digital signature\n";
                    $err = true;
                }

                if (!$err)
                {

                    $ddd = Deposit::find($_POST['m_orderid']);

                    $order_curr = 'USD';
                    $order_amount = round($ddd->usd, 2);

                    if ($_POST['m_amount'] != $order_amount)
                    {
                        $message .= " - wrong amount\n";
                        $err = true;
                    }

                    if ($_POST['m_curr'] != $order_curr)
                    {
                        $message .= " - wrong currency\n";
                        $err = true;
                    }

                    if (!$err)
                    {
                        switch ($_POST['m_status'])
                        {
                            case 'success':

                                $this->userDataUpdate($ddd);
                                $message = 'Sell Successfully Completed';
                                $err = false;

                                break;

                            default:
                                $message .= " - the payment status is not success\n";
                                $err = true;
                                break;
                        }
                    }
                }

                if ($err)
                {
                    return redirect()->route('deposit')->with('success', $message);
                }
                else
                {
                    return redirect()->route('deposit')->with('success', $message);
                }
            }
        }

    }

    public function purchaseVogue($trx, $type)
    {

        if ($type == 'error') redirect()->route('home')->with('alert', 'Transaction Failed, Ref: ' . $trx);
        return redirect()->route('home')->with('success', 'Transaction was successful, Ref: ' . $trx);

    }

    public function ipnPayStack(Request $request)
    {

        $request->validate([
            'reference' => 'required',
            'paystack-trxref' => 'required',
        ]);

        $gateway = Gateway::find(107);

        $ref = $request->reference;
        $secret_key = $gateway->val2;

        $result = array();
        //The parameter after verify/ is the transaction reference to be verified
        $url = 'https://api.paystack.co/transaction/verify/' . $ref;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $secret_key]);
        $r = curl_exec($ch);
        curl_close($ch);

        if ($r) {
            $result = json_decode($r, true);

            if($result){
                if($result['data']){
                    if ($result['data']['status'] == 'success') {
                        $ddd = Deposit::where('trx', $ref)->first();
                        $am = $result['data']['amount'];
                        $sam = round($ddd->usd/$ddd->gateway->val7, 2)*100;
                        if ($am == $sam) {
                            $this->userDataUpdate($ddd);
                            return redirect()->route('deposit')->with('success', 'Payment Successful');
                        } else {
                            return redirect()->route('deposit')->with('danger', 'Less Amount Paid. Please Contact With Admin');
                        }
                    }else{
                        return redirect()->route('deposit')->with('danger', $result['data']['gateway_response']);
                    }
                }else{
                    return redirect()->route('deposit')->with('danger', $result['message']);
                }

            }else{
                return redirect()->route('deposit')->with('danger', 'Something went wrong while executing');
            }
        }else{
            return redirect()->route('deposit')->with('danger', 'Something went wrong while executing');
        }

    }

    public function ipnVoguePay(Request $request)
    {

        $request->validate([
            'transaction_id' => 'required'
        ]);

        $trx = $request->transaction_id;

        $req_url = "https://voguepay.com/?v_transaction_id=$trx&type=json";
        $data = file_get_contents($req_url);
        $data = json_decode($data);

        $merchant_id = $data->merchant_id;
        $total_paid = $data->total;
        $custom = $data->merchant_ref;
        $status = $data->status;
        $vogue = Gateway::find(108);

        if($status == "Approved" && $merchant_id == $vogue->val1){

            $ddd = Deposit::where('trx' , $custom)->first();
            $totalamo = $ddd->usd;

            if($totalamo == $total_paid)
            {
                $this->userDataUpdate($ddd);
            }
        }

    }



    public function ipnBchain()
    {
        $gatewayData = Gateway::find(501);

        $track = $_GET['invoice_id'];
        $secret = $_GET['secret'];
        $address = $_GET['address'];
        $value = $_GET['value'];
        $confirmations = $_GET['confirmations'];
        $value_in_btc = $_GET['value'] / 100000000;

        $trx_hash = $_GET['transaction_hash'];

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();

        if ($data->status == 0) {
            if ($data->btc_amo == $value_in_btc && $data->btc_wallet == $address && $secret == "ABIR" && $confirmations > 2) {
                //Update User Data
                $this->userDataUpdate($data);
            }
        }

    }

    public function blockIpnBtc(Request $request)
    {

        $DepositData = Deposit::where('status', 0)->where('gateway_id', 502)->where('try', '<=', 100)->get();

        $method = Gateway::find(502);
        $apiKey = $method->val1;
        $version = 2;
        $pin = $method->val2;
        $block_io = new BlockIo($apiKey, $pin, $version);


        foreach ($DepositData as $data) {
            $balance = $block_io->get_address_balance(array('addresses' => $data->btc_wallet));
            $bal = $balance->data->available_balance;

            if ($bal > 0 && $bal >= $data->btc_amo) {
                //Update User Data
                $this->userDataUpdate($data);
            }
            $data['try'] = $data->try + 1;
            $data->update();
        }
    }

    public function blockIpnLite(Request $request)
    {

        $DepositData = Deposit::where('status', 0)->where('gateway_id', 503)->where('try', '<=', 100)->get();

        $method = Gateway::find(503);
        $apiKey = $method->val1;
        $version = 2;
        $pin = $method->val2;
        $block_io = new BlockIo($apiKey, $pin, $version);


        foreach ($DepositData as $data) {
            $balance = $block_io->get_address_balance(array('addresses' => $data->btc_wallet));
            $bal = $balance->data->available_balance;

            if ($bal > 0 && $bal >= $data->btc_amo) {
                //Update User Data
                $this->userDataUpdate($data);
            }
            $data['try'] = $data->try + 1;
            $data->update();
        }
    }

    public function blockIpnDog(Request $request)
    {
        $DepositData = Deposit::where('status', 0)->where('gateway_id', 504)->where('try', '<=', 100)->get();

        $method = Gateway::find(504);
        $apiKey = $method->val1;
        $version = 2;
        $pin = $method->val2;
        $block_io = new BlockIo($apiKey, $pin, $version);


        foreach ($DepositData as $data) {
            $balance = $block_io->get_address_balance(array('addresses' => $data->btc_wallet));
            $bal = $balance->data->available_balance;

            if ($bal > 0 && $bal >= $data->btc_amo) {
                //Update User Data
                $this->userDataUpdate($data);
            }
            $data['try'] = $data->try + 1;
            $data->update();
        }
    }

    public function ipnCoinPayBtc(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount2 = floatval($request->amount2);
        $currency2 = $request->currency2;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;
        if ($status >= 100 || $status == 2) {
            if ($currency2 == "BTC" && $data->status == '0' && $data->btc_amo <= $amount2) {
                $this->userDataUpdate($data);
            }
        }
    }

    public function ipnCoinPayEth(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount2 = floatval($request->amount2);
        $currency2 = $request->currency2;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;
        if ($status >= 100 || $status == 2) {
            if ($currency2 == "ETH" && $data->status == '0' && $data->btc_amo <= $amount2) {
                $this->userDataUpdate($data);
            }
        }
    }

    public function ipnCoinPayBch(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount2 = floatval($request->amount2);
        $currency2 = $request->currency2;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;
        if ($status >= 100 || $status == 2) {
            if ($currency2 == "BCH" && $data->status == '0' && $data->btc_amo <= $amount2) {
                $this->userDataUpdate($data);
            }
        }
    }

    public function ipnCoinPayDash(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount2 = floatval($request->amount2);
        $currency2 = $request->currency2;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;
        if ($status >= 100 || $status == 2) {
            if ($currency2 == "DASH" && $data->status == '0' && $data->btc_amo <= $amount2) {
                $this->userDataUpdate($data);
            }
        }
    }

    public function ipnCoinPayDoge(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount2 = floatval($request->amount2);
        $currency2 = $request->currency2;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;
        if ($status >= 100 || $status == 2) {
            if ($currency2 == "DOGE" && $data->status == '0' && $data->btc_amo <= $amount2) {
                $this->userDataUpdate($data);
            }
        }
    }

    public function ipnCoinPayLtc(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount2 = floatval($request->amount2);
        $currency2 = $request->currency2;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;
        if ($status >= 100 || $status == 2) {
            if ($currency2 == "LTC" && $data->status == '0' && $data->btc_amo <= $amount2) {
                $this->userDataUpdate($data);
            }
        }
    }

    public function ipnCoinGate()
    {
        $data = Deposit::where('trx',$_POST['order_id'])->orderBy('id', 'DESC')->first();

        if($_POST['status'] == 'paid' && $_POST['price_amount'] == $data->usd && $data->status == '0')
        {
            $this->userDataUpdate($data);
        }

    }

    public function ipnCoin(Request $request)
    {
        $track = $request->custom;
        $status = $request->status;
        $amount1 = floatval($request->amount1);
        $currency1 = $request->currency1;

        $data = Deposit::where('trx', $track)->orderBy('id', 'DESC')->first();
        $bcoin = $data->btc_amo;

        if ($currency1 == "BTC" && $amount1 >= $bcoin && $data->status == '0') {
            if ($status >= 100 || $status == 2) {
                //Update User Data
                $this->userDataUpdate($data);
            }
        }
    }

}
