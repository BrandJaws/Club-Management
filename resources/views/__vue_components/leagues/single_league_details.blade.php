<template id="leagueDetailsTemplate">
    <div>
        <div class="col-lg-4 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">@{{ league.name }}</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="leagueView">
                            <div class="row">
                                <div class="col-md-12">
                                    <img :src="league.image  ? servicesUrl+league.image : servicesUrl+'/img/placeholders/league.png'" class="img-responsive media" alt="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <p class="description">
                                    @{{ league.description }}
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <label for="">League Type</label>
                                </div>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <p class="description type">
                                        @{{ league.league_type }}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <label for="">Structure Type</label>
                                </div>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <p class="description type">
                                        @{{ league.structure_type }}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <label for="">Player Expert Level</label>
                                </div>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <p class="description playerLevel">
                                        @{{ league.abilityLevel }}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <label for="">Registration Dates</label>
                                </div>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <p class="description dates">
                                        @{{ league.registrationStartAt+' to '+league.registrationCloseAt }}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <label for="">League Start Date</label>
                                </div>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <p class="description dates">
                                        @{{ league.leagueStartDate }}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <label for="">No. of Weeks</label>
                                </div>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <p class="description dates">
                                        @{{ league.numberOfWeeks }}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <label for="">Winning Criteria</label>
                                </div>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <p class="description type">
                                        @{{ league.winning_criteria }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


</template>
<script>


    Vue.component('league-details', {
        template: "#leagueDetailsTemplate",
        props: [
                "league",
                "servicesUrl",


        ],
        mounted:function(){

        },
        computed:{

        },
        data:function(){
            return {

            }
        },
        methods: {



        }
    });
</script>