<?php

namespace App\Http\Controllers;
require'../vendor/autoload.php';
use GuzzleHttp\Client;
use App\IGSession;
use \Session;
use \App\ftse;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class HistoryController extends Controller
{

	public function index(){
		return view('history.index');
	}

	public function plotHistory($epic){
		
		$history = ftse::all();

		foreach ($history as $snapshot) {
			$points[] = $snapshot['openPriceBid'];
			$times[] = $snapshot['timePoint'];
		}

		return view('historyPlot', [
			'points' => json_encode($points),
			'times' => json_encode($times)
		]);
	}

	public function getHistory($epic){

		$this -> igSession = Session::get('igSession');

		//$URL = 'https://demo-api.ig.com/gateway/deal/prices/IX.D.FTSE.DAILY.IP?resolution=DAY&pageSize=100';
		$URL = 'https://demo-api.ig.com/gateway/deal/prices/'.$epic.'?resolution=DAY&max=365&pageSize=365';
		//$URL = 'https://demo-api.ig.com/gateway/deal/prices/'.$epic.'?resolution=MINUTE_30&max=15&pageSize=100';

		$client = new Client();
		$res = $client->request('GET', $URL, [
			'headers' => [
				'Accept' => 'application/json',
				'Content-type' => 'application/json; charset=UTF-8',
				'Version' => '3',
				'X-IG-API-KEY' => 'b4a9b5f64e40e6aa24114a5a8ab2c6456e1b22a3',
				'CST' => $this -> igSession -> CST,
				'X-SECURITY-TOKEN' => $this -> igSession -> XST
			]
		]);

		$response = json_decode($res->getBody(), true);

        foreach($response['prices'] as $ftsePrice){
            $price = \App\ftse::firstOrCreate(['timePoint' => $ftsePrice['snapshotTime']]);
            $price -> openPriceBid = $ftsePrice['openPrice']['bid'];
            $price -> openPriceAsk = $ftsePrice['openPrice']['ask'];
            $price -> closePriceBid = $ftsePrice['closePrice']['bid'];
            $price -> closePriceAsk = $ftsePrice['closePrice']['ask'];
            $price -> highPriceBid = $ftsePrice['highPrice']['bid'];
            $price -> highPriceAsk = $ftsePrice['highPrice']['ask'];
            $price -> lowPriceBid = $ftsePrice['lowPrice']['bid'];
            $price -> lowPriceAsk = $ftsePrice['lowPrice']['ask'];
            $price -> save();
        }
//		return($response);
	}


}