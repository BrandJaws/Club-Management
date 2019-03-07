<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */
Route::get('/', [
  'as' => 'login',
  'uses' => 'EmployeeController@login'
]);

Route::get('/login', [
    'as' => 'login2',
    'uses' => 'EmployeeController@login'
]);
Route::post('/login', [
    'as' => 'login',
    'uses' => 'AuthController@login'
]);
Route::get('mobile/reset/password/{auth_token}', [
    'as' => 'forgot',
    'uses' => 'ForgotController@forgot'
]);
Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/dashboard', [
        'as' => 'dashboard',
        'uses' => 'EmployeeController@dashboard'
    ]);
    Route::get('/logout', [
        'as' => 'logout',
        'uses' => 'AuthController@logout'
    ]);
    Route::get('/reservation', [
        'as' => 'reservation',
        'uses' => 'ReservationController@index'
    ]);
    Route::get('/reservation/{date}', [
        'as' => 'reservation',
        'uses' => 'ReservationController@getReservationsByDate'
    ]);
    Route::post('/reservation', [
        'as' => 'reservation',
        'uses' => 'ReservationController@store'
    ]);
    Route::put('/reservation', [
        'as' => 'reservation',
        'uses' => 'ReservationController@update'
    ]);
    Route::delete('/reservation/{tennis_reservation_id}', [
        'as' => 'reservation',
        'uses' => 'ReservationController@destroy'
    ]);
    Route::get('/member', [
        'as' => 'member',
        'uses' => 'MemberController@index'
    ]);
    
    Route::group([
        'prefix' => 'newsfeeds',
        'as' => 'newsfeeds.'
    ], function () {
        Route::get('/', [
            'as' => 'list',
            'uses' => 'NewsFeedsController@index'
        ]);
        Route::get('/create', [
            'as' => 'create',
            'uses' => 'NewsFeedsController@create'
        ]);
        Route::post('/', [
            'as' => 'store',
            'uses' => 'NewsFeedsController@store'
        ]);
        Route::get('/{newsfeed_id}', [
            'as' => 'show',
            'uses' => 'NewsFeedsController@show'
        ]);
        Route::get('/{newsfeed_id}/edit', [
            'as' => 'edit',
            'uses' => 'NewsFeedsController@edit'
        ]);
        Route::put('/', [
            'as' => 'update',
            'uses' => 'NewsFeedsController@update'
        ]);
        Route::delete('/{newsfeed_id}', [
            'as' => 'delete',
            'uses' => 'NewsFeedsController@destroy'
        ]);
    });
    
    /**
     * Club Related Routes
     * 1) Club Settings
     * 2)
     */
    Route::group([
        'prefix' => 'club',
        'as' => 'club.'
    ], function () {
        Route::get('/', [
            'as' => 'club',
            'uses' => 'ClubController@index'
        ]);
        Route::put('/', [
            'as' => 'update',
            'uses' => 'ClubController@update'
        ]);
        Route::put('/settings', [
            'as' => 'settings',
            'uses' => 'ClubController@updateSettings'
        ]);
    });
    /*
     * Court Related routes
     *
     */
    Route::group([
        'prefix' => 'court',
        'as' => 'court.'
    ], function () {
        Route::get('/', [
            'as' => 'list',
            'uses' => 'CourtController@index'
        ]);
        Route::get('/create', [
            'as' => 'create',
            'uses' => 'CourtController@create'
        ]);
        Route::post('/', [
            'as' => 'store',
            'uses' => 'CourtController@store'
        ]);
        Route::get('/{court_id}/edit', [
            'as' => 'edit',
            'uses' => 'CourtController@edit'
        ]);
        Route::put('/{court_id}', [
            'as' => 'update',
            'uses' => 'CourtController@update'
        ]);
        Route::delete('/{court_id}', [
            'as' => 'delete',
            'uses' => 'CourtController@destroy'
        ]);
    });
    // Memebrs Related Routes
    Route::group([
        'prefix' => 'member',
        'as' => 'member.'
    ], function () {
        Route::get('/', [
            'as' => 'list',
            'uses' => 'MemberController@index'
        ]);
        Route::get('/pending', [
            'as' => 'pending',
            'uses' => 'MemberController@pendingApproval'
        ]);
        Route::get('/rejected', [
          'as' => 'pending',
          'uses' => 'MemberController@rejected'
        ]);
        Route::get('/create', [
            'as' => 'create',
            'uses' => 'MemberController@create'
        ]);
        Route::post('/', [
            'as' => 'store',
            'uses' => 'MemberController@store'
        ]);
        Route::get('/{member_id}/edit', [
            'as' => 'edit',
            'uses' => 'MemberController@edit'
        ]);
        Route::put('/{member_id}', [
            'as' => 'update',
            'uses' => 'MemberController@update'
        ]);
        Route::delete('/{member_id}', [
            'as' => 'delete',
            'uses' => 'MemberController@destroy'
        ]);
        Route::get('/list', [
            'as' => 'search-list',
            'uses' => 'MemberController@searchAndListMembers'
        ]);
        Route::post('/import', [
            'as' => 'import',
            'uses' => 'MemberController@importMembers'
        ]);
        
        Route::get('approve/affiliate/{member_id}',['as'=>'approve','uses'=>'MemberController@approveAffiliateMember']);
        Route::get('reject/affiliate/{member_id}',['as'=>'reject','uses'=>'MemberController@rejectAffiliateMember']);
    });
    // Beacon Related routes
    Route::group([
        'prefix' => 'beacon',
        'as' => 'beacon.'
    ], function () {
        Route::get('/', [
            'as' => 'list',
            'uses' => 'BeaconController@index'
        ]);
        Route::get('/create', [
            'as' => 'create',
            'uses' => 'BeaconController@create'
        ]);
        Route::post('/', [
            'as' => 'store',
            'uses' => 'BeaconController@store'
        ]);
        Route::get('/{beacon_id}/edit', [
            'as' => 'edit',
            'uses' => 'BeaconController@edit'
        ]);
        Route::put('/{beacon_id}', [
            'as' => 'update',
            'uses' => 'BeaconController@update'
        ]);
        Route::get('/delete/{beacon_id}', [
            'as' => 'delete',
            'uses' => 'BeaconController@destroy'
        ]);
    });
    
    Route::group([
        'prefix' => 'communication',
        'as' => 'communication.'
    ], function () {
        Route::get('/', [
            'as' => 'communication',
            'uses' => 'CommunicationController@index'
        ]);
        Route::post('/mobile-announcement', [
            'as' => 'mobile_announcement',
            'uses' => 'CommunicationController@mobileAnnouncement'
        ]);
    });
    Route::group([
        'prefix' => 'coaches',
        'as' => 'coaches.'
    ], function () {
        Route::get('/', [
            'as' => 'list',
            'uses' => 'CoachesController@index'
        ]);
        Route::get('/create', [
            'as' => 'create',
            'uses' => 'CoachesController@create'
        ]);
        Route::post('/', [
            'as' => 'store',
            'uses' => 'CoachesController@store'
        ]);
        Route::get('/edit/{coach_id}', [
            'as' => 'edit',
            'uses' => 'CoachesController@edit'
        ]);
        Route::put('/{coach_id}', [
            'as' => 'update',
            'uses' => 'CoachesController@update'
        ]);
        Route::delete('/{coach_id}', [
            'as' => 'delete',
            'uses' => 'CoachesController@destroy'
        ]);
    });
    Route::group([
        'prefix' => 'trainings',
        'as' => 'trainings.'
    ], function () {
        Route::get('/', [
            'as' => 'list',
            'uses' => 'TrainingsController@index'
        ]);
        Route::get('/create', [
            'as' => 'create',
            'uses' => 'TrainingsController@create'
        ]);
        Route::post('/store', [
            'as' => 'store',
            'uses' => 'TrainingsController@store'
        ]);
        Route::get('/edit/{training_id}', [
            'as' => 'edit',
            'uses' => 'TrainingsController@edit'
        ]);
        Route::put('/{training_id}', [
            'as' => 'update',
            'uses' => 'TrainingsController@update'
        ]);
        Route::delete('/{training_id}', [
            'as' => 'delete',
            'uses' => 'TrainingsController@destroy'
        ]);
        Route::get('/participants/{training_id}', [
            'as' => 'participants',
            'uses' => 'TrainingsController@show'
        ]);
        Route::delete('/remove/{reservation_player_id}',[
            'as'=>'remove',
            'uses'=>'TrainingsController@removeReservation'
        ]);
        Route::post('/', [
            'as' => 'book',
            'uses' => 'TrainingsController@bookTraining'
        ]);
        Route::post('/{training_id}/clone', [
            'as' => 'clone',
            'uses' => 'TrainingsController@cloneTraining'
        ]);
    });
    
    /*
     * League Related routes
     *
     */
    Route::group([
        'prefix' => 'league',
        'as' => 'league.'
    ], function () {
        Route::get('/', [
            'as' => 'list',
            'uses' => 'LeagueController@index'
        ]);
        Route::get('/create', [
            'as' => 'create',
            'uses' => 'LeagueController@create'
        ]);
        Route::post('/', [
            'as' => 'store',
            'uses' => 'LeagueController@store'
        ]);
        Route::get('/{league_id}/edit', [
            'as' => 'edit',
            'uses' => 'LeagueController@edit'
        ]);
        Route::put('/{league_id}', [
            'as' => 'update',
            'uses' => 'LeagueController@update'
        ]);
        Route::delete('/{league_id}', [
            'as' => 'delete',
            'uses' => 'LeagueController@destroy'
        ]);
        Route::get('/{league_id}/show', [
            'as' => 'show',
            'uses' => 'LeagueController@show'
        ]);
        Route::get('/{league_id}/leaderboard', [
            'as' => 'leaderboard',
            'uses' => 'LeagueController@leaderboard'
        ]);
        Route::post('/create-scorecard', [
          'as' => 'createScoreCard',
          'uses' => 'LeagueController@createScoreCard'
        ]);
        Route::post('/reserve-match', [
          'as' => 'reserveMatch',
          'uses' => 'LeagueController@reserveMatchForUnstructuredLeague'
        ]);
        Route::post('/update-ladder-ranks', [
          'as' => 'updateLadderRanks',
          'uses' => 'LeagueController@updateLadderLeagueRanks'
        ]);
        Route::post('/update-pyramid-ranks', [
          'as' => 'updatePyramidRanks',
          'uses' => 'LeagueController@updatePyramidLeagueRanks'
        ]);
        Route::post('/delete-league-player', [
          'as' => 'deleteLeaguePlayer',
          'uses' => 'LeagueController@deleteRegisteredLeaguePlayer'
        ]);
        Route::post('/add-league-players', [
          'as' => 'addLeaguePlayers',
          'uses' => 'LeagueController@addLeaguePlayers'
        ]);
        Route::get('/create-challenges/{league_id}', [
        	'as' => 'createChallenges',
	        'uses' => 'LeagueController@createLeagueChallenges'
        ]);
       
    });

    Route::group([
      'prefix' => 'employee',
      'as' => 'employee.'
    ], function () {
        Route::get('/', [
          'as' => 'list',
          'uses' => 'EmployeeController@index'
        ]);
        Route::get('/create', [
          'as' => 'create',
          'uses' => 'EmployeeController@create'
        ]);
        Route::post('/', [
          'as' => 'store',
          'uses' => 'EmployeeController@store'
        ]);
        Route::get('/edit/{employee_id}', [
          'as' => 'edit',
          'uses' => 'EmployeeController@edit'
        ]);
        Route::put('/{employee_id}', [
          'as' => 'update',
          'uses' => 'EmployeeController@update'
        ]);
        Route::delete('/{employee_id}', [
          'as' => 'delete',
          'uses' => 'EmployeeController@destroy'
        ]);

    });
	
	/**
	Tournments Route
	**/
	
	Route::group([
      'prefix' => 'tournament',
      'as' => 'tournament.'
    ], function () {
        Route::get('/', [
          'as' => 'list',
          'uses' => 'TournamentController@index'
        ]);
        Route::get('/create', [
          'as' => 'create',
          'uses' => 'TournamentController@create'
        ]);
        Route::post('/', [
          'as' => 'store',
          'uses' => 'TournamentController@store'
        ]);
        Route::get('/edit/{tournament_id}', [
          'as' => 'edit',
          'uses' => 'TournamentController@edit'
        ]);
        Route::put('/{tournament_id}', [
          'as' => 'update',
          'uses' => 'TournamentController@update'
        ]);
        Route::delete('/{tournament_id}', [
          'as' => 'delete',
          'uses' => 'TournamentController@destroy'
        ]);
        Route::get('/{tournament_id}/show', [
          'as' => 'show',
          'uses' => 'TournamentController@show'
        ]);
    });
	
	
	
    Route::group([
      'prefix' => 'nps',
      'as' => 'nps.'
    ], function () {

        Route::post('/', [
          'as' => 'store',
          'uses' => 'NPSController@store'
        ]);

    });

    /**
    Private Lessons Routes
     **/

    Route::group([
      'prefix' => 'private-lessons',
      'as' => 'private_lessons.'
    ], function () {
        Route::get('/', [
          'as' => 'list',
          'uses' => 'PrivateLessonsController@index'
        ]);

    });

    /**
     * Routes related to shop
     */
    Route::group([
      'prefix' => 'shop',
      'as' => 'shop.'
    ], function () {
        Route::get('/', [
          'as' => 'shop',
          'uses' => 'ShopController@index'
        ]);
        Route::post('/categories', [
          'as' => 'create_category',
          'uses' => 'ShopController@createNewCategory'
        ]);
        Route::delete('/categories/{category_id}', [
          'as' => 'delete_category',
          'uses' => 'ShopController@deleteCategory'
        ]);
        Route::put('/categories', [
          'as' => 'update_category',
          'uses' => 'ShopController@updateCategory'
        ]);


        Route::get('/products/new', [
          'as' => 'create_product',
          'uses' => 'ShopController@showNewProductForm'
        ]);

        Route::post('/products', [
          'as' => 'store_product',
          'uses' => 'ShopController@saveNewProduct'
        ]);

        Route::get('/products/{product_id}/edit', [
          'as' => 'edit_product',
          'uses' => 'ShopController@showEditProductForm'
        ]);
        Route::post('/products/{product_id}', [
          'as' => 'update_product',
          'uses' => 'ShopController@updateProduct'
        ]);
        Route::delete('/products/{product_id}', [
          'as' => 'delete_product',
          'uses' => 'ShopController@deleteProduct'
        ]);
        Route::get('/products/by-category', [
          'as' => 'products_by_category',
          'uses' => 'ShopController@getProductsByCategoryIdPaginated'
        ]);
    });

    /**
     * Routes related to restaurant
     */
    Route::group([
      'prefix' => 'restaurant',
      'as' => 'restaurant.'
    ], function () {
        Route::get('/', [
          'as' => 'restaurant',
          'uses' => 'RestaurantController@index'
        ]);

        Route::get('/main-categories/new', [
          'as' => 'create_main_category',
          'uses' => 'RestaurantController@showNewMainCategoryForm'
        ]);
        Route::post('/main-categories', [
          'as' => 'store_main_category',
          'uses' => 'RestaurantController@saveNewMainCategory'
        ]);
        Route::get('/main-categories/{main_category_id}/edit', [
          'as' => 'edit_main_category',
          'uses' => 'RestaurantController@showEditMainCategoryForm'
        ]);
        Route::post('/main-categories/{main_category_id}', [
          'as' => 'update_main_category',
          'uses' => 'RestaurantController@updateMainCategory'
        ]);
        Route::delete('/main-categories/{main_category_id}', [
          'as' => 'delete_main_category',
          'uses' => 'RestaurantController@deleteMainCategory'
        ]);



        Route::post('/sub-categories', [
          'as' => 'create_sub_category',
          'uses' => 'RestaurantController@createNewSubCategory'
        ]);
        Route::post('/sub-categories/update-sort-ranks', [
          'as' => 'update_sub_category_sort_ranks',
          'uses' => 'RestaurantController@updateSubCategorySortRanks'
        ]);
        Route::delete('/sub-categories/{sub_category_id}', [
          'as' => 'delete_sub_category',
          'uses' => 'RestaurantController@deleteSubCategory'
        ]);
        Route::put('/sub-categories', [
          'as' => 'update_sub_category',
          'uses' => 'RestaurantController@updateSubCategory'
        ]);


        Route::get('/products/new', [
          'as' => 'create_product',
          'uses' => 'RestaurantController@showNewProductForm'
        ]);

        Route::post('/products', [
          'as' => 'store_product',
          'uses' => 'RestaurantController@saveNewProduct'
        ]);
        Route::post('/products/update-sort-ranks', [
          'as' => 'update_product_sort_ranks',
          'uses' => 'RestaurantController@updateProductSortRanks'
        ]);
        Route::get('/products/{product_id}/edit', [
          'as' => 'edit_product',
          'uses' => 'RestaurantController@showEditProductForm'
        ]);
        Route::post('/products/{product_id}', [
          'as' => 'update_product',
          'uses' => 'RestaurantController@updateProduct'
        ]);
        Route::delete('/products/{product_id}', [
          'as' => 'delete_product',
          'uses' => 'RestaurantController@deleteProduct'
        ]);
        Route::get('/products/by-category', [
          'as' => 'products_by_category',
          'uses' => 'RestaurantController@getProductsByCategoryIdPaginated'
        ]);
        Route::get('/products/search', [
          'as' => 'search_products',
          'uses' => 'RestaurantController@searchAndListProducts'
        ]);


//        Route::get('/orders', [
//          'as' => 'orders',
//          'uses' => 'RestaurantController@ordersList'
//        ]);
//
//        Route::get('/orders/{order_id}', [
//          'as' => 'single_order',
//          'uses' => 'RestaurantController@orderView'
//        ]);
//
//        Route::post('/orders/mark-in-process', [
//          'as' => 'mark_order_in_process',
//          'uses' => 'RestaurantController@markOrderAsInProcess'
//        ]);
//        Route::post('/orders/mark-is-ready', [
//          'as' => 'mark_order_is_ready',
//          'uses' => 'RestaurantController@markOrderAsIsReady'
//        ]);
//        Route::post('/orders/mark-is-served', [
//          'as' => 'mark_order_is_served',
//          'uses' => 'RestaurantController@markOrderAsIsServed'
//        ]);
        Route::get('/orders-archive', [
          'as' => 'orders_archive',
          'uses' => 'RestaurantController@ordersArchive'
        ]);
    });

    /**
     * Routes related to Miscellaneous Receipts
     */
    Route::group([
      'prefix' => 'misc-receipts',
      'as' => 'misc-receipts.'
    ], function () {

        Route::get('/', [
          'as' => 'list',
          'uses' => 'MiscellaneousReceiptsController@miscellaneousReceiptsList'
        ]);


    });

    /**
     * Routes related to Messages From POS
     */
    Route::group([
      'prefix' => 'employee-chat',
      'as' => 'employee-chat.'
    ], function () {

//        Route::post('/delete-one', [
//          'as' => 'delete-one',
//          'uses' => 'EmployeeChatController@deleteOne'
//        ]);
//        Route::get('/delete-all', [
//          'as' => 'delete-all',
//          'uses' => 'EmployeeChatController@deleteAll'
//        ]);
        Route::get('/', [
          'as' => 'list',
          'uses' => 'EmployeeChatController@getMessageFromPOSPaginated'
        ]);

        Route::post('/', [
          'as' => 'store',
          'uses' => 'EmployeeChatController@store'
        ]);
    });

    /**
     * Routes related to Miscellaneous Receipts
     */
    Route::group([
      'prefix' => 'tab-accounts',
      'as' => 'tab-accounts.'
    ], function () {

        Route::get('/', [
          'as' => 'list',
          'uses' => 'TabAccountsController@tabAccountsList'
        ]);
        Route::put('/', [
          'as' => 'update',
          'uses' => 'TabAccountsController@updateTabAccount'
        ]);
        Route::get('/deposits', [
          'as' => 'deposits',
          'uses' => 'TabAccountsController@tabAccountDepositsList'
        ]);
        Route::get('/{tab_account_id}/details', [
          'as' => 'show_details',
          'uses' => 'TabAccountsController@showDetails'
        ]);


    });

    /**
    * Routes related toReports
    */
    Route::group([
      'prefix' => 'reports',
      'as' => 'reports.'
    ], function () {

        Route::post('/orders-archive-csv', [
          'as' => 'orders-archive-csv',
          'uses' => 'ReportsController@createOrdersArchiveCSV'
        ]);


    });

});
