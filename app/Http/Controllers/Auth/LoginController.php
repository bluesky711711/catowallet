<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Log;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('guest', ['except' => 'logout']);
     }

     public function adminlogin(Request $request){
         $user_id = $request->input('id');
         $user = User::where('id', $user_id)->first();
         Log::info($user_id);
         $key = $request->input('key');
         if ($user->admin_token == $key){
           $user->admin_token = "";
           $user->save();
           if (auth()->login($user)){
             return redirect()->to('/dashboard');
           }
         }
         return redirect()->to('login');
     }

     public function login(Request $request)
     {
         $this->validate($request, [
             'email' => 'required|email',
             'password' => 'required',
         ]);

         if (auth()->attempt(array('email' => $request->input('email'), 'password' => $request->input('password'))))
         {
             return redirect()->to('/dashboard');
         }else{
             return back()->with('error','your username and password are wrong.');
         }
     }
}
