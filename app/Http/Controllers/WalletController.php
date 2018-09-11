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
      //$this->middleware(['auth', '2fa'] );
      $this->middleware('auth');
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

        $rpc_password = $this->my_simple_crypt($wallet->rpcpassword, 'd');
        $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$rpc_password.'@'.$wallet->ip.':'.$wallet->rpcport.'/');
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
        $rpc_password = $this->my_simple_crypt($wallet->rpcpassword, 'd');
        $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$rpc_password.'@'.$wallet->ip.':'.$wallet->rpcport.'/');
        if ($client == null) continue;
        $walletinfo = $client->getwalletinfo();
        if ($walletinfo == null) continue;
        $transactions_item = $client->listtransactions('*', 750);
        foreach ($transactions_item as $tran){
          $bagain = false;
          foreach ($transactions as $item){
            if ($item['txid'] == $tran['txid']){
              $bagain = true;
            }
          }
          if ($bagain == true){
            continue;
          }

          $tran['type'] = $tran['category'];
          if ((isset($tran["generated"]) && $tran["generated"] == true) && $tran['vout'] == 2 && $tran['category']=="receive"){
            $tran['type'] = "Masternode Reward";
          }
          else if (isset($tran["generated"]) && $tran["generated"] == true && $tran['vout'] == 2 && $tran['category']=="send")
          {
              $tran['type'] = "Minted";
              $tran['amount'] = $tran['fee'] + $tran['amount'];
              foreach ($transactions_item as $item1){
                if (($item1['txid'] == $tran['txid']) && (isset($item1["generated"]) && $item1["generated"] == true) && $item1['vout'] == 1 && $item1['category']=="receive"){
                  $tran['account'] = $item1['account'];
                  break;
                }
              }
          } else {
            if ($tran['type'] == 'receive') {
              foreach ($transactions_item as $item){
                if ($item['txid'] == $tran['txid'] && $item['category'] == 'send'){
                  $tran['type'] = 'Payment to yourself';
                  break;
                }
              }
            } else if ($tran['type'] == 'send') {
              foreach ($transactions_item as $item){
                if ($item['txid'] == $tran['txid'] && $item['category'] == 'receive'){
                  $tran['type'] = 'Payment to yourself';
                  break;
                }
              }
            }
          }

          $tran['datetime'] = date('Y-m-d h:m:s', $tran['time']);
          if ($tran['type'] != "Payment to yourself" )
          {
            array_push($transactions, $tran);
          }
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
        $rpc_password = $this->my_simple_crypt($wallet->rpcpassword, 'd');
        $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$rpc_password.'@'.$wallet->ip.':'.$wallet->rpcport.'/');
        if ($client == null) continue;
        $walletinfo = $client->getwalletinfo();
        if ($walletinfo == null) continue;
        $addresses = $client->listaddressgroupings();
        foreach ($addresses as $item) {
        foreach ($item as $address){
          if ($address[1] >= 1){
            array_push($addresses_data, array("item_addr" => $address[0], "balance" => $address[1]));
          }
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
        $rpc_password = $this->my_simple_crypt($wallet->rpcpassword, 'd');
        $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$rpc_password.'@'.$wallet->ip.':'.$wallet->rpcport.'/');
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
        $rpc_password = $this->my_simple_crypt($wallet->rpcpassword, 'd');
        $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$rpc_password.'@'.$wallet->ip.':'.$wallet->rpcport.'/');
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
         $rpc_password = $this->my_simple_crypt($wallet->rpcpassword, 'd');
         $client = new jsonRPCClient('http://'.$wallet->rpcuser.':'.$rpc_password.'@'.$wallet->ip.':'.$wallet->rpcport.'/');
         if ($client == null) continue;
         $walletinfo = $client->getwalletinfo();
         if ($walletinfo == null) continue;
         $wallet_balance = $wallet_balance + $walletinfo['balance'];
         $transactions_item = $client->listtransactions("*", 50);

         $addresses = $client->listaddressgroupings();

         foreach ($transactions_item as $tran){
           $tran['type'] = $tran['category'];
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
