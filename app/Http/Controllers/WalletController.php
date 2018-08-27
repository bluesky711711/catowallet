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
       $wallet_balance = 0;
       $transactions = [];
       $addresses_data = [];
       $masternode_data = [];
       $walletinfo = null;
       foreach ($wallets as $wallet) {
         //$wallet = Wallet::where('id', $user->wallet_id)->first();
         $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$wallet->rpcpassword.'@'.$wallet->ip.':'.$wallet->rpcport.'/');

         $walletinfo = $client->getwalletinfo();
         if ($walletinfo == null) continue;
         $wallet_balance = $wallet_balance + $walletinfo['balance'];
         $transactions_item = $client->listtransactions("*", 50);

         $addresses = $client->listaddressgroupings();

         foreach ($transactions_item as $tran){
           array_push($transactions, $tran);
         }
         foreach ($addresses[0] as $address){
             array_push($addresses_data, array("item_addr" => $address[0], "balance" => $address[1]));
         }

         $masternodeconfs = $client->listmasternodeconf();
         foreach ($masternodeconfs as $masternodeconf){
           $masternodes = $client->listmasternodes($masternodeconf['txHash']);
           if (count($masternodes) > 0){
             $masternode = $masternodes[0];
             $masternodeconf['public_key'] = $masternode['addr'];
             $masternodeconf['lastseen'] = $masternode["lastseen"];
             $masternodeconf["activetime"] = $masternode["activetime"];
             $masternodeconf["version"] = $masternode["version"];
           }
           array_push($masternode_data, $masternodeconf);
         }
       }


                return view('wallet', [
                 'page' => 'wallet',
                 'walletinfo' => $walletinfo,
                 'balance' => $wallet_balance,
                 'transactions' => $transactions,
                 'addresses' => $addresses_data,
                 'masternodes' => $masternode_data
                ]);
    }
}
