<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gateway;
use Image;
use Carbon\Carbon;
use App\GeneralSettings;
use Illuminate\Support\Facades\Input;
class GatewayController extends Controller
{
    public function show()
        {
        	$gateways = Gateway::all();
            
            if(is_null($gateways))
            {
                $default=[
                    'gateimg' => 'paypal.png',
                    'name' => 'PayPal',
                    'minamo' => '100',
                    'maxamo' => '100000',
                    'fixed_charge' => '10',
                    'percent_charge' => '11',
                    'rate' => '21',
                    'val1' => 'JHuiqejhkjq',
                    'val2' => '24897HHd',
                    'status' => '1'
                ];

                Gateway::create($default);
                $gateways = Gateway::all();
            }       
        	$page_title = "Gateway";
        	return view('admin.deposit.gateway', compact('gateways','page_title'));

        }

    public function update(Request $request)
    {
        $gateway = Gateway::findorFail($request->id);
        $this->validate($request, [
            'gateimg' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'name' => 'required',
            'rate' => 'required|numeric',
            'minamo' => 'required|numeric',
            'maxamo' => 'required|numeric',
            'chargefx' => 'required|numeric',
            'chargepc' => 'required|numeric',
            'val1' => 'nullable',
            'val2' => 'nullable',
            'val3' => 'nullable',
            'val4' => 'nullable',
            'val5' => 'nullable',
            'val6' => 'nullable',
            'val7' => 'nullable',
            'status' => 'nullable'
        ]);
        if($request->hasFile('gateimg'))
        {
            $npath = 'assets/images/gateway/'.$gateway->id.'.jpg';
            Image::make($request->gateimg)->resize(800, 800)->save($npath);
        }

        $gateway['name'] = $request->name;
        $gateway['rate'] = $request->rate;
        $gateway['minamo'] = $request->minamo;
        $gateway['maxamo'] = $request->maxamo;
        $gateway['fixed_charge'] = $request->chargefx;
        $gateway['percent_charge'] = $request->chargepc;
        $gateway['val1'] = $request->val1;
        $gateway['val2'] = $request->val2;
        $gateway['val3'] = $request->val3;
        $gateway['val4'] = $request->val4;
        $gateway['val5'] = $request->val5;
        $gateway['val6'] = $request->val6;
        $gateway['val7'] = $request->val7;
        $gateway['status'] = $request->status;
        $res = $gateway->save();

        if ($res) {
            return back()->with('success', 'Gateway Updated Successfully!');
        } else {
            return back()->with('alert', 'Problem With Updating Gateway');
        }


    }
}
