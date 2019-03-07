<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ReportsController extends Controller {

	private $restService = [
		'createOrdersArchiveCSV' => 'admin/reports/orders-archive-csv',
	];
	private $error;


	public function createOrdersArchiveCSV(Request $request){

		$data = [];

		try {
			$data = $this->post($this->restService['createOrdersArchiveCSV'], $request->all())->response();

		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}
		

		if($this->error != ''){
			
			return response()->json($this->error, 412);

		}else{
			return response()->json($data);
		}


	}


}
