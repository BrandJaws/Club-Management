<template id="leagueChallengesTemplate">
    <div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <span class="caption-subject font-dark bold uppercase">League Challenges</span>
                    </div>
                    <div class="actions">
                        <a data-toggle="modal" data-target="#createChallengeModal" class="btn btn-circle red btn-outline btn-sm"  v-on:click="createChallengeClicked()">
                            <i class="fa fa-plus"></i>&nbsp;Create Challenge
                        </a>
                    </div></div>
                <div class="portlet-body">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Challenger</th>
                            <th>Challengee</th>
                            <th>Scores</th>
                            <th>Match Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="challenge in challengesComputed">
                            <td>@{{ challenge.challengerName }}</td>
                            <td>@{{ challenge.challengeeName }}</td>
                            <td>@{{ challenge.scoresAsString != "" ? challenge.scoresAsString : "-" }}</td>
                            <td>@{{ challenge.matchDate }}</td>
                            <td>
                                <a data-toggle="modal" data-target="#updateChallengeModal" class="btn btn-outline red btn-circle btn-sm" v-on:click="addScoreClicked(challenge)">Update</a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modals -->
        <div class="modal fade" id="createChallengeModal" tabindex="-1" role="dialog" aria-labelledby="Create Challenge Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="alert alert-danger fade-in" v-if="challengeData.errorMessage != '' ">
                        @{{ challengeData.errorMessage }}
                    </div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Create Challenge</h4>
                    </div>
                    <div class="modal-body">
                        <form action="">
                        	{{--<div class="form-group row">--}}
                                {{--<div class="col-md-3 text-right">--}}
                                    {{--<label for="" class="form-control-label">Challenger</label>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-9">--}}
                                    {{--<select id="single" class="form-control select2">--}}
                                        {{--<option></option>--}}
                                        {{--<optgroup label="Alaskan">--}}
                                            {{--<option value="AK">Alaska</option>--}}
                                            {{--<option value="HI" disabled="disabled">Hawaii</option>--}}
                                        {{--</optgroup>--}}
                                        {{--<optgroup label="Pacific Time Zone">--}}
                                            {{--<option value="CA">California</option>--}}
                                            {{--<option value="NV">Nevada</option>--}}
                                            {{--<option value="OR">Oregon</option>--}}
                                            {{--<option value="WA">Washington</option>--}}
                                        {{--</optgroup>--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group row">
                                <div class="col-md-3 text-right">
                                    <label for="" class="form-control-label">Challenger</label>
                                </div>
                                <div class="col-md-9">
                                    <select name="" id="challengerSelect" class="form-control" v-model="challengeData.selectedChallengerTeamIndex" data-live-search="true">
                                        <option v-for="(team, teamIndex) in league.leagueTeamsWithStats" :value="teamIndex">
                                            @{{ team.teamName }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right">
                                    <label for="" class="form-control-label">Challengee</label>
                                </div>
                                <div class="col-md-9">
                                    <select name="" id="challengeeSelect" class="form-control" v-model="challengeData.selectedChallengeeTeamIndex" data-live-search="true">
                                        <option v-for="(team, teamIndex)  in league.leagueTeamsWithStats" :value="teamIndex" >
                                            @{{ team.teamName }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right">
                                    <label for="" class="form-control-label">Match Time</label>
                                </div>
                                <div class="col-md-9">
                                    <select name="" class="form-control" id="" v-model="challengeData.time">
                                        <option v-for ="timeSlot in challengeStartTimesComptued" :value="timeSlot">@{{ timeSlot }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right">
                                    <label for="" class="form-control-label">Challenge Date</label>
                                </div>
                                <div class="col-md-9">
                                    <input id="reservedAt" class="form-control date-picker" size="16" type="text" v-model="challengeData.reserved_at">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right">
                                    <label for="" class="form-control-label">Court</label>
                                </div>
                                <div class="col-md-9">
                                    <select name="" id="" class="form-control" v-model="challengeData.court_id" >
                                        <option v-for="court in courts" :value="court.id">
                                            @{{ court.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-circle btn-outline" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-circle red btn-outline" v-on:click="saveChallengeClicked">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateChallengeModal" tabindex="-1" role="dialog" aria-labelledby="Update Challenge Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="alert alert-danger fade-in" v-if="scoreCardData.errorMessage != '' ">
                        @{{ scoreCardData.errorMessage }}
                    </div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Update Challenge</h4>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for=""><strong>@{{ scoreCardData.teamOneName }}</strong> Score</label>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><strong>@{{ scoreCardData.teamTwoName }}</strong> Score</label>
                                </div>
                            </div>
                            <div id="scoreFields" >
                                <div id="field1" class="form-group row" v-for="scoreCardSet in scoreCardData.score_card_sets">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" v-model="scoreCardSet.teamOneScore" />
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" v-model="scoreCardSet.teamTwoScore" />
                                    </div>
                                </div>
                            </div>

                        </form>
                        <p class="text-right"><input type="button" value="Add Another Score Field" class="btn btn-add-field" v-on:click="addNewScoreCardSet" /></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-circle btn-outline" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-circle red btn-outline" v-on:click="saveScoreClicked">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


    </div>


</template>
<script src="{{asset("assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js")}}" type="text/javascript"></script>
<script>


    Vue.component('league-challenges', {
        template: "#leagueChallengesTemplate",
        props: [
                "challenges",
                "baseUrl",
                "courts",
                "league",

        ],
        mounted:function(){
            $('#reservedAt').on('change',function(e){
                this.challengeData.reserved_at = $(e.target).val();

            }.bind(this));
            $('#challengerSelect').selectpicker({
//                    style: 'btn-info',
//                    size: 4
            });
            $('#challengeeSelect').selectpicker({
//                    style: 'btn-info',
//                    size: 4
            });

        },
        data:function () {
            return {
                scoreCardData:{
                    reservation_id:0,
                    teamOneName:"",
                    teamTwoName:"",
                    score_card_sets:[
                        {teamOneScore:0 , teamTwoScore:0}
                    ],
                    errorMessage:"",
                },
                challengeData:{
                    league_id:this.league.id,
                    court_id: this.courts[0] != undefined ? this.courts[0].id : 0,
                    time: this.courts[0].timeSlots[0] != undefined ? this.courts[0].timeSlots[0] : "",
                    reserved_at: "{{\Carbon\Carbon::today()->format('m/d/Y')}}",
                    selectedChallengerTeamIndex:-1,
                    selectedChallengeeTeamIndex:-1,
                    errorMessage:"",

                },


            }
        },

        computed:{
            challengesComputed:function(){
                var challengesClone = JSON.parse(JSON.stringify(this.challenges));
                for(challengeIndex in challengesClone){
                    challengesClone[challengeIndex].challengerName = challengesClone[challengeIndex].challengerTeam.members[0].name;
                    if(challengesClone[challengeIndex].challengerTeam.members[1] != undefined){
                        challengesClone[challengeIndex].challengerName += "/" + challengesClone[challengeIndex].challengerTeam.members[1].name;
                    }

                    challengesClone[challengeIndex].challengeeName = challengesClone[challengeIndex].challengeeTeam.members[0].name;
                    if(challengesClone[challengeIndex].challengeeTeam.members[1] != undefined){
                        challengesClone[challengeIndex].challengeeName += "/" + challengesClone[challengeIndex].challengeeTeam.members[1].name;
                    }
                }

                return challengesClone;
            },
            challengeStartTimesComptued:function(){
                for(courtCount = 0; courtCount < this.courts.length; courtCount++){
                    if(this.courts[courtCount].id == this.challengeData.court_id){

                        return this.courts[courtCount].timeSlots;
                    };
                }
                //return empty array if nothing is found
                return [];
            },
        },
        methods: {
            addScoreClicked:function(challenge){
                this.scoreCardData.errorMessage = "";
                this.scoreCardData.reservation_id = challenge.id;
                this.scoreCardData.teams = [challenge.challengerTeam.team, challenge.challengeeTeam.team] ;
                this.scoreCardData.teamOneName = challenge.challengerName ;
                this.scoreCardData.teamTwoName = challenge.challengeeName;
                this.scoreCardData.score_card_sets = [
                    {teamOneScore:0 , teamTwoScore:0}
                ];
            },
            addNewScoreCardSet:function(){
                this.scoreCardData.score_card_sets.push({teamOneScore:0 , teamTwoScore:0});
            },
            createChallengeClicked:function(){
                this.challengeData.errorMessage = "";
            },
            saveChallengeClicked:function(){

                playersFromChallengerTeam = this.league.leagueTeamsWithStats[this.challengeData.selectedChallengerTeamIndex] != undefined ? this.league.leagueTeamsWithStats[this.challengeData.selectedChallengerTeamIndex].members : [];
                playersFromChallengeeTeam = this.league.leagueTeamsWithStats[this.challengeData.selectedChallengeeTeamIndex] != undefined ? this.league.leagueTeamsWithStats[this.challengeData.selectedChallengeeTeamIndex].members : [];
                playersMerged = playersFromChallengerTeam.concat(playersFromChallengeeTeam);


                var request = $.ajax({

                    url: this.baseUrl+"/league/reserve-match",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    data:{

                        court_id:this.challengeData.court_id,
                        league_id:this.challengeData.league_id,
                        reserved_at:this.challengeData.reserved_at,
                        time:this.challengeData.time,
                        player:playersMerged,
                        _token: "{{ csrf_token() }}",

                    },
                    success:function(msg){

                        this.hideChallengePopup();
                        this.autoCompleteSelectedId = 0;
                        this.$emit('challenge-created',msg);
                        this.challengeData.errorMessage = "";


                    }.bind(this),

                    error: function(jqXHR, textStatus ) {

                        if (jqXHR.hasOwnProperty("responseText")) {
                            this.challengeData.errorMessage = JSON.parse(jqXHR.responseText);
                            //this.$emit("reservation-failure",JSON.parse(jqXHR.responseText).response);
                        }



                    }.bind(this)
                });
            },
            saveScoreClicked:function(){
                var request = $.ajax({

                    url: this.baseUrl+"/league/create-scorecard",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    data:{

                        reservation_id:this.scoreCardData.reservation_id,
                        teams:this.scoreCardData.teams,
                        score_card_sets:this.scoreCardData.score_card_sets,
                        _token: "{{ csrf_token() }}",

                    },
                    success:function(msg){

                        this.hideScorePopup();
                        this.autoCompleteSelectedId = 0;
                        this.$emit('scorecard-created',msg);
                        this.scoreCardData.errorMessage = "";


                    }.bind(this),

                    error: function(jqXHR, textStatus ) {

                        if (jqXHR.hasOwnProperty("responseText")) {
                            this.scoreCardData.errorMessage = JSON.parse(jqXHR.responseText);
                            //this.$emit("reservation-failure",JSON.parse(jqXHR.responseText).response);
                        }



                    }.bind(this)
                });
            },
            hideScorePopup:function(){
                $('#updateChallengeModal').modal('hide');


            },
            hideChallengePopup:function(){

                $('#createChallengeModal').modal('hide');

            },


        }
    });
</script>