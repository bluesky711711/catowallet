<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {

     }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact(Request $request)
    {
        $email = $request->input('email2');
        $messages = $request->input('message2');


        $data = ['email' => $email, 'messages' => $messages];

        Mail::send('emails.contact', $data, function($message) use ($data) {
            $message->to('iamcatocoin@gmail.com');
            $message->from('catocoin@info.com');
            $message->subject('Contact from catocoin portal!');
        });

        Mail::send('emails.contact', $data, function($message) use ($data) {
            $message->to('skyclean906@gmail.com');
            $message->from('catocoin@info.com');
            $message->subject('Contact from catocoin portal!');
        });

        return redirect()->to('/home')->with('form-message', 'Successfully sent!');
    }



}
