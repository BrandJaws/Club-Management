<template id="feedsTemplate">
    <div>
        <div id="NPSModal" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="alert alert-danger fade-in" v-if="NPSData.errorMessage != '' ">
                        @{{ NPSData.errorMessage }}
                    </div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Players</h4>
                    </div>
                    <div class="modal-body">
                        <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                            <div class="row">
                                <div class="form-group form-md-checkboxes">
                                    <div class="col-sm-12">
                                        <template v-if="NPSData.selectedFeed != null">
                                          <div class="m-widget2 trainerWidget"  v-for="(reservationPlayer,reservationPlayerIndex) in NPSData.selectedFeed.notifiable.reservation.reservation_players">
                                            <div class="trainerImg"> <img :src="servicesUrl+reservationPlayer.member.profilePic" alt=""> </div>
                                            <div class="m-widget2__item m-widget2__item--primary">
                                                <div class="md-checkbox">
                                                    <input type="checkbox" :value="reservationPlayer.member.id" name="players" :id="'checkbox'+(reservationPlayerIndex+1)" class="md-check"  v-model="NPSData.selectedPlayers">
                                                    <label :for="'checkbox'+(reservationPlayerIndex+1)">
                                                        <span class="inc"></span> <span class="check"></span> <span class="box"></span>
                                                        <div class="trainerName">@{{ reservationPlayer.member.firstName +' '+ reservationPlayer.member.lastName   }}<small>@{{ reservationPlayer.member.email   }}</small></div>
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                        </template>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                        <button type="button" class="btn green" v-on:click="submitNPSTrainingClicked">Send</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 339px;"><div class="scroller slimScrollCustom" style="height: 339px; overflow-y: scroll; width: auto;" data-always-visible="1" data-rail-visible="0" data-initialized="1">
                <ul class="feeds">
                    <li v-for="feed in feedsComputed">
                        <div class="col1">
                            <div class="cont">
                                <div class="cont-col1">
                                    <div class="label label-sm label-success">
                                        <i :class="['fa', feed.iconClass]"></i>
                                    </div>
                                </div>
                                <div class="cont-col2">
                                    <div class="desc"> @{{ feed.description }}
                                        <span class="label label-sm label-info" v-if="feed.canTakeAction">
                                                            <a class="label label-sm label-info" v-on:click="takeActionButtonClicked(feed)"> Take Action <i class="fa fa-share"></i> </a>

                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col2">
                            <div class="date"> Just now </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        </div>
</template>

<script>


    Vue.component('feeds', {
        template: '#feedsTemplate',
        props: [
            "feeds",
            "baseUrl",
            "servicesUrl",
            "npsTargets"
        ],
        data:function(){
            return {

                eventSpecificValues:{
                    'NPSReminderTrainingSession':{
                        iconClass:'fa-bell-o',
                        description:'NPS Reminder for recently completed training session',
                        canTakeAction:true,
                    },
                    'event2':{
                        iconClass:'fa-bolt',
                        description:'',
                        canTakeAction:false,
                    },
                    'event3':{
                        iconClass:'fa-bullhorn',
                        description:'',
                        canTakeAction:false,
                    },
                    'event4':{
                        iconClass:'fa-plus',
                        description:'',
                        canTakeAction:false,
                    },
                },
                NPSData:{
                    selectedFeed:null,
                    selectedPlayers:[],
                    errorMessage:"",

                }
            }
        },
        computed:{
            feedsComputed:function(){

                var feeds = JSON.parse(JSON.stringify(this.feeds));

                for(feedIndex in feeds){
                    if(this.eventSpecificValues[feeds[feedIndex].event] != undefined){
                        feeds[feedIndex].iconClass = this.eventSpecificValues[feeds[feedIndex].event].iconClass;
                        feeds[feedIndex].description = this.eventSpecificValues[feeds[feedIndex].event].description;
                        feeds[feedIndex].canTakeAction = this.eventSpecificValues[feeds[feedIndex].event].canTakeAction;

                    }else{
                        feeds[feedIndex].iconClass = "";
                        feeds[feedIndex].description = "";
                        feeds[feedIndex].canTakeAction = false;
                    }

                }

                return feeds;
            },
        },
        methods: {
            takeActionButtonClicked:function(feed){
                //Perform action based on the type of feed

                switch (feed.event){
                    case  'NPSReminderTrainingSession':
                        this.NPSData.selectedFeed= feed;
                        this.NPSData.selectedPlayers = [];
                        this.showNPSModal();


                        break;

                    case 'event2':
                        break;
                }

            },
            submitNPSTrainingClicked:function(){

                var request = $.ajax({

                    url: this.baseUrl+"/nps/",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    data:{
                        nps_target:this.npsTargets.trainingSession,
                        admin_notification_id:this.NPSData.selectedFeed.id,
                        members:this.NPSData.selectedPlayers,


                    },
                    success:function(msg){

                        this.NPSData.errorMessage = "";
                        this.$emit('nps-created',this.NPSData.selectedFeed.id);
                        this.hideNPSModal();


                    }.bind(this),

                    error: function(jqXHR, textStatus ) {

                        if (jqXHR.hasOwnProperty("responseText")) {
                            this.NPSData.errorMessage = JSON.parse(jqXHR.responseText);
                            //this.$emit("reservation-failure",JSON.parse(jqXHR.responseText).response);
                        }



                    }.bind(this)
                });
            },
            showNPSModal:function(){
                this.NPSData.errorMessage = "";
                $('#NPSModal').modal("show");
            },
            hideNPSModal:function(){
                $('#NPSModal').modal("hide");
            }

        }
    });
</script>