<?php

namespace App\Http\Controllers;

use App\Custom\Authorization;
use App\Custom\Utility;
use App\Http\Libraries\Pagination;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TournamentController extends Controller {
	private $restService = [
								'listTournament' => 'admin/tournament',
								'editTournament' => 'admin/tournament/%s/show',
								'createTournament' => 'admin/tournament',
								'updateTournament' => 'admin/tournament/update',
								'deleteTournament' => 'admin/tournament/%s',
								'listCourt' => 'admin/court',
	];

	private $error;

	public function index(Request $request)
	{

		if (!Authorization::canAccess('tournaments')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$data = [];
		$page = ($request->has('page')) ? $request->get('page') : 1;
		try {
			$data = $this->get($this->restService['listTournament'], [
				'page' => $page
			])->response();
		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}

		if (!isset($this->error) && $data) {
			$paginator = (new Pagination())->total($data['total'])
				->per_page(10)
				->page_name('page')
				->ul_class('pagination');
			return \View::make('tournament.list', compact('data', 'paginator'));
		}
		return \View::make('tournament.list', [
			'serverError' => $this->error
		]);
	}

	public function create()
	{
		if (!Authorization::canAccess('tournaments')) {
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

		if (is_null ( $this->error ) && $courts)
			return view('tournament.create',["courts"=>$courts]);

		return \Redirect::back ()->with ( [
			'serverError' => $this->error
		] );

	}

	public function edit(Request $request, $tournamentId)
	{
		if (!Authorization::canAccess('tournaments')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$tournament = null;
		try {
			$tournament = $this->get ( sprintf ( $this->restService ['editTournament'], $tournamentId ) )->response ();

		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
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

		if (is_null ( $this->error ) && $tournament && $courts)
			return \View::make ( 'tournament.edit', ["courts"=>$courts, "tournament" => $tournament] );

		return \Redirect::back ()->with ( [
			'serverError' => $this->error
		] );
	}

	public function store(Request $request)
	{

		if (!Authorization::canAccess('tournaments')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$validator = Validator::make ( $request->all (), [
			'name' => 'required|min:5,max:40',
			'description' => 'required|string',
			'image' => 'sometimes|image|mimes:jpeg,bmp,png,svg|max:1024',
			'scheduling_details' => 'required',
			'tournament_events' => 'required',
			'tournamentStartDate' => 'required',
			'numberOfWeeks' => 'required|numeric|min:1',
			'winning_criteria' => 'required',
			'pointsPerWin' => 'required|numeric|min:1',
			'pointsPerLoss' => 'required|numeric|min:0',
			'registrationStartAt' => 'required',
			'registrationCloseAt' => 'required',

		] );

		$foundOneOrMoreErrors = false;
		$error = [];

		if ($validator->fails ()) {

			$error = json_decode(json_encode($validator->errors()),true);
			$foundOneOrMoreErrors = true;
		}

		//Validate scheduling details

		if($request->has('scheduling_details')){

			$schedulingDetails = json_decode($request->get('scheduling_details'));
			if(!is_array($schedulingDetails) || count($schedulingDetails) < 1) {

				$error["scheduling_details"][] = 'tournament_scheduling_details_missing';
				$foundOneOrMoreErrors = TRUE;
			}else{
				$daysReceived = [];
				foreach($schedulingDetails as $schedule){
					$schedule->errors = [];
					//Validate time
					if(!isset($schedule->reservationTimeStart) || trim($schedule->reservationTimeStart) == ""){
						$schedule->errors["reservationTimeStart"] = "tournament_schedule_time_missing";
						$foundOneOrMoreErrors = TRUE;
					}else{

						try{
							Carbon::parse($schedule->reservationTimeStart);
						}catch (\Exception $e){
							$schedule->errors["reservationTimeStart"] = "tournament_invalid_schedule_time";
							$foundOneOrMoreErrors = TRUE;
						}

					}

					//Validate court slots
					if(!isset($schedule->courtSlotsBooked) || (int)($schedule->courtSlotsBooked) < 1){
						$schedule->errors["courtSlotsBooked"] =  "tournament_schedule_slots_missing";
						$foundOneOrMoreErrors = TRUE;
					}else{
						$schedule->courtSlotsBooked = (int)($schedule->courtSlotsBooked);
					}

					//Validate courts

					if(!isset($schedule->courts) || !is_array($schedule->courts) || count($schedule->courts) < 1){
						$schedule->errors["courts"] =  "tournament_schedule_courts_missing";
						$foundOneOrMoreErrors = TRUE;
					}

					//Validate day

					if(!isset($schedule->selectedDay) || trim($schedule->selectedDay) == ""){

						$schedule->errors["selectedDay"] =  "tournament_schedule_day_missing";
						$foundOneOrMoreErrors = TRUE;
					}else{
						$schedule->selectedDay = trim($schedule->selectedDay);
						if(!in_array($schedule->selectedDay, Config::get('global.tournament.days'))){

							$schedule->errors["selectedDay"] = "tournament_schedule_invalid_day";
							$foundOneOrMoreErrors = TRUE;
						}
					}
					if(in_array($schedule->selectedDay,$daysReceived )){
						$schedule->errors["selectedDay"] =  "tournament_schedule_duplicate_day";
						$foundOneOrMoreErrors = TRUE;
					}
					$daysReceived[] = $schedule->selectedDay;


				}
			}

		}



		//Validate tournament events

		$tournamentEvents = json_decode($request->get('tournament_events'));
		if(!is_array($tournamentEvents) || count($tournamentEvents) < 1){
			$error["tournament_events"][] = 'tournament_events_missing';
			$foundOneOrMoreErrors = TRUE;
		}else{
			foreach($tournamentEvents as $tournamentEvent){
				$tournamentEvent->errors = [];
				//validate name
				if(!isset($tournamentEvent->name) || trim($tournamentEvent->name) == ""){
					$tournamentEvent->errors["name"] = "tournament_events_name_missing";
					$foundOneOrMoreErrors = TRUE;
				}else{
					$tournamentEvent->name = trim($tournamentEvent->name);
				}

				//validate max players
				if(!isset($tournamentEvent->maxNumberOfPlayers) || (int)$tournamentEvent->maxNumberOfPlayers < 2) {
					$tournamentEvent->errors["maxNumberOfPlayers"] = "tournament_events_max_players_missing";
					$foundOneOrMoreErrors = TRUE;
				}else{
					$tournamentEvent->maxNumberOfPlayers = (int)$tournamentEvent->maxNumberOfPlayers;
				}

				//validate event type
				if(!isset($tournamentEvent->event_type) || trim($tournamentEvent->event_type) == "") {
					$tournamentEvent->errors["event_type"] = "tournament_events_event_type_missing";
					$foundOneOrMoreErrors = TRUE;
				}else{
					$tournamentEvent->event_type = trim($tournamentEvent->event_type);
					if(!in_array($tournamentEvent->event_type,  Config::get('global.tournament.event_types'))){
						$tournamentEvent->errors["event_type"] = "tournament_events_event_type_invalid";
						$foundOneOrMoreErrors = TRUE;
					}
				}

				//validate elimination type
				if(!isset($tournamentEvent->elimination_type) || trim($tournamentEvent->elimination_type) == "") {
					$tournamentEvent->errors["elimination_type"] = "tournament_events_elimination_type_missing";
					$foundOneOrMoreErrors = TRUE;
				}else{
					$tournamentEvent->elimination_type = trim($tournamentEvent->elimination_type);
					if(!in_array($tournamentEvent->elimination_type,  Config::get('global.tournament.elimination_types'))){
						$tournamentEvent->errors["elimination_type"] = "tournament_events_elimination_type_invalid";
						$foundOneOrMoreErrors = TRUE;
					}
				}
			}
		}


		if(isset($schedulingDetails)){
			$request->merge(["scheduling_details" => json_encode($schedulingDetails)]);
		}
		if(isset($tournamentEvents)){
			$request->merge(["tournament_events" => json_encode($tournamentEvents)]);
		}

		if($foundOneOrMoreErrors){
			return \Redirect::back ()->withInput()->withErrors ( $error );
		}

		try {
			$data = $request->all();

			if($request->hasFile('image')){

				$tempFile = $request->file('image')->move($request->file('image')->getPath(), $request->file('image')->getFilename().".".$request->file('image')->getClientOriginalExtension());
				$data["image"] = fopen($tempFile,'r');
				\Illuminate\Support\Facades\File::delete($tempFile);

			}

			$response = $this->post ( $this->restService ['createTournament'], $data )->response ();

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

		return \Redirect::to ( '/tournament' )->with ( [
			'success' => $response
		] );

	}

	public function update(Request $request, $tournamentId)
	{
		if (!Authorization::canAccess('tournaments')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}


		$validator = Validator::make ( $request->all (), [
			'name' => 'required|min:5,max:40',
			'description' => 'required|string',
			'image' => 'sometimes|image|mimes:jpeg,bmp,png,svg|max:1024',
			'scheduling_details' => 'required',
			'tournament_events' => 'required',
			'tournamentStartDate' => 'required',
			'numberOfWeeks' => 'required|numeric|min:1',
			'winning_criteria' => 'required',
			'pointsPerWin' => 'required|numeric|min:1',
			'pointsPerLoss' => 'required|numeric|min:0',
			'registrationStartAt' => 'required',
			'registrationCloseAt' => 'required',

		] );

		$foundOneOrMoreErrors = false;
		$error = [];

		if ($validator->fails ()) {

			$error = json_decode(json_encode($validator->errors()),true);
			$foundOneOrMoreErrors = true;
		}

		//Validate scheduling details

		if($request->has('scheduling_details')){

			$schedulingDetails = json_decode($request->get('scheduling_details'));
			if(!is_array($schedulingDetails) || count($schedulingDetails) < 1) {

				$error["scheduling_details"][] = 'tournament_scheduling_details_missing';
				$foundOneOrMoreErrors = TRUE;
			}else{
				$daysReceived = [];
				foreach($schedulingDetails as $schedule){
					$schedule->errors = [];
					//Validate time
					if(!isset($schedule->reservationTimeStart) || trim($schedule->reservationTimeStart) == ""){
						$schedule->errors["reservationTimeStart"] = "tournament_schedule_time_missing";
						$foundOneOrMoreErrors = TRUE;
					}else{

						try{
							Carbon::parse($schedule->reservationTimeStart);
						}catch (\Exception $e){
							$schedule->errors["reservationTimeStart"] = "tournament_invalid_schedule_time";
							$foundOneOrMoreErrors = TRUE;
						}

					}

					//Validate court slots
					if(!isset($schedule->courtSlotsBooked) || (int)($schedule->courtSlotsBooked) < 1){
						$schedule->errors["courtSlotsBooked"] =  "tournament_schedule_slots_missing";
						$foundOneOrMoreErrors = TRUE;
					}else{
						$schedule->courtSlotsBooked = (int)($schedule->courtSlotsBooked);
					}

					//Validate courts

					if(!isset($schedule->courts) || !is_array($schedule->courts) || count($schedule->courts) < 1){
						$schedule->errors["courts"] =  "tournament_schedule_courts_missing";
						$foundOneOrMoreErrors = TRUE;
					}

					//Validate day

					if(!isset($schedule->selectedDay) || trim($schedule->selectedDay) == ""){

						$schedule->errors["selectedDay"] =  "tournament_schedule_day_missing";
						$foundOneOrMoreErrors = TRUE;
					}else{
						$schedule->selectedDay = trim($schedule->selectedDay);
						if(!in_array($schedule->selectedDay, Config::get('global.tournament.days'))){

							$schedule->errors["selectedDay"] = "tournament_schedule_invalid_day";
							$foundOneOrMoreErrors = TRUE;
						}
					}
					if(in_array($schedule->selectedDay,$daysReceived )){
						$schedule->errors["selectedDay"] =  "tournament_schedule_duplicate_day";
						$foundOneOrMoreErrors = TRUE;
					}
					$daysReceived[] = $schedule->selectedDay;


				}
			}

		}



		//Validate tournament events

		$tournamentEvents = json_decode($request->get('tournament_events'));
		if(!is_array($tournamentEvents) || count($tournamentEvents) < 1){
			$error["tournament_events"][] = 'tournament_events_missing';
			$foundOneOrMoreErrors = TRUE;
		}else{
			foreach($tournamentEvents as $tournamentEvent){
				$tournamentEvent->errors = [];
				//validate name
				if(!isset($tournamentEvent->name) || trim($tournamentEvent->name) == ""){
					$tournamentEvent->errors["name"] = "tournament_events_name_missing";
					$foundOneOrMoreErrors = TRUE;
				}else{
					$tournamentEvent->name = trim($tournamentEvent->name);
				}

				//validate max players
				if(!isset($tournamentEvent->maxNumberOfPlayers) || (int)$tournamentEvent->maxNumberOfPlayers < 2) {
					$tournamentEvent->errors["maxNumberOfPlayers"] = "tournament_events_max_players_missing";
					$foundOneOrMoreErrors = TRUE;
				}else{
					$tournamentEvent->maxNumberOfPlayers = (int)$tournamentEvent->maxNumberOfPlayers;
				}

				//validate event type
				if(!isset($tournamentEvent->event_type) || trim($tournamentEvent->event_type) == "") {
					$tournamentEvent->errors["event_type"] = "tournament_events_event_type_missing";
					$foundOneOrMoreErrors = TRUE;
				}else{
					$tournamentEvent->event_type = trim($tournamentEvent->event_type);
					if(!in_array($tournamentEvent->event_type,  Config::get('global.tournament.event_types'))){
						$tournamentEvent->errors["event_type"] = "tournament_events_event_type_invalid";
						$foundOneOrMoreErrors = TRUE;
					}
				}

				//validate elimination type
				if(!isset($tournamentEvent->elimination_type) || trim($tournamentEvent->elimination_type) == "") {
					$tournamentEvent->errors["elimination_type"] = "tournament_events_elimination_type_missing";
					$foundOneOrMoreErrors = TRUE;
				}else{
					$tournamentEvent->elimination_type = trim($tournamentEvent->elimination_type);
					if(!in_array($tournamentEvent->elimination_type,  Config::get('global.tournament.elimination_types'))){
						$tournamentEvent->errors["elimination_type"] = "tournament_events_elimination_type_invalid";
						$foundOneOrMoreErrors = TRUE;
					}
				}
			}
		}


		if(isset($schedulingDetails)){
			$request->merge(["scheduling_details" => json_encode($schedulingDetails)]);
		}
		if(isset($tournamentEvents)){
			$request->merge(["tournament_events" => json_encode($tournamentEvents)]);
		}

		if($foundOneOrMoreErrors){
			return \Redirect::back ()->withInput()->withErrors ( $error );
		}

		try {
			$data = $request->all();

			if($request->hasFile('image')){

				$tempFile = $request->file('image')->move($request->file('image')->getPath(), $request->file('image')->getFilename().".".$request->file('image')->getClientOriginalExtension());
				$data["image"] = fopen($tempFile,'r');
				\Illuminate\Support\Facades\File::delete($tempFile);

			}
			$data["tournament_id"] = $tournamentId;
			$response = $this->post ( $this->restService ['updateTournament'], $data )->response ();

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

		return \Redirect::to ( '/tournament' )->with ( [
			'success' => $response
		] );

	}

	public function destroy($tournamentId)
	{
		if (!Authorization::canAccess('tournaments')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}


		try {
			$response = $this->delete(sprintf($this->restService['deleteTournament'], $tournamentId))->response();
		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {

			$this->error = \trans('messages.general_error');
		}

		if (isset($this->error) && $this->error != '') {
			return \Redirect::back()->withInput()->with([
				'serverError' => $this->error
			]);
		}
		return \Redirect::route('tournament.list')->with([
			'success' => $response
		]);
	}
	
	public function show(){
		return view('tournament.show');	
	}
	
	
	
}
