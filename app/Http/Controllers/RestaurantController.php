<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Exception\NotFoundException;

class RestaurantController extends Controller {

	private $restService = [
		'index' => 'admin/restaurant',
		'getMainCategories' => 'admin/restaurant/main-categories',
		'saveMainCategory' => 'admin/restaurant/main-categories',
		'editMainCategory' => 'admin/restaurant/main-categories/%s/edit',
		'updateMainCategory' => 'admin/restaurant/main-categories/%s',
		'deleteMainCategory' => 'admin/restaurant/main-categories/%s',
		'createMainCategory' => 'admin/restaurant/main-categories',
		'getSubCategories' => 'admin/restaurant/sub-categories',
		'saveSubCategory' => 'admin/restaurant/sub-categories',
		'updateSubCategory' => 'admin/restaurant/sub-categories',
		'deleteSubCategory' => 'admin/restaurant/sub-categories/%s',
		'saveNewProduct' => 'admin/restaurant/products',
		'editProduct' => 'admin/restaurant/products/%s/edit',
		'updateProduct' => 'admin/restaurant/products/%s',
		'deleteProduct' => 'admin/restaurant/products/%s',
		'getProductsByCategory' => 'admin/restaurant/products/by-category',
		'ordersList' => 'admin/restaurant/orders',
		'singleOrder' => 'admin/restaurant/orders/%s',
		'markOrderAsInProcess' => 'admin/restaurant/orders/mark-in-process',
		'markOrderAsIsReady' => 'admin/restaurant/orders/mark-is-ready',
		'markOrderAsIsServed' => 'admin/restaurant/orders/mark-is-served',
		'ordersArchive' => 'admin/restaurant/orders-archive',
		'searchAndListProducts' => 'admin/restaurant/products/search',
		'updateProductSortRanks' => 'admin/restaurant/products/update-sort-ranks',
		'updateSubCategorySortRanks' => 'admin/restaurant/sub-categories/update-sort-ranks',

	];
	private $error;

	public function index(Request $request) {

		$data = [];
		$mainCategories = [];
		$categories = [];
		//$page = ($request->has('page')) ? $request->get('page') : 1;
		//$search = ($request->has('search')) ? trim($request->get('search')) : "";
		try {
			$data = $this->get($this->restService['index'], [])->response();
			$mainCategories = $data["mainCategories"];
			$categories = $data["categories"];
		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}

		return view ( 'restaurant.restaurant', ["mainCategories"=>json_encode($mainCategories),"categories"=>json_encode($categories) ] );
	}

	public function getProductsByCategoryIdPaginated(Request $request) {

		$data = [];
		$mainCategories = [];
		$categories = [];
		//$page = ($request->has('page')) ? $request->get('page') : 1;
		//$search = ($request->has('search')) ? trim($request->get('search')) : "";
		try {
			$data = $this->get($this->restService['getProductsByCategory'], $request->all())->response();
			
		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}

		return $data;

	}

	public function showNewMainCategoryForm(Request $request){


		return view ( 'restaurant.create_main_category' );
	}

	public function saveNewMainCategory(Request $request){

		$validator = Validator::make($request->all(), [

			'name' => 'required|min:1,max:50',
			'icon' => 'required|image|image|mimes:jpeg,bmp,png,jpg|max:1024',
			'menu_icon' => 'required|image|image|mimes:jpeg,bmp,png,jpg|max:1024',

		]);

		if ($validator->fails()) {
			$this->error = $validator->errors();
			return \Redirect::back()->withInput()->withErrors($this->error);
		}
		try {
			$data = $request->all();
			if($request->hasFile('icon')){

				$tempFile = $request->file('icon')->move($request->file('icon')->getPath(), $request->file('icon')->getFilename().".".$request->file('icon')->getClientOriginalExtension());
				$data["icon"] = fopen($tempFile,'r');
				\Illuminate\Support\Facades\File::delete($tempFile);

			}

			if($request->hasFile('menu_icon')){

				$tempFile = $request->file('menu_icon')->move($request->file('menu_icon')->getPath(), $request->file('menu_icon')->getFilename().".".$request->file('menu_icon')->getClientOriginalExtension());
				$data["menu_icon"] = fopen($tempFile,'r');
				\Illuminate\Support\Facades\File::delete($tempFile);

			}

			$response = $this->post ( $this->restService ['createMainCategory'], $data )->response ();

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
		return \Redirect::to ( '/restaurant' )->with ( [
			'success' => trans ( 'messages.league_success' )
		] );


	}

	public function showEditMainCategoryForm($main_category_id){

		$data = null;

		try {
			$data = $this->get(sprintf($this->restService['editMainCategory'], $main_category_id))->response();
		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}

		if (is_null ( $this->error ) && $data)
			return view ( 'restaurant.edit_main_category',["main_category"=>$data] );

		return redirect()->route('restaurant.restaurant')->with ( [
				'serverError' => $this->error
			] );


	}

	public function updateMainCategory($main_category_id, Request $request){

		$validator = Validator::make($request->all(), [


			'name' => 'required|min:1,max:50',

		]);


		if ($validator->fails()) {
			$this->error = $validator->errors();
			return \Redirect::back()->withInput()->withErrors($this->error);
		}

		try {
			$data = $request->all();
			if($request->hasFile('icon')){

				$tempFile = $request->file('icon')->move($request->file('icon')->getPath(), $request->file('icon')->getFilename().".".$request->file('icon')->getClientOriginalExtension());
				$data["icon"] = fopen($tempFile,'r');
				\Illuminate\Support\Facades\File::delete($tempFile);

			}

			if($request->hasFile('menu_icon')){

				$tempFile = $request->file('menu_icon')->move($request->file('menu_icon')->getPath(), $request->file('menu_icon')->getFilename().".".$request->file('menu_icon')->getClientOriginalExtension());
				$data["menu_icon"] = fopen($tempFile,'r');
				\Illuminate\Support\Facades\File::delete($tempFile);

			}

			$response = $this->post ( sprintf($this->restService ['updateMainCategory'],$main_category_id), $data )->response ();

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
		return \Redirect::to ( '/restaurant' )->with ( [
			'success' => trans ( 'messages.league_success' )
		] );
	}

	public function deleteMainCategory($main_category_id){

		try {
			$response = $this->delete(sprintf($this->restService['deleteMainCategory'],$main_category_id))
				->response();

		} catch (\Exception $exp) {

			$this->error = $exp->getMessage();

		}
		if ($this->error != '') {
			return response()->json($this->error, 412);

		} else {
			return $response;
		}

	}



	public function createNewSubCategory(Request $request){

		if(!$request->has('name')){
			$this->error = "category_name_missing";
			return $this->error;
		}
		if(!$request->has('restaurant_main_category_id')){
			$this->error = "category_id_missing";
			return $this->error;
		}
		$response = null;
		try {
			$response = $this->post($this->restService['saveSubCategory'], $request->all())
				->response();

		} catch (\Exception $exp) {

			$this->error = $exp->getMessage();

		}
		if ($this->error != '') {
			return response()->json($this->error, 412);
		} else {
			return $response;
		}

	}

	public function updateSubCategory(Request $request){


		if(!$request->has('restaurant_sub_category_id')){
			$this->error = "category_id_missing";
			return $this->response();
		}

		if(!$request->has('name')){
			$this->error = "category_name_missing";
			return $this->response();
		}
		$response = null;
		try {
			$response = $this->put($this->restService['updateSubCategory'], $request->all())
				->response();

		} catch (\Exception $exp) {

			$this->error = $exp->getMessage();

		}
		if ($this->error != '') {
			return response()->json($this->error, 412);
		} else {
			return $response;
		}

	}

	public function deleteSubCategory($restaurant_sub_category_id){

		try {
			$response = $this->delete(sprintf($this->restService['deleteSubCategory'],$restaurant_sub_category_id))
				->response();

		} catch (\Exception $exp) {

			$this->error = $exp->getMessage();

		}
		if ($this->error != '') {
			return response()->json($this->error, 412);
		} else {
			return $response;
		}

	}

	public function showNewProductForm(Request $request){

		$categoryId = "";
		if($request->has('category')){
			$categoryId = $request->get('category');
		}

		$data = [];

		try {
			$data = $this->get($this->restService['getSubCategories'])->response();
		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}


		return view ( 'restaurant.create_product',["categories"=>$data, "selectedCategory"=>$categoryId] );
	}

	public function saveNewProduct(Request $request){

		$validator = Validator::make($request->all(), [
			'restaurant_sub_category_id' => 'required',
			'name' => 'required|min:1,max:50',
			'description' => 'required|min:1,max:250',
			//'image' => 'required|image|image|mimes:jpeg,bmp,png,jpg|max:1024',
			'price' =>'required|numeric',
			'ingredients'=>'array'

		]);

		if ($validator->fails()) {
			$this->error = $validator->errors();

			return \Redirect::back()->withInput()->withErrors($this->error);
		}

		try {
			$data = $request->all();
			if($request->hasFile('image')){

				$tempFile = $request->file('image')->move($request->file('image')->getPath(), $request->file('image')->getFilename().".".$request->file('image')->getClientOriginalExtension());
				$data["image"] = fopen($tempFile,'r');
				\Illuminate\Support\Facades\File::delete($tempFile);

			}

			$response = $this->post ( $this->restService ['saveNewProduct'], $data )->response ();

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
		return \Redirect::to ( '/restaurant' )->with ( [
			'success' => trans ( 'messages.league_success' )
		] );


	}

	public function showEditProductForm($product_id){
		$product = null;

		try {
			$product = $this->get(sprintf($this->restService['editProduct'], $product_id))->response();
		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}

		$categories = [];

		try {
			$categories = $this->get($this->restService['getSubCategories'])->response();
		} catch (\App\Exceptions\ServerCrashException $exp) {
			$this->error = $exp->getMessage();
		} catch (\App\Exceptions\InValidResponse $exp) {
			$this->error = $exp->getMessage();
		} catch (\Exception $exp) {
			$this->error = \trans('messages.general_error');
		}

		if (is_null ( $this->error ) && $product)
			return view ( 'restaurant.edit_product',["categories"=>$categories , "product"=>$product] );

		return redirect()->route('restaurant.restaurant')->with ( [
			'serverError' => $this->error
		] );


	}

	public function updateProduct($product_id, Request $request){

		$validator = Validator::make($request->all(), [

			'restaurant_sub_category_id' => 'required',
			'name' => 'required|min:1,max:50',
			'description' => 'required|min:1,max:250',
			//'image' => 'required|image|image|mimes:jpeg,bmp,png,jpg|max:1024',
			'price' =>'required|numeric',
			'ingredients'=>'array'

		]);


		if ($validator->fails()) {
			$this->error = $validator->errors();

			return \Redirect::back()->withInput()->withErrors($this->error);
		}

		try {
			$data = $request->all();
			if($request->hasFile('image')){

				$tempFile = $request->file('image')->move($request->file('image')->getPath(), $request->file('image')->getFilename().".".$request->file('image')->getClientOriginalExtension());
				$data["image"] = fopen($tempFile,'r');
				\Illuminate\Support\Facades\File::delete($tempFile);

			}

			$response = $this->post ( sprintf($this->restService ['updateProduct'],$product_id), $data )->response ();

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
		return \Redirect::to ( '/restaurant' )->with ( [
			'success' => trans ( 'messages.league_success' )
		] );
	}

	public function deleteProduct($product_id){

		try {
			$response = $this->delete(sprintf($this->restService['deleteProduct'],$product_id))
				->response();

		} catch (\Exception $exp) {

			$this->error = $exp->getMessage();

		}
		if ($this->error != '') {
			return response()->json($this->error, 412);

		} else {
			return $response;
		}


	}

	public function ordersList() {

		$orders = RestaurantOrder::getOpenOrdersForAClub(Auth::user()->club_id);
//		$maxEntityBasedNotificationId = EntityBasedNotification::max('id');
//		$entity_based_notification_id = $maxEntityBasedNotificationId ? $maxEntityBasedNotificationId : 0;
		$entity_based_notification_id = 0;
		return view ( 'admin.restaurant.orders', ["orders"=>json_encode($orders),
												  "entity_based_notification_id"=>$entity_based_notification_id]);
	}

	public function markOrderAsInProcess(Request $request){
		if (!$request->has('restaurant_order_id')) {
			$this->error = "order_id_missing";
			return $this->response();
		}
		$order = RestaurantOrder::getSingleOrderById($request->get("restaurant_order_id"));
		if(!$order){
			$this->error = "order_id_missing";
			return $this->response();
		}

		if($order->club_id != Auth::user()->club_id){
			$this->error = "order_doesnt_belong_to_requesting_body";
			return $this->response();
		}

		if($order->in_process == "YES"){
			$this->error = "order_id_missing";
			return $this->response();
		}

		try{

			DB::beginTransaction();
			$order->in_process = "YES";
			$order->save();
			$this->response = $order;

//			EntityBasedNotification::create([
//				"club_id"=>$order->club_id,
//				"event"=>AdminNotificationEventsManager::$RestaurantOrderUpdation,
//				"entity_id"=>$order->id,
//				"entity_type"=>RestaurantOrder::class
//			]);
//			AdminNotificationEventsManager::broadcastRestaurantOrderUpdationEvent($order->club_id);
			$order->sendNotificationToMemberOnStatusUpdate();
			DB::commit();
		}catch (\Exception $e){

			$this->error = $e->getMessage();

		}

		return $this->response();
	}

	public function markOrderAsIsReady(Request $request){
		if (!$request->has('restaurant_order_id')) {
			$this->error = "order_id_missing";
			return $this->response();
		}
		$order = RestaurantOrder::getSingleOrderById($request->get("restaurant_order_id"));
		if(!$order){
			$this->error = "order_id_missing";
			return $this->response();
		}

		if($order->club_id != Auth::user()->club_id){
			$this->error = "order_doesnt_belong_to_requesting_body";
			return $this->response();
		}
		if($order->is_ready == "YES"){
			$this->error = "order_id_missing";
			return $this->response();
		}
		try{
			DB::beginTransaction();

			$order->in_process = "YES";
			$order->is_ready = "YES";
			$order->save();
			$this->response = $order;

//			EntityBasedNotification::create([
//				"club_id"=>$order->club_id,
//				"event"=>AdminNotificationEventsManager::$RestaurantOrderUpdation,
//				"entity_id"=>$order->id,
//				"entity_type"=>RestaurantOrder::class
//			]);
//			AdminNotificationEventsManager::broadcastRestaurantOrderUpdationEvent($order->club_id);
			$order->sendNotificationToMemberOnStatusUpdate();
			DB::commit();
		}catch (\Exception $e){

			$this->error = $e->getMessage();

		}

		return $this->response();
	}

	public function markOrderAsIsServed(Request $request){
		if (!$request->has('restaurant_order_id')) {
			$this->error = "order_id_missing";
			return $this->response();
		}
		$order = RestaurantOrder::getSingleOrderById($request->get("restaurant_order_id"));
		if(!$order){
			$this->error = "order_id_missing";
			return $this->response();
		}

		if($order->club_id != Auth::user()->club_id){
			$this->error = "order_doesnt_belong_to_requesting_body";
			return $this->response();
		}
		if($order->in_served == "YES"){
			$this->error = "order_id_missing";
			return $this->response();
		}
		try{
			DB::beginTransaction();
			
			$order->in_process = "YES";
			$order->is_ready = "YES";
			$order->is_served = "YES";
			$order->save();
			$this->response = $order;

//			EntityBasedNotification::create([
//				"club_id"=>$order->club_id,
//				"event"=>AdminNotificationEventsManager::$RestaurantOrderUpdation,
//				"entity_id"=>$order->id,
//				"entity_type"=>RestaurantOrder::class
//			]);
//			AdminNotificationEventsManager::broadcastRestaurantOrderUpdationEvent($order->club_id);
			$order->sendNotificationToMemberOnStatusUpdate();
			DB::commit();
		}catch (\Exception $e){

			$this->error = $e->getMessage();

		}

		return $this->response();
	}

	public function orderView($order_id) {
		$order = RestaurantOrder::getSingleOrderById($order_id);
		if(!$order || $order->club_id != Auth::user()->id){
			return \Redirect::back()->with([
				'error' => trans('message.order_not_found.message')]);

		}

		$order->restaurant_order_details = $order->getRestaurantOrderDetailsCustomized();
//		$maxEntityBasedNotificationId = EntityBasedNotification::max('id');
//		$entity_based_notification_id = $maxEntityBasedNotificationId ? $maxEntityBasedNotificationId : 0;
		$entity_based_notification_id = 0;
		return view ( 'admin.restaurant.orders-details', ['order' => json_encode($order),
			"entity_based_notification_id"=>$entity_based_notification_id]);
	}

	public function ordersArchive(Request $request){

		$data = [];
		$mainCategories = [];
		$categories = [];
		//$page = ($request->has('page')) ? $request->get('page') : 1;
		//$search = ($request->has('search')) ? trim($request->get('search')) : "";
		try {
			$data = $this->get($this->restService['ordersArchive'], $request->all())->response();

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

			try {
				$mainCategories = $this->get($this->restService['getMainCategories'])->response();
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

			$data["mainCategories"] = $mainCategories;
			return view ( 'restaurant.orders-archive', ["ordersWithFilters"=>json_encode($data)]);
		}


	}

	public function searchAndListProducts(Request $request)
	{
		$search = $request->has('search') ? $request->get('search') : '';

		try {
			$data = $this->get(sprintf($this->restService['searchAndListProducts'] . "?search=" . $search))->response();
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
			return $data;
		}
	}

	public function updateProductSortRanks(Request $request){

		$response = null;
		try {
			$response = $this->post($this->restService['updateProductSortRanks'], $request->all())
				->response();

		} catch (\Exception $exp) {

			$this->error = $exp->getMessage();

		}
		if ($this->error != '') {
			return response()->json($this->error, 412);
		} else {
			return $response;
		}

	}

	public function updateSubCategorySortRanks(Request $request){

		$response = null;
		try {
			$response = $this->post($this->restService['updateSubCategorySortRanks'], $request->all())
				->response();

		} catch (\Exception $exp) {

			$this->error = $exp->getMessage();

		}
		if ($this->error != '') {
			return response()->json($this->error, 412);
		} else {
			return $response;
		}

	}

	


}
