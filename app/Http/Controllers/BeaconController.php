<?php

namespace App\Http\Controllers;

use App\Custom\Authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use \Session;
use Carbon\Carbon;

class BeaconController extends Controller {
	private $restService = [ 
			'listBeacon' => 'admin/beacon',
			'editBeacon' => 'admin/beacon/%s',
			'createBeacon' => 'admin/beacon',
			'updateBeacon' => 'admin/beacon/%s',
			'deleteBeacon' => 'admin/beacon/%s',
			'listCourt' => 'admin/court' 
	];
	public $error;
	
	/**
	 * List courts associated with Logedin Club
	 *
	 * @return type
	 */
	public function index() {
		if (!Authorization::canAccess('beacons')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			$data = $this->get ( $this->restService ['listBeacon'] )->response ();
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
		}
		
		if (is_null ( $this->error )) {
			
			return \View::make ( 'beacon.list', compact ( 'data' ) );
		} else {
			return \Redirect::to ( 'beacon/create' )->withErrors ( [ 
					'serverError' => $this->error 
			] );
		}
	}
	
	/**
	 * Create a new court for loged in club
	 *
	 * @return type
	 */
	public function create() {
		if (!Authorization::canAccess('beacons')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			$data = $this->get ( $this->restService ['listCourt'] )->response ();
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
		}
		if (is_null ( $this->error ))
			return \View::make ( 'beacon.create', compact ( 'data' ) );
		return \Redirect::to ( 'dashboard' )->withErrors ( [ 
				'serverError' => $this->error 
		] );
	}
	
	/**
	 * Store a court for loged in club
	 *
	 * @param Illuminate\Http\Request $request        	
	 */
	public function store(Request $request) {
		if (!Authorization::canAccess('beacons')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$validator = Validator::make ( $request->all (), [ 
				'name' => 'required',
				'court_id' => 'required',
				'UUID' => 'required',
				'major' => 'required',
				'minor' => 'required',
				'recordCheckin' => 'required' 
		] );
		
		if ($validator->fails ()) {
			$this->error = $validator->errors ();
			return \Redirect::back ()->withInput ()->withErrors ( $this->error );
		}
		
		try {
			$data = $request->all ();
			$response = $this->post ( $this->restService ['createBeacon'], $data )->response ();
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
		return \Redirect::to ( '/beacon' )->with ( [ 
				'success' => trans ( 'messages.beacon_success' ) 
		] );
	}
	
	/**
	 * show club details
	 *
	 * @param int $beaconId        	
	 * @return html
	 */
	public function edit($beaconId) {
		if (!Authorization::canAccess('beacons')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			
			$data = $this->get ( sprintf ( $this->restService ['editBeacon'], $beaconId ) )->response ();
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
		}
		
		if ($this->error) {
			return \Redirect::back ()->with ( [ 
					'serverError' => $this->error 
			] );
		}
		
		try {
			$courts = $this->get ( $this->restService ['listCourt'] )->response ();
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
		}
		if (is_null ( $this->error ) && $courts)
			return \View::make ( 'beacon.edit', [ 
					'data' => $data,
					'courts' => $courts 
			] );
		return \Redirect::back ()->with ( [ 
				'serverError' => $this->error 
		] );
	}
	
	/**
	 *
	 * @param Request $request        	
	 * @param int $beaconId
	 *        	return redirect
	 */
	public function update(Request $request, $beaconId) {
		if (!Authorization::canAccess('beacons')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$validator = Validator::make ( $request->all (), [ 
				'name' => 'required',
				'court_id' => 'required',
				'UUID' => 'required',
				'major' => 'required',
				'minor' => 'required',
				'recordCheckin' => 'required' 
		] );
		
		if ($validator->fails ()) {
			$this->error = $validator->errors ();
			return \Redirect::back ()->withInput ()->withErrors ( $this->error );
		}
		try {
			$data = $request->all ();
			
			$response = $this->put ( sprintf ( $this->restService ['updateBeacon'], $beaconId ), $data )->response ();
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
		return \Redirect::to ( '/beacon' )->with ( [ 
				'success' => trans ( 'messages.beacon_update_success' ) 
		] );
	}
	
	/**
	 *
	 * @param int $courtId
	 *        	return redirect
	 */
	public function destroy($beaconId) {
		if (!Authorization::canAccess('beacons')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			
			$response = $this->delete ( sprintf ( $this->restService ['deleteBeacon'], $beaconId ) )->response ();
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
		return \Redirect::to ( '/beacon' )->with ( [ 
				'success' => trans ( 'messages.beacon_delete_success' ) 
		] );
	}
}
