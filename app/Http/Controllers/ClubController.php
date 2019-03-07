<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use \Session;

class ClubController extends Controller {
	use \ImageHandler;
	private $error;
	private $restService = [ 
			'updateProfile' => 'admin/club/employee/update',
			'updateClubSettings' => 'admin/club/settings/update' 
	];
	public function index() {
		$data = $this->getEmployee ();
		$club = $this->getClubInfo ();
		return \View::make ( 'club.club', compact ( 'data', 'club' ) );
	}
	public function update(Request $request) {
		$validator = Validator::make ( $request->all (), [ 
				'email' => 'required|email',
				'firstName' => 'required|min:3|max:50',
				'lastName' => 'required|min:3|max:50',
				// 'gender' => 'required|in:Female,Male',
				'phone' => 'required',
				'profilePic' => 'sometimes|image|mimes:jpeg,bmp,png,jpg|max:1024' 
		] );
		
		if ($validator->fails ()) {
			$this->error = $validator->errors ();
			return \Redirect::back ()->withInput ()->withErrors ( $this->error );
		}
		$data = $request->all ();
		if ($request->hasFile ( 'profilePic' )) {
			$uploadPath = self::uploadImage ( $request->file ( 'profilePic' ), 'employee_profile_path', md5 ( \Session::get ( 'email' ) ), true, true );
			$data ['profilePic'] = $uploadPath;
		}
		
		try {
			$response = $this->post ( $this->restService ['updateProfile'], $data )->response ();
			$this->AuthorizeEmployee ( $response );
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
		}
		
		if ($this->error != '') {
			return \Redirect::back ()->withInput ()->with ( [ 
					'serverError' => $this->error 
			] );
		}
		return \Redirect::back ()->withInput ()->with ( [ 
				'success' => trans ( 'messages.account_update_successfull' ) 
		] );
	}
	public function updateSettings(Request $request) {
		$validator = Validator::make ( $request->all (), [ 
				'mainMember' => 'required|Integer',
				'spouse' => 'required|Integer',
				'child' => 'required|Integer' 
		] );
		
		if ($validator->fails ()) {
			$this->error = $validator->errors ();
			return \Redirect::back ()->withInput ()->withErrors ( $this->error );
		}
		
		try {
			$data ['mainMember'] = $request->get ( 'mainMember', 0 ) * 60;
			$data ['spouse'] = $request->get ( 'spouse', 0 ) * 60;
			$data ['child'] = $request->get ( 'child', 0 ) * 60;
			$response = $this->post ( $this->restService ['updateClubSettings'], $data )->response ();
			$this->setClubInfo($response);
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
		}
		
		if ($this->error != '') {
			return \Redirect::back ()->withInput ()->with ( [ 
					'serverError' => $this->error 
			] );
		}
		return \Redirect::back ()->withInput ()->with ( [ 
				'success' => trans ( 'message.club_settings_update_successfull' ) 
		] );
	}
}
