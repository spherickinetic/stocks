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
				'X-IG-API-KEY' => ''
			],
			'body' => json_encode(
				[
					'identifier' => '',
					'password' => ''
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
