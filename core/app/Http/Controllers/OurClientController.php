<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OurClient;
use Illuminate\Support\Facades\Input;
use File;
use Image;



class OurClientController extends Controller
{
    public function ourClient()
    {
        $data['page_title'] = "Our Client ";
        $data['ourClient'] = OurClient::all();
        return view('admin.clients.index', $data);
    }

    public function storeClient(Request $request)
    {
        $request->validate([
            'link' => 'required',
            'image' => 'required | mimes:png,PNG | max:1000'
        ],
            [
                'link.required' => ' Website address must not be empty',
                'image.mimes' => 'Image Only allowed png types',
            ]
        );

        $in = input::except('_token');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'client_image_' . time() . '.png';
            $location = 'assets/images/our-client/' . $filename;
            Image::make($image)->resize(240,106)->save($location);
            $in['image'] = $filename;
        }
        OurClient::create($in);

        $notify = array('message' => 'Saved Successfully.', 'alert-type' => 'success');
        return back()->with($notify);
    }

    public function deleteClient(Request $request)
    {
        $data = OurClient::find($request->id);
        $path = './assets/images/our-client/';
        File::delete($path . $data->image);
        $data->delete();
        $notification = array('message' => 'Deleted Successfully.', 'alert-type' => 'success');
        return back()->with($notification);

    }

}
