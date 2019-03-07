<?php

namespace App\Http\Controllers;

use App\Custom\Authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use \Session;
use Carbon\Carbon;

class CourtController extends Controller {
	private $restService = [ 
			'listCourt' => 'admin/court',
			'editCourt' => 'admin/court/%s/details',
			'createCourt' => 'admin/court',
			'updateCourt' => 'admin/court/%s' 
	];
	public $error;
	
	/**
	 * List courts associated with Logedin Club
	 *
	 * @return type
	 */
	public function index() {

		if (!Authorization::canAccess('courts')) {
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
			return \View::make ( 'court.list', compact ( 'data' ) );
		return \Redirect::to ( 'dashboard' )->withErrors ( [ 
				'serverError' => $this->error 
		] );
	}
	
	/**
	 * Create a new court for loged in club
	 *
	 * @return type
	 */
	public function create() {
		return \View::make ( 'court.create', compact ( 'data' ) );
	}
	
	/**
	 * Store a court for loged in club
	 *
	 * @param Illuminate\Http\Request $request        	
	 */
	public function store(Request $request) {
		if (!Authorization::canAccess('courts')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$validator = Validator::make ( $request->all (), [ 
				'name' => 'required|min:5,max:40',
				'openTime' => 'required|date_format:H:i A',
				'closeTime' => 'required|date_format:H:i A',
				'environment' => 'required|in:' . implode ( ',', \Config::get ( 'global.court.environment' ) ),
				'ballMachineAvailable' => 'required|in:' . implode ( ',', array_flip(\Config::get ( 'global.court.ballmachinestatus' ) )),
				'status' => 'required' 
		] );
		
		if ($validator->fails ()) {
			$this->error = $validator->errors ();
			return \Redirect::back ()->withInput()->withErrors ( $this->error );
		}
		
		try {
			$openTime = Carbon::createFromFormat ( 'H:i A', $request->get ( 'openTime' ) );
			$closeTime = Carbon::createFromFormat ( 'H:i A', $request->get ( 'closeTime' ) );
			$data = $request->all ();
			$data ['openTime'] = $openTime->format ( 'H:i' );
			$data ['closeTime'] = $closeTime->format ( 'H:i' );
			$response = $this->post ( $this->restService ['createCourt'], $data )->response ();
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
		return \Redirect::to ( '/court' )->with ( [ 
				'success' => trans ( 'messages.court_success' ) 
		] );
	}
	
	/**
	 * show club details
	 *
	 * @param int $courtId        	
	 * @return html
	 */
	public function edit($courtId) {
		if (!Authorization::canAccess('courts')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			$data = $this->get ( sprintf ( $this->restService ['editCourt'], $courtId ) )->response ();
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
		}
		if (is_null ( $this->error ) && $data)
			return \View::make ( 'court.edit', compact ( 'data' ) );
		return \Redirect::back ()->with ( [ 
				'serverError' => $this->error 
		] );
	}
	
	/**
	 *
	 * @param Request $request        	
	 * @param int $courtId
	 *        	return redirect
	 */
	public function update(Request $request, $courtId) {
		if (!Authorization::canAccess('courts')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}
		
		$validator = Validator::make ( $request->all (), [ 
				'name' => 'required|min:5,max:40',
				'openTime' => 'required|date_format:H:i A',
				'closeTime' => 'required|date_format:H:i A',
				'environment' => 'required|in:' . implode ( ',', \Config::get ( 'global.court.environment' ) ),
				'ballMachineAvailable' => 'required|in:' . implode ( ',', array_flip(\Config::get ( 'global.court.ballmachinestatus' ) ) ),
				'status' => 'required' 
		] );
		
		if ($validator->fails ()) {
			$this->error = $validator->errors ();
			return \Redirect::back ()->withInput()->withErrors ( $this->error );
		}
		try {
			$openTime = Carbon::createFromFormat ( 'H:i A', $request->get ( 'openTime' ) );
			$closeTime = Carbon::createFromFormat ( 'H:i A', $request->get ( 'closeTime' ) );
			$data = $request->all ();
			$data ['openTime'] = $openTime->format ( 'H:i' );
			$data ['closeTime'] = $closeTime->format ( 'H:i' );
			$response = $this->put ( sprintf ( $this->restService ['updateCourt'], $courtId ), $data )->response ();
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
		return \Redirect::to ( '/court' )->with ( [ 
				'success' => trans ( 'messages.court_update_success' ) 
		] );
	}
	
	/**
	 *
	 * @param int $courtId
	 *        	return redirect
	 */
	public function destroy($courtId) {
	}
}
