@include("__vue_components.autocomplete.autocomplete")
<template id="leagueRankingsManagerTemplate">
    <div>
       <div class="col-md-6 text-right">
           
           <a data-toggle="modal" data-target="#leagueAddMembers" class="btn btn-circle red page-title-btn" v-if="league.registrationOpen">Add Members</a>
           <a data-toggle="modal" data-target="#updateLadderRanks" class="btn btn-circle red page-title-btn" v-if="league.structure_type == 'Unstructured' && league.unstructuredLeagueVariant == 'LADDER' " >Update League Ranks</a>
           <a data-toggle="modal" data-target="#updatePyramidRank" class="btn btn-circle red page-title-btn" v-if="league.structure_type == 'Unstructured' && league.unstructuredLeagueVariant == 'PYRAMID' ">Update Pyramid Ranks</a>
           <a :href="'{{route('league.createChallenges','')}}' + '/' + league.id" class="btn btn-circle red page-title-btn" v-if="!league.registrationOpen">Create Matches</a>
           <a :href="baseUrl+'/league/'+league.id+'/edit'" class="btn btn-circle red page-title-btn" >Edit League</a>
       </div>
        
        
        <!--updateLadderRanks-->
        <div class="modal fade" id="updateLadderRanks" tabindex="-1" role="dialog" aria-labelledby="Update League Ranks"  v-if="league.structure_type == 'Unstructured' && league.unstructuredLeagueVariant == 'LADDER' ">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="alert alert-danger fade-in" v-if="ladderRanksPopupErrorMessage != '' ">
                        @{{ ladderRanksPopupErrorMessage }}
                    </div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Update League Ranks</h4>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <ul class="rankCreator">
                                <li class="draggableLadderPlayer" draggable="true" v-for="leaguePlayer in leaguePlayersWithStatsData" :data-member-id="leaguePlayer.member_id" :data-rank="leaguePlayer.rank">
                                    <span class="image">
                                        <img :src="leaguePlayer.playerProfilePic  ? servicesUrl+leaguePlayer.playerProfilePic : servicesUrl+'/img/placeholders/person.png'" >
                                    </span>
                                    <span> @{{ leaguePlayer.playerName }}</span>
                                    <span class="rankSpan">@{{ leaguePlayer.rank }}</span>

                                </li>

                            </ul>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-circle btn-outline" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-circle red btn-outline" v-on:click="updateLadderRanksClicked">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--updatePyramidRank-->
        <div class="modal fade" id="updatePyramidRank" tabindex="-1" role="dialog" aria-labelledby="Update Pyramid Rank" v-if="league.structure_type == 'Unstructured' && league.unstructuredLeagueVariant == 'PYRAMID' ">
            <div class="modal-dialog" style="width: 980px;" role="document">
                <div class="modal-content">
                    <div class="alert alert-danger fade-in" v-if="ladderRanksPopupErrorMessage != '' ">
                        @{{ ladderRanksPopupErrorMessage }}
                    </div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <a href="#." class="btn btn-circle red pull-right mr20" v-on:click="addPyramidRankRow">Add Rank</a>
                        <h4 class="modal-title" id="myModalLabel">Update Pyramid Rank</h4>
                    </div>
                    <div class="modal-body">
                        <div class="pyramidRanking">
                            <div v-for="(rank,rankIndex) in leaguePlayersGroupedForPyramid" class="row rankRow pyramidRow">
                                <div class="col-md-2">
                                    <h3 class="rankHeadingTitle">@{{ 'Rank '+ (1 + rankIndex)}} </h3>
                                </div>
                                <div class="col-md-10  text-center">
                                    <div v-for="leaguePlayer in rank" class="rankedUser draggablePyramidPlayer"  draggable="true" :data-member-id="leaguePlayer.member_id" :data-rank="leaguePlayer.rank">
                                        {{--<span class="removeRankedUser"><i class="fa fa-times"></i></span>--}}
                                        <span class="userNameImage" :style="{backgroundImage: 'url('+(leaguePlayer.playerProfilePic ? servicesUrl+leaguePlayer.playerProfilePic : servicesUrl+'/img/placeholders/person.png')+')'}">&nbsp;</span>
                                        <!--<img title="User Name" :src="'//'+servicesUrl+leaguePlayer.playerProfilePic" alt="" />-->
                                        <div class="leagueName">@{{ leaguePlayer.playerName }}</div>
                                    </div>
                                    {{--<span class="addPlayerBtn" data-placement="right" data-popover-content="#a1" data-toggle="popover">+</span>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-circle btn-outline" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-circle red btn-outline" v-on:click="updatePyramidRanksClicked">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--leagueAddMembers-->
        <div class="modal fade" id="leagueAddMembers" tabindex="-1" role="dialog" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="alert alert-danger fade-in" v-if="addLeaguePlayersPopupErrorMessage != '' ">
                        @{{ addLeaguePlayersPopupErrorMessage }}
                    </div>
        			<div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Member</h4>
                    </div>
                    <div class="modal-body">
                        <div class="tooltips btn w-100 mb20" data-placement="top" data-original-title="Search Members">
                            <form action="" method="GET" class="text-left searchWithForm" v-on:submit.prevent>
                                <div class="input-icon right">
                                    <auto-complete-box url="{{url('member/list')}}" property-for-id="id" property-for-name="name"
                                                       filtered-from-source="true" include-id-in-list="true"
                                                       initial-text-value="" search-query-key="search" field-name="memberId" enable-explicit-selection="true" @explicit-selection="addNewPlayer"
                                                       placeholder-text="Search Member">
                                {{--<input type="text" class="form-control form-control-solid input-circle" placeholder="search..." name="search">--}}
                                    <button>
	                                    <i class="icon-magnifier"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="clearfix"></div>
                        <div class="resultBox">
                        	<div class="rankedUser" v-for="(player,playerIndex) in newLeaguePlayers">
                            	<span class="removeRankedUser" v-on:click="removeNewPlayer(playerIndex)"><i class="fa fa-times"></i></span>
                                <span class="userNameImage" :style="{backgroundImage: 'url('+(player.profilePic  ? servicesUrl+player.profilePic : servicesUrl+'/img/placeholders/person.png')+')'}" >&nbsp;</span>
                                <div class="leagueName">@{{ player.name }}</div>
                            </div>

                            
                        </div>
                        
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-circle btn-outline" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-circle red btn-outline" v-on:click="sendAddPlayerRequest">Save Member</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script src="{{asset('assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/apps/scripts/components-select2.min.js')}}" type="text/javascript"></script>

<script>


    Vue.component('rankings-manager', {
        template: "#leagueRankingsManagerTemplate",
        props: [
                "league",
                "servicesUrl",
                "baseUrl"

        ],
        mounted:function(){

            this.leaguePlayersGroupedForPyramid = this.getLeaguePlayersGroupedForPyramid();

            this.$nextTick(function(){
                Object.defineProperty(Object.prototype, 'indexOf',{
                    value : function(elm) {
                        for (var i = 0; i < this.length; i++) if(elm==this.item(i)) return i;
                        return -1;
                    },
                    enumerable : false
                });
                var list = [];
                var dragElmSrc = null;

                list = $('.draggableLadderPlayer');

                for (var i = 0; i < list.length; i++) {
                    item = list[i];

                    this.addCommonItemListenersForPlayer(item);
                    this.addItemListenersForLadderPlayers(item);
                }

                list = $('.draggablePyramidPlayer');

                for (var i = 0; i < list.length; i++) {
                    item = list[i];

                    this.addCommonItemListenersForPlayer(item);
                    this.addItemListenersForPyramidPlayers(item);
                }

                rankRowsForPyramid = $('.pyramidRow');
                for (var i = 0; i < rankRowsForPyramid.length; i++) {
                    item = rankRowsForPyramid[i];
                    this.addItemListenersForPyramidRows(item);
                }





            }.bind(this));






        },
        computed:{

        },
        data:function(){
            return {
                ladderRanksPopupErrorMessage:"",
                addLeaguePlayersPopupErrorMessage:"",
                leaguePlayersWithStatsData:JSON.parse(JSON.stringify(this.league.leaguePlayersWithStats)),
                leaguePlayersGroupedForPyramid:[],
                newLeaguePlayers:[],
            }
        },
        methods: {
            addNewPlayer:function(e){

                console.log(JSON.parse(JSON.stringify(this.league)));
                if(this.league.isDoubles){
                    if(this.newLeaguePlayers.length >= 2){
                        return;
                    }
                }else{
                    if(this.newLeaguePlayers.length >= 1){
                        return;
                    }
                }
                var alreadyAdded = false;
                for(playerIndex in this.newLeaguePlayers){
                    if(this.newLeaguePlayers[playerIndex].id == e.id){
                        alreadyAdded = true;
                        break;
                    }
                }
                if(!alreadyAdded){
                    this.newLeaguePlayers.push({
                        id:e.id,
                        name:e.name,
                        profilePic:e.profilePic
                    });
                }

            },
            removeNewPlayer:function(playerIndex){
                this.newLeaguePlayers.splice(playerIndex,1);
            },
            sendAddPlayerRequest:function(){
                var members = [];
                for(playerIndex in this.newLeaguePlayers){
                    members.push(this.newLeaguePlayers[playerIndex].id);
                }
                var request = $.ajax({

                    url: this.baseUrl+"/league/add-league-players",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    data:{

                        league_id:this.league.id,
                        members:members,


                    },
                    success:function(msg){

                        this.hideAddLeaguePlayersPopup();
                        this.autoCompleteSelectedId = 0;
                        this.$emit('new-players-added',msg);
                        this.addLeaguePlayersPopupErrorMessage = "";
                        this.newLeaguePlayers = [];

                    }.bind(this),

                    error: function(jqXHR, textStatus ) {

                        if (jqXHR.hasOwnProperty("responseText")) {
                            this.addLeaguePlayersPopupErrorMessage = JSON.parse(jqXHR.responseText);
                            //this.$emit("reservation-failure",JSON.parse(jqXHR.responseText).response);
                        }



                    }.bind(this)
                });
            },
            updateLadderRanksClicked:function(){
                playersSortedByRanks = [];
                listItemsForPlayers = $('li.draggableLadderPlayer');
                listItemsForPlayers.each(function (itemIndex, item) {
                    playersSortedByRanks.push($(item).data('member-id'));
                })
                
                var request = $.ajax({

                    url: this.baseUrl+"/league/update-ladder-ranks",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    data:{

                        league_id:this.league.id,
                        playersSortedByRanks:playersSortedByRanks,


                    },
                    success:function(msg){

                        this.hideLadderRanksPopup();
                        this.autoCompleteSelectedId = 0;
                        this.$emit('ranks-updated',msg);
                        this.ladderRanksPopupErrorMessage = "";


                    }.bind(this),

                    error: function(jqXHR, textStatus ) {

                        if (jqXHR.hasOwnProperty("responseText")) {
                            this.ladderRanksPopupErrorMessage = JSON.parse(jqXHR.responseText);
                            //this.$emit("reservation-failure",JSON.parse(jqXHR.responseText).response);
                        }



                    }.bind(this)
                });
            },
            updatePyramidRanksClicked:function(){
                var playersSortedByRanks = [];
                var pyramidRow = $('.pyramidRow');
                //clear blank rows
                var clearedRowsCount = 0;
                pyramidRow.each(function (rowIndex, row) {
                    var players = $(row).children().eq(1).children();

                    if(players.length == 0){
                        clearedRowsCount++;
                        row.remove();
                    }

                })

                //reset rank numbers on ui
                if(clearedRowsCount > 0){
                    var pyramidRow = $('.pyramidRow');
                    pyramidRow.each(function (rowIndex, row) {
                        $(row).children().eq(0).children().eq(0).text("Rank "+(rowIndex+1));
                        //$(row).children().eq(0).html("Rank "+(rowIndex+1));
                    });
                }

                pyramidRow.each(function (rowIndex, row) {
                    playersSortedByRanks.push([]);
                    $(row).children().eq(1).children().each(function(playerIndex, player){
                        playersSortedByRanks[rowIndex].push($(player).attr("data-member-id"));

                    });
                })

                var request = $.ajax({

                    url: this.baseUrl+"/league/update-pyramid-ranks",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    data:{

                        league_id:this.league.id,
                        playersSortedByRanks:playersSortedByRanks,


                    },
                    success:function(msg){
                        console.log(msg);
                        this.hidePyramidRanksPopup();
                        this.autoCompleteSelectedId = 0;
                        this.$emit('ranks-updated',msg);
                        this.ladderRanksPopupErrorMessage = "";


                    }.bind(this),

                    error: function(jqXHR, textStatus ) {

                        if (jqXHR.hasOwnProperty("responseText")) {
                            this.ladderRanksPopupErrorMessage = JSON.parse(jqXHR.responseText);
                            //this.$emit("reservation-failure",JSON.parse(jqXHR.responseText).response);
                        }



                    }.bind(this)
                });
            },
            hideLadderRanksPopup:function(){
                $('#updateLadderRanks').modal('hide');

            },
            hidePyramidRanksPopup:function(){
                $('#updatePyramidRank').modal('hide');

            },
            hideAddLeaguePlayersPopup:function(){
                $('#leagueAddMembers').modal('hide');

            },
            getLeaguePlayersGroupedForPyramid:function(){

                var leaguePlayersGrouped = [];
                var rankIndex = -1;
                var rank = -1;
                for(leaguePlayerIndex in this.leaguePlayersWithStatsData){
                    if(rank != this.leaguePlayersWithStatsData[leaguePlayerIndex].rank){
                        leaguePlayersGrouped.push([]);
                        rankIndex++;
                        rank = this.leaguePlayersWithStatsData[leaguePlayerIndex].rank;
                    }
                    leaguePlayersGrouped[rankIndex].push(this.leaguePlayersWithStatsData[leaguePlayerIndex]);
                }

                return leaguePlayersGrouped;
            },
            addPyramidRankRow:function(){
                this.leaguePlayersGroupedForPyramid.push([]);
                this.$nextTick(function(){
                    rankRowsForPyramid = $('.pyramidRow');
                    this.addItemListenersForPyramidRows(rankRowsForPyramid[rankRowsForPyramid.length -1] );
                    rankRowsForPyramid.each(function (rowIndex, row) {
                        $(row).children().eq(0).children().eq(0).text("Rank "+(rowIndex+1));
                    });

                }.bind(this));

            },
            addItemListenersForPyramidRows: function (item){

            var vueInstance = this;
            item.addEventListener('dragenter', function (e) {
                draggedElement = vueInstance.getPyramidPlayerDomElementByMemberId(e.dataTransfer.getData("memberId"));
                if (this == draggedElement) return;
                this.classList.add('over');
            }, false);
            item.addEventListener('dragleave', function (e) {
                this.classList.remove('over');
            }, false);
            item.addEventListener('dragover', function (e) {
                if (e.preventDefault) e.preventDefault(); // Necessary. Allows us to drop.
                this.classList.add('over');
                e.dataTransfer.dropEffect = 'move'; // See the section on the DataTransfer object.
                return false;
            }, false);
            item.addEventListener('drop', function (e) {
                if (e.stopPropagation) e.stopPropagation(); // stops the browser from redirecting.

                draggedElement = vueInstance.getPyramidPlayerDomElementByMemberId(e.dataTransfer.getData("memberId"));

                draggedElement.classList.remove('dragging');
                this.classList.remove('over');
                this.parentNode.parentNode.classList.remove('over');

                var clone = draggedElement.cloneNode(true);
                vueInstance.addCommonItemListenersForPlayer(clone);
                vueInstance.addItemListenersForPyramidPlayers(clone);

                draggedElement.remove();
                this.childNodes[2].appendChild(clone);
                return false;
            }, false);

        },

         addCommonItemListenersForPlayer: function (item) {

            item.addEventListener('dragstart', function (e) {
                this.classList.add('dragging');
                e.dataTransfer.setData("memberId", $(this).attr("data-member-id"));
                dragElmSrc = this;
            }, false);
            item.addEventListener('dragend', function (e) {
                this.classList.remove('dragging');
                //document.querySelector('.over').classList.remove('over');
            }, false);
            item.addEventListener('dragenter', function (e) {
                if (this == dragElmSrc) return;
                this.classList.add('over');
            }, false);
            item.addEventListener('dragleave', function (e) {
                this.classList.remove('over');
            }, false);
            item.addEventListener('dragover', function (e) {
                this.classList.add('over');
                if (e.preventDefault) e.preventDefault(); // Necessary. Allows us to drop.
                e.dataTransfer.dropEffect = 'move'; // See the section on the DataTransfer object.
                return false;
            }, false);
         },
         addItemListenersForLadderPlayers:function (item){
             var vueInstance = this;
            item.addEventListener('drop', function (e) {
                if (e.stopPropagation) e.stopPropagation(); // stops the browser from redirecting.

                list = this.parentNode.querySelectorAll('[draggable]');
                var srcIndex = list.indexOf(dragElmSrc);
                var targetIndex = list.indexOf(this);


                if (targetIndex == srcIndex) return;

                dragElmSrc.classList.remove('dragging');
                this.classList.remove('over');

                var clone = dragElmSrc.cloneNode(true);
                vueInstance.addCommonItemListenersForPlayer(clone);
                vueInstance.addItemListenersForLadderPlayers(clone);

                dragElmSrc.remove();

                if (targetIndex < srcIndex) {
                    this.parentNode.insertBefore(clone, this);
                } else {
                    this.parentNode.insertBefore(clone, this.nextSibling);
                }


                $('li[draggable="true"]').each(function(index){
                    $(this).find('.rankSpan').text(index + 1);
                });

                return false;
            }, false);


        },
        addItemListenersForPyramidPlayers:function (item){
            var vueInstance = this;
            item.addEventListener('drop', function (e) {
                if (e.stopPropagation) e.stopPropagation(); // stops the browser from redirecting.

                list = this.parentNode.querySelectorAll('[draggable]');
                var srcIndex = list.indexOf(dragElmSrc);
                var targetIndex = list.indexOf(this);

                if (targetIndex == srcIndex) return;

                dragElmSrc.classList.remove('dragging');
                this.classList.remove('over');
                this.parentNode.parentNode.classList.remove('over');

                var clone = dragElmSrc.cloneNode(true);
                vueInstance.addCommonItemListenersForPlayer(clone);
                vueInstance.addItemListenersForPyramidPlayers(clone);

                dragElmSrc.remove();

                if (targetIndex < srcIndex) {
                    this.parentNode.insertBefore(clone, this);
                } else {
                    this.parentNode.insertBefore(clone, this.nextSibling);
                }

                return false;
            }, false);
     },
     getPyramidPlayerDomElementByMemberId:function(memberId){

                list = $('.draggablePyramidPlayer');

                for (var i = 0; i < list.length; i++) {
                    item = list[i];
                    if($( list[i]).attr('data-member-id') == memberId){
                        return list[i];
                    }

                }


     },




    }
    });
</script>