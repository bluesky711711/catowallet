@extends('layouts.app')
@section('content')
<!-- Start page content -->
<section id="page-content" class="page-wrapper">
		<div class="about-sheltek-area ptb-115" style="padding-bottom: 30px !important;">
				<div class="container">
						<div></div>
						<div class="row">
								<table class="table table-bordered text-center">
										<thead>
										<tr>
												<th class="text-center">Cato Coin Balance</th>
												<th class="text-center">Current BTC Price</th>
												<th class="text-center">BTC Value of Coins</th>
												<th class="text-center">Value of CatoCoins</th>
										</tr>
										</thead>
										<tbody>
										<tr>
												<td class="catocoin_balance">0</td>
												<td class="btc_price">0</td>
												<td class="btc_value_of_coins">0</td>
												<td class="value_of_catocoins">0</td>
										</tr>
										</tbody>
								</table>
						</div>
				</div>
		</div>
</section>
<section id="page-content" class="page-wrapper">
		<div class="about-sheltek-area ptb-115" style="padding-top: 50px !important;">
				<div class="container">
						<div class="row">
								<div class="elements-tab-1">
										<h5 class="mb-50">Accounts</h5>
										<!-- Nav tabs -->
										<ul class="nav nav-tabs">
												<li class="active"><a href="#transections"  data-toggle="tab">Transactions</a></li>
												<li><a href="#aBalance_1"  data-toggle="tab">Address Balances</a></li>
												<li><a href="#MNStatus_1"  data-toggle="tab">Master Node Status</a></li>
										</ul>
										<!-- Tab panes -->
										<div class="tab-content">
												<div class="tab-pane fade in active" id="transections">
														<table class="table table-bordered text-center">
																<thead>
																<tr>
																		<th class="text-center">#</th>
																		<th class="text-center">Date</th>
																		<th class="text-center">Type</th>
																		<th class="text-center">Address</th>
																		<th class="text-center">Amount</th>
																</tr>
																</thead>
																<tbody>
																<tr>
																		<th scope="row">1</th>
																		<td>10-05-2018</td>
																		<td>Sell</td>
																		<td>8901 Marmora Raod, Glasgow, D04  89GR</td>
																		<td>150</td>
																</tr>
																</tbody>
														</table>
												</div>
												<div class="tab-pane fade" id="aBalance_1">
														<table class="table table-bordered text-center">
																<thead>
																<tr>
																		<th class="text-center">#</th>
																		<th class="text-center">Address</th>
																		<th class="text-center">Balance</th>
																</tr>
																</thead>
																<tbody>
																<tr>
																		<th scope="row">1</th>
																		<td>8901 Marmora Raod, Glasgow, D04  89GR</td>
																		<td>150</td>
																</tr>
																</tbody>
														</table>
												</div>
												<div class="tab-pane fade" id="MNStatus_1">
														<table class="table table-bordered text-center">
																<thead>
																<tr>
																		<th class="text-center">#</th>
																		<th class="text-center">Alias</th>
																		<th class="text-center">Address</th>
																		<th class="text-center">Protocol</th>
																		<th class="text-center">Collateral</th>
																		<th class="text-center">Active</th>
																		<th class="text-center">Last Seen</th>
																		<th class="text-center">Pubkey</th>
																</tr>
																</thead>
																<tbody>
																<tr>
																		<th scope="row">1</th>
																		<td>Dummy Data</td>
																		<td>8901 Marmora Raod, Glasgow, D04  89GR</td>
																		<td>https</td>
																		<td>Dummy</td>
																		<td>Yes</td>
																		<td>Dummy</td>
																		<td>837t423hwedgy7y837</td>
																</tr>
																</tbody>
														</table>
												</div>
										</div>
								</div>
						</div>
				</div>
		</div>
</section>
<script>
$(document).ready(function(){
	jQuery.get('https://api.coinmarketcap.com/v1/ticker/bitcoin/', function(data, status){
		$('.btc_price').html(parseFloat(data[0].price_usd).toFixed(2) + ' $');
	});

	@if (isset($walletinfo) && isset($walletinfo['balance']))
		var cato_balance = parseFloat("{{$walletinfo['balance']}}");
		$('.catocoin_balance').html(cato_balance);

		jQuery.get('https://www.worldcoinindex.com/apiservice/ticker?key=HmnCf2MbMnG5vGvrLZ3B9hJhgcTc4Y&label=catobtc&fiat=btc', function(data, status){
			price = data['Markets'][0]['Price'];
			btc_value_of_coins = price * cato_balance;
			$('.btc_value_of_coins').html(btc_value_of_coins.toFixed(5));
		});

		jQuery.get('https://www.worldcoinindex.com/apiservice/ticker?key=HmnCf2MbMnG5vGvrLZ3B9hJhgcTc4Y&label=catobtc&fiat=usd', function(data, status){
			price = data['Markets'][0]['Price'];
			value_of_catocoins = price * cato_balance;
			$('.value_of_catocoins').html(value_of_catocoins.toFixed(5));
		});
	@endif
});
</script>
<!-- End page content -->
@endsection
