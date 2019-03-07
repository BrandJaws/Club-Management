var options = {
      url: function(phrase) {
                return baseUrl+'/member/list?search=' + phrase ;
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

/*
if(requestForReservationsPage){
  _courts = prepareViewModelForCourts(_courts);
}
*/
var vue = new Vue({
    el:'#vue-reservations-container',
    data:{
      firstLoad:true,
      courts: [],
      dateSelected:_date,
      dateReceived:_date,
      errorBarVisible:false,
      errorBarText:"",
      successBarVisible:false,
      successBarText:"",
      bookingStatusFilterOptions:["Both","Booked","Vacant"],
      bookingStatusFilterSelected:"Both",
      noResultForFilter:false
      
    },
    methods:{
    editButtonClicked:function(reservation){
      
      reservation.temp = JSON.stringify(reservation.playersForBinding);
      reservation.captionsRowVisible = false;
      reservation.visibleBasedOnFilter = true;
       
          Vue.nextTick(function() {
            $(".autocomplete-input").easyAutocomplete(options);
            });
        
            //vue.data.reservationsList[x].captionsRowVisible = false;
           
        
    },
    cancelButtonClicked:function(reservation){
      
      reservation.playersForBinding = JSON.parse(reservation.temp);
      reservation.temp = null;
      reservation.captionsRowVisible = true;
      reservation.inputRowVisible = false;

           
        
    },
    saveButtonClicked:function(reservation,clubId,courtId){
      
     
      
      if(reservation.reservations[0].tennis_reservation_id == null){
        this.sendNewReservationRequest(reservation.reservations[0],reservation.timeSlot,clubId,courtId);
      }else{
      
        this.sendUpdateReservationRequest(reservation.reservations[0]);
      }
        
    },
    sendNewReservationRequest:function(reservation,timeSlot,clubId,courtId){
      
      showProgressRing();
      var _time = timeSlot;
      //console.log(_time);
      //return;
      var reservedAt = dateFrommddYYYYtoYYYYmmdd(this.dateReceived);

        // Players for new reservation   
      var _players = [reservation.playersForBinding[0].playerId,
                      reservation.playersForBinding[1].playerId,
                      reservation.playersForBinding[2].playerId,
                      reservation.playersForBinding[3].playerId];
     
            
                   
        var request = $.ajax({
          url: baseUrl+'/reservation',
          method: "POST",
          data: { club_id : clubId, 
                  court_id:courtId, 
                  time:_time, 
                  reserved_at:reservedAt, 
                  player: _players ,
                  parent_id:_players[0],
                  dataType: "html"
                },
          success: function(msg){
                
                 newReservation = tryParseReservationAsJSON(msg);
                 if(newReservation !== null){
                    
                    this.updateReservationRowWithNewData(newReservation);
                    this.successBarText = "Successfuly added a new reservation";
                    this.successBarVisible = true;
                    this.errorBarVisible = false;
                    reservation.captionsRowVisible = true;
                   
                    
                }else{
                    this.errorBarText = msg;
                    this.errorBarVisible = true;
                    this.successBarVisible = false;
              
                }
                hideProgressRing();

          }.bind(this),
          error: function(msg){
              
              hideProgressRing()

          }.bind(this),
        });

    },
    sendUpdateReservationRequest:function(reservation){
      showProgressRing();
      var tennisReservationId = reservation.tennis_reservation_id;
       
        //Players for updation of reservation
      var _players = [reservation.playersForBinding[0].playerId,
                      reservation.playersForBinding[1].playerId,
                      reservation.playersForBinding[2].playerId,
                      reservation.playersForBinding[3].playerId];
       
      
      
      
        var request = $.ajax({
          url: baseUrl+'/reservation',
          method: "POST",
          data: { 
                  _method:"PUT",
                  tennis_reservation_id:tennisReservationId,
                  player: _players ,
                  parent_id:reservation.playersForBinding[0].playerId,
                  dataType: "html"
                },
          success: function(msg){
                    console.log();
                     updatedReservation = tryParseReservationAsJSON(msg);
                     if(updatedReservation !== null){
                        
                        this.updateReservationRowWithNewData(updatedReservation);
                        this.reAssessReservationVisibiltyBasedOnBookingStatus();
                        this.successBarText = "Successfuly updated reservation";
                        this.successBarVisible = true;
                        this.errorBarVisible = false;
                        reservation.captionsRowVisible = true;
                       
                        
                      }else{
                          this.errorBarText = msg;
                          this.errorBarVisible = true;
                          this.successBarVisible = false;
                    
                      }
                      hideProgressRing();
                 }.bind(this),
          error: function(jqXHR, textStatus ) {
                    console.log( "Request failed: " + textStatus );
                    hideProgressRing();
              }
        });   
    },
    sendDeleteReservationRequest: function(reservation){
        
        showProgressRing();
        var tennisReservationId = reservation.tennis_reservation_id;
        
        var request = $.ajax({
          url: baseUrl+'/reservation/'+tennisReservationId,
          method: "POST",
          data: { 
                  _method:"DELETE",
                  dataType: "html"
                },
          success: function(msg){

                     deletedReservation = tryParseReservationAsJSON(msg);
                     if(deletedReservation !== null){

                      this.clearReservationRowOnDeletion(deletedReservation);
                      this.reAssessReservationVisibiltyBasedOnBookingStatus();
                      this.successBarText = "Successfuly cancelled reservation";
                      this.successBarVisible = true;
                      this.errorBarVisible = false;
                      reservation.captionsRowVisible = true;


                    }else{
                      this.errorBarText = msg;
                      this.errorBarVisible = true;
                      this.successBarVisible = false;

                    }
                   
                   hideProgressRing();
                }.bind(this),
          error: function(jqXHR, textStatus ) {
                    console.log( "Request failed: " + textStatus );
                    hideProgressRing();
                }
        });    
      

    },
    fetchReservationsDataForSelectedDate: function()  {
        showProgressRing();
        var request = $.ajax({

          url: baseUrl+'/reservation/'+dateFrommddYYYYtoYYYYmmdd($('#date').val()),
          method: "GET",
          success:function(msg){
                
                   _courtsByDate = tryParseCourtsByDateAsJSON(msg);
                  console.log(msg);
                   if(_courtsByDate !== null){
                      this.courts = prepareViewModelForCourts(_courtsByDate.courts);
                      this.reAssessReservationVisibiltyBasedOnBookingStatus();
                      this.dateSelected = _courtsByDate.date;
                      this.dateReceived = _courtsByDate.date;
                      //To make sure that doesnt show success message on pages that dont get prefilled reservations data
                      
                      if(!this.firstLoad){
                         this.successBarText = "Data for the specified date loaded successfuly";
                         this.successBarVisible = true;
                         this.errorBarVisible = false;
                     
                      }else{
                        this.firstLoad = false;
                      }
                     
                   
                    }else{
                      this.errorBarText = "Failed to load data for the specified date!";
                      this.errorBarVisible = true;
                      this.successBarVisible = false;
                        
                    }
                
                  Vue.nextTick(function(){
                    Metronic.init();
                  });
                  hideProgressRing();
                }.bind(this),

          error: function(jqXHR, textStatus ) {
               console.log( "Request failed: " + textStatus );
               hideProgressRing();
          }
        }); 

       
       
    },
    updateReservationRowWithNewData: function(newData){
     console.log(newData);
       courts = this.courts;
       if(newData.date == this.dateReceived){
        for(courtCount=0; courtCount<courts.length; courtCount++){

          if(courts[courtCount].court_id == newData.court_id){
            for(timeSlotCount=0; timeSlotCount<courts[courtCount].reservations.length; timeSlotCount++ ){
             if(courts[courtCount].reservations[timeSlotCount].timeSlot == newData.time_start){
               
              var reservation = courts[courtCount].reservations[timeSlotCount].reservations[0];
              reservation.tennis_reservation_id = newData.id;
              reservation.reservationPlayers = [];
              reservation.playersForBinding = [];
              for(newPlayersCount = 0; newPlayersCount<newData.players.length; newPlayersCount++){
                  console.log(newData.players[newPlayersCount].firstName + " "+newData.players[newPlayersCount].lastName);
               reservation.reservationPlayers[newPlayersCount] = {tennis_reservation_player_id:newData.players[newPlayersCount].tennis_reservation_player_id, playerId:newData.players[newPlayersCount].player_id,playerName:newData.players[newPlayersCount].firstName + " "+newData.players[newPlayersCount].lastName};
             }
             for(playerCount=0; playerCount<4; playerCount++){

              reservation.playersForBinding[playerCount] = reservation.reservationPlayers[playerCount] ? {tennisReservationPlayerId:reservation.reservationPlayers[playerCount].tennis_reservation_player_id,playerId:reservation.reservationPlayers[playerCount].playerId, playerName:reservation.reservationPlayers[playerCount].playerName} : {tennisReservationPlayerId:"",playerId:"", playerName:""} ;

            }
            
            break;
          }
        }
      }
    }
  }
},
clearReservationRowOnDeletion: function(deletedReservation){
       courts = this.courts;
       if(deletedReservation.date == this.dateReceived){
        for(courtCount=0; courtCount<courts.length; courtCount++){

          if(courts[courtCount].court_id == deletedReservation.court_id){
            for(timeSlotCount=0; timeSlotCount<courts[courtCount].reservations.length; timeSlotCount++ ){
             if(courts[courtCount].reservations[timeSlotCount].reservations[0].tennis_reservation_id == deletedReservation.id){
              
              var reservation = courts[courtCount].reservations[timeSlotCount].reservations[0];
                
              reservation.reservationPlayers = [];
              reservation.playersForBinding = [];
              reservation.tennis_reservation_id = null;
              // reservation.reservationInfo.time_start = null;
              // reservation.reservationInfo.time_end = null;
             
             for(playerCount=0; playerCount<4; playerCount++){

              reservation.playersForBinding[playerCount] = {tennisReservationPlayerId:"",playerId:"", playerName:""} ;

            }

            break;
          }
        }
      }
    }
  }
},
playerValueChanged:function(reservation,playerIndex,event){

                    
                      var inputField = $(event.target);
                     

                      if(inputField.attr("data-player-name") === inputField.val()){
                        reservation.playersForBinding[playerIndex].playerName = inputField.attr("data-player-name");
                        reservation.playersForBinding[playerIndex].playerId = inputField.attr("data-player-id");
                      }else{
                       
                        reservation.playersForBinding[playerIndex].playerId = "";
                      }
                      
                     
                  
     
    

  },
  bookingFilterSelectionChanged:function(){
 
    this.reAssessReservationVisibiltyBasedOnBookingStatus();
  },
  reAssessReservationVisibiltyBasedOnBookingStatus:function(){

    visibleRowsCount = 0;
    for(courtCount = 0; courtCount < this.courts.length; courtCount++){

        for(timeSlotCount=0; timeSlotCount<this.courts[courtCount].reservations.length; timeSlotCount++){

          if(this.courts[courtCount].reservations[timeSlotCount].reservations[0].tennis_reservation_id != null){
            if(this.bookingStatusFilterSelected == this.bookingStatusFilterOptions[0] || this.bookingStatusFilterSelected == this.bookingStatusFilterOptions[1]){
              this.courts[courtCount].reservations[timeSlotCount].reservations[0].visibleBasedOnBookingStatusFilter = true;
              visibleRowsCount++;
            }else if(this.bookingStatusFilterSelected == this.bookingStatusFilterOptions[2]){
              this.courts[courtCount].reservations[timeSlotCount].reservations[0].visibleBasedOnBookingStatusFilter = false;
            }
                
          }else{

            if(this.bookingStatusFilterSelected == this.bookingStatusFilterOptions[0] || this.bookingStatusFilterSelected == this.bookingStatusFilterOptions[2]){
              this.courts[courtCount].reservations[timeSlotCount].reservations[0].visibleBasedOnBookingStatusFilter = true;
              visibleRowsCount++;
            }else if(this.bookingStatusFilterSelected == this.bookingStatusFilterOptions[1]){
              this.courts[courtCount].reservations[timeSlotCount].reservations[0].visibleBasedOnBookingStatusFilter = false;
            }
          }
          
        }



    }

    if(visibleRowsCount == 0){
      this.noResultForFilter = true;
    }else{
      this.noResultForFilter = false;
    }

   }
  }
});
vue.fetchReservationsDataForSelectedDate();

//Contional logic to render if the request is from another page such as dashboard which isnt pre loaded with data
//if(!requestForReservationsPage){
//      vue.$nextTick(function(){
//        vue.fetchReservationsDataForSelectedDate();
//      });
//}



function prepareViewModelForCourts(courts){
  
    for(courtCount = 0; courtCount < courts.length; courtCount++){

        for(timeSlotCount=0; timeSlotCount<courts[courtCount].reservations.length; timeSlotCount++){
            
            if(!(courts[courtCount].reservations[timeSlotCount].reservations.length > 0)){
                courts[courtCount].reservations[timeSlotCount].reservations[0] = {};
            }
            courts[courtCount].reservations[timeSlotCount].reservations[0].captionsRowVisible = true;
            courts[courtCount].reservations[timeSlotCount].reservations[0].visibleBasedOnBookingStatusFilter = true;
            courts[courtCount].reservations[timeSlotCount].reservations[0].playersForBinding = [];

            for(playerCount=0; playerCount<4; playerCount++){
                   
                courts[courtCount].reservations[timeSlotCount].reservations[0].playersForBinding[playerCount] = courts[courtCount].reservations[timeSlotCount].reservations[0].reservationPlayers != null && courts[courtCount].reservations[timeSlotCount].reservations[0].reservationPlayers[playerCount] != null ? {tennisReservationPlayerId:courts[courtCount].reservations[timeSlotCount].reservations[0].reservationPlayers[playerCount].tennis_reservation_player_id,playerId:courts[courtCount].reservations[timeSlotCount].reservations[0].reservationPlayers[playerCount].player_id, playerName:courts[courtCount].reservations[timeSlotCount].reservations[0].reservationPlayers[playerCount].player_name} : {tennisReservationPlayerId:"",playerId:"", playerName:""} ;
                 
            }
          
                 
            
          
          
        }

    }
    //console.log(JSON.stringify(courts));
    return courts;

}

function tryParseReservationAsJSON(reponse){
    
     
        if(typeof(reponse) === "object"){
            if(reponse.hasOwnProperty('club_id') && reponse.club_id !== ""){
           
             return reponse;
            
            }else{

                return null;
            }
        }else{
            return null;
        }
            
}

function tryParseCourtsByDateAsJSON(reponse){
    
     
        
           if(typeof(reponse) === "object"){

              if(reponse.hasOwnProperty('date') && reponse.date !="" ){
               return reponse;
              
              }else{

                  return null;
              }
          }else{
            
              return null;
          }
      
            
}

function dateFrommddYYYYtoYYYYmmdd(date){

  var mmddYY = date.split("/");
  var YYYYmmdd = mmddYY[2]+"-"+mmddYY[0]+"-"+mmddYY[1];
  return YYYYmmdd;
}



function showProgressRing(){
     $(".se-pre-con").fadeIn("fast");
}

function hideProgressRing(){
    $(".se-pre-con").fadeOut("fast");
}


