<?php
namespace App\Http\Controllers;
use App\Custom\Authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
class CommunicationController extends Controller {
        private $error;
        private $restService = [ 
			'makeAnnouncement' => 'admin/club/announcement' 
	];
        
	public function index() {
		if (!Authorization::canAccess('communication')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		return \View::make('communication.communication');
	}
        public function mobileAnnouncement(Request $request) {
               
		$validator = Validator::make ( $request->all (), [ 
				
				'msgBody' => 'required'
		] );
		
		if ($validator->fails ()) {
			$this->error = $validator->errors ();
			return \Redirect::back ()->withInput ()->withErrors ( $this->error );
		}
                
                try {
			$response = $this->post ( $this->restService ['makeAnnouncement'], $request->all () )->response ();
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
		}
		
		if ($this->error != '') {
                    return $this->error;
                }else{
                    return $response;
                }
                
                
	}

}