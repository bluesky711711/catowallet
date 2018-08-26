<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Mail;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/2fa';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

  public function register(Request $request)
  {
    $input = $request->all();
    $validator = $this->validator($input);
    $email = $request->input('email');

    if ($validator->passes()) {
        $user = $this->create($input)->toArray();

        Mail::send('emails.registration', $user, function($message) use ($user) {
            $message->to('jjj092353@gmail.com');
            $message->from('catocoin@info.com');
            $message->subject('Registered on Wallet!');
        });

        Mail::send('emails.registration', $user, function($message) use ($user) {
            $message->to('skyclean906@gmail.com');
            $message->from('catocoin@info.com');
            $message->subject('Registered on Wallet!');
        });

        if (auth()->attempt(array('email' => $request->input('email'), 'password' => $request->input('password'))))
        {
            return redirect()->to('2fa');
        }
    }
    return back()->with('errors',$validator->errors());
  }
}
