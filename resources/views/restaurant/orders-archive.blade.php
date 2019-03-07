@extends('__layouts.admin')
@section('heading')
    Orders Archive
    @endSection
@section('main')
            <!-- BEGIN PAGE HEADER-->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a> <i
                        class="fa fa-angle-right"></i></li>
            <li>Orders Archive </li>

        </ul>
    </div>
    <h1 class="page-title"> Orders Archive</h1>

    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->

    <!-- BEGIN PROFILE CONTENT -->

	<div ui-view class="app-body" id="view">
		<!-- ############ PAGE START-->
		<div id="orders-vue-container" class="segments-main padding">
			<div class="row">
                <div class="col-md-12">
				<div class="segments-inner">
					<div class="box">
						<div class="inner-header">
                            <div class="filters">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Main Category</label>
                                                <select name="restaurantMainCategoryId" class="form-control"  v-model="filtersForBinding.restaurantMainCategoryId" v-on:change="filtersForBinding.restaurantMainCategoryId == 0 ? filtersForBinding.restaurantSubCategoryId = 0 : null">
                                                    <option value="0">Select Main Category</option>
                                                    <option v-for="mainCategory in categories"  :value="mainCategory.id" >@{{mainCategory.name}}</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Sub Category</label>
                                                <select name="restaurantSubCategoryId" class="form-control" v-model="filtersForBinding.restaurantSubCategoryId">
                                                    <option value="0">Select Sub Category</option>
                                                    <option v-for="subCategory in subCategories"  :value="subCategory.id" >@{{subCategory.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Product</label>
                                                <auto-complete-box url="{{url('restaurant/products/search')}}" property-for-id="id" property-for-name="name"
                                                                   filtered-from-source="true"
                                                                   include-id-in-list="false"
                                                                   initial-text-value="" search-query-key="search" field-name="productId" enable-explicit-selection="false" v-model="filtersForBinding.productId"> </auto-complete-box>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Member</label>
                                                <auto-complete-box url="{{url('member/list')}}" property-for-id="id" property-for-name="name"
                                                                   filtered-from-source="true"
                                                                   include-id-in-list="true"
                                                                   initial-text-value="" search-query-key="search" field-name="memberId" enable-explicit-selection="false" v-model="filtersForBinding.memberId"> </auto-complete-box>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Date From</label>
                                                <input id="dateFrom" type="text" name="" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Date To</label>
                                                <input id="dateTo" type="text" name="" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Payment Method</label>
                                                <select name="paymentMethod" class="form-control"  v-model="filtersForBinding.paymentMethod" >
                                                    <option value="">Select Payment Method</option>
                                                    <option v-for="paymentMethod in paymentMethods"  :value="paymentMethod" >@{{paymentMethod}}</option>

                                                </select>
                                            </div>
                                        </div>
                                     </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="form-group">
                                                <br>
                                                <input type="submit" name="" value="Search" class="btn-def btn btn-full-width" @click.prevent="loadNextPage(true)" />
                                                <input type="submit" name="" value="Download CSV" class="btn-def btn btn-full-width" @click.prevent="downloadCSV()" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
						@if(Session::has('serverError'))
                            <div class="alert alert-warning" role="alert"> {{Session::get('serverError')}} </div>
                        @endif
                        @if(Session::has('success'))
                        	<div class="alert alert-success" role="alert"> {{Session::get('success')}} </div>
                        @endif
						<!-- inner header -->
						<orders-archive :orders-list="ordersListPrintable" :base-url="baseUrl"></orders-archive>
					</div>
				</div>
            </div>
			</div>
		</div>
	</div>
@endsection

@section('page-specific-scripts')
@include("__vue_components.restaurant.orders-archive")
@include("__vue_components.autocomplete.autocomplete")
<script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")   }}" type="text/javascript"></script>
<script>


    var _baseUrl = "{{url('')}}";
    var vue = new Vue({
        el: "#orders-vue-container",
        data: {
            //Null filters as at the time of initialization to send null value with the request if the filtersForBinding Equals these
            //This will save us where query clauses at the server
            nullFilters:{ restaurantMainCategoryId:0, restaurantSubCategoryId:0, productId:0,memberId:-1,  dateFrom:"",dateTo:"",paymentMethod:"" },
            filtersReceived : ({!! $ordersWithFilters !!}).filters != null ? ({!! $ordersWithFilters !!}).filters : { restaurantMainCategoryId:0, restaurantSubCategoryId:0, productId:0, memberId:-1,  dateFrom:"", dateTo:"",paymentMethod:"" },
            filtersForBinding:{
                restaurantMainCategoryId:0,
                restaurantSubCategoryId:0,
                productId:0,
                memberId:-1,
                dateFrom:"",
                dateTo:"",
                paymentMethod:"",


            },
            orderList: ({!! $ordersWithFilters !!}).data,
            categories: ({!! $ordersWithFilters !!}).mainCategories,
            ajaxRequestInProcess:false,
            nextAvailablePage:({!! $ordersWithFilters!!}).next_page_url !== null ? 2 : null ,
            searchRequestHeld:false,
            baseUrl:_baseUrl,
            servicesUrl:"{{env('REST_API')}}",
            paymentMethods:({!! config('global.restaurantOrders.payment_methods') ? json_encode(array_values(config('global.restaurantOrders.payment_methods'))) : '[]' !!})




        },
        computed:{
            subCategories:function(){
               for(mainCategoryIndex in this.categories){
                   if(this.categories[mainCategoryIndex].id == this.filtersForBinding.restaurantMainCategoryId){
                       return this.categories[mainCategoryIndex].sub_categories;

                   }
               }
                return [];
            },
            ordersListPrintable:function(){
                var ordersListPrintable = [];
                for(orderIndex in this.orderList){
                    var order = this.orderList[orderIndex];
                    var orderPrintable = {
                        mainCategoryName:"",
                        subCategoryName:"",
                        productName:"",
                        saleTotal:"",
                        createdAt:"",
                        paymentMethod:"",
                    }
                    if(order.restaurant_product != undefined){
                        orderPrintable.mainCategoryName = order.restaurant_product.restaurant_sub_category.restaurant_main_category.name;
                        orderPrintable.subCategoryName = order.restaurant_product.restaurant_sub_category.name;
                        orderPrintable.productName = order.restaurant_product.name;
                    }
                    orderPrintable.saleTotal = order.sale_total;
                    orderPrintable.createdAt = order.time;
                    orderPrintable.paymentMethod = order.payment_method;
                    ordersListPrintable.push(orderPrintable);
                }
                //.log(ordersListPrintable);
                return ordersListPrintable;
            }
        },
        mounted:function(){

            $( "#dateFrom" ).datepicker()
                    .on('changeDate', function(e) {

                        vue.filtersForBinding.dateFrom = $( "#dateFrom" ).val();



                    });
            $( "#dateFrom" ).datepicker()
                    .on('input', function(e) {

                        vue.filtersForBinding.dateFrom = $( "#dateFrom" ).val();



                    });

            $( "#dateTo" ).datepicker()
                    .on('changeDate', function(e) {

                        vue.filtersForBinding.dateTo = $( "#dateTo" ).val();



                    });
            $( "#dateTo" ).datepicker()
                    .on('input', function(e) {

                        vue.filtersForBinding.dateTo = $( "#dateTo" ).val();



                    });

        },
        methods: {

            loadNextPage:function(isSearchQuery){

                var _data ={};

                if(isSearchQuery){

                    if(JSON.stringify(this.filtersForBinding) ==  JSON.stringify(this.filtersReceived)){

                        return;
                    }

                    if(this.ajaxRequestInProcess){
                        this.searchRequestHeld=true;
                        return;
                    }

                    //If is search query we need to set filters equal to filters for binding that have been selected by the user
                    //Also we need to reset nextAvailablePage so that the method doesn't return void since  the nextAvailablePage
                    //might have been set to null due to previous scrolling or search results

                    _data.filters = JSON.stringify(this.filtersForBinding) == JSON.stringify(this.nullFilters) ? null : JSON.stringify(this.filtersForBinding);
                    this.nextAvailablePage = 1;
                    _data.current_page = this.nextAvailablePage;


                }else{
                    //If is scroll query we need to set filters equal to filters received last time
                    //might have been set to null due to previous scrolling or search results

                    _data.filters =  JSON.stringify(this.filtersReceived) == JSON.stringify(this.nullFilters) ? null : JSON.stringify(this.filtersReceived);
                    _data.current_page = this.nextAvailablePage;

                }

                //Return void if there is no available next page. Placed here so that in case of search query when we need to refresh the counter
                //we can set it to a non null value i-e 1 before we reach this check.
                if(this.nextAvailablePage === null){
                    return;
                }





                if(!this.ajaxRequestInProcess){
                    this.ajaxRequestInProcess = true;
                    var request = $.ajax({

                        url: this.baseUrl+'/restaurant/orders-archive',
                        method: "GET",
                        data:_data,
                        success:function(msg){

                            this.ajaxRequestInProcess = false;
                            if(this.searchRequestHeld){

                                this.searchRequestHeld=false;
                                this.loadNextPage(true);

                            }

                            pageDataReceived = msg;
                            orderList = pageDataReceived.data ;
                            this.filtersReceived = pageDataReceived.filters != null ? pageDataReceived.filters : {  restaurantMainCategoryId:0, restaurantSubCategoryId:0, productId:0, memberId:-1,dateFrom:"" , dateTo:"", paymentMethod:"" };

                            //Success code to follow
                            if(pageDataReceived.next_page_url !== null){
                                this.nextAvailablePage = pageDataReceived.current_page+1;
                            }else{
                                this.nextAvailablePage = null;
                            }

                            if(isSearchQuery){

                                this.orderList=orderList;
                            }else{

                                appendArray(this.orderList,orderList);
                            }



                        }.bind(this),

                        error: function(jqXHR, textStatus ) {
                            this.ajaxRequestInProcess = false;

                            //Error code to follow


                        }.bind(this)
                    });
                }
            },
            downloadCSV:function(){
                    _url = this.baseUrl+'/reports/orders-archive-csv'
                    var request = $.ajax({

                        url: _url,
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        data:{

                            _token: "{{ csrf_token() }}",
                            data:JSON.stringify(this.ordersListPrintable),

                        },
                        success:function(msg){
                            if(msg.reportUrl != undefined){
                                window.location = this.servicesUrl+'admin/reports/download'+'?path='+msg.reportUrl;
                            }
                        }.bind(this),
                        error: function(jqXHR, textStatus ) {

                            //Error code to follow


                        }.bind(this)
                    });

            }


        },





    });


    /* $(document).ready(function() {
     vue.loadNextPage();
     }); */
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {

            vue.loadNextPage(false);

        }
    });
 
   
</script>

@endSection
