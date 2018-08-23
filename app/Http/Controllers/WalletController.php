<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Rpc\jsonRPCClient;
use App\PasswordSecurity;
use App\Wallet;
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
       // $mfa = PasswordSecurity::where('user_id', $user->id)->first();
       // if (!isset($mfa) || !$mfa->google2fa_enable) {
       //   return redirect('/2fa');
       // }
       $wallets = Wallet::where('user_id', $user->id)->get();
       $balance = 0;
       $transactions = [];
       $addresses_data = [];
       $walletinfo = null;
       foreach ($wallets as $wallet) {
         //$wallet = Wallet::where('id', $user->wallet_id)->first();
         $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$wallet->rpcpassword.'@'.$wallet->ip.':'.$wallet->rpcport.'/');

         $walletinfo = $client->getwalletinfo();
         if ($walletinfo == null) continue;
         $balance = $balance + $walletinfo['balance'];
         $transactions_item = $client->listtransactions();

         $accounts_item = $client->listaccounts();

         foreach ($accounts_item as $key => $value) {
           $addresses = $client->getaddressesbyaccount($key);
           foreach ($addresses as $address){
             $received = 0;
             $sent = 0;
             foreach ($transactions_item as $tran){
               array_push($transactions, $tran);
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
       }


                return view('wallet', [
                 'page' => 'wallet',
                 'walletinfo' => $walletinfo,
                 'balance' => $balance,
                 'transactions' => $transactions,
                 'addresses' => $addresses_data
                ]);
    }
}
