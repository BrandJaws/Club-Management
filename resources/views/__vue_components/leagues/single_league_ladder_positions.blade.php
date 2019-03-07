<template id="ladderPositionsTemplate">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">Ladder Positions</span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th style="max-width: 35px;">
                            Ladder Rank
                        </th>
                        <th v-if="showPoints" style="max-width: 35px;">
                            Points
                        </th>
                        <th>
                            Player
                        </th>
                        <th style="max-width: 35px;">
                            P
                        </th>
                        <th style="max-width: 35px;">
                            W
                        </th>
                        <th style="max-width: 35px;">
                            L
                        </th>
                        <th style="max-width: 35px;">
                            D
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="leaguePlayer in leagueTeams">
                        <td>@{{ leaguePlayer.rank }}</td>
                        <td v-if="showPoints">@{{ leaguePlayer.points }}</td>
                        <td>@{{ leaguePlayer.teamName }}</td>
                        <td>@{{ leaguePlayer.matchesPlayed }}</td>
                        <td>@{{ leaguePlayer.wins }}</td>
                        <td>@{{ leaguePlayer.losses }}</td>
                        <td>@{{ leaguePlayer.draws }}</td>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>




</template>
<script>


    Vue.component('ladder-positions', {
        template: "#ladderPositionsTemplate",
        props: [
            "leagueTeams",
            "showPoints"
        ],
        mounted:function(){

        },
        methods: {


        }
    });
</script>