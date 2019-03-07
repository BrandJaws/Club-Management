
<template id="eventsFormTemplate">

    <div>
        <div class="text-left form-group">
            <a style="border-radius: 40px !important; min-width: 120px;" href="#." class="btn btn-outline blue-steel btn-sm addEvent m-t-15 " v-on:click.prevent="addNewEvent"><i class="fa fa-plus"></i>&nbsp;Add Event</a>
        </div>
        <!--Event Box-->
        <div class="eventBox bg-grey-steel mb30 mt30" v-for="(event,eventIndex) in eventsData">
            <div class="p-25">
                <div class="portlet-title">
                    <div class="caption captionMD">
                        <span class="caption-subject">Add Event</span>
                    </div>
                    <div class="action-btns">
                        <div class="btn-group btn-group-circle text-right">
                            <a style="padding: 5px 16px; width: 85px" type="submit" class="btn btn-outline red btn-sm delEvent" v-on:click.prevent="removeEvent(eventIndex)"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                        </div>


                    </div>
                </div>
                <div :class="['form-group', event.errors != undefined && event.errors.name != undefined ? 'has-error': '']">
                    <label class="control-label">Event name</label>
                    <input type="text"  class="form-control" placeholder='Event name' v-model="event.name"/>
                    <span class="help-block" v-if="event.errors != undefined && event.errors.name != undefined">@{{event.errors.name }}</span>
                </div>
                <div :class="['form-group', event.errors != undefined && event.errors.maxNumberOfPlayers != undefined ? 'has-error': '']">
                    <label class="control-label"> Max no of players</label>
                    <input type="number" class="form-control" placeholder='Max no of players' v-model="event.maxNumberOfPlayers"/>
                    <span class="help-block" v-if="event.errors != undefined && event.errors.maxNumberOfPlayers != undefined">@{{event.errors.maxNumberOfPlayers }}</span>
                </div>
                <div :class="['form-group', event.errors != undefined && event.errors.event_type != undefined ? 'has-error': '']">
                    <label class="control-label">Event Type</label>
                    <select  id="" class="form-control" v-model="event.event_type">
                        <option v-for="eventType in eventTypes" :value="eventType.key">@{{ eventType.value }}</option>
                    </select>
                    <span class="help-block" v-if="event.errors != undefined && event.errors.event_type != undefined">@{{event.errors.event_type }}</span>
                </div>
                <div :class="['form-group', event.errors != undefined && event.errors.elimination_type != undefined ? 'has-error': '']">
                    <label class="control-label">Elimination Type</label>
                    <select  id="" class="form-control" v-model="event.elimination_type">
                        <option v-for="eliminationType in eliminationTypes" :value="eliminationType.key">@{{ eliminationType.value }}</option>
                    </select>
                    <span class="help-block" v-if="event.errors != undefined && event.errors.elimination_type != undefined">@{{event.errors.elimination_type }}</span>
                </div>
            </div>
        </div>
        <!--Event Box End-->
        <input type="hidden" name="tournament_events" :value="eventsCollective">
    </div>

</template>
<script>


    Vue.component('events-form', {
        template: "#eventsFormTemplate",
        props: [
            "events"
        ],
        data:function () {
            return {
                eventsData:JSON.parse(JSON.stringify(this.events)),
                eliminationTypes:[
                    {"key":"SIMPLE ELIMINATION","value":"Simple Elimination"},
                    {"key":"DOUBLE ELIMINATION","value":"Double Elimination"},
                    {"key":"ROUND ROBIN","value":"Round Robin"},

                ],
                eventTypes:[
                    {"key":"MENS SINGLES","value":"Mens' Singles"},
                    {"key":"WOMENS SINGLES","value":"Womens' Singles"},
                    {"key":"MENS DOUBLES","value":"Mens' Doubles"},
                    {"key":"WOMENS DOUBLES","value":"Womens' Doubles"},
                    {"key":"MIX SINGLES","value":"Mix Singles"},
                    {"key":"MIX DOUBLES","value":"Mix Doubles"},


                ],


            }
        },
        mounted:function(){
            if(!(this.eventsData instanceof Array) || this.eventsData.length == 0){
                this.addNewEvent();
            }
        },
        computed:{
            eventsCollective:function(){

                return JSON.stringify(this.eventsData);
            }
        },
        methods: {
            addNewEvent:function(){
                this.eventsData.push({
                    name:"",
                    maxNumberOfPlayers:"",
                    event_type:this.eventTypes[0].key,
                    elimination_type:this.eliminationTypes[0].key,
                });
            },
            removeEvent:function(eventIndex){
                if(this.eventsData.length <= 1){
                    return;
                }
                this.eventsData.splice(eventIndex,1);
            }
        }
    });
</script>