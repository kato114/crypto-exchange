<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Testimonial;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use File;


class TestimonialController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Testimonials";
        $data['posts'] = Testimonial::latest()->paginate(20);
        return view('admin.testimonial.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Testimonial';
        return view('admin.testimonial.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'image' => 'required | mimes:jpeg,jpg | max:1000'
        ],
            [
                'name.required' => 'Name must not be empty',
                'designation.required' => 'Designation must not be empty',
            ]
        );

        $in = Input::except('_token');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'testimonial_'.time().'.jpg';
            $location = 'assets/images/testimonial/' . $filename;
            Image::make($image)->resize(100,100)->save($location);
            $in['image'] = $filename;
        }
        $res = Testimonial::create($in);
        if ($res) {
            return back()->with('success', 'Updated Successfully!');
        } else {
            return back()->with('alert', 'Problem With Updating Plan');
        }

    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Testimonial';
        $data['post'] = Testimonial::find($id);
        return view('admin.testimonial.edit', $data);
    }
    public function updatePost(Request $request)
    {

        $data = Testimonial::find($request->id);
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'image' => ' mimes:jpeg,jpg | max:1000'
        ],
            [
                'name.required' => 'Name must not be empty',
                'designation.required' => 'Designation must not be empty',
            ]
        );


         $in = Input::except('_token');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'testimonial_'.time().'.jpg';
            $location = 'assets/images/testimonial/' . $filename;
            Image::make($image)->resize(100,100)->save($location);
            $path = './assets/images/testimonial/';
            File::delete($path.$data->image);
            $in['image'] = $filename;
        }
        $res = $data->fill($in)->save();

        if ($res) {
            return back()->with('success', 'Updated Successfully!');
        } else {
            return back()->with('alert', 'Problem With Updating Plan');
        }
        return $data;
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $data = Testimonial::findOrFail($request->id);
        $path = './assets/images/testimonial/';
        File::delete($path.$data->image);
        $res =  $data->delete();

        if ($res) {
            return back()->with('success', 'Post Delete Successfully!');
        } else {
            return back()->with('alert', 'Problem With Deleting Post');
        }
    }
}
