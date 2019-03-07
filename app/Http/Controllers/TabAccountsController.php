<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class TabAccountsController extends Controller {

	private $restService = [
		'list' => 'admin/tab-accounts',
		'deposits' => 'admin/tab-accounts/deposits',
		'update' => 'admin/tab-accounts',
		'showDetails' =>'admin/tab-accounts/%s/details'
	];
	private $error;


	public function tabAccountsList(Request $request){

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

			return view ( 'tab-accounts.list', ["tabAccountsWithFilters"=>json_encode($data)]);
		}


	}

	public function tabAccountDepositsList(Request $request){

		$data = [];
		//$page = ($request->has('page')) ? $request->get('page') : 1;
		//$search = ($request->has('search')) ? trim($request->get('search')) : "";
		try {
			$data = $this->get($this->restService['deposits'], $request->all())->response();

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

			return view ( 'tab-accounts.deposits', ["tabAccountDepositsWithFilters"=>json_encode($data)]);
		}


	}

	public function updateTabAccount(Request $request){


		try {
			$data = $request->all();
			$response = $this->put($this->restService['update'], $request->all())->response();


		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}

		

		if ($this->error != '') {
			return response()->json($this->error, 412);
		} else {
			return $response;
		}


	}

	public function showDetails($tab_account_id){

		$data = null;
		//$page = ($request->has('page')) ? $request->get('page') : 1;
		//$search = ($request->has('search')) ? trim($request->get('search')) : "";
		try {
			$data = $this->get(sprintf($this->restService['showDetails'],$tab_account_id))->response();
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
		
		return view ( 'tab-accounts.show_details', ["tabAccount"=>$data]);



	}



}
