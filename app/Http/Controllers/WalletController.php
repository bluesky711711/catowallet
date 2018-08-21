<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Rpc\jsonRPCClient;
use Log;
use Auth;
class WalletController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware(['auth', '2fa'] );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function wallet()
    {
       $user = Auth::user();

       if (isset($user->wallet_id)){
         $client = new jsonRPCClient('http://catoportal:69cJOb0PoBFEkijLlNblkU1bhhsi8hha3a@207.148.65.130:6082/');

         $walletinfo = $client->getwalletinfo();
         $transactions = $client->listtransactions();
         $accounts = $client->listaccounts();

         $addresses_data = [];

         foreach ($accounts as $key => $value) {
           $addresses = $client->getaddressesbyaccount($key);
           foreach ($addresses as $address){
             $received = 0;
             $sent = 0;
             foreach ($transactions as $tran){
               if ($tran['address'] == $address){
                 if ($tran['category'] == 'receive'){
                   $received = $received + $tran['amount'];
                 } else if ($tran['category'] == 'send') {
                   $sent = $sent + $tran['amount'];
                 }
               }
             }
             $balance = $received - $sent;
             array_push($addresses_data, array("item_addr" => $address, "balance" => $balance));
           }
         }

         return view('wallet', [
          'page' => 'wallet',
          'walletinfo' => $walletinfo,
          'transactions' => $transactions,
          'addresses' => $addresses_data
         ]);
       }

       return view('wallet', [
        'page' => 'wallet',
        'walletinfo' => null,
        'transactions' => null,
        'addresses' => null
       ]);
    }
}
