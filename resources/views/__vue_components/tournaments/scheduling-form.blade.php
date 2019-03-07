
<template id="schedulingFormTemplate">

    <div id="schedulingFormVueContainer">

        <div class="text-left form-group">
            <a style="border-radius: 40px !important; min-width: 120px;" href="#." class="btn btn-outline blue-steel btn-sm addEvent m-t-15 " v-on:click.prevent="addNewSchedule"><i class="fa fa-plus"></i>&nbsp;Add Schedule</a>
        </div>
        <!--Weeks Days-->
        <div class="weekBox bg-grey-steel mb30 mt30" v-for="(schedule,scheduleIndex) in schedulingDetailsData">
            <div class="p-25">
                <div class="portlet-title">
                    <div class="caption captionMD">
                        <span class="caption-subject">Set Reservation Schedule</span>
                    </div>
                    <div class="action-btns">
                        <div class="btn-group btn-group-circle text-right">
                            <a style="padding: 5px 16px; width: 85px" type="submit" class="btn btn-outline red btn-sm" v-on:click.prevent="removeSchedule(scheduleIndex)"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                        </div>


                    </div>
                </div>
                <div :class="['form-group', schedule.errors != undefined && schedule.errors.selectedDay != undefined ? 'has-error': '']" >
                    <label class="control-label">Day</label>
                    <select class="form-control" v-model="schedule.selectedDay">
                        <option v-for="day in getAvailableDays(schedule)">@{{ day }}</option>
                    </select>
                    <span class="help-block" v-if="schedule.errors != undefined && schedule.errors.selectedDay != undefined">@{{schedule.errors.selectedDay }}</span>
                </div>
                <div :class="['form-group', schedule.errors != undefined && schedule.errors.reservationTimeStart != undefined ? 'has-error': '']"  >
                    <label class="control-label">Reservation Time Start</label>
                    <div class="input-group">
                        <input :id="'timestart-schedule-'+scheduleIndex" type="text" size="16" class="form-control timepicker-no-seconds timepicker-reservation-time-start" placeholder="Starts Time" :data-schedule-index="scheduleIndex" :value="schedule.reservationTimeStart">
									<span class="input-group-addon">
										<button class="date-set" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
									</span>
                    </div>
                    <span class="help-block" v-if="schedule.errors != undefined && schedule.errors.reservationTimeStart != undefined">@{{schedule.errors.reservationTimeStart }}</span>
                </div>
                <div :class="['form-group', schedule.errors != undefined && schedule.errors.courtSlotsBooked != undefined ? 'has-error': '']" >
                    <label class="control-label">Court slots booked</label>
                    {!! Form::number('numberOfSlots',  '', ['class'=>'form-control', 'placeholder'=>'Total Bookings', 'min'=>1,'v-model'=>'schedule.courtSlotsBooked'] ) !!}
                    <span class="help-block" v-if="schedule.errors != undefined && schedule.errors.courtSlotsBooked != undefined">@{{schedule.errors.courtSlotsBooked }}</span>
                </div>
                <div :class="['form-group', schedule.errors != undefined && schedule.errors.courts != undefined ? 'has-error': '']">
                    <label class="control-label" for="CourtSelection">Court(s)</label>
                    <select :id="'courts-schedule-'+scheduleIndex"  :data-schedule-index="scheduleIndex" class="form-control select2-courts"  multiple="multiple" tabindex="-1" aria-hidden="true" >
                        <option v-for="court in courts" :value="court.id" >@{{ court.name }}</option>
                    </select>
                    <span class="help-block" v-if="schedule.errors != undefined && schedule.errors.courts != undefined">@{{schedule.errors.courts }}</span>
                </div>
            </div>
        </div>
        <!--Weeks Days End-->
        <input type="hidden" name="scheduling_details" :value="schedulingDetailsCollective">
    </div>

</template>
<script>


    Vue.component('scheduling-form', {
        template: "#schedulingFormTemplate",
        props: [
            "schedulingDetails",
            "courts",
        ],
        data:function () {
            return {
                schedulingDetailsData:JSON.parse(JSON.stringify(this.schedulingDetails)),
                days:['MONDAY','TUESDAY','WEDNESDAY','THURSDAY','FRIDAY','SATURDAY','SUNDAY'],

            }
        },
        mounted:function(){

            var vueInstance = this;
            if(!(this.schedulingDetailsData instanceof Array) || this.schedulingDetailsData.length == 0){
                this.addNewSchedule();
            }else{

                if($.isReady){
                    $('.select2-courts').each(function(index){
                        $(this).val(vueInstance.schedulingDetailsData[index].courts);
                    });
                    $('.select2-courts').select2();
                    $('.select2-courts').on('change',function(){

                        vueInstance.schedulingDetailsData[$(this).attr('data-schedule-index')].courts = $(this).val();
                    });


                    $('.timepicker-reservation-time-start').timepicker();
                    $('.timepicker-reservation-time-start').on('change',function(){
                        vueInstance.schedulingDetailsData[$(this).attr('data-schedule-index')].reservationTimeStart = $(this).val();
                    });

                }else{
                    $(document).ready(function(){
                        $('.select2-courts').each(function(index){
                            $(this).val(vueInstance.schedulingDetailsData[index].courts);
                        });

                        $('.select2-courts').select2();
                        $('.select2-courts').on('change',function(){

                            vueInstance.schedulingDetailsData[$(this).attr('data-schedule-index')].courts = $(this).val();
                        });


                        $('.timepicker-reservation-time-start').timepicker();
                        $('.timepicker-reservation-time-start').on('change',function(){
                            vueInstance.schedulingDetailsData[$(this).attr('data-schedule-index')].reservationTimeStart = $(this).val();
                        });
                    }.bind(this));
                }
            }





        },
        computed:{
            earliestCourtOpenTime:function(){
                var earliestOpenTime = "";
                for(courtIndex in this.courts){
                    var timeObject = moment(this.courts[courtIndex].openTime,'HH:mm:ss');
                    if(earliestOpenTime === ""){
                        earliestOpenTime = timeObject;
                    }
                    else if(timeObject < earliestOpenTime){
                        earliestOpenTime = timeObject;

                    }
                }
                if(earliestOpenTime === ""){
                    return "12:00 AM";
                }else{
                    return earliestOpenTime.format('hh:mm A');
                }

            },
            schedulingDetailsCollective:function(){
                return JSON.stringify(this.schedulingDetailsData);
            }
        },
        methods: {
            testFunction:function(){
                console.log("abc");
            },
            addNewSchedule:function(){
                //Do not add a schedule if already added 7 for each day of the week
                if(this.schedulingDetailsData.length >= 7){
                    return;
                }

                var newSchedule = {
                    reservationTimeStart:this.earliestCourtOpenTime,
                    courtSlotsBooked:0,
                    courts:[],
                    selectedDay:"",

                };
                this.schedulingDetailsData.push(newSchedule);
                newSchedule.selectedDay = this.getAvailableDays(newSchedule)[0];
                vueInstance = this;

                if($.isReady){

                    this.$nextTick(function(){
                        var selectElement =  $('#courts-schedule-'+(this.schedulingDetailsData.length-1));
                        this.initializeSelect2(selectElement);
                        selectElement.on('change',function(){

                            vueInstance.schedulingDetailsData[$(this).attr('data-schedule-index')].courts = $(this).val();
                        });
                        var timeStartElement = $('#timestart-schedule-'+(this.schedulingDetailsData.length-1));
                        timeStartElement.timepicker();
                        timeStartElement.on('change',function(){
                            vueInstance.schedulingDetailsData[$(this).attr('data-schedule-index')].reservationTimeStart = $(this).val();
                        });


                    });
                }else{
                    $(document).ready(function(){

                        this.$nextTick(function(){
                            var selectElement =  $('#courts-schedule-'+(this.schedulingDetailsData.length-1));
                            this.initializeSelect2(selectElement);
                            selectElement.on('change',function(){
                                vueInstance.schedulingDetailsData[$(this).attr('data-schedule-index')].courts = $(this).val();
                            });

                            var timeStartElement = $('#timestart-schedule-'+(this.schedulingDetailsData.length-1));
                            timeStartElement.timepicker();
                            timeStartElement.on('change',function(){
                                vueInstance.schedulingDetailsData[$(this).attr('data-schedule-index')].reservationTimeStart = $(this).val();
                            });


                        });
                    }.bind(this));
                }


            },
            removeSchedule:function(scheduleIndex){
                if(this.schedulingDetailsData.length <= 1){
                    return;
                }
                this.schedulingDetailsData.splice(scheduleIndex,1);
            },
            getAvailableDays:function(schedule){
                var totalAvailableDays = JSON.parse(JSON.stringify(this.days));
                for(scheduleIndex in this.schedulingDetailsData){
                    if(this.schedulingDetailsData[scheduleIndex] != schedule && this.schedulingDetailsData[scheduleIndex].selectedDay != "" ){
                        for(dayIndex in totalAvailableDays){
                            if(totalAvailableDays[dayIndex] == this.schedulingDetailsData[scheduleIndex].selectedDay ){
                                totalAvailableDays.splice(dayIndex,1);
                                break;
                            }
                        }
                    }

                }

                return totalAvailableDays;
            },
            courtIsSelectedInSchedule:function(court,schedule){
                console.log(schedule.courts.indexOf(court.id));
            },
            updateCourtsProperty:function(){

            },
            initializeSelect2:function(selectElement){

                if (!$(selectElement).data('select2'))
                {
                    $(selectElement).select2();
                }

            }
        }
    });
</script>