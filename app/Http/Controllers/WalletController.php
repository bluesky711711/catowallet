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
    public function getwalletinfo() {
      $user = Auth::user();

      $wallets = Wallet::where('user_id', $user->id)->get();
      $wallet_balance = 0;
      $transactions = [];
      $addresses_data = [];
      $masternode_data = [];
      $walletinfo = null;
      $client = null;
      foreach ($wallets as $wallet) {
        //$wallet = Wallet::where('id', $user->wallet_id)->first();
        $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$wallet->rpcpassword.'@'.$wallet->ip.':'.$wallet->rpcport.'/');
        if ($client == null) continue;
        $walletinfo = $client->getwalletinfo();
        if ($walletinfo == null) continue;
        $wallet_balance = $wallet_balance + $walletinfo['balance'];
      }

      return array('wallet_balance' => $wallet_balance, 'connection' => $walletinfo);
    }


    public function gettransactions(){
      $user = Auth::user();

      $wallets = Wallet::where('user_id', $user->id)->get();
      $wallet_balance = 0;
      $transactions = [];
      $walletinfo = null;
      $client = null;
      foreach ($wallets as $wallet) {
        $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$wallet->rpcpassword.'@'.$wallet->ip.':'.$wallet->rpcport.'/');
        if ($client == null) continue;
        $walletinfo = $client->getwalletinfo();
        if ($walletinfo == null) continue;

        $transactions_item = $client->listtransactions("*", 50);
        foreach ($transactions_item as $tran){
          $tran['type'] = $tran['category'];
          Log::info($tran);
          if ((isset($tran["generated"]) && $tran["generated"] == true) && $tran['vout'] == 2 && $tran['category']=="receive"){
            $tran['type'] = "Masternode Reward";
          }
          $tran['datetime'] = date('Y-m-d h:m:s', $tran['time']);
          array_push($transactions, $tran);
        }
      }
      return array('transactions' => $transactions, 'connection' => $walletinfo);
    }

    public function getaddresses() {
      $user = Auth::user();
      $wallets = Wallet::where('user_id', $user->id)->get();
      $wallet_balance = 0;
      $transactions = [];
      $addresses_data = [];
      $masternode_data = [];
      $walletinfo = null;
      $client = null;
      foreach ($wallets as $wallet) {
        $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$wallet->rpcpassword.'@'.$wallet->ip.':'.$wallet->rpcport.'/');
        if ($client == null) continue;
        $walletinfo = $client->getwalletinfo();
        if ($walletinfo == null) continue;
        $addresses = $client->listaddressgroupings();

        foreach ($addresses[0] as $address){
          if ($address[1] > 0){
            array_push($addresses_data, array("item_addr" => $address[0], "balance" => $address[1]));
          }
        }
      }

      return array('addresses_data' => $addresses_data , 'connection' => $walletinfo);
    }

    public function getmasternodestatus() {
      $user = Auth::user();

      $wallets = Wallet::where('user_id', $user->id)->get();
      $wallet_balance = 0;
      $masternode_data = [];
      $walletinfo = null;
      $client = null;
      foreach ($wallets as $wallet) {
        //$wallet = Wallet::where('id', $user->wallet_id)->first();
        $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$wallet->rpcpassword.'@'.$wallet->ip.':'.$wallet->rpcport.'/');
        if ($client == null) continue;
        $walletinfo = $client->getwalletinfo();
        if ($walletinfo == null) continue;
        $wallet_balance = $wallet_balance + $walletinfo['balance'];

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

      return array('masternode_data' => $masternode_data, 'connection' => $walletinfo);
    }

    public function wallet()
    {
      $user = Auth::user();
      $wallets = Wallet::where('user_id', $user->id)->get();
      $wallet_balance = 0;
      $walletinfo = null;
      foreach ($wallets as $wallet) {
        $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$wallet->rpcpassword.'@'.$wallet->ip.':'.$wallet->rpcport.'/');
        if ($client == null) continue;
        $walletinfo = $client->getwalletinfo();
        if ($walletinfo == null) continue;
        $wallet_balance = $wallet_balance + $walletinfo['balance'];
      }

        return view('wallet', [
         'page' => 'wallet',
         'connection' => $walletinfo,
         'balance' => $wallet_balance
        ]);
    }

    public function walletorg()
    {
       $user = Auth::user();

       $wallets = Wallet::where('user_id', $user->id)->get();
       $wallet_balance = 0;
       $transactions = [];
       $addresses_data = [];
       $masternode_data = [];
       $walletinfo = null;
       $client = null;
       foreach ($wallets as $wallet) {

         $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$wallet->rpcpassword.'@'.$wallet->ip.':'.$wallet->rpcport.'/');
         if ($client == null) continue;
         $walletinfo = $client->getwalletinfo();
         if ($walletinfo == null) continue;
         $wallet_balance = $wallet_balance + $walletinfo['balance'];
         $transactions_item = $client->listtransactions("*", 50);

         $addresses = $client->listaddressgroupings();

         foreach ($transactions_item as $tran){
           $tran['type'] = $tran['category'];
           Log::info($tran);
           if ((isset($tran["generated"]) && $tran["generated"] == true) && $tran['vout'] == 2 && $tran['category']=="receive"){
             $tran['type'] = "Masternode Reward";
           }

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
       if ($client == null) $walletinfo = null;

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
