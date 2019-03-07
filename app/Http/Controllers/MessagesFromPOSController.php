<?php

namespace App\Http\Controllers;

use App\Custom\Authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MessagesFromPOSController extends Controller {
	private $restService = [
								'delete-one' => 'admin/message-from-pos/delete-one',
								'delete-all' => 'admin/message-from-pos/delete-all',
								'messagesFromPos' => 'admin/message-from-pos',

	];
	private $error;
    public function deleteOne(Request $request) {
		if (!Authorization::canAccess('restaurant')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {
			$data = $request->all();
			$response = $this->post ( $this->restService ['delete-one'], $data )->response ();

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

	public function deleteAll() {
		if (!Authorization::canAccess('restaurant')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		try {

			$response = $this->get ( $this->restService ['delete-all'] )->response ();

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

	public function getMessageFromPOSPaginated(Request $request) {

		$data = [];
		try {
			$data = $this->get($this->restService['messagesFromPos'], $request->all())->response();

		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}

		return $data;

	}

	
}
