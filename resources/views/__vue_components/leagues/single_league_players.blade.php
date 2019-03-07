
<template id="leaguePlayersTemplate">
    <div class="col-lg-8 col-xs-12 col-sm-12">
        <div class="portlet light bordered equalHeight">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Registered Members</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <!-- BEGIN: Actions -->
                    <div class="mt-actions">
                        <div class="mt-action" v-for="leaguePlayer in leaguePlayers">
                            <div class="mt-action-img">
                                <img :src="leaguePlayer.playerProfilePic  ? servicesUrl+leaguePlayer.playerProfilePic : servicesUrl+'/img/placeholders/person.png'"> </div>
                            <div class="mt-action-body">
                                <div class="mt-action-row">
                                    <div class="mt-action-info ">
                                        <div class="mt-action-details ">
                                            <span class="mt-action-author">@{{ leaguePlayer.playerName }}</span>
                                            <p class="mt-action-desc">@{{ leaguePlayer.nextMatch}}</p>
                                        </div>
                                    </div>
                                    <div class="mt-action-datetime text-center ">
                                        Exp. Level: <strong>@{{ leaguePlayer.expLevel}}</strong>
                                    </div>
                                    <div class="mt-action-datetime ">
                                        Matches Won: <strong>@{{ leaguePlayer.wins}}</strong>
                                    </div>
                                    <div class="mt-action-buttons ">
                                        <div class="">
                                            <button type="button" class="btn btn-outline btn-circle red btn-sm" v-on:click="deleteRegisteredLeaguePlayer(leaguePlayer.id)">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- END: Actions -->
                </div>
            </div>
        </div>
    </div>



</template>
<script>


    Vue.component('league-players', {
        template: "#leaguePlayersTemplate",
        props: [
            "leaguePlayers",
            "baseUrl",
            "servicesUrl",
            "league",
        ],
        data:function () {
            return {
                registrationPopupVisible:false,
                autoCompleteSelectedId:0,
                autoCompleteData:[],
                errorMessage:"",

            }
        },
        mounted:function(){

        },
        computed:{
            selectedPartner:function(){
                for(var index in this.autoCompleteData){
                    if(this.autoCompleteData[index].id == this.autoCompleteSelectedId){
                        return this.autoCompleteData[index];
                    }
                }
            },
            selfIncludedInPlayers:function(){
                for(var index in this.leaguePlayers){
                    if(this.leaguePlayers[index].member_id == this.ownId){
                        return true;
                    }
                }

                return false;
            }
        },
        methods: {
            registerButtonClicked:function(){
                this.errorMessage = "";
                if(this.league.isDoubles){
                    this.showRegistrationPopup();
                }else{
                    //proceed with registration
                    this.registerForLeague();
                }

            },
            showRegistrationPopup:function(){

                this.registrationPopupVisible = true;

            },
            hideRegistrationPopup:function(){
                $('#doublesLeagueRegistration').modal('hide');


            },
            autoCompleteDataUpdated:function (e) {
                this.autoCompleteData = e;

            },
            deleteRegisteredLeaguePlayer:function(leaguePlayerId){
                var request = $.ajax({

                    url: this.baseUrl+"/league/delete-league-player",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    data:{

                        league_player_id:leaguePlayerId,
                        _token: "{{ csrf_token() }}",

                    },
                    success:function(msg){

                        this.hideRegistrationPopup();
                        this.autoCompleteSelectedId = 0;
                        this.$emit('players-removed',msg);
                        this.errorMessage = "";

                    }.bind(this),

                    error: function(jqXHR, textStatus ) {

                        if (jqXHR.hasOwnProperty("responseText")) {
                            this.errorMessage = JSON.parse(jqXHR.responseText);
                            this.$emit("player-removal-failure",JSON.parse(jqXHR.responseText));
                        }



                    }.bind(this)
                });
            },









            reservationButtonClicked:function(league){

                if(league.registrationStarted == 0 ){
                    return;
                }else if(league.reservation_player_id == null){
                    this.reservePlace(league.id);
                }else{
                    this.cancelReservation(league.reservation_player_id);
                }

            },
            reservationButtonCaption:function(league){
                if(league.registrationStarted == 0 ){
                    return 'Coming Soon';
                }else if(league.reservation_player_id == null){
                    return 'Join';
                }
            },
            reservePlace:function(id){

                var request = $.ajax({

                    url: this.baseUrl+"/league/reserve",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    data:{

                        league_id:id,
                        _token: "{{ csrf_token() }}",

                    },
                    success:function(msg){


                        this.$emit("reservation-success",msg.response);

                    }.bind(this),

                    error: function(jqXHR, textStatus ) {

                        if (jqXHR.hasOwnProperty("responseText")) {
                            this.$emit("reservation-failure",JSON.parse(jqXHR.responseText).response);
                        }



                        //Error code to follow



                    }.bind(this)
                });
            },
            cancelReservation:function(_reservation_player_id){

                if(_reservation_player_id == null){
                    return;
                }

                var request = $.ajax({

                    url: this.baseUrl+"/portal/league/cancel-reservation",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    data:{

                        reservation_player_id:_reservation_player_id,
                        _token: "{{ csrf_token() }}",

                    },
                    success:function(msg){


                        this.$emit("reservation-success",msg.response);

                    }.bind(this),

                    error: function(jqXHR, textStatus ) {

                        if (jqXHR.hasOwnProperty("responseText")) {
                            this.$emit("reservation-failure",JSON.parse(jqXHR.responseText).response);
                        }



                        //Error code to follow



                    }.bind(this)
                });
            },
            leagueRowClicked:function(league){
                console.log(league);
            }
        }
    });
</script>