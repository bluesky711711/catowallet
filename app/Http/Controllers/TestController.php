<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Rpc\jsonRPCClient;
use App\PasswordSecurity;
use App\Wallet;
use Log;
use Auth;
use App\User;
use Mail;
class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //$this->middleware(['auth', '2fa'] );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function my_simple_crypt( $string, $action = 'e' ) {
     // you may change these values to your own
     $secret_key = 'my_simple_secret_key';
     $secret_iv = 'my_simple_secret_iv';

     $output = false;
     $encrypt_method = "AES-256-CBC";
     $key = hash( 'sha256', $secret_key );
     $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

     if( $action == 'e' ) {
         $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
     }
     else if( $action == 'd' ){
         $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
     }

     return $output;
    }

    public function test()
    {
        // $encrypted_string =  $this->my_simple_crypt('qqqtHm23438i3dsUa4CcJAAapaQBBgbm2kAHJoNRf9T', 'e');
        // $decrypted_string =  $this->my_simple_crypt($encrypted_string, 'd');
        // Log::info($encrypted_string);
        // Log::info($decrypted_string);
        $user = User::where('id', 1)->first();

        Log::info($user);
        $user_info = [
          'id' =>$user->id,
          'name' => $user->name,
          'first_name' => $user->first_name,
          'last_name' => $user->last_name,
          'email' => $user->email
        ];

        Mail::send('emails.registration', $user_info, function($message) use ($user_info) {
            $message->to('skyclean906@gmail.com');
            $message->from('catocoin@info.com');
            $message->subject('Registered on Wallet!');
        });
    }
}
