<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Social;
use Illuminate\Http\Request;
use Auth;
use App\GeneralSettings;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use File;
use Image;


class WebSettingController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function manageLogo()
    {
        $data['page_title'] = "Manage Logo & Favicon";
        return view('admin.webControl.logo', $data);
    }

    public function updateLogo(Request $request)
    {
        $this->validate($request, [
            'logo' => 'mimes:png',
            'favicon' => 'mimes:png',
            'freeloader' => 'mimes:gif',
        ]);
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $filename = 'logo.png';
            $location = 'assets/images/logo/' . $filename;
            Image::make($image)->save($location);
        }
        if ($request->hasFile('favicon')) {
            $image = $request->file('favicon');
            $filename = 'favicon.png';
            $location = 'assets/images/logo/' . $filename;
            Image::make($image)->save($location);
        }
        $notification = array('message' => 'Update Successfully', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function manageBreadcrumb()
    {
        $data['page_title'] = "Manage Breadcrumb";
        return view('admin.webControl.breadcrumb', $data);
    }

    public function updateBreadcrumb(Request $request)
    {
        $this->validate($request, [
//            'breadcrumb' => 'nullable|mimes:jpg',
//            'banner' => 'nullable|mimes:jpg',
        ]);

        if ($request->hasFile('breadcrumb')) {
            $image = $request->file('breadcrumb');
            $filename = 'about-bg.jpg';
            $location = 'assets/images/logo/' . $filename;
            Image::make($image)->save($location);
        }
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $filename = 'banner-bg.jpg';
            $location = 'assets/images/logo/' . $filename;
            Image::make($image)->save($location);
        }
        $notification = array('message' => 'Update Successfully', 'alert-type' => 'success');
        return back()->with($notification);
    }


    public function manageFooter()
    {
        $data['page_title'] = "Manage  Text";
        return view('admin.webControl.footer', $data);
    }
    public function updateFooter(Request $request)
    {
        $basic = GeneralSettings::first();
        $in = Input::except('_method','_token');
        $basic->fill($in)->save();
        $notification = array('message' => ' Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }


    public function getAbout()
    {
        $data['page_title'] = "Manage About ";
        return view('admin.webControl.about',$data);
    }

    public function updateAbout(Request $request)
    {
        $basic = GeneralSettings::first();
        $this->validate($request,[
            'about' => 'required',
            'about_title' => 'required',
//            'about_video' => 'required',
            'image' => 'mimes:jpg,jpeg| max:1000',
        ],[
            'about_title.required' => 'Title field must not be empty',
//            'about_video.required' => 'Video link  must not be empty',
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = 'about-video-image.jpg';
            $location = 'assets/images/' . $filename;
            Image::make($image)->resize(540,500)->save($location);
        }
        $basic->about = $request->about;
        $basic->about_title = $request->about_title;
//        $basic->about_video = $request->about_video;
        $basic->save();
        $notification = array('message' => 'About Page Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }







    public function manageMenu()
    {
        $data['page_title'] = "Control Menu";
        $data['menus'] = Menu::paginate(2);
        return view('admin.webControl.menu-show',$data);
    }
    public function createMenu()
    {
        $data['page_title'] = "Create Menu";
        return view('admin.webControl.menu-create',$data);
    }
    public function storeMenu(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:menus,name',
            'description' => 'required'
        ]);
        $in = Input::except('_method','_token');
        $in['slug'] = str_slug($request->name);
        Menu::create($in);
        $notification = array('message' => 'Menu Created Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }
    public function editMenu($id)
    {
        $data['page_title'] = "Edit Menu";
        $data['menu'] = Menu::findOrFail($id);
        return view('admin.webControl.menu-edit',$data);
    }
    public function updateMenu(Request $request,$id)
    {
        $menu = Menu::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|unique:menus,name,'.$menu->id,
            'description' => 'required'
        ]);
        $in = Input::except('_method','_token');
        $in['slug'] = str_slug($request->name);
        $menu->fill($in)->save();
        $notification = array('message' => 'Menu Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }
    public function deleteMenu(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);
        Menu::destroy($request->id);
        $notification = array('message' => 'Menu Deleted Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }



    public function manageSocial()
    {
        $data['page_title'] = "Manage Social";
        $data['social'] = Social::all();
        return view('admin.webControl.social', $data);
    }
    public function storeSocial(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'code' => 'required',
            'link' => 'required',
        ]);
        $product = Social::create($request->input());
        return response()->json($product);
    }
    public function editSocial($product_id)
    {
        $product = Social::find($product_id);
        return response()->json($product);
    }
    public function updateSocial(Request $request,$product_id)
    {
        $product = Social::find($product_id);
        $product->name = $request->name;
        $product->code = $request->code;
        $product->link = $request->link;
        $product->save();
        return response()->json($product);
    }
    public function destroySocial(Request $request)
    {
        $product = Social::destroy($request->delete_id);
        $notification = array('message' => 'Deleted Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function terms()
    {
        $data['page_title'] = "Manage Terms & Condition";
        return view('admin.webControl.terms',$data);
    }
    public function privacy()
    {
        $data['page_title'] = "Manage Privacy & Policy";
        return view('admin.webControl.privacy',$data);
    }
    public function updateTerms(Request $request)
    {
        $data = GeneralSettings::first();

         $in = Input::except('_token');
        $data->fill($in)->save();
        $notification = array('message' => 'Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }

}
