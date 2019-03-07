<?php

namespace App\Http\Controllers;

use App\Custom\Authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class NPSController extends Controller {
	private $restService = [
								'store-nps' => 'admin/nps/',

	];
	private $error;
    public function store(Request $request) {
		if (!Authorization::canAccess('trainings')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			$data = $request->all();
			$response = $this->post ( $this->restService ['store-nps'], $data )->response ();

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

	
}
