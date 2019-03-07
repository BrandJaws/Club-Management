<?php

namespace App\Http\Controllers;

use App\Custom\Authorization;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use \Session;
use Carbon\Carbon;
use App\Http\Libraries\Pagination;

class LeagueController extends Controller {
	private $restService = [ 
			'listLeague' => 'admin/league',
			'editLeague' => 'admin/league/%s/show',
			'createLeague' => 'admin/league',
			'updateLeague' => 'admin/league/update',
			'deleteLeague' => 'admin/league/%s',
			'listCourt' => 'admin/court',
			'courtsWithTimeSlots' => 'admin/court/courts-with-timeslots',
			'leagueDetails' => 'admin/league/%s/details',
			'createScoreCard' => 'admin/league/create-scorecard',
			'reserveMatchForUnstructuredLeague' => 'admin/league/reserve-match',
			'updateLadderLeagueRanks' => 'admin/league/update-ladder-ranks',
			'updatePyramidLeagueRanks' => 'admin/league/update-pyramid-ranks',
			'deleteRegisteredLeaguePlayer' => 'admin/league/delete-league-player',
			'addLeaguePlayers' => 'admin/league/add-league-players',
			'createLeagueChallenges' => 'admin/league/generate-matches'

	];
	public $error;
	
	/**
	 * List Leagues associated with Logedin Club
	 *
	 * @return type
	 */
	public function index(Request $request) {
		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}
		
		$data = [ ];
		$page = ($request->has('page'))?$request->get('page'):1;
		try {
			$data = $this->get ( $this->restService ['listLeague'], ['page'=>$page] )->response ();
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
		}

		if (is_null ( $this->error ) && $data) {
			$paginator = (new Pagination())->total ($data['total'])->per_page ( 10 )->page_name ( 'page' )->ul_class('pagination');
			return \View::make ( 'league.list', compact ( 'data','paginator' ) );
		}
		return \View::make ( 'league.list', [
			'serverError' => $this->error
		] );
	}
	
	/**
	 * Create a new League for loged in club
	 *
	 * @return type
	 */
	public function create() {
		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$courts = [];
		try {
			$courts = $this->get($this->restService['listCourt'])->response();
		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}
		$data = ["courts"=>$courts];
		return \View::make ( 'league.create', compact ( 'data' ) );
	}
	
	/**
	 * Store a League for loged in club
	 *
	 * @param Illuminate\Http\Request $request
	 */
	public function store(Request $request) {
		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$validationRules = [
			'name' => 'required|min:5,max:40',
			'description' => 'required|string',
			'image' => 'sometimes|image|mimes:jpeg,bmp,png,svg|max:1024',
			'league_type' => 'required|min:5,max:40',
			'structure_type' => 'required|min:5,max:40',
			'weeksToPenalty' => 'sometimes|numeric|min:0',
			'registrationStartAt' => 'required',
			'registrationCloseAt' => 'required',
			'leagueStartDate' => 'required',
			'numberOfWeeks' => 'required|numeric|min:1',
			'abilityLevel' => 'required',
			'minNumberOfPlayers' => 'required|numeric|min:1',
			'maxNumberOfPlayers' => 'required|numeric|min:1',


		];

		if($request->has('structure_type') && $request->get('structure_type') == 'UNSTRUCTURED'){
			$validationRulesUnStructured = [
				'unstructuredLeagueVariant'=>'required',
			];
			if($request->has('unstructuredLeagueVariant') && $request->get('unstructuredLeagueVariant') == 'POINT BASED'){
				$validationRulesUnStructured["pointsPerWin"] ='required|numeric|min:1';
				$validationRulesUnStructured["pointsPerLoss"] ='required|numeric|min:0';
				$validationRulesUnStructured["winning_criteria"] ='required';
			}
			$validationRules = array_merge($validationRules, $validationRulesUnStructured);
		}

		if($request->has('structure_type') && $request->get('structure_type') == 'STRUCTURED'){
			$validationRulesStructured = [
				'days'=>'required|array',
				'reservationTimeStart' => 'required',
				'numberOfSlots'=>'required',
				'court'=>'required|array',
				'pointsPerWin' => 'required|numeric|min:1',
				'pointsPerLoss' => 'required|numeric|min:0',
				'winning_criteria' => 'required',
			];
			$validationRules = array_merge($validationRules, $validationRulesStructured);
		}


		$validator = Validator::make ( $request->all (),  $validationRules);



		if ($validator->fails ()) {
			
			$this->error = $validator->errors ();
			return \Redirect::back ()->withInput()->withErrors ( $this->error );
		}


		try {
			$data = $request->all();
			if($request->hasFile('image')){

				$tempFile = $request->file('image')->move($request->file('image')->getPath(), $request->file('image')->getFilename().".".$request->file('image')->getClientOriginalExtension());
				$data["image"] = fopen($tempFile,'r');
				\Illuminate\Support\Facades\File::delete($tempFile);

			}

			$response = $this->post ( $this->restService ['createLeague'], $data )->response ();

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
		return \Redirect::to ( '/league' )->with ( [
				'success' => trans ( 'messages.league_success' )
		] );
	}
	
	/**
	 * show club details
	 *
	 * @param int $leagueId
	 * @return html
	 */
	public function edit($leagueId) {
		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$courts = [];
		try {
			$courts = $this->get($this->restService['listCourt'])->response();
		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}
		$data = ["courts"=>$courts];

		try {
			$data["league"] = $this->get ( sprintf ( $this->restService ['editLeague'], $leagueId ) )->response ();

		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
		}
		
		if (is_null ( $this->error ) && $data)
			return \View::make ( 'league.edit', compact ( 'data' ) );
		return \Redirect::back ()->with ( [ 
				'serverError' => $this->error 
		] );
	}
	
	/**
	 *
	 * @param Request $request        	
	 * @param int $leagueId
	 *        	return redirect
	 */
	public function update(Request $request, $leagueId) {
		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}
		
		$validationRules = [
			'name' => 'required|min:5,max:40',
			'description' => 'required|string',
			'image' => 'sometimes|image|mimes:jpeg,bmp,png,svg|max:1024',
			'league_type' => 'required|min:5,max:40',
			'structure_type' => 'required|min:5,max:40',
			'weeksToPenalty' => 'sometimes|numeric|min:0',
			'registrationStartAt' => 'required',
			'registrationCloseAt' => 'required',
			'leagueStartDate' => 'required',
			'numberOfWeeks' => 'required|numeric|min:1',
			'abilityLevel' => 'required',
			'minNumberOfPlayers' => 'required|numeric|min:1',
			'maxNumberOfPlayers' => 'required|numeric|min:1',


		];

		if($request->has('structure_type') && $request->get('structure_type') == 'UNSTRUCTURED'){
			$validationRulesUnStructured = [
				'unstructuredLeagueVariant'=>'required',
			];
			if($request->has('unstructuredLeagueVariant') && $request->get('unstructuredLeagueVariant') == 'POINT BASED'){
				$validationRulesUnStructured["pointsPerWin"] ='required|numeric|min:1';
				$validationRulesUnStructured["pointsPerLoss"] ='required|numeric|min:0';
				$validationRulesUnStructured["winning_criteria"] ='required';
			}
			$validationRules = array_merge($validationRules, $validationRulesUnStructured);
		}

		if($request->has('structure_type') && $request->get('structure_type') == 'STRUCTURED'){
			$validationRulesStructured = [
				'days'=>'required|array',
				'reservationTimeStart' => 'required',
				'numberOfSlots'=>'required',
				'court'=>'required|array',
				'pointsPerWin' => 'required|numeric|min:1',
				'pointsPerLoss' => 'required|numeric|min:0',
				'winning_criteria' => 'required',
			];
			$validationRules = array_merge($validationRules, $validationRulesStructured);
		}

		$validator = Validator::make ( $request->all (),  $validationRules);

		if ($validator->fails ()) {

			$this->error = $validator->errors ();
			return \Redirect::back ()->withInput()->withErrors ( $this->error );
		}
		try {

			$data = $request->all ();

			if($request->hasFile('image')){

				$tempFile = $request->file('image')->move($request->file('image')->getPath(), $request->file('image')->getFilename().".".$request->file('image')->getClientOriginalExtension());
				$data["image"] = fopen($tempFile,'r');
				\Illuminate\Support\Facades\File::delete($tempFile);

			}
			$data['league_id'] = $leagueId;
			$response = $this->post ( $this->restService ['updateLeague'], $data )->response ();

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
		return \Redirect::to ( '/league' )->with ( [
				'success' => trans ( 'messages.league_update_success' )
		] );
	}
	
	/**
	 *
	 * @param int $leagueId
	 *        	return redirect
	 */
	public function destroy($leagueId) {
		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			$response = $this->delete ( sprintf ( $this->restService ['deleteLeague'], $leagueId ) )->response ();
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
		return \Redirect::to ( 'league' )->with ( [
			'success' => \trans ( 'messages.league_delete_success' )
		] );


	}

	/**
	 * Update a ranks for ladder league variant
	 *
	 * @param Illuminate\Http\Request $request
	 */
	public function updateLadderLeagueRanks(Request $request) {

		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			$data = $request->all();
			$response = $this->post ( $this->restService ['updateLadderLeagueRanks'], $data )->response ();

		} catch ( \App\Exceptions\ServerCrashException $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {

			$this->error = \trans ( 'messages.general_error' );
		}

		if($this->error != ''){
			return response()->json($this->error, 412);

		}else{
			return response()->json($response);
		}

	}

	/**
	 * Update a ranks for pyramid league variant
	 *
	 * @param Illuminate\Http\Request $request
	 */
	public function updatePyramidLeagueRanks(Request $request) {

		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			$data = $request->all();
			$response = $this->post ( $this->restService ['updatePyramidLeagueRanks'], $data )->response ();

		} catch ( \App\Exceptions\ServerCrashException $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {

			$this->error = \trans ( 'messages.general_error' );
		}

		if($this->error != ''){
			return response()->json($this->error, 412);

		}else{
			return response()->json($response);
		}

	}

	/**
     * show method for displaying lead information - NEW PAGE
     */
	public function show($league_id) {
		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}


		try {
			$data["league"] = $this->get ( sprintf ( $this->restService ['leagueDetails'], $league_id ) )->response ();
			$data["courts"] = $this->get($this->restService['courtsWithTimeSlots'])->response();
		} catch ( \App\Exceptions\ServerCrashException $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {


			$this->error = \trans ( 'messages.general_error' );
		}
		if (is_null ( $this->error ) && $data) {
			return \View::make ( 'league.show' , compact('data'));
		}

		return \View::make ( 'league.list', [

			'serverError' => $this->error
		] );

    }

    public function leaderboard() {
        return \View::make ( 'league.leaderboard' );
    }



	/**
	 * Create a challenge reservation
	 *
	 * @param Illuminate\Http\Request $request
	 */
	public function reserveMatchForUnstructuredLeague(Request $request) {

		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			$data = $request->all();
			$response = $this->post ( $this->restService ['reserveMatchForUnstructuredLeague'], $data )->response ();

		} catch ( \App\Exceptions\ServerCrashException $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {

			$this->error = \trans ( 'messages.general_error' );
		}

		if($this->error != ''){
			return response()->json($this->error, 412);

		}else{
			return response()->json($response);
		}

	}


	/**
	 * Create or update a scorecard against a challenge
	 *
	 * @param Illuminate\Http\Request $request
	 */
	public function createScoreCard(Request $request) {

		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}


		try {
			$data = $request->all();
			$response = $this->post ( $this->restService ['createScoreCard'], $data )->response ();

		} catch ( \App\Exceptions\ServerCrashException $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {

			$this->error = \trans ( 'messages.general_error' );
		}

		if($this->error != ''){
			return response()->json($this->error, 412);

		}else{
			return response()->json($response);
		}

	}

	/**
	 * Delete league player with team mate if any
	 *
	 * @param Illuminate\Http\Request $request
	 */
	public function deleteRegisteredLeaguePlayer(Request $request) {

		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			$data = $request->all();
			$response = $this->post ( $this->restService ['deleteRegisteredLeaguePlayer'], $data )->response ();

		} catch ( \App\Exceptions\ServerCrashException $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {

			$this->error = \trans ( 'messages.general_error' );
		}

		if($this->error != ''){
			return response()->json($this->error, 412);

		}else{
			return response()->json($response);
		}

	}

	/**
	 * Delete league player with team mate if any
	 *
	 * @param Illuminate\Http\Request $request
	 */
	public function addLeaguePlayers(Request $request) {

		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			$data = $request->all();
			$response = $this->post ( $this->restService ['addLeaguePlayers'], $data )->response ();

		} catch ( \App\Exceptions\ServerCrashException $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {

			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {

			$this->error = \trans ( 'messages.general_error' );
		}

		if($this->error != ''){
			return response()->json($this->error, 412);

		}else{
			return response()->json($response);
		}

	}
	
	public function createLeagueChallenges($leagueId) {
		if (!Authorization::canAccess('leagues')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}
		$data["league_id"] = $leagueId;
		try {
			$response = $this->post ( $this->restService ['createLeagueChallenges'], $data )->response ();
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
		
		return \Redirect::back()->with ( [
			'success' => $response
		] );
	}


}
