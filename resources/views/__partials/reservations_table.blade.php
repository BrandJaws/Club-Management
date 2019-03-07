<div id ="error-bar" class="alert alert-warning " v-if="errorBarVisible" role="alert" v-cloak >@{{errorBarText}}</div>
<div id ="success-bar" class="alert alert-success " v-if="successBarVisible" role="alert" v-cloak>@{{successBarText}}</div>

<div class="row" v-cloak>
        <div class="col-md-12">
          <div class="tennis-courts" id="reservation-tennis"> 
            
            <!-- Nav tabs -->
            <div class="tabbable-custom">
                <ul class="nav nav-tabs" role="tablist" >
                    <li v-for="(court,courtIndex) in courts" role="presentation" :class="courtIndex == 0 ? 'active' : null "><a :href="'#c'+court.court_id" :aria-controls="'c'+court.court_id" role="tab" data-toggle="tab" >@{{court.court_name}}</a></li>
                </ul>
            </div>
            <!-- Tab panes -->
            <div class="tab-content" >
             <!--  preloader -->
				<div class="preloader-icon"></div>
              <div v-for="(court,courtIndex) in courts" role="tabpanel" :class="[courtIndex == 0 ? 'active' : null,'tab-pane']"  :id="'c'+court.court_id">
              <div class="scroller" style="height: 500px;" data-always-visible="1" data-rail-visible="0">
                <div class="bs-example " data-example-id="contextual-table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Time</th>
                        <th>Player 1</th>
                        <th>Player 2</th>
                        <th>Player 3</th>
                        <th>Player 4</th>
                        <th>
                          <div v-cloak>
                            <select class="form-control" @change="bookingFilterSelectionChanged" v-model="bookingStatusFilterSelected">
                              <option v-for="filterOption in bookingStatusFilterOptions">@{{filterOption}}</option>
                            </select>
                          </div>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(reservation,index) in court.reservations" v-if="reservation.reservations[0].captionsRowVisible && reservation.reservations[0].visibleBasedOnBookingStatusFilter" class="" data-tennis-reservation-id="" :key="index">
                        <th scope="row">@{{reservation.timeSlot }}</th>
                        <td class="" v-for="player in reservation.reservations[0].playersForBinding">@{{player.playerName }}</td>
                       
                        <td class=""><a class="editButton label label-primary" title="Edit" @click="editButtonClicked(reservation.reservations[0])"><i class="fa fa-pencil"></i></a> &nbsp;</td>
                    </tr>
                    <tr  class="" v-else  v-if="reservation.reservations[0].visibleBasedOnBookingStatusFilter">
                         <th scope="row">@{{reservation.timeSlot }}</th>
                         <td class="active-def" v-for="(player,playerIndex) in reservation.reservations[0].playersForBinding"><input class="form-control autocomplete-input" v-model="player.playerName" type="text" @input="playerValueChanged(reservation.reservations[0],playerIndex,$event)" :data-player-name="player.playerName" :data-player-id="player.playerId" ></td>
                        
                         <td class="active-def"><a @click="cancelButtonClicked(reservation.reservations[0])" class="cancelButton label label-success-gray"><i class="fa fa-ban"></i></a>&nbsp;<a class="saveButton label label-success-green" title="Save" @click="saveButtonClicked(reservation,court.club_id,court.court_id)"><i class="fa fa-floppy-o"></i></a>&nbsp;<a class="deleteButton  label label-danger" @click="sendDeleteReservationRequest(reservation.reservations[0])"><i class="fa fa-trash"></i></a></td> 
                     </tr>
                      <tr  v-if="noResultForFilter" class="" >
                      	
                        <td  colspan="6" style="text-align:center;">No results available for the selected filter</td>
                       
                      </tr>
                   
                     
                    </tbody>
                  </table>
                  
                </div>
              
              </div>
              </div>
              <!-- court 1 ends here -->
              
            </div>
          </div>
        </div>
      </div>