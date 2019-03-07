@extends('__layouts.admin') @section('main')

<!-- BEGIN PAGE HEADER-->
<div id="vue-reservations-container">
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li><i class="fa fa-home"></i> <a href="#">Home</a> <i
						class="fa fa-angle-right"></i></li>
			<li><a href="{{url('/reservation')}}">Reservations</a></li>
		</ul>
		<div class="page-toolbar">
			<div id="" class="pull-right tooltips btn btn-fit-height" data-placement="top" data-original-title="Search Members">
				<div class="input-icon right">
					<i class="icon-calendar"></i>
					<input type="text" class="form-control form-control-inline input-medium date-picker input-circle" id="courtDateUpdate" placeholder="Select Date" >
				</div>
			</div>
		</div>
	</div>

	<h1 class="page-title">
		Reservations
	</h1>
	<!-- END PAGE HEADER-->
	<div class="clearfix"></div>
	<div id="error-bar" class="alert alert-warning " v-if="errorBarText" role="alert" v-cloak>@{{errorBarText}}</div>
	<div id="success-bar" class="alert alert-success " v-if="successBarText" role="alert" v-cloak>@{{successBarText}}</div>

	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
				<reservations-container :courts="courts" :base-url="baseUrl" @error-message="errorMessageReceived" @success-message="successMessageReceived" :date-received="dateReceived"></reservations-container>
			</div><!-- portlet -->
		</div>
	</div>
</div>



@section('page-specific-scripts')
	<link href="{{asset("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css")}}" rel="stylesheet" type="text/css" />
	<script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")}}" type="text/javascript"></script>
	<script src="{{asset("assets/pages/scripts/components-date-time-pickers.min.js")}}" type="text/javascript"></script>
	<link href="{{asset("assets/global/plugins/pace/themes/pace-theme-flash.css")}}" rel="stylesheet" type="text/css" />

@include('__vue_components.reservations.reservations-container')
<script>

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
		mounted:function() {
            $('#courtDateUpdate').datepicker()
			.on('changeDate', function(e) {
				vue.fetchReservationsDataForSelectedDate();
			});
            this.hideProgressRing();
		},
		methods: {

			fetchReservationsDataForSelectedDate: function () {
				this.showProgressRing();
				console.log("fetch reservations called");

				var requestedDate = moment($('#courtDateUpdate').val()).format('YYYY-MM-DD');
                console.log(requestedDate);
				if (!moment(requestedDate).isValid()) {
					this.showErrorBar("Failed to load data for the specified date!");

					return;
				}

				var request = $.ajax({

					url: this.baseUrl + '/reservation/' + requestedDate,
					method: "GET",
					success: function (msg) {

						_courtsByDate = this.tryParseCourtsByDateAsJSON(msg);
						console.log(msg);
						if (_courtsByDate !== null) {
							this.courts = this.prepareViewModelForCourts(_courtsByDate.courts);

							this.dateSelected = _courtsByDate.date;
							this.dateReceived = _courtsByDate.date;


							this.showSuccessBar("Data for the specified date loaded successfuly");


						} else {
							this.showErrorBar("Failed to load data for the specified date!");

						}

//						Vue.nextTick(function () {
//							Metronic.init();
//						});
						this.hideProgressRing();
					}.bind(this),

					error: function (jqXHR, textStatus) {
						console.log("Request failed: " + textStatus);
						this.hideProgressRing();
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

						//console.log(courts[courtCount].reservations[timeSlotCount].reservations[0].reservation_type == "");
						if(!courts[courtCount].reservations[timeSlotCount].reservations[0].hasOwnProperty('reservation_type')){

							courts[courtCount].reservations[timeSlotCount].reservations[0].reservation_type = "";
						}

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



</script>

@endSection


@stop


