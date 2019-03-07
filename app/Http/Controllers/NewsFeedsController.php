<?php

namespace App\Http\Controllers;

use App\Custom\Authorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Http\Libraries\Pagination;

class NewsFeedsController extends Controller {
	private $restService = [ 
			'listNewsFeeds' => 'admin/newsfeeds',
			'createNewsFeed' => 'admin/newsfeeds',
                        'showNewsFeed' => 'admin/newsfeeds/%s',
                        'deleteNewsFeed' => 'admin/newsfeeds/%s',
                        'updateNewsFeed' => 'admin/newsfeeds/update',
			
	];
        
	public $error;
        
	public function index(Request $request) {
		if (!Authorization::canAccess('news')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$data = [ ];
		$page = ($request->has('page'))?$request->get('page'):1;
		try {
			$data = $this->get ( $this->restService ['listNewsFeeds'], ['page'=>$page] )->response ();
                        
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
                      
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
                       
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
                       
		}
		
		if (is_null ( $this->error ) && $data) {
    		$paginator = (new Pagination())->total ($data['total'])->per_page ( 10 )->page_name ( 'page' )->ul_class('pagination');
                    return \View::make ( 'newsfeeds.list', compact ( 'data','paginator' ) );
		}
		return \View::make ( 'newsfeeds.list', [ 
				'serverError' => $this->error 
		] );
	}
        
	public function create() {
		if (!Authorization::canAccess('news')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		return \View::make ( 'newsfeeds.create' );
	}
	public function store(Request $request) {
		if (!Authorization::canAccess('news')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$validator = Validator::make ( $request->all (), [ 
				'title' => 'required|string',
				'description' => 'required|string',
				'image' => 'sometimes|image|mimes:jpeg,bmp,png,svg|max:1024',
		] );
                
		if ($validator->fails ()) {
			$this->error = $validator->errors ();
			return \Redirect::back ()->withInput ()->withErrors ( $this->error );
		}
                
		try {
                        if($request->hasFile('image')){
                           
                           $tempFile = $request->file('image')->move($request->file('image')->getPath(), $request->file('image')->getFilename().".".$request->file('image')->getClientOriginalExtension());
                           $response = $this->post ( $this->restService ['createNewsFeed'], ["title"=>$request->get('title'),"description"=>$request->get('description'),"image"=>fopen($tempFile,'r')] )->response ();
                           \Illuminate\Support\Facades\File::delete($tempFile);
                          
                        }else{
                            $response = $this->post ( $this->restService ['createNewsFeed'], $request->all())->response ();
                        }
			
                        
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
		return \Redirect::back ()->with ( [ 
				'success' => $response
		] );
	}
        public function show($newsfeed_id){
			if (!Authorization::canAccess('news')) {
				return Redirect::route('dashboard')->with([
					'error' => \trans('message.unauthorized_access')
				]);
			}

                $data = null;
		
		try {
			$data = $this->get (sprintf($this->restService ['showNewsFeed'],$newsfeed_id ))->response ();
                        
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
                      
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
                       
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
                       
		}
		
		if ($this->error != '') {
			return \Redirect::back ()->with ( [ 
					'serverError' => $this->error 
			] );
		}
		return \View::make ( 'newsfeeds.show', [ 
				'data' => $data 
		] );
            
        }
	public function edit($newsfeed_id) {
		if (!Authorization::canAccess('news')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$data = null;
		
		try {
			$data = $this->get (sprintf($this->restService ['showNewsFeed'],$newsfeed_id ))->response ();
                       
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
                     
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
                        
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
                        
		}
		
		if ($this->error != '') {
			return \Redirect::back ()->with ( [ 
					'serverError' => $this->error 
			] );
		}
		return \View::make ( 'newsfeeds.edit', [ 
				'data' => $data 
		] );
	}
	
	/**
	 *
	 * @param Request $request        	
	 * @param int $memberId
	 *        	return redirect
	 */
	public function update(Request $request) {
		if (!Authorization::canAccess('news')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}

		$validator = Validator::make ( $request->all (), [
                                'newsfeed_id' => 'required|integer',
				'title' => 'required|string',
				'description' => 'required|string',
				'image' => 'sometimes|image|mimes:jpeg,bmp,png,svg|max:1024',
		] );
                
		if ($validator->fails ()) {
			$this->error = $validator->errors ();
			return \Redirect::back ()->withInput ()->withErrors ( $this->error );
		}
                
		try {
                        if($request->hasFile('image')){
                           
                           $tempFile = $request->file('image')->move($request->file('image')->getPath(), $request->file('image')->getFilename().".".$request->file('image')->getClientOriginalExtension());
                           $response = $this->post ( $this->restService ['updateNewsFeed'], ["newsfeed_id"=>$request->get('newsfeed_id'),"title"=>$request->get('title'),"description"=>$request->get('description'),"image"=>fopen($tempFile,'r')] )->response ();
                           \Illuminate\Support\Facades\File::delete($tempFile);
                          
                        }else{
                            $response = $this->post ( $this->restService ['updateNewsFeed'], $request->all())->response ();
                        }
			
                       // dd($response);
                } catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
                     //dd($exp);
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
                     // dd($exp);
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
                      // dd($exp);
		}
		
		if ($this->error != '') {
			return \Redirect::back ()->withInput ()->with ( [ 
					'serverError' => $this->error 
			] );
		}
		return \Redirect::back ()->with ( [ 
				'success' => $response
		] );
	}
	
	/**
	 *
	 * @param int $memberId
	 *        	return redirect
	 */
	public function destroy($newsfeed_id) {
		if (!Authorization::canAccess('news')) {
			return Redirect::route('dashboard')->with([
				'error' => \trans('message.unauthorized_access')
			]);
		}
		
		$response = null;
		
		try {
                   
			$response = $this->delete ( sprintf($this->restService ['deleteNewsFeed'],$newsfeed_id ))->response ();
                        
		} catch ( \App\Exceptions\ServerCrashException $exp ) {
			$this->error = $exp->getMessage ();
                        
		} catch ( \App\Exceptions\InValidResponse $exp ) {
			$this->error = $exp->getMessage ();
                       
		} catch ( \Exception $exp ) {
			$this->error = \trans ( 'messages.general_error' );
                      
		}
		
		
                if ($this->error != '') {
			return \Redirect::back ()->with ( [ 
					'serverError' => $this->error 
			] );
		}
		return \Redirect::back ()->with ( [ 
				'success' => $response
		] );
	}

}
