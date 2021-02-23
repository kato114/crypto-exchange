<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{

    public function sendMail()
    {
        $data['page_title'] = 'Mail to Subscribers';
        return view('admin.subscribers.subscriber-email', $data);
    }

    public function sendMailsubscriber(Request $request)
    {
        $this->validate($request,
            [
                'subject' => 'required',
                'emailMessage' => 'required'
            ]);
        $subscriber = Subscriber::whereStatus(1)->get();
        foreach ($subscriber as $data) {
            $to =  $data->email;
            $name = substr($data->email, 0, strpos($data->email, "@"));
            $subject = $request->subject;
            $message = $request->emailMessage;
            send_email($to, $name, $subject, $message);
        }
        $notification = array('message' => 'Mail Sent Successfully!', 'alert-type' => 'success');
        return back()->with($notification);
    }

    public function manageSubscribers()
    {
        $data['page_title'] = 'Subscribers';
        $data['events'] = Subscriber::latest()->paginate(30);
        return view('admin.subscribers.subscriber', $data);
    }



    public function updateSubscriber(Request $request)
    {

        $mac = Subscriber::findOrFail($request->id);
        $mac['status'] = $request->status;
        $res = $mac->save();

        if ($res) {
            return back()->with('success', ' Updated Successfully!');
        } else {
            return back()->with('alert', 'Problem With Updating ');
        }
    }

}
