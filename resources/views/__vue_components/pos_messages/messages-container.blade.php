<template id="messagesContainerTemplate">
    <div class="tennis-courts" id="reservation-tennis">
        <div class="preLoader">
            <div class="sk-cube-grid">
                <div class="sk-cube sk-cube1"></div>
                <div class="sk-cube sk-cube2"></div>
                <div class="sk-cube sk-cube3"></div>
                <div class="sk-cube sk-cube4"></div>
                <div class="sk-cube sk-cube5"></div>
                <div class="sk-cube sk-cube6"></div>
                <div class="sk-cube sk-cube7"></div>
                <div class="sk-cube sk-cube8"></div>
                <div class="sk-cube sk-cube9"></div>
            </div>
        </div>
        <!-- Nav tabs -->
        {{--<div class="tabbable-line">--}}
            {{--<ul class="nav nav-tabs" role="tablist">--}}

                {{--<li v-for="(court,courtIndex) in courts" role="presentation"--}}
                    {{--:class="courtIndex == 0 ? 'active' : null "><a :href="'#c'+court.court_id"--}}
                                                                   {{--:aria-controls="'c'+court.court_id" role="tab"--}}
                                                                   {{--data-toggle="tab">@{{court.court_name}}</a></li>--}}


            {{--</ul>--}}
        {{--</div>--}}
        <!-- Tab panes -->
        <div class="tab-content">
            <!--  preloader -->
            <div class="preloader-icon"></div>
            <div role="tabpanel"
                 :class="['active','tab-pane']" :id="'c'+1">
                <div class="scroller" style="max-height: 500px;" data-always-visible="1" data-rail-visible="0"  v-on:scroll="messagesScrolled">
                    <div class="bs-example " data-example-id="contextual-table">
                        <table class="table table-hover reservationsTabelVue">
                            <thead>
								<tr>
									<th width="20%">Employee Name</th>
									<th width="15%">Subject</th>
									<th width="30%">Message</th>
									<th width="15%">Sent at</th>
                                    <th width="10%">Action</th>
								</tr>
                            </thead>
							<tbody  v-if="messages.length == 0">
							<tr >

								<td colspan="4" style="text-align:center;" scope="row">No Messages Found </td>

							</tr>
							</tbody>
                            <tbody  v-else v-for="(message,index) in messagesList">

								<tr>
									<td width="20%" scope="row">@{{message.employee_name }}</td>
									<td width="15%" scope="row">@{{message.subject }}</td>
									<td width="30%" scope="row">@{{message.message }}</td>
									<td width="15%" scope="row">@{{message.formatted_time }}</td>
                                    <th width="10%" class="text-center">
                                        <a v-on:click="showReplyModal(message)" class="btn-circle red-thunderbird btn btn-outline green btn-sm"><i class="fa fa-reply"></i> Reply</a>
                                    </th>
								</tr>

                            </tbody>

                        </table>

                    </div>

                </div>
            </div>
            <!-- court 1 ends here -->

        </div>
        <div class="modal fade" id="createMessageModal" tabindex="-1" role="dialog" aria-labelledby="Create Message Modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="alert alert-danger fade-in" v-if="newMessageData.errorMessage != '' ">
                        @{{ newMessageData.errorMessage }}
                    </div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Reply</h4>
                    </div>
                    <div class="modal-body">
						{{--<div class="form-group ">--}}
                        	{{--<label class="form-control-label">Subject</label>--}}
                            {{--<input type="text" name="subject" value="" class="form-control" v-model="newMessageData.subject">--}}
                        {{--</div>--}}
                        <div class="form-group ">
                        	<label class="form-control-label">Message</label>
                            <textarea name="message" id="" rows="5" class="form-control" v-model="newMessageData.message"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-circle btn-outline" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-circle red btn-outline" v-on:click="reply()">Send Message</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>

    Vue.component('messages-container', {


        template: "#messagesContainerTemplate",
        props: [

            "messages",
            "baseUrl",


        ],
		mounted:function(){
			console.log(this.messages);
		},
        data: function () {

            return {
                //Null filters as at the time of initialization to send null value with the request if the filtersForBinding Equals these
                //This will save us where query clauses at the server
                nullFilters:{ restaurantMainCategoryId:0, restaurantSubCategoryId:0, memberId:-1,  dateFrom:"",dateTo:"" },
                filtersReceived : this.messages.filters != null ? this.messages.filters : { restaurantMainCategoryId:0, restaurantSubCategoryId:0, memberId:-1,  dateFrom:"", dateTo:"",timeFrom:"",timeTo:"", },
                filtersForBinding:{
                    restaurantMainCategoryId:0,
                    restaurantSubCategoryId:0,
                    memberId:-1,
                    dateFrom:"",
                    dateTo:"",
                    timeFrom:"",
                    timeTo:"",


                },
                messagesList: this.messages.data,
                ajaxRequestInProcess:false,
                nextAvailablePage:this.messages.next_page_url !== null ? 2 : null ,
                searchRequestHeld:false,
                newMessageData:{
                    subject:"",
                    message:"",
                    replied_to_id:null,
                    employee_chat_conversation_id:null,
                    errorMessage:""
                }

            }
        },
        methods: {
            showReplyModal:function(message){

                this.newMessageData.replied_to_id=message.id;
                this.newMessageData.employee_chat_conversation_id=message.employee_chat_conversation_id;
                $('#createMessageModal').modal('show');
            },
            reply:function(message){
                var request = $.ajax({

                    url: this.baseUrl+'/employee-chat',
                    method: "POST",
                    data:this.newMessageData,
                    success:function(msg){

                        this.clearNewMessageData();
                        $('#createMessageModal').modal('hide');

                    }.bind(this),

                    error: function(jqXHR, textStatus ) {

                        this.setErrorOnNewMessageData(JSON.parse(jqXHR.responseText));



                    }.bind(this)
                });
                console.log(message);
            },
            clearNewMessageData:function(){

                this.newMessageData.subject="";
                this.newMessageData.message="";
                this.newMessageData.replied_to_id=null;
                this.newMessageData.employee_chat_conversation_id=null;
                this.newMessageData.errorMessage="";
            },
            setErrorOnNewMessageData:function(msg){
                this.newMessageData.errorMessage=msg;
            },
            messagesScrolled:function(e){

                var element = e.target;
                if (element.scrollHeight - element.scrollTop === element.clientHeight)
                {
                    // element is at the end of its scroll, load more content

                    this.loadNextPage(false);
                }

            },
            loadNextPage:function(isSearchQuery){

                var _data ={};

                if(isSearchQuery){

                    if(JSON.stringify(this.filtersForBinding) ==  JSON.stringify(this.filtersReceived)){

                        return;
                    }

                    if(this.ajaxRequestInProcess){
                        this.searchRequestHeld=true;
                        return;
                    }

                    //If is search query we need to set filters equal to filters for binding that have been selected by the user
                    //Also we need to reset nextAvailablePage so that the method doesn't return void since  the nextAvailablePage
                    //might have been set to null due to previous scrolling or search results

                    _data.filters = JSON.stringify(this.filtersForBinding) == JSON.stringify(this.nullFilters) ? null : JSON.stringify(this.filtersForBinding);
                    this.nextAvailablePage = 1;
                    _data.current_page = this.nextAvailablePage;


                }else{
                    //If is scroll query we need to set filters equal to filters received last time
                    //might have been set to null due to previous scrolling or search results

                    _data.filters =  JSON.stringify(this.filtersReceived) == JSON.stringify(this.nullFilters) ? null : JSON.stringify(this.filtersReceived);
                    _data.current_page = this.nextAvailablePage;

                }

                //Return void if there is no available next page. Placed here so that in case of search query when we need to refresh the counter
                //we can set it to a non null value i-e 1 before we reach this check.
                if(this.nextAvailablePage === null){
                    return;
                }





                if(!this.ajaxRequestInProcess){
                    this.ajaxRequestInProcess = true;
                    var request = $.ajax({

                        url: this.baseUrl+'/employee-chat',
                        method: "GET",
                        data:_data,
                        success:function(msg){

                            this.ajaxRequestInProcess = false;
                            if(this.searchRequestHeld){

                                this.searchRequestHeld=false;
                                this.loadNextPage(true);

                            }

                            pageDataReceived = msg;
                            messagesList = pageDataReceived.data ;
                            this.filtersReceived = pageDataReceived.filters != null ? pageDataReceived.filters : {  restaurantMainCategoryId:0, restaurantSubCategoryId:0, memberId:-1,  dateFrom:"", timeFrom:"",timeTo:"", };

                            //Success code to follow
                            if(pageDataReceived.next_page_url !== null){
                                this.nextAvailablePage = pageDataReceived.current_page+1;
                            }else{
                                this.nextAvailablePage = null;
                            }

                            if(isSearchQuery){

                                this.messagesList=messagesList;
                            }else{

                                appendArray(this.messagesList,messagesList);
                            }



                        }.bind(this),

                        error: function(jqXHR, textStatus ) {
                            this.ajaxRequestInProcess = false;

                            //Error code to follow


                        }.bind(this)
                    });
                }
            },
		},

    });


</script>
