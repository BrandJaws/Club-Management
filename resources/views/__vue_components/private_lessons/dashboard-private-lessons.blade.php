<template id="dashboardPrivateLessonsTemplate">
    <div>
        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 290px;"><div class="scroller slimScrollCustom" style="height: 290px; overflow-y: scroll; width: auto;" data-always-visible="1" data-rail-visible1="1" data-initialized="1">
                <ul class="feeds myfeeds">
                   <li v-for="privateLesson in privateLessonsComputed">
                    <div class="col1">
                        <div class="cont">
                            <div class="cont-col1">
                                <div class="label label-sm label-success">
                                    <i class="fa fa-bell-o"></i>
                                </div>
                            </div>
                            <div class="cont-col2">
                                <div class="desc"> 
                                    Private lesson requested by <span>@{{ privateLesson.member.firstName+' '+privateLesson.member.lastName }}</span>
                                        <span class="label label-sm label-info">
                                            <a class="label label-sm label-info" :href="baseUrl+'/private-lessons'"> Detail <i class="fa fa-share"></i></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
               <!-- <div class="well well-sm">

                     <table class="table table-bordered">
                        <thead>
                        <th>Coach</th>
                        <th>Duration(Mins)</th>
                        <th>Session</th>
                        <th>Member(s)</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>@{{ privateLesson.coach.firstName+' '+privateLesson.coach.lastName }}</td>
                            <td align="center">@{{ privateLesson.duration }}</td>
                            <td>@{{ privateLesson.session }}</td>
                            <td>@{{ privateLesson.memberNames }}</td>
                            <td><a href="#." class="btn btn-primary">Detail</a></td>
                        </tr>
                        </tbody>
                    </table> 
                </div>-->
            </div>
        </div>
    </div>
</template>

<script>


    Vue.component('dashboard-private-lessons', {
        template: '#dashboardPrivateLessonsTemplate',
        props: [
            "privateLessons",
            "baseUrl",
            "servicesUrl",
        ],
        mounted:function () {
            console.log(this.privateLessonsComputed);
        },
        data:function(){
            return {


            }
        },
        computed:{
            privateLessonsComputed:function(){
                var privateLessonsClone = JSON.parse(JSON.stringify(this.privateLessons));
                for(var privateLessonIndex in privateLessonsClone){
                    var privateLesson = privateLessonsClone[privateLessonIndex];
                    var memberNames = [];
                    for(var reservationPlayerIndex in privateLesson.reservation_players){
                        var reservationPlayer = privateLesson.reservation_players[reservationPlayerIndex];
                        memberNames.push(reservationPlayer.member.firstName+' '+reservationPlayer.member.lastName);

                    }
                    privateLesson.memberNames = memberNames.join(', ');
                }

                return privateLessonsClone;
            }
        },
        methods: {


        }
    });
</script>