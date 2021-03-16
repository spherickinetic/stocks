<?php

namespace App\Http\Controllers;
require'../vendor/autoload.php';
use GuzzleHttp\Client;
use App\IGSession;
use \Session;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class DashboardController extends Controller
{
	public function index(){
		$this -> igSession = Session::get('igSession');

		$openPositions = $this -> getOpenPositions();
		$marketDetails = $this -> getMarketDetails();

//		$this -> placeADeal();
		
		return view('dashboard', [
			'openPositions' => $openPositions['positions'],
			'marketDetails' => $marketDetails,
			'igSession' => $this -> igSession
		]);
	}

	public function getOpenPositions(){
		$client = new Client();
		$res = $client->request('GET', 'https://demo-api.ig.com/gateway/deal/positions', [
			'headers' => [
			'Accept' => 'application/json',
			'Content-type' => 'application/json; charset=UTF-8',
			'Version' => '2',
			'X-IG-API-KEY' => 'b4a9b5f64e40e6aa24114a5a8ab2c6456e1b22a3',
			'CST' => $this -> igSession -> CST,
			'X-SECURITY-TOKEN' => $this -> igSession -> XST
			]
		]);

		$response = json_decode($res->getBody(), true);

/*
		echo("<pre>");
		print_r($response);
		echo("</pre>");
*/
		return($response);
	}

	public function getMarketDetails(){
		$client = new Client();
		$res = $client->request('GET', 'https://demo-api.ig.com/gateway/deal/markets/IX.D.FTSE.DAILY.IP', [
			'headers' => [
			'Accept' => 'application/json',
			'Content-type' => 'application/json; charset=UTF-8',
			'Version' => '1',
			'X-IG-API-KEY' => 'b4a9b5f64e40e6aa24114a5a8ab2c6456e1b22a3',
			'CST' => $this -> igSession -> CST,
			'X-SECURITY-TOKEN' => $this -> igSession -> XST
			]
		]);

		$response = json_decode($res->getBody(), true);

/*
		echo("<pre>");
		print_r($response);
		echo("</pre>");
*/
		return($response);
	}

	public function placeADeal(){
		$client = new Client();
		$res = $client->request('POST', 'https://demo-api.ig.com/gateway/deal/positions/otc', [
			'headers' => [
			'Accept' => 'application/json',
			'Content-type' => 'application/json; charset=UTF-8',
			'Version' => '1',
			'X-IG-API-KEY' => 'b4a9b5f64e40e6aa24114a5a8ab2c6456e1b22a3',
			'CST' => $this -> igSession -> CST,
			'X-SECURITY-TOKEN' => $this -> igSession -> XST
			],
			'body' => json_encode(
				[
					"currencyCode" => "GBP",
					"dealReference" => "test5",
					"epic" => "IX.D.FTSE.DAILY.IP",
					"expiry" => "DFB",
					"direction" => "SELL",
					"size" => "10",
					"forceOpen" => false,
					"guaranteedStop" => true,
					"stopDistance" => "150",
					"orderType" => "MARKET",
				]
			)
		]);

		$response = json_decode($res->getBody());
	}

}