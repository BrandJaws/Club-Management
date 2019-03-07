<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Exception\NotFoundException;

class MiscellaneousReceiptsController extends Controller {

	private $restService = [
		'list' => 'admin/misc-receipts',
	];
	private $error;


	public function miscellaneousReceiptsList(Request $request){

		$data = [];
		//$page = ($request->has('page')) ? $request->get('page') : 1;
		//$search = ($request->has('search')) ? trim($request->get('search')) : "";
		try {
			$data = $this->get($this->restService['list'], $request->all())->response();

		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}

		if ($this->error != '') {

			return \Redirect::back ()->withInput ()->with ( [
				'serverError' => $this->error
			] );
		}

		if($request->ajax()){
			return $data;
		}else{

			if ($this->error != '') {

				return \Redirect::back ()->withInput ()->with ( [
					'serverError' => $this->error
				] );
			}

			return view ( 'miscellaneous-receipts.list', ["miscellaneousReceiptsWithFilters"=>json_encode($data)]);
		}


	}


}
