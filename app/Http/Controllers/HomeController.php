<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomeController extends Controller
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
    public function index()
    {
        return view('index', [
          'page' => 'Index'
        ]);
    }

    public function download()
    {
        return view('download', [
          'page' => 'Index'
        ]);
    }

    public function fund()
    {
        return view('fund', [
          'page' => 'fund'
        ]);
    }

    public function reauthenticate(Request $request)
    {
        // get the logged in user
        $user = \Auth::user();

        // initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        // generate a new secret key for the user
        $user->google2fa_secret = $google2fa->generateSecretKey();

        // save the user
        $user->save();

        // generate the QR image
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );

        // Pass the QR barcode image to our view.
        return view('google2fa.register', ['QR_Image' => $QR_Image,
                                            'secret' => $user->google2fa_secret,
                                            'reauthenticating' => true
                                        ]);
    }

}
