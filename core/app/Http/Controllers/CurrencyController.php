<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;
use Auth;
use App\GeneralSettings;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use File;
use Image;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Manage Currency';
        $data['currency'] = Currency::latest()->paginate(25);
        return view('admin.currency.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Manage Currency';
        return view('admin.currency.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'buy' => 'required|min:0',
            'sell' => 'required|min:0',
            'exchange' => 'required|min:0',
            'price' => 'required|numeric|min:0',
            'available_balance' => 'required|numeric|min:0',
            'symbol' => 'required',
            'payment_id' => 'required',
            'name' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg'
        ]);
        $in = Input::except('_method', '_token');
        $in['is_coin'] = $request->is_coin == "on" ? 1 : 0;
        $in['status'] = $request->status == "on" ? 1 : 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = str_slug($request->name) . '_' . time() . '.'.$image->getClientOriginalExtension();;
            $location = 'assets/images/currency/' . $filename;
            Image::make($image)->resize(32, 21)->save($location);
            $in['image'] = $filename;
        }
        Currency::create($in);
        return back()->with('success', 'Save Successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        $data['currency'] = $currency;
        $data['page_title'] = "Manage Currency";
        return view('admin.currency.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {

        $request->validate([
            'buy' => 'required|min:0',
            'payment_id' => 'required',
            'sell' => 'required|min:0',
            'exchange' => 'required|min:0',
            'price' => 'required|numeric|min:0',
            'available_balance' => 'required|numeric|min:0',
            'symbol' => 'required',
            'name' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg'
        ]);
        $in = Input::except('_method', '_token');
        $in['is_coin'] = $request->is_coin == "on" ? 1 : 0;
        $in['status'] = $request->status == "on" ? 1 : 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = str_slug($request->name).'_' . time() .'.'. $image->getClientOriginalExtension();
            $location = 'assets/images/currency/' . $filename;
            Image::make($image)->resize(32, 21)->save($location);
            $path = './assets/images/currency/';
            File::delete($path . $currency->image);
            $in['image'] = $filename;
        }

        $currency->fill($in)->save();

        return back()->with('success', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Currency $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        //
    }
}
