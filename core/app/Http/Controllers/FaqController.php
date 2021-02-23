<?php

namespace App\Http\Controllers;

use App\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class FaqController extends Controller
{

    public function createFaqs()
    {
        $data['page_title'] = "Create New Faq";
        return view('admin.faqs.create',$data);
    }

    public function storeFaqs(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $in = Input::except('_method','_token');
        Faq::create($in);
        $notification = array('message' => 'FAQS Created Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function allFaqs()
    {
        $data['page_title'] = "All Question";
        $data['faqs'] = Faq::orderBy('id','desc')->paginate(10);
        return view('admin.faqs.index',$data);
    }

    public function editFaqs($id)
    {
        $data['page_title'] = "Edit Faqs";
        $data['faqs'] = Faq::findOrFail($id);
        return view('admin.faqs.edit',$data);
    }

    public function updateFaqs(Request $request, $id)
    {
        $faqs = Faq::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $in = Input::except('_method','_token');
        $faqs->fill($in)->save();

        $notification = array('message' => 'FAQS Updated Successfully.', 'alert-type' => 'success');
        return back()->with($notification);

    }

    public function deleteFaqs(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        Faq::destroy($request->id);
        $notification = array('message' => 'FAQS Deleted Successfully.', 'alert-type' => 'success');
        return back()->with($notification);
    }

}
