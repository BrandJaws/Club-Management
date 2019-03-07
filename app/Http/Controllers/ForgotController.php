<?php
namespace App\Http\Controllers;

class ForgotController extends Controller {

	public function forgot() {
		return \View::make('mobile.forgot');
	}

	/*public function dashboard() {
		return \View::make('employee.dashboard');
	} */

}