<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller {

    private $error;

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required'
        ]);
        if ($validator->fails()) {
            $this->error = $validator->errors();
            return \Redirect::back()->withErrors($this->error);
        }
        try {
            $response = $this->post('login', $request->all())->response();
        } catch (\App\Exceptions\ServerCrashException $exp) {
            $this->error = $exp->getMessage();
        } catch (\App\Exceptions\InValidResponse $exp) {
            $this->error = $exp->getMessage();
        } catch (\Exception $exp) {

            $this->error = \trans('messages.general_error');
        }
		
        if ($this->error != '') {
            return \Redirect::back()->withInput()->with(['serverError' => $this->error]);
        } else {
           
            return $this->AuthorizeEmployee($response);
        }
    }

    public function logout() {
        return $this->logoutEmployee();
    }

}
