@extends('__layouts.admin')
@section('main') 

<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body"> Widget settings form goes here </div>
      <div class="modal-footer">
        <button type="button" class="btn blue">Save changes</button>
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
    <!-- /.modal-content --> 
    
  </div>
  
  <!-- /.modal-dialog --> 
  
</div>

<!-- /.modal --> 

<!-- BEGIN PAGE HEADER-->

<div class="page-bar">
  <ul class="page-breadcrumb">
    <li> <i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
    <!-- <li> <a href="#">Dashboard</a> </li> -->
  </ul>
</div>
<h1 class="page-title"> Dashboard </h1>
@if(Session::has('serverError'))
<div class="alert alert-warning" role="alert"> {{Session::get('serverError')}} </div>
@endif 
<!-- END PAGE HEADER--> 

<!-- BEGIN DASHBOARD STATS -->

<div class="row">
    @canAccess('members')
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="dashboard-stat2 ">
      <div class="display">
        <div class="number">
          <h3 class="font-green-sharp"> <span data-counter="counterup" data-value="{{isset($stats['members'])?$stats['members']:0}}">{{isset($stats['members'])?$stats['members']:0}}</span> <small class="font-green-sharp"></small> </h3>
          <small>TOTAL MEMBERS</small> </div>
        <div class="icon"> <i class="icon-pie-chart"></i> </div>
      </div>
      <div class="progress-info">
        <div class="progress"> <span style="width: 26%;" class="progress-bar progress-bar-success green-sharp"> <span class="sr-only">{{isset($stats['members'])?$stats['members']:0}} Members</span> </span> </div>
        <div class="status">
          <div class="status-title"> members </div>
          <div class="status-number"> {{isset($stats['members'])?$stats['members']:0}} </div>
        </div>
      </div>
    </div>
  </div>
    @endif

    @canAccess('courts')
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-red-haze"> <span data-counter="counterup" data-value="{{isset($stats['totalHoursBooked'])?$stats['totalHoursBooked']:0}}">{{isset($stats['totalHoursBooked'])?$stats['totalHoursBooked']:0}}</span> </h3>
                        <small>BILLED COURT HOURS</small> </div>
                    <div class="icon"> <i class="icon-like"></i> </div>
                </div>
                <div class="progress-info">
                    <div class="progress"> <span style="width: 80%;" class="progress-bar progress-bar-success red-haze"> <span class="sr-only">{{isset($stats['totalHoursBooked'])?$stats['totalHoursBooked']:0}}$ charged</span> </span> </div>
                    <div class="status">
                        <div class="status-title"> charged </div>
                        <div class="status-number"> {{isset($stats['totalHoursBooked'])?$stats['totalHoursBooked']:0}}$ </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="dashboard-stat2 ">
                <div class="display">
                    <div class="number">
                        <h3 class="font-blue-sharp"> <span data-counter="counterup" data-value="{{isset($stats['courts'])?$stats['courts']:0}}">{{isset($stats['courts'])?$stats['courts']:0}}</span> </h3>
                        <small>TOTAL COURTS</small> </div>
                    <div class="icon"> <i class="icon-basket"></i> </div>
                </div>
                <div class="progress-info">
                    <div class="progress"> <span style="width: 55%;" class="progress-bar progress-bar-success blue-sharp"> <span class="sr-only">{{isset($stats['courts'])?$stats['courts']:0}} courts</span> </span> </div>
                    <div class="status">
                        <div class="status-title"> courts </div>
                        <div class="status-number"> {{isset($stats['courts'])?$stats['courts']:0}} </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat2 ">
            <div class="display">
                <div class="number">
                    <h3 class="font-purple-soft"> <span data-counter="counterup" data-value="{{isset($stats['totalUnbookedHours'])?$stats['totalUnbookedHours']:0}}">{{isset($stats['totalUnbookedHours'])?$stats['totalUnbookedHours']:0}}</span> </h3>
                    <small>UNUSED COURT HOURS</small> </div>
                <div class="icon"> <i class="icon-user"></i> </div>
            </div>
            <div class="progress-info">
                <div class="progress"> <span style="width: 70%;" class="progress-bar progress-bar-success purple-soft"> <span class="sr-only">{{isset($stats['totalUnbookedHours'])?$stats['totalUnbookedHours']:0}}% unused hours</span> </span> </div>
                <div class="status">
                    <div class="status-title"> unused hours </div>
                    <div class="status-number"> {{isset($stats['totalUnbookedHours'])?$stats['totalUnbookedHours']:0}}% </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{--@canAccess('restaurant')--}}
        {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
            {{--<div class="dashboard-stat2 ">--}}
                {{--<div class="display">--}}
                    {{--<div class="number">--}}
                        {{--<h3 class="font-green-sharp"> <span data-counter="counterup" data-value="{{isset($saleInvoiceStats['netTotalForTheDay'])?$saleInvoiceStats['netTotalForTheDay']:0}}">{{isset($saleInvoiceStats['netTotalForTheDay'])?$saleInvoiceStats['netTotalForTheDay']:0}}</span> <small class="font-green-sharp"></small> </h3>--}}
                        {{--<small>NET SALES FOR THE DAY</small> </div>--}}
                    {{--<div class="icon"> <i class="icon-pie-chart"></i> </div>--}}
                {{--</div>--}}
                {{--<div class="progress-info">--}}
                    {{--<div class="progress"> <span style="width: 26%;" class="progress-bar progress-bar-success green-sharp"> <span class="sr-only">{{isset($saleInvoiceStats['netTotalForTheDay'])?$saleInvoiceStats['netTotalForTheDay']:0}} Sales</span> </span> </div>--}}
                    {{--<div class="status">--}}
                        {{--<div class="status-title"> Sales </div>--}}
                        {{--<div class="status-number"> {{isset($saleInvoiceStats['netTotalForTheDay'])?$saleInvoiceStats['netTotalForTheDay']:0}} </div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
        {{--<div class="dashboard-stat2 ">--}}
            {{--<div class="display">--}}
                {{--<div class="number">--}}
                    {{--<h3 class="font-red-haze"> <span data-counter="counterup" data-value="{{isset($saleInvoiceStats['invoiceCountForTheDay'])?$saleInvoiceStats['invoiceCountForTheDay']:0}}">{{isset($saleInvoiceStats['invoiceCountForTheDay'])?$saleInvoiceStats['invoiceCountForTheDay']:0}}</span> <small class="font-red-haze"></small> </h3>--}}
                    {{--<small>INVOICE COUNT FOR THE DAY</small> </div>--}}
                {{--<div class="icon"> <i class="icon-pie-chart"></i> </div>--}}
            {{--</div>--}}
            {{--<div class="progress-info">--}}
                {{--<div class="progress"> <span style="width: 26%;" class="progress-bar progress-bar-success red-haze"> <span class="sr-only">{{isset($saleInvoiceStats['invoiceCountForTheDay'])?$saleInvoiceStats['invoiceCountForTheDay']:0}} Sales</span> </span> </div>--}}
                {{--<div class="status">--}}
                    {{--<div class="status-title"> Sales </div>--}}
                    {{--<div class="status-number"> {{isset($saleInvoiceStats['invoiceCountForTheDay'])?$saleInvoiceStats['invoiceCountForTheDay']:0}} </div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
        {{--<div class="dashboard-stat2 ">--}}
            {{--<div class="display">--}}
                {{--<div class="number">--}}
                    {{--<h3 class="font-blue-sharp"> <span data-counter="counterup" data-value="{{isset($saleInvoiceStats['netTotalTillDate'])?$saleInvoiceStats['netTotalTillDate']:0}}">{{isset($saleInvoiceStats['netTotalTillDate'])?$saleInvoiceStats['netTotalTillDate']:0}}</span> <small class="font-blue-sharp"></small> </h3>--}}
                    {{--<small>NET SALES TILL DATE</small> </div>--}}
                {{--<div class="icon"> <i class="icon-pie-chart"></i> </div>--}}
            {{--</div>--}}
            {{--<div class="progress-info">--}}
                {{--<div class="progress"> <span style="width: 26%;" class="progress-bar progress-bar-success blue-sharp"> <span class="sr-only">{{isset($saleInvoiceStats['netTotalTillDate'])?$saleInvoiceStats['netTotalTillDate']:0}} Sales</span> </span> </div>--}}
                {{--<div class="status">--}}
                    {{--<div class="status-title"> Sales </div>--}}
                    {{--<div class="status-number"> {{isset($saleInvoiceStats['netTotalTillDate'])?$saleInvoiceStats['netTotalTillDate']:0}} </div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">--}}
        {{--<div class="dashboard-stat2 ">--}}
            {{--<div class="display">--}}
                {{--<div class="number">--}}
                    {{--<h3 class="font-purple-soft"> <span data-counter="counterup" data-value="{{isset($saleInvoiceStats['invoiceCountTillDate'])?$saleInvoiceStats['invoiceCountTillDate']:0}}">{{isset($saleInvoiceStats['invoiceCountTillDate'])?$saleInvoiceStats['invoiceCountTillDate']:0}}</span> <small class="font-purple-soft"></small> </h3>--}}
                    {{--<small>INVOICE COUNT TILL DATE</small> </div>--}}
                {{--<div class="icon"> <i class="icon-pie-chart"></i> </div>--}}
            {{--</div>--}}
            {{--<div class="progress-info">--}}
                {{--<div class="progress"> <span style="width: 26%;" class="progress-bar progress-bar-success purple-soft"> <span class="sr-only">{{isset($saleInvoiceStats['invoiceCountTillDate'])?$saleInvoiceStats['invoiceCountTillDate']:0}} Sales</span> </span> </div>--}}
                {{--<div class="status">--}}
                    {{--<div class="status-title"> Sales </div>--}}
                    {{--<div class="status-number"> {{isset($saleInvoiceStats['invoiceCountTillDate'])?$saleInvoiceStats['invoiceCountTillDate']:0}} </div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--@endif--}}

</div>

<!-- END DASHBOARD STATS -->

<div class="clearfix"></div>
{{--<div class="row">--}}
  {{--<div class="col-md-6 col-sm-6">--}}
    {{--<div class="portlet light ">--}}
      {{--<div class="portlet-title">--}}
        {{--<div class="caption"> <i class="icon-cursor font-dark hide"></i> <span class="caption-subject font-dark bold uppercase">General Stats</span> </div>--}}
        {{--<div class="actions"> <a href="javascript:;" class="btn btn-sm btn-circle red easy-pie-chart-reload"> <i class="fa fa-repeat"></i> Reload </a> </div>--}}
      {{--</div>--}}
      {{--<div class="portlet-body">--}}
        {{--<div class="row">--}}
          {{--<div class="col-md-4">--}}
            {{--<div class="easy-pie-chart">--}}
              {{--<div class="number transactions" data-percent="55"> <span>55</span>%--}}
                {{--<canvas height="75" width="75"></canvas>--}}
              {{--</div>--}}
              {{--<a class="title" href="javascript:;"> Transactions <i class="icon-arrow-right"></i> </a> </div>--}}
          {{--</div>--}}
          {{--<div class="margin-bottom-10 visible-sm"> </div>--}}
          {{--<div class="col-md-4">--}}
            {{--<div class="easy-pie-chart">--}}
              {{--<div class="number visits" data-percent="85"> <span>10</span>%--}}
                {{--<canvas height="75" width="75"></canvas>--}}
              {{--</div>--}}
              {{--<a class="title" href="javascript:;"> New Visits <i class="icon-arrow-right"></i> </a> </div>--}}
          {{--</div>--}}
          {{--<div class="margin-bottom-10 visible-sm"> </div>--}}
          {{--<div class="col-md-4">--}}
            {{--<div class="easy-pie-chart">--}}
              {{--<div class="number bounce" data-percent="46"> <span>70</span>%--}}
                {{--<canvas height="75" width="75"></canvas>--}}
              {{--</div>--}}
              {{--<a class="title" href="javascript:;"> Bounce <i class="icon-arrow-right"></i> </a> </div>--}}
          {{--</div>--}}
        {{--</div>--}}
      {{--</div>--}}
    {{--</div>--}}
  {{--</div>--}}
  {{--<div class="col-md-6 col-sm-6">--}}
    {{--<div class="portlet light ">--}}
      {{--<div class="portlet-title">--}}
        {{--<div class="caption"> <i class="icon-equalizer font-dark hide"></i> <span class="caption-subject font-dark bold uppercase">Server Stats</span> <span class="caption-helper">monthly stats...</span> </div>--}}
      {{--</div>--}}
      {{--<div class="portlet-body">--}}
        {{--<div class="row">--}}
          {{--<div class="col-md-4">--}}
            {{--<div class="sparkline-chart">--}}
              {{--<div class="number" id="sparkline_bar5">--}}
                {{--<canvas width="113" height="55" style="display: inline-block; width: 113px; height: 55px; vertical-align: top;"></canvas>--}}
              {{--</div>--}}
              {{--<a class="title" href="javascript:;"> Network <i class="icon-arrow-right"></i> </a> </div>--}}
          {{--</div>--}}
          {{--<div class="margin-bottom-10 visible-sm"> </div>--}}
          {{--<div class="col-md-4">--}}
            {{--<div class="sparkline-chart">--}}
              {{--<div class="number" id="sparkline_bar6">--}}
                {{--<canvas width="107" height="55" style="display: inline-block; width: 107px; height: 55px; vertical-align: top;"></canvas>--}}
              {{--</div>--}}
              {{--<a class="title" href="javascript:;"> CPU Load <i class="icon-arrow-right"></i> </a> </div>--}}
          {{--</div>--}}
          {{--<div class="margin-bottom-10 visible-sm"> </div>--}}
          {{--<div class="col-md-4">--}}
            {{--<div class="sparkline-chart">--}}
              {{--<div class="number" id="sparkline_line">--}}
                {{--<canvas width="100" height="55" style="display: inline-block; width: 100px; height: 55px; vertical-align: top;"></canvas>--}}
              {{--</div>--}}
              {{--<a class="title" href="javascript:;"> Load Rate <i class="icon-arrow-right"></i> </a> </div>--}}
          {{--</div>--}}
        {{--</div>--}}
      {{--</div>--}}
    {{--</div>--}}
  {{--</div>--}}
{{--</div>--}}
<div class="clearfix"></div>
<div  class="row" >

{{--@canAccess('trainings')--}}
    {{--<div id="vue-feeds-container"  class="col-md-6 col-sm-6">--}}
    {{--<div>--}}

        {{--<div class="portlet light ">--}}
            {{--<div class="portlet-title tabbable-line">--}}
                {{--<div class="caption">--}}
                    {{--<i class="icon-globe font-dark hide"></i>--}}
                    {{--<span class="caption-subject font-dark bold uppercase">Feeds</span>--}}
                {{--</div>--}}
                {{--<ul class="nav nav-tabs">--}}
                    {{--<li class="active">--}}
                        {{--<a href="#tab_1_1" class="active" data-toggle="tab"> System </a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="#tab_1_2" data-toggle="tab"> Private Lessons </a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{--<div class="portlet-body">--}}
                {{--<!--BEGIN TABS-->--}}
                {{--<div class="tab-content">--}}
                    {{--<div class="tab-pane active" id="tab_1_1">--}}
                        {{--<feeds :feeds="feeds" :base-url="baseUrl" :services-url="servicesUrl" :nps-targets="npsTargets" v-on:nps-created="npsCreatedAgainstFeed"></feeds>--}}
                    {{--</div>--}}
                    {{--<div class="tab-pane" id="tab_1_2">--}}
                        {{--<dashboard-private-lessons :private-lessons="privateLessons" :base-url="baseUrl" :services-url="servicesUrl" ></dashboard-private-lessons>--}}

                    {{--</div>--}}
                    {{--<!--END TABS-->--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

{{--</div>--}}
{{--@endif--}}

@canAccess('communication')

    <div class="col-md-12 col-sm-12"> @include('__partials.announcement_panel') </div>

@endif
<div class="clearfix"></div>
@canAccess('reservations')
<div class="" id ="vue-reservations-container">
  <div class="col-md-12">
    <div class="portlet light">
      <div class="portlet-title tabbable-line">
        <div class="caption"> <i class="icon-globe font-dark hide"></i> <span class="caption-subject font-dark bold uppercase">Pickleball Courts</span> </div>
      </div>
      <div id="error-bar" class="alert alert-warning " v-if="errorBarText" role="alert" v-cloak>@{{errorBarText}}</div>
      <div id="success-bar" class="alert alert-success " v-if="successBarText" role="alert" v-cloak>@{{successBarText}}</div>
      <reservations-container :courts="courts" :base-url="baseUrl" @error-message="errorMessageReceived" @success-message="successMessageReceived" :date-received="dateReceived"></reservations-container>
    </div>
    <!-- portlet --> 
  </div>
</div>
@endif

<div class="clearfix"></div>

    {{--@canAccess('restaurant')--}}
    {{--<div class="" id ="vue-messages-from-pos-container">--}}
        {{--<div class="col-md-12">--}}
            {{--<div class="portlet light">--}}
                {{--<div class="portlet-title tabbable-line">--}}
                    {{--<div class="caption"> <i class="icon-globe font-dark hide"></i> <span class="caption-subject font-dark bold uppercase">Messages From POS Client</span> </div>--}}
                {{--</div>--}}
                {{--<div id="error-bar" class="alert alert-warning " v-if="errorBarText" role="alert" v-cloak>@{{errorBarText}}</div>--}}
                {{--<div id="success-bar" class="alert alert-success " v-if="successBarText" role="alert" v-cloak>@{{successBarText}}</div>--}}
                {{--<messages-container :messages="messages" :base-url="baseUrl" @error-message="errorMessageReceived" @success-message="successMessageReceived"></messages-container>--}}
            {{--</div>--}}
            {{--<!-- portlet -->--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--<div class="clearfix"></div>--}}

<!--Datye-TimePicker--> 

@section('page-specific-scripts')
<link href="{{asset("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css")}}" rel="stylesheet" type="text/css" />
<script src="{{asset("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js")}}" type="text/javascript"></script> 
{{--@include('__partials.admin_checkin_notifications_js')--}}

        @canAccess('communication')

            @include('__partials.communication_announcement_js')

        @endif


              @include('__vue_components.reservations.reservations-container')
            @include('__vue_components.feeds.feeds')
        @include('__vue_components.private_lessons.dashboard-private-lessons')

        @canAccess('restaurant')

            @include('__vue_components.pos_messages.messages-container')

        @endif

    <script>
        @canAccess('reservations')
//				$('.datepicker').datetimepicker({
//					format: 'DD-MM-YYYY HH:mm:ss'
//				});
				  
                  var _courtsByDate = {!! json_encode($data) !!};
                  var _date = _courtsByDate.date;
                  var _courts = _courtsByDate.courts;
                  var _baseUrl = "{{url()}}";


                  var options = {
                      url: function(phrase) {
                          return _baseUrl+'/member/list?search=' + phrase ;
                      },
                      getValue: "name",
                      template: {
                          type: "description",
                          fields: {
                              description: "id"
                          }
                      },
                      list: {
                          match: {
                              enabled: true
                          }
                      },
                      theme: "plate-dark"
                  };


                  //_courts = prepareViewModelForCourts(_courts);

                  var vue = new Vue({
                      el:'#vue-reservations-container',
                      data:{

                          courts: null,
                          dateReceived:_date,
                          errorBarText:"",
                          successBarText:"",
                          bookingStatusFilterOptions:["Both","Booked","Vacant"],
                          bookingStatusFilterSelected:"Both",
                          noResultForFilter:false,
                          baseUrl:_baseUrl,

                      },
                      created:function(){

                            this.courts = this.prepareViewModelForCourts(_courts);

                      },
                      mounted: function() {
                          this.hideProgressRing();
                      },
                      methods: {

                          fetchReservationsDataForSelectedDate: function () {
                              showProgressRing();


                              var requestedDate = moment($('#date').val()).format('YYYY-MM-DD');
                              if (!moment(requestedDate).isValid()) {
                                  this.showErrorBar("Failed to load data for the specified date!");

                                  return;
                              }

                              var request = $.ajax({

                                  url: this.baseUrl + '/reservation/' + requestedDate,
                                  method: "GET",
                                  success: function (msg) {

                                      _courtsByDate = this.tryParseCourtsByDateAsJSON(msg);

                                      if (_courtsByDate !== null) {
                                          this.courts = _courtsByDate.courts;
                                          this.prepareViewModelForCourts();
                                          this.dateSelected = _courtsByDate.date;
                                          this.dateReceived = _courtsByDate.date;


                                          this.showSuccessBar("Data for the specified date loaded successfuly");


                                      } else {
                                          this.showErrorBar("Failed to load data for the specified date!");

                                      }

                                      Vue.nextTick(function () {
                                          Metronic.init();
                                      });
                                      hideProgressRing();
                                  }.bind(this),

                                  error: function (jqXHR, textStatus) {
                                      console.log("Request failed: " + textStatus);
                                      hideProgressRing();
                                  }
                              });


                          },
                          showSuccessBar: function (successBarText) {
                              this.successBarText = successBarText;
                              this.errorBarText = "";
                              console.log(this.errorBarText);
                          },
                          showErrorBar: function (errorBarText) {
                              this.successBarText = "";
                              this.errorBarText = errorBarText;
                          },
                          successMessageReceived: function (message) {
                              this.showSuccessBar(message);
                          },
                          errorMessageReceived: function (message) {
                              this.showErrorBar(message);
                          },
                          prepareViewModelForCourts: function (courts) {

                              for (courtCount = 0; courtCount < courts.length; courtCount++) {

                                  for (timeSlotCount = 0; timeSlotCount < courts[courtCount].reservations.length; timeSlotCount++) {

                                      if (!(courts[courtCount].reservations[timeSlotCount].reservations.length > 0)) {
                                          courts[courtCount].reservations[timeSlotCount].reservations[0] = {};
                                      }
                                      courts[courtCount].reservations[timeSlotCount].reservations[0].reservation_type = "";
                                      courts[courtCount].reservations[timeSlotCount].reservations[0].captionsRowVisible = true;
                                      courts[courtCount].reservations[timeSlotCount].reservations[0].visibleBasedOnBookingStatusFilter = true;
                                      courts[courtCount].reservations[timeSlotCount].reservations[0].playersForBinding = [];

                                      for (playerCount = 0; playerCount < 4; playerCount++) {

                                          courts[courtCount].reservations[timeSlotCount].reservations[0].playersForBinding[playerCount] = courts[courtCount].reservations[timeSlotCount].reservations[0].reservationPlayers != null && courts[courtCount].reservations[timeSlotCount].reservations[0].reservationPlayers[playerCount] != null ? {
                                              tennisReservationPlayerId: courts[courtCount].reservations[timeSlotCount].reservations[0].reservationPlayers[playerCount].tennis_reservation_player_id,
                                              playerId: courts[courtCount].reservations[timeSlotCount].reservations[0].reservationPlayers[playerCount].player_id,
                                              playerName: courts[courtCount].reservations[timeSlotCount].reservations[0].reservationPlayers[playerCount].player_name
                                          } : {tennisReservationPlayerId: "", playerId: "", playerName: ""};

                                      }


                                  }


                              }

                              return courts;

                          },
                          tryParseCourtsByDateAsJSON: function (reponse) {
                              if (typeof(reponse) === "object") {

                                  if (reponse.hasOwnProperty('date') && reponse.date != "") {
                                      return reponse;

                                  } else {

                                      return null;
                                  }
                              } else {

                                  return null;
                              }
                          },
                          showProgressRing: function() {
                              $(".preLoader").fadeIn("fast");
                          },
                          hideProgressRing: function() {
                              $(".preLoader").fadeOut("fast");
                          }

                      }


                  });

        @endif
                  function showProgressRing(){
                      $(".se-pre-con").fadeIn("fast");
                  }

                  function hideProgressRing(){
                      $(".se-pre-con").fadeOut("fast");
                  }


    @canAccess('restaurant')


        var vueMessagesFromPOS = new Vue({
            el:'#vue-messages-from-pos-container',
            data:{

                messages: {!! json_encode($messagesFromPos) !!},
                errorBarText:"",
                successBarText:"",
                baseUrl:"{{url()}}",

            },
            mounted: function() {
                this.hideProgressRing();
            },
            methods: {

                fetchReservationsDataForSelectedDate: function () {
                    showProgressRing();


                    var requestedDate = moment($('#date').val()).format('YYYY-MM-DD');
                    if (!moment(requestedDate).isValid()) {
                        this.showErrorBar("Failed to load data for the specified date!");

                        return;
                    }

                    var request = $.ajax({

                        url: this.baseUrl + '/reservation/' + requestedDate,
                        method: "GET",
                        success: function (msg) {

                            _courtsByDate = this.tryParseCourtsByDateAsJSON(msg);

                            if (_courtsByDate !== null) {
                                this.courts = _courtsByDate.courts;
                                this.prepareViewModelForCourts();
                                this.dateSelected = _courtsByDate.date;
                                this.dateReceived = _courtsByDate.date;


                                this.showSuccessBar("Data for the specified date loaded successfuly");


                            } else {
                                this.showErrorBar("Failed to load data for the specified date!");

                            }

                            Vue.nextTick(function () {
                                Metronic.init();
                            });
                            hideProgressRing();
                        }.bind(this),

                        error: function (jqXHR, textStatus) {
                            console.log("Request failed: " + textStatus);
                            hideProgressRing();
                        }
                    });


                },
                showSuccessBar: function (successBarText) {
                    this.successBarText = successBarText;
                    this.errorBarText = "";
                    console.log(this.errorBarText);
                },
                showErrorBar: function (errorBarText) {
                    this.successBarText = "";
                    this.errorBarText = errorBarText;
                },
                successMessageReceived: function (message) {
                    this.showSuccessBar(message);
                },
                errorMessageReceived: function (message) {
                    this.showErrorBar(message);
                },
                showProgressRing: function() {
                    $(".preLoader").fadeIn("fast");
                },
                hideProgressRing: function() {
                    $(".preLoader").fadeOut("fast");
                }

            }


        });

     @endif





        @canAccess('trainings')
             var vueFeeds = new Vue({
                    el:'#vue-feeds-container',
                    data:{

                        baseUrl:"{{url()}}",
                        servicesUrl:'{{env('REST_API')}}',
                        feeds:{!! json_encode($feeds) !!},
                        npsTargets:{!! json_encode(Config::get('global.nps_targets')) !!},
                        privateLessons:{!! json_encode($privateLessons) !!},

                    },
                    mounted: function() {

                    },
                    methods: {
                        npsCreatedAgainstFeed:function(e){
                            for(feedIndex in this.feeds){
                                if(this.feeds[feedIndex].id == e ){
                                    this.feeds.splice(feedIndex,1);
                                    break;
                                }
                            }
                        }

                    }


                });
        @endif



    </script>
@endsection

 @stop