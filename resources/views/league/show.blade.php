@extends('__layouts.admin') @section('main')

 <div id="league-vue-container">


    <!-- BEGIN PAGE HEADER-->
    <div class="page-bar">

        <ul class="page-breadcrumb">
            <li><i class="fa fa-home"></i> <a href="index.html">Home</a> <i
                        class="fa fa-angle-right"></i></li>
            <li><a href="{{url('/league')}}">Leagues</a> <i
                        class="fa fa-angle-right"></i></li>
            <li><a href="#.">View</a></li>
        </ul>
    </div>
     <message-bar v-if="messageBar.message" :type="messageBar.type" :message="messageBar.message"></message-bar>
    <div class="row">
        <div class="col-md-6 text-left">
            <h1 class="page-title">
                View League
            </h1>
        </div>

        <rankings-manager :league="league" :services-url="servicesUrl" :base-url="baseUrl" v-on:ranks-updated="leagueRanksUpdated" v-on:new-players-added="newLeaguePlayersAdded"></rankings-manager>

    </div>

    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->


    <!-- BEGIN PROFILE CONTENT -->
    <div class="row" >
        <div class="col-md-12">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(session()->has('serverError'))
                <div class="alert alert-danger">
                    {{ session()->get('serverError') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <league-details :league="league" :services-url="servicesUrl"></league-details>
        <league-players :league-players="league.leaguePlayersWithStats" :league="league" :base-url="baseUrl" :services-url="servicesUrl" v-on:players-removed="playersRemoved"  v-on:player-removal-failure="playerRemovalFailed"></league-players>

        <ladder-positions  v-if="league.hasStarted" :league-teams="league.leagueTeamsWithStats" :show-points="showPoints"></ladder-positions>
        <league-challenges v-if="league.hasStarted" :base-url="baseUrl" :challenges="league.leagueChallenges" :courts="courts" :league="league" v-on:scorecard-created="newScoreCardAdded" v-on:challenge-created="newChallengeCreated"  ></league-challenges>
    </div>




 </div>
    <!-- END PROFILE CONTENT -->
    <!-- END PAGE CONTENT-->

@section('page-specific-scripts')
    <link href="{{asset("assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")}}"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")}}"></script>

    <link rel="stylesheet" href="{{asset("assets/leagueViewStyles.css")}}" />
    <link href="{{asset("assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/custom/jquery.steps.min.js")}}"></script>
    <link href="{{asset("assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")   }}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/pages/scripts/components-date-time-pickers.min.js")}}" type="text/javascript"></script>

    @include("__vue_components.MessageBar.message-bar")
    @include("__vue_components.leagues.single_league_details")
    @include("__vue_components.leagues.single_league_players")
    @include("__vue_components.leagues.single_league_ladder_positions")
    @include("__vue_components.leagues.single_league_challenges")
    @include("__vue_components.leagues.single_league_rankings_manager")

    <script>
        $(function(){
            $("[data-toggle=popover]").popover({
                html : true,
                content: function() {
                    var content = $(this).attr("data-popover-content");
                    return $(content).children(".popover-body").html();
                },
                title: function() {
                    var title = $(this).attr("data-popover-content");
                    return $(title).children(".popover-heading").html();
                }
            });
        });
    </script>

    <script>

        var _baseUrl ="{{url('')}}";

        var vue = new Vue({
            el: "#league-vue-container",
            data: {
                league:{!!json_encode($data["league"]) !!},
                courts:{!!json_encode($data["courts"]) !!},
                baseUrl:_baseUrl,
                servicesUrl:'{{env('REST_API')}}',
                messageBar:{
                    type:"",
                    message:""
                },




            },
            mounted:function(){

            },
            computed:{
                promoIsImage:function(){

                    if(this.league.promotionType == promoTypes.image){

                        return true;
                    }else{

                        return false;
                    }
                },
                reservationButtonCaption:function(){
                    if(this.league.registrationStarted == 0 ){
                        return 'Coming Soon';
                    }else if(this.league.reservation_player_id == null){
                        return 'Join';
                    }else{
                        return 'Joined';
                    }
                },
                showPoints:function(){
                    var leagueIsStructuredLeague = this.league.structure_type == "Structured";
                    var leagueIsUnstructuredPointBased = this.league.structure_type == "Unstructured" && this.league.unstructuredLeagueVariant == "POINT BASED";
                    return leagueIsStructuredLeague || leagueIsUnstructuredPointBased;
                }
            },
            methods: {
                newLeaguePlayersAdded:function(e){
                    this.league.leaguePlayersWithStats = e.leaguePlayersWithStats;
                    this.league.leagueTeamsWithStats = e.leagueTeamsWithStats;
                    this.showMessageInMessageBar("success", "Registration Successful");
                },
                newChallengeCreated:function(e){
                    this.league.leaguePlayersWithStats = e.leaguePlayersWithStats ;
                    this.league.leagueTeamsWithStats = e.leagueTeamsWithStats;
                    this.league.leagueChallenges = e.leagueChallenges;
                    this.showMessageInMessageBar("success", "Score Card Created Successful");
                },
                newScoreCardAdded:function(e){

                    this.league.leaguePlayersWithStats = e.leaguePlayersWithStats ;
                    this.league.leagueTeamsWithStats = e.leagueTeamsWithStats;
                    this.league.leagueChallenges = e.leagueChallenges;
                    this.showMessageInMessageBar("success", "Score Card Created Successful");

                },
                leagueRanksUpdated:function(e){

                    this.league.leaguePlayersWithStats = e.leaguePlayersWithStats;
                    this.league.leagueTeamsWithStats = e.leagueTeamsWithStats;
                    this.showMessageInMessageBar("success", "Ranks Updated Successfully");
                },
                playersRemoved:function(e){
                    this.league.leaguePlayersWithStats = e.leaguePlayersWithStats;
                    this.league.leagueTeamsWithStats = e.leagueTeamsWithStats;
                    this.showMessageInMessageBar("success", "Player Removed Successfully");
                },
                playerRemovalFailed:function(e){
                    this.showMessageInMessageBar("error", e);
                },
                reservationButtonClicked:function(){


                    if(this.league.registrationStarted == 0 ){
                        return;
                    }else if(this.league.reservation_player_id == null){
                        this.reservePlace(this.league.id);
                    }else{
                        this.cancelReservation(this.league.reservation_player_id);
                    }

                },
                showMessageInMessageBar:function(type,message){
                    this.messageBar.type = type;
                    this.messageBar.message = message;
                }
            },





        });





    </script>
@endSection
@stop
