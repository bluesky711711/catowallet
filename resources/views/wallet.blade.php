@extends('layouts.app')
@section('content')
@if ($connection != null)
<!-- Start page content -->
<style>
.loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
		left:50%;
		position: relative;
		margin-left:-60px;
		top:50px;
    animation: spin 2s linear infinite;
		display:none;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
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
												<th class="text-center">Last Sale Price ($)</th>
												<th class="text-center">CatoCoin Value ($)</th>
										</tr>
										</thead>
										<tbody>
										<tr>
												<td class="catocoin_balance">0</td>
												<td class="btc_price">0</td>
												<td class="last_sale_usd_price_of_coin">0</td>
												<td class="value_usd_of_catocoin">0</td>
										</tr>
										</tbody>
								</table>
						</div>
				</div>
		</div>
</section>

<section id="page-content" class="page-wrapper">
		<div class="about-sheltek-area ptb-115" style="padding-top: 0px !important;">
				<div class="container">
						<div class="row">
								<div class="elements-tab-1">
										<!-- <h5 class="mb-50">Accounts</h5> -->
										<!-- Nav tabs -->
										<ul class="nav nav-tabs" style="min-width:450px">
												<li class="active"><a href="#transections" data-tab="transactions" data-toggle="tab">Transactions</a></li>
												<li><a href="#aBalance_1"  data-tab="addresses" data-toggle="tab">Address Balances</a></li>
												<li><a href="#MNStatus_1"  data-tab="masternodes" data-toggle="tab">Master Node Status</a></li>
										</ul>
										<!-- Tab panes -->
										<div class="tab-content">
												<div class="tab-pane fade in active" id="transections">
														<table class="table table-bordered text-center">
																<thead>
																<tr>
                                    <th class="text-center">Confirmed</th>
																		<th class="text-center">Tx ID</th>
																		<th class="text-center">Date</th>
																		<th class="text-center">Type</th>
																		<th class="text-center">Account</th>
																		<th class="text-center">Amount</th>
																</tr>
																</thead>
																<tbody id="tbody_transactions">

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
																<tbody id="tbody_addresses">

																</tbody>
														</table>
												</div>
												<div class="tab-pane fade" id="MNStatus_1">
														<table class="table table-bordered text-center">
																<thead>
																<tr>
																		<th class="text-center">Alias</th>
																		<th class="text-center">Address</th>
																		<th class="text-center">Protocol</th>
																		<th class="text-center">Collateral</th>
																		<th class="text-center">Status</th>
																		<th class="text-center">Active</th>
																		<th class="text-center">Last Seen</th>
																		<th class="text-center">Pubkey</th>
																</tr>
																</thead>
																<tbody id="tbody_masternodes">

																</tbody>
														</table>
												</div>
										</div>
								</div>
						</div>
						<div class="loader"></div>
				</div>
		</div>
</section>
@else
<section id="page-content" class="page-wrapper" style="padding:300px 0px;text-align:center; font-size:30px">
	Wallet offline - support has been notified!
</section>
@endif
<script>
function CommaFormatted(amount)
{
	var delimiter = ","; // replace comma if desired
	console.log(amount);
	amount = amount + '';
	var a = amount.split('.',2)
	var d='';
	if (a[1])
		d = a[1];
	var i = parseInt(a[0]);
	if(isNaN(i)) { return ''; }
	var minus = '';
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	var n = new String(i);
	var a = [];
	while(n.length > 3)
	{
		var nn = n.substr(n.length-3);
		a.unshift(nn);
		n = n.substr(0,n.length-3);
	}
	if(n.length > 0) { a.unshift(n); }
	n = a.join(delimiter);
	if(d.length < 1) { amount = n; }
	else { amount = n + '.' + d; }
	amount = minus + amount;
	return amount;
}

$(document).ready(function(){
	jQuery.get('https://api.coinmarketcap.com/v1/ticker/bitcoin/', function(data, status){
		btc_price = data[0].price_usd;
		$('.btc_price').html('$'+CommaFormatted(parseFloat(data[0].price_usd).toFixed(2)));

		jQuery.get('https://api.crypto-bridge.org/api/v1/ticker', function(data, status){
			var price = 0;
			for (var i in data){
				if (data[i]['id'] == "CATO_BTC"){
						price = data[i]['last'];
				}
			}
			//btc_value_of_coins = price * cato_balance;
			price = price * btc_price;
			cato_balance = parseFloat("{{$balance}}");
			total_price_balance = cato_balance * price;
			$('.value_usd_of_catocoin').html('$'+CommaFormatted(total_price_balance.toFixed(5)));
			$('.last_sale_usd_price_of_coin').html('$'+CommaFormatted(price.toFixed(5)));
		});
	});

	@if (isset($balance))
		var cato_balance = parseFloat("{{$balance}}");
		$('.catocoin_balance').html(CommaFormatted(cato_balance));

		jQuery.get('https://www.worldcoinindex.com/apiservice/ticker?key=HmnCf2MbMnG5vGvrLZ3B9hJhgcTc4Y&label=catobtc&fiat=usd', function(data, status){
			price = data['Markets'][0]['Price'];
		});
	@endif
});

$('.nav-tabs li a').click(function(){
	tab = $(this).data('tab');
	console.log(tab);

	if (tab == 'transactions'){
    $('#tbody_transactions').html('');
		$('.loader').show();
		jQuery.post('/gettransactions', function(res, status){
			html = '';
			for (i in res.transactions){
				console.log(res.transactions[i]);
				transaction = res.transactions[i];
        console.log('transaction', transaction);
        if (transaction.confirmations >= 15){
          html = html + '<tr>\
              <td style="color:green">&#10004;</td>\
              <td scope="row">'+ transaction['txid'] +'</td>' +
              '<td>'+ transaction['datetime'] +'</td>' +
              '<td>'+ transaction['type'] +'</td>' +
              '<td>'+ transaction['account'] +'</td>' +
              '<td>'+ transaction['amount'] +'</td>' +
          '</tr>';
        } else {
          html = html + '<tr>\
              <td>'+ transaction['confirmations'] + '</td> \
              <td scope="row">'+ transaction['txid'] +'</td>' +
              '<td>'+ transaction['datetime'] +'</td>' +
              '<td>'+ transaction['type'] +'</td>' +
              '<td>'+ transaction['account'] +'</td>' +
              '<td>'+ transaction['amount'] +'</td>' +
          '</tr>';
        }
			}
			$('#tbody_transactions').html(html);
			$('.loader').hide();
		});
	} else if (tab == 'masternodes') {
    $('#tbody_masternodes').html('');
		$('.loader').show();
		jQuery.post('/getmasternodestatus', function(res, status){
			html = '';
			for (i in res.masternode_data){
				console.log(res.masternode_data[i]);
				masternode = res.masternode_data[i];
        address = masternode['address'];
        ip = address.split(':')[0];
        port = address.split(':')[1];
        str = ip.replace(/[0-9]/g, "X");
        address = [str, port].join(':');
				html = html + '<tr>' +
												'<td>'+masternode['alias']+'</td>' +
												'<td>'+address+'</td>' +
												'<td>'+masternode['version'] +'</td>' +
												'<td>3150</td>'+
												'<td>'+ masternode['status']+'</td>' +
												'<td>'+masternode['activetime'] + '</td>' +
												'<td>'+masternode['lastseen']+'</td>' +
												'<td>'+masternode['public_key']+'</td>' +
												'</tr>';
			}
			$('#tbody_masternodes').html(html);
			$('.loader').hide();
		});
	} else if (tab == 'addresses') {
    $('#tbody_addresses').html('');
		$('.loader').show();
		jQuery.post('/getaddresses', function(res, status){
			html = '';
			for (i in res.addresses_data){
				console.log(res.addresses_data[i]);
				address = res.addresses_data[i];

				html = html + '<tr>' +
												'<td>'+i+'</td>' +
												'<td>'+address['item_addr']+'</td>' +
												'<td>'+address['balance'] +'</td>' +
												'</tr>';
			}
			$('#tbody_addresses').html(html);
			$('.loader').hide();
		});
	}
});
</script>
<!-- End page content -->
@endsection
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
