<?php

namespace App\Http\Controllers;
require'../vendor/autoload.php';
use GuzzleHttp\Client;
use App\IGSession;
use \Session;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class LoginController extends Controller
{
	public function login(){

		$client = new Client();
		$res = $client -> request('POST', 'https://demo-api.ig.com/gateway/deal/session', [
			'headers' => [
				'Accept' => 'application/json',
				'Content-type' => 'application/json; charset=UTF-8',
				'Version' => '2',
				'X-IG-API-KEY' => 'b4a9b5f64e40e6aa24114a5a8ab2c6456e1b22a3'
			],
			'body' => json_encode(
				[
					'identifier' => 'danjaboltonTest',
					'password' => 'Danjabolton1Test'
				]
			)
		]);

		$igSession = new IGSession();
		$igSession -> CST = $res -> getHeader('CST')[0];
		$igSession -> XST = $res -> getHeader('X-SECURITY-TOKEN')[0];
		$igSession -> accountInfo = json_decode($res -> getBody());

		Session::put('igSession', $igSession);

		return redirect() -> route('dashboard');
	}
}