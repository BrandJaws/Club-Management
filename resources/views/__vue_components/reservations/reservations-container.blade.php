<template id="reservationsContainerTemplate">
	<div class="tennis-courts" id="reservation-tennis">
		<div class="preLoader">
			<div class="sk-cube-grid">
				<div class="sk-cube sk-cube1"></div>
				<div class="sk-cube sk-cube2"></div>
				<div class="sk-cube sk-cube3"></div>
				<div class="sk-cube sk-cube4"></div>
				<div class="sk-cube sk-cube5"></div>
				<div class="sk-cube sk-cube6"></div>
				<div class="sk-cube sk-cube7"></div>
				<div class="sk-cube sk-cube8"></div>
				<div class="sk-cube sk-cube9"></div>
			</div>
		</div>
		<!-- Nav tabs -->
		<div class="tabbable-line">
			<ul class="nav nav-tabs" role="tablist">
				
				<li v-for="(court,courtIndex) in courts" role="presentation"
				    :class="courtIndex == 0 ? 'active' : null "><a :href="'#c'+court.court_id"
				                                                   :aria-controls="'c'+court.court_id" role="tab"
				                                                   data-toggle="tab">@{{court.court_name}}</a></li>
			
			
			</ul>
		</div>
		<!-- Tab panes -->
		<div class="tab-content">
			<!--  preloader -->
			<div class="preloader-icon"></div>
			<div v-for="(court,courtIndex) in courts" role="tabpanel"
			     :class="[courtIndex == 0 ? 'active' : null,'tab-pane']" :id="'c'+court.court_id">
				<div class="scroller" style="height: 500px;" data-always-visible="1" data-rail-visible="0">
					<div class="bs-example " data-example-id="contextual-table">
						<table class="table table-hover reservationsTabelVue">
							<thead>
							<tr>
								<th style="width: 95px;">Time</th>
								<th>Name</th>
								<th>Email</th>
								<th>Checkout Method</th>
								<th style="width: 141px;">
									<div>
										<select class="form-control input-circle input-sm"
										        @change="bookingFilterSelectionChanged" v-model
										        ="bookingStatusFilterSelected">
											<option
												v-for="filterOption in bookingStatusFilterOptions">@{{filterOption}}
											</option>
										</select>
									</div>
								</th>
							</tr>
							</thead>
							<tbody v-for="(reservation,index) in court.reservations">
							
							<tr v-if="reservationIsNotRoutineTennisReservation(reservation)">
								<td scope="row">@{{reservation.timeSlot }}
								</th>
								<td colspan="5" class="text-center">Booked For A Different Category</td>
							</tr>
							<tr v-else-if="reservation.reservations[0].captionsRowVisible && reservation.reservations[0].visibleBasedOnBookingStatusFilter"
							    class="" data-tennis-reservation-id="" :key="index">
								<td scope="row">@{{reservation.timeSlot }}
								</th>
								<td class="">
									@{{reservation.reservations[0].customerName}}
								</td>
								<td class="">
									@{{reservation.reservations[0].email}}
								</td>
								<td class="">
									@{{reservation.reservations[0].checkoutMethod}}
								</td>
								<td class="">
									{{--@{{reservation.reservations[0].customerName}}--}}
								</td>
								
								{{--<td class="text-center">--}}
									{{--<a class="btn btn-outline btn-circle btn-sm red csEditBtn" title="Edit" @click="editButtonClicked(reservation.reservations[0])"><i class="fa fa-pencil"></i> Edit</a>--}}
								{{--</td>--}}
							</tr>
							<tr v-else-if="reservation.reservations[0].visibleBasedOnBookingStatusFilter">
								<td scope="row">@{{reservation.timeSlot }}
								</th>
								<td class="active-def" v-for="(player,playerIndex) in reservation.reservations[0].playersForBinding">
									{{--<input class="form-control autocomplete-input input-sm" v-model="player.playerName"--}}
									       {{--type="text" @input="--}}
                                                            {{--playerValueChanged(reservation.reservations[0],playerIndex,$event)"--}}
									       {{--:data-player-name="player.playerName" :data-player-id="player.playerId">--}}
									@{{ player.playerName }}
								</td>
								
								<td class="active-def">
									<div class="text-center">
										<a @click="cancelButtonClicked(reservation.reservations[0])"
										   class="btn btn-outline btn-circle btn-sm red-thunderbird"><i
												class="fa fa-ban"></i></a>
										<a class="btn btn-outline btn-circle btn-sm green-jungle" title="Save"
										   @click="saveButtonClicked(reservation,court.club_id,court.court_id)"><i
												class="fa fa-floppy-o"></i></a>
										<a class="btn btn-outline btn-circle btn-sm red"
										   @click="sendDeleteReservationRequest(reservation.reservations[0])"><i
												class="fa fa-trash"></i></a>
									</div>
								</td>
							</tr>
							
							
							</tbody>
							<tbody>
							<tr v-if="noResultForFilter" class="">
								
								<td colspan="6" style="text-align:center;">No results available for the selected
									filter
								</td>
							
							</tr>
							</tbody>
						</table>
					
					</div>
				
				</div>
			</div>
			<!-- court 1 ends here -->
		
		</div>
	</div>

</template>
<script>

	Vue.component('reservations-container', {


		template: "#reservationsContainerTemplate",
		props: [

			"courts",
			"baseUrl",
			"dateReceived"


		],
		data: function () {

			return {

				bookingStatusFilterOptions: ["Both", "Booked", "Vacant"],
				bookingStatusFilterSelected: "Both",
				noResultForFilter: false
			}
		},
		methods: {
			editButtonClicked: function (reservation) {

				reservation.temp = JSON.stringify(reservation.playersForBinding);
				reservation.captionsRowVisible = false;
				reservation.visibleBasedOnFilter = true;

				Vue.nextTick(function () {
					$(".autocomplete-input").easyAutocomplete(options);
				});

				//vue.data.reservationsList[x].captionsRowVisible = false;


			},
			cancelButtonClicked: function (reservation) {

				reservation.playersForBinding = JSON.parse(reservation.temp);
				reservation.temp = null;
				reservation.captionsRowVisible = true;
				reservation.inputRowVisible = false;


			},
			saveButtonClicked: function (reservation, clubId, courtId) {


				if (reservation.reservations[0].tennis_reservation_id == null) {
					this.sendNewReservationRequest(reservation.reservations[0], reservation.timeSlot, clubId, courtId);
				} else {

					this.sendUpdateReservationRequest(reservation.reservations[0]);
				}

			},
			sendNewReservationRequest: function (reservation, timeSlot, clubId, courtId) {

				this.showProgressRing();
				var _time = timeSlot;

				var reservedAt = moment(this.dateReceived).format('YYYY-MM-DD');

				// Players for new reservation
				var _players = [reservation.playersForBinding[0].playerId,
					reservation.playersForBinding[1].playerId,
					reservation.playersForBinding[2].playerId,
					reservation.playersForBinding[3].playerId];


				var request = $.ajax({
					url: this.baseUrl + '/reservation',
					method: "POST",
					data: {
						club_id: clubId,
						court_id: courtId,
						time: _time,
						reserved_at: reservedAt,
						player: _players,
						parent_id: _players[0],
						dataType: "html"
					},
					success: function (msg) {

						newReservation = this.tryParseReservationAsJSON(msg);
						if (newReservation !== null) {

							this.updateReservationRowWithNewData(newReservation);
							this.$emit('success-message', "Successfuly added a new reservation");
							reservation.captionsRowVisible = true;


						} else {

							this.$emit('error-message', msg);


						}
						this.hideProgressRing();

					}.bind(this),
					error: function (msg) {

						hideProgressRing()

					}.bind(this),
				});

			},
			sendUpdateReservationRequest: function (reservation) {
				this.showProgressRing();
				var tennisReservationId = reservation.tennis_reservation_id;

				//Players for updation of reservation
				var _players = [reservation.playersForBinding[0].playerId,
					reservation.playersForBinding[1].playerId,
					reservation.playersForBinding[2].playerId,
					reservation.playersForBinding[3].playerId];


				var request = $.ajax({
					url: this.baseUrl + '/reservation',
					method: "POST",
					data: {
						_method: "PUT",
						tennis_reservation_id: tennisReservationId,
						player: _players,
						parent_id: reservation.playersForBinding[0].playerId,
						dataType: "html"
					},
					success: function (msg) {

						updatedReservation = this.tryParseReservationAsJSON(msg);
						if (updatedReservation !== null) {

							this.updateReservationRowWithNewData(updatedReservation);
							this.reAssessReservationVisibiltyBasedOnBookingStatus();
							this.$emit('success-message', "Successfuly updated reservation");

							reservation.captionsRowVisible = true;


						} else {
							this.$emit('error-message', msg);

						}
						this.hideProgressRing();
					}.bind(this),
					error: function (jqXHR, textStatus) {
						console.log("Request failed: " + textStatus);
						this.hideProgressRing();
					}
				});
			},
			sendDeleteReservationRequest: function (reservation) {

				this.showProgressRing();
				var tennisReservationId = reservation.tennis_reservation_id;

				var request = $.ajax({
					url: this.baseUrl + '/reservation/' + tennisReservationId,
					method: "POST",
					data: {
						_method: "DELETE",
						dataType: "html"
					},
					success: function (msg) {

						deletedReservation = this.tryParseReservationAsJSON(msg);
						if (deletedReservation !== null) {

							this.clearReservationRowOnDeletion(deletedReservation);
							this.reAssessReservationVisibiltyBasedOnBookingStatus();
							this.$emit('success-message', "Successfuly cancelled reservation");

							reservation.captionsRowVisible = true;


						} else {
							this.$emit('error-message', msg);

						}

						this.hideProgressRing();
					}.bind(this),
					error: function (jqXHR, textStatus) {
						console.log("Request failed: " + textStatus);
						this.hideProgressRing();
					}
				});


			},
			updateReservationRowWithNewData: function (newData) {

				courts = this.courts;

				if (newData.date == this.dateReceived) {
					for (courtCount = 0; courtCount < courts.length; courtCount++) {

						if (courts[courtCount].court_id == newData.court_id) {
							for (timeSlotCount = 0; timeSlotCount < courts[courtCount].reservations.length; timeSlotCount++) {
								if (courts[courtCount].reservations[timeSlotCount].timeSlot == newData.time_start) {

									var reservation = courts[courtCount].reservations[timeSlotCount].reservations[0];

									reservation.tennis_reservation_id = newData.id;

									reservation.reservationPlayers = [];
									reservation.playersForBinding = [];
									for (newPlayersCount = 0; newPlayersCount < newData.players.length; newPlayersCount++) {

										reservation.reservationPlayers[newPlayersCount] = {
											tennis_reservation_player_id: newData.players[newPlayersCount].tennis_reservation_player_id,
											playerId: newData.players[newPlayersCount].player_id,
											playerName: newData.players[newPlayersCount].firstName + " " + newData.players[newPlayersCount].lastName
										};
									}
									for (playerCount = 0; playerCount < 4; playerCount++) {

										reservation.playersForBinding[playerCount] = reservation.reservationPlayers[playerCount] ? {
											tennisReservationPlayerId: reservation.reservationPlayers[playerCount].tennis_reservation_player_id,
											playerId: reservation.reservationPlayers[playerCount].playerId,
											playerName: reservation.reservationPlayers[playerCount].playerName
										} : {tennisReservationPlayerId: "", playerId: "", playerName: ""};

									}

									break;
								}
							}
						}
					}
				}
			},
			clearReservationRowOnDeletion: function (deletedReservation) {
				courts = this.courts;
				if (deletedReservation.date == this.dateReceived) {
					for (courtCount = 0; courtCount < courts.length; courtCount++) {

						if (courts[courtCount].court_id == deletedReservation.court_id) {
							for (timeSlotCount = 0; timeSlotCount < courts[courtCount].reservations.length; timeSlotCount++) {
								if (courts[courtCount].reservations[timeSlotCount].reservations[0].tennis_reservation_id == deletedReservation.id) {

									var reservation = courts[courtCount].reservations[timeSlotCount].reservations[0];

									reservation.reservationPlayers = [];
									reservation.playersForBinding = [];
									reservation.tennis_reservation_id = null;
									// reservation.reservationInfo.time_start = null;
									// reservation.reservationInfo.time_end = null;

									for (playerCount = 0; playerCount < 4; playerCount++) {

										reservation.playersForBinding[playerCount] = {
											tennisReservationPlayerId: "",
											playerId: "",
											playerName: ""
										};

									}

									break;
								}
							}
						}
					}
				}
			},
			playerValueChanged: function (reservation, playerIndex, event) {


				var inputField = $(event.target);


				if (inputField.attr("data-player-name") === inputField.val()) {
					reservation.playersForBinding[playerIndex].playerName = inputField.attr("data-player-name");
					reservation.playersForBinding[playerIndex].playerId = inputField.attr("data-player-id");
				} else {

					reservation.playersForBinding[playerIndex].playerId = "";
				}


			},
			bookingFilterSelectionChanged: function () {

				this.reAssessReservationVisibiltyBasedOnBookingStatus();
			},
			reAssessReservationVisibiltyBasedOnBookingStatus: function () {

				visibleRowsCount = 0;
				for (courtCount = 0; courtCount < this.courts.length; courtCount++) {

					for (timeSlotCount = 0; timeSlotCount < this.courts[courtCount].reservations.length; timeSlotCount++) {

						if (this.courts[courtCount].reservations[timeSlotCount].reservations[0].tennis_reservation_id != null) {
							if (this.bookingStatusFilterSelected == this.bookingStatusFilterOptions[0] || this.bookingStatusFilterSelected == this.bookingStatusFilterOptions[1]) {
								this.courts[courtCount].reservations[timeSlotCount].reservations[0].visibleBasedOnBookingStatusFilter = true;
								visibleRowsCount++;
							} else if (this.bookingStatusFilterSelected == this.bookingStatusFilterOptions[2]) {
								this.courts[courtCount].reservations[timeSlotCount].reservations[0].visibleBasedOnBookingStatusFilter = false;
							}

						} else {

							if (this.bookingStatusFilterSelected == this.bookingStatusFilterOptions[0] || this.bookingStatusFilterSelected == this.bookingStatusFilterOptions[2]) {
								this.courts[courtCount].reservations[timeSlotCount].reservations[0].visibleBasedOnBookingStatusFilter = true;
								visibleRowsCount++;
							} else if (this.bookingStatusFilterSelected == this.bookingStatusFilterOptions[1]) {
								this.courts[courtCount].reservations[timeSlotCount].reservations[0].visibleBasedOnBookingStatusFilter = false;
							}
						}

					}


				}

				if (visibleRowsCount == 0) {
					this.noResultForFilter = true;
				} else {
					this.noResultForFilter = false;
				}

			},
			tryParseReservationAsJSON: function (reponse) {

				if (typeof (reponse) === "object") {
					if (reponse.hasOwnProperty('club_id') && reponse.club_id !== "") {

						return reponse;

					} else {

						return null;
					}
				} else {

					return null;

				}

			},
			reservationIsNotRoutineTennisReservation: function (reservation) {
				return (reservation.reservations[0].reservation_type != '' && reservation.reservations[0].reservation_type != 'TennisReservation');
			},
			showProgressRing: function () {
				$(".preLoader").fadeIn("fast");
			},
			hideProgressRing: function () {
				$(".preLoader").fadeOut("fast");
			}
		},
		watch: {

			courts: function (val) {

				this.reAssessReservationVisibiltyBasedOnBookingStatus();


			},


		}

	});


</script>
