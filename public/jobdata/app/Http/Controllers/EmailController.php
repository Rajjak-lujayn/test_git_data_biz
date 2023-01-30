<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendingEmail;

class EmailController extends Controller
{
    function index()
    {
      
        return view('admin.emailsend');
    }

    function send(Request $request)
    {
        $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required'
        ]);

        $data = array(
            'name' => $request->name,
            'message' => $request->message
        );

        Mail::to('nitesh.pandit.lujayninfoways@gmail.com')->send(new sendingEmail($data));
        return back()->with('success', 'Thanks for contacting us!');
    }

}