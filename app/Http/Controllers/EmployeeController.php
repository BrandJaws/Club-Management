<?php

namespace App\Http\Controllers;

use App\Custom\Authorization;
use App\Http\Libraries\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller {
	private $restService = [
								'court' => 'admin/court/stats',
								'reservations' => 'admin/court/reservations',
								'list' => 'admin/employee',
								'edit' => 'admin/employee/%s',
								'create' => 'admin/employee',
								'update' => 'admin/employee/%s',
								'delete' => 'admin/employee/%s',
								'feeds' => 'admin/club/feeds',
								'privateLessons' => 'admin/private-lessons',
								'saleInvoiceStats' => 'admin/sale-invoices/dashboard-sales-stats',
								'employeeChat' => 'admin/employee-chat',
	];
    public function login() {
        return \View::make('employee.login');
    }

    public function dashboard() {


    	$stats =$data = [];
		$privateLessons = [];
		$saleInvoiceStats = [];
		$messagesFromPos = [];
		$feeds = [];
    	try {
			//get courts with reservations
			$data = $this->get ( $this->restService ['reservations'] )->response ();
    		$stats = $this->get ( $this->restService ['court'] )->response ();
			$feeds = $this->get ( $this->restService ['feeds'] )->response ();
			$privateLessons = $this->get ( $this->restService ['privateLessons'] )->response ();
			$saleInvoiceStats = $this->get ( $this->restService ['saleInvoiceStats'] )->response ();
			$messagesFromPos = $this->get ( $this->restService ['employeeChat'] )->response ();
			if(isset($privateLessons["data"])){
				$privateLessons = $privateLessons["data"];
			}

    	} catch ( \App\Exceptions\ServerCrashException $exp ) {
    		$this->error = $exp->getMessage ();

    	} catch ( \App\Exceptions\InValidResponse $exp ) {
    		$this->error = $exp->getMessage ();
    	} catch ( \Exception $exp ) {
    	
    		$this->error = \trans ( 'messages.general_error' );
    	}
		
    	return \View::make('employee.dashboard',['stats'=>$stats,
												 'data'=>$data,
												 'feeds'=>$feeds,
												 'privateLessons' => $privateLessons,
												 'saleInvoiceStats' => $saleInvoiceStats,
												 'messagesFromPos' => $messagesFromPos,
		]);
    }

	public function index(Request $request)
	{

		if (!Authorization::canAccess('employees')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$data = [];
		$page = ($request->has('page')) ? $request->get('page') : 1;
		try {
			$data = $this->get($this->restService['list'], [
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
			return \View::make('employee.list', compact('data', 'paginator'));
		}
		return \View::make('employee.list', [
			'serverError' => $this->error
		]);
	}

	public function create()
	{
		if (!Authorization::canAccess('employees')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}


		return view('employee.create');
	}

	public function edit(Request $request, $employeeId)
	{
		if (!Authorization::canAccess('employees')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}


		$employee = [];
		try {
			$employee = $this->get(sprintf($this->restService['edit'], $employeeId))->response();
			$employee["permissions"] = json_decode($employee["permissions"],true);
		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}
		if (!isset($this->error) && $employee) {
			return \View::make('employee.edit', compact('employee','employeeId'));
		} else {
			return \Redirect::back()->with([
				'serverError' => $this->error
			]);
		}
	}

	public function store(Request $request)
	{
		if (!Authorization::canAccess('employees')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}


		$validator = Validator::make($request->all(), [
			'firstName' => 'required|min:1,max:40',
			'lastName' => 'required|min:1,max:40',
			'email' => 'required|email',
			'phone' => 'numeric',
			'profilePic' => 'sometimes|image|max:1024',
			'password' => 'required'
		]);
		if ($validator->fails()) {
			$this->error = $validator->errors();
			return \Redirect::back()->withInput()->withErrors($this->error);
		}

		try {
			$data = $request->all();
			if ($request->hasFile('profilePic')) {
				$tempFile = $request->file('profilePic')->move($request->file('profilePic')
					->getPath(), str_replace(' ', '_', $request->file('profilePic')
						->getFilename()) . '_' . time() . '_' . "." . $request->file('profilePic')
						->getClientOriginalExtension());
				$data['profilePic'] = fopen($tempFile, 'r');
			}
			$response = $this->post($this->restService['create'], $data)->response();
			if ($request->hasFile('profilePic'))
				\Illuminate\Support\Facades\File::delete($tempFile);
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
		return \Redirect::route('employee.list')->with([
			'success' => $response
		]);
	}

	public function update(Request $request, $employeeId)
	{
		if (!Authorization::canAccess('employees')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}


		$validator = Validator::make($request->all(), [
			'firstName' => 'required|min:1,max:40',
			'lastName' => 'required|min:1,max:40',
			'email' => 'required|email',
			'phone' => 'numeric',
			'profilePic' => 'sometimes|image|max:1024'
		]);

		if ($validator->fails()) {
			$this->error = $validator->errors();
			return \Redirect::back()->withInput()->withErrors($this->error);
		}
		try {
			$data = $request->all();
			if ($request->hasFile('profilePic')) {
				$tempFile = $request->file('profilePic')->move($request->file('profilePic')
					->getPath(), str_replace(' ', '_', $request->file('profilePic')
						->getFilename()) . '_' . time() . '_' . "." . $request->file('profilePic')
						->getClientOriginalExtension());
				$data['profilePic'] = fopen($tempFile, 'r');
			}
			$response = $this->post(sprintf($this->restService['update'], $employeeId), $data)->response();
			if ($request->hasFile('profilePic'))
				\Illuminate\Support\Facades\File::delete($tempFile);
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

		return \Redirect::route('employee.list')->with([
			'success' => $response
		]);
	}

	public function destroy($employeeId)
	{
		if (!Authorization::canAccess('employees')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}


		try {
			$response = $this->delete(sprintf($this->restService['delete'], $employeeId))->response();
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
		return \Redirect::route('employees.list')->with([
			'success' => $response
		]);
	}
	
}
