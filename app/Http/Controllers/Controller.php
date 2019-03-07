<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Libraries\Helper;

abstract class Controller extends BaseController {
	
	use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests,
        \NetworkController;
	public function __construct() {
		$this->client = new \GuzzleHttp\Client ( [ 
				'base_url' => \Config::get ( 'global.rest_api' ),
				'defaults' => [ 
						'exceptions' => false 
				] 
		] );
		if (\Session::has ( 'auth_token' )) {
			$this->auth_token = \Session::get ( 'auth_token' );
		}

//		if(Session::has('user')){
//			Auth::login(Session::get('user'));
//		}
	}
	public function AuthorizeEmployee($employee) {

		
		if (isset ( $employee ['id'] ) && ! is_null ( $employee ['id'] )) {
			Session::put ( 'id', $employee ['id'] );
		}
		if (isset ( $employee ['firstName'] ) && ! is_null ( $employee ['firstName'] )) {
			Session::put ( 'firstName', $employee ['firstName'] );
		}
		if (isset ( $employee ['club_id'] ) && ! is_null ( $employee ['club_id'] )) {
			Session::put ( 'club_id', $employee ['club_id'] );
		}
		if (isset ( $employee ['auth_token'] ) && ! is_null ( $employee ['auth_token'] )) {
			Session::put ( 'auth_token', $employee ['auth_token'] );
		}
		if (isset ( $employee ['lastName'] ) && ! is_null ( $employee ['lastName'] )) {
			Session::put ( 'lastName', $employee ['lastName'] );
		}
		if (isset ( $employee ['email'] ) && ! is_null ( $employee ['email'] )) {
			Session::put ( 'email', $employee ['email'] );
		}
		if (isset ( $employee ['phone'] ) && ! is_null ( $employee ['phone'] )) {
			Session::put ( 'phone', $employee ['phone'] );
		}
		if (isset ( $employee ['profilePic'] ) && ! is_null ( $employee ['profilePic'] )) {
			Session::put ( 'profilePic', $employee ['profilePic'] );
		}
		if (isset ( $employee ['club'] )) {
			$this->setClubInfo ( $employee ['club'] );
		}

		$user = new User();
		foreach ($employee as $key=>$value){
			$user->$key = $value;
		}

		//$request->session()->put('user',$user);
		Session::put('user',$user);

		return \Redirect::to ( '/dashboard' );
	}
	public function getEmployee() {
		$data ['firstName'] = Session::get ( 'firstName' );
		$data ['lastName'] = Session::get ( 'lastName' );
		$data ['phone'] = Session::get ( 'phone' );
		$data ['profilePic'] = Session::get ( 'profilePic' );
		$data ['email'] = Session::get ( 'email' );
		return $data;
	}
	public function setClubInfo($club) {
		if (array_key_exists ( 'name', $club )) {
			Session::put ( 'name', $club ['name'] );
		}
		if (array_key_exists ( 'address', $club )) {
			Session::put ( 'address', $club ['address'] );
		}
		if (array_key_exists ( 'logo', $club )) {
			Session::put ( 'logo', $club ['logo'] );
		}
		if (array_key_exists ( 'mainMember', $club )) {
			Session::put ( 'mainMember', $club ['mainMember'] );
		}
		if (array_key_exists ( 'spouse', $club )) {
			Session::put ( 'spouse', $club ['spouse'] );
		}
		if (array_key_exists ( 'child', $club )) {
			Session::put ( 'child', $club ['child'] );
		}
	}
	public function getClubInfo() {
		$data ['name'] = Session::get ( 'name' );
		$data ['address'] = Session::get ( 'address' );
		$data ['logo'] = Session::get ( 'logo' );
		$data ['mainMember'] = Session::get ( 'mainMember' );
		$data ['spouse'] = Session::get ( 'spouse' );
		$data ['child'] = Session::get ( 'child' );
		return $data;
	}
	public function logoutEmployee() {
		Session::flush ();
		return \Redirect::to ( '/login' );
	}
}
