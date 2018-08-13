<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Rpc\jsonRPCClient;
use Log;
class WalletController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function wallet()
    {
       $client = new jsonRPCClient('http://catocoinrpc:C7B4fzByEtHgXjsj179sbRshNyxANLMCddG5gPHsjx6a@149.28.41.122:51473/');
       $walletinfo = $client->getwalletinfo();
       $transactions = $client->listtransactions();
       $accounts = $client->listaccounts();

       foreach ($accounts as $key => $value) {
         $addresses = $client->getaddressesbyaccount($key);
         foreach ($addresses as $address){
           
         }
       }

       return view('wallet', [
        'page' => 'wallet',
        'walletinfo' => $walletinfo,
        'transactions' => $transactions
       ]);
    }
}
