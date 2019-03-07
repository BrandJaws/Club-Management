@extends('__layouts.admin')
@section('heading')
    Tabs
    @endSection
@section('main') 
<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
  <ul class="page-breadcrumb">
    <li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a> <i
                        class="fa fa-angle-right"></i></li>
    <li>Tabs</li>
  </ul>
</div>
<div id="tab-account-vue-container">
<h1 class="page-title pull-left">Tab Account Details</h1>
<h1 class="page-title pull-right" v-cloak>Current Balance :  <span><strong>$ @{{tabAccount.current_balance}}</strong></span></h1>



<!-- END PAGE HEADER--> 

<!-- BEGIN PAGE CONTENT--> 

<!-- BEGIN PROFILE CONTENT -->

<div ui-view class="app-body" id="view"> 
  
  <!-- ############ PAGE START-->
  <div  class="segments-main padding">
    <message-bar v-if="messageBar.message" :type="messageBar.type" :message="messageBar.message"></message-bar>
    <div class="row">
      <div class="col-md-12">
        <div class="segments-inner">
          <div class="box"> @if(Session::has('serverError'))
            <div class="alert alert-warning" role="alert"> {{Session::get('serverError')}} </div>
            @endif
            @if(Session::has('success'))
            <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div>
            @endif 
            <!-- inner header --> 
          </div>
        </div>
      </div>
    </div>
    <tab-account-details :tab-account="tabAccount"></tab-account-details>

</div>
</div>
@endsection

@section('page-specific-scripts')
@include("__vue_components.tab-accounts.tab-account-details")
@include("__vue_components.MessageBar.message-bar") 
<script>


    var _baseUrl = "{{url('')}}";
    var vue = new Vue({
        el: "#tab-account-vue-container",
        data: {

            tabAccount: {!! json_encode($tabAccount) !!},
            baseUrl:_baseUrl,
            messageBar:{
                type:"",
                message:""
            },

        },
        computed:{

        },
        created:function(){

        },
        mounted:function(){

        },
        methods: {

            showMessageInMessageBar:function(type,message){
                this.messageBar.type = type;
                this.messageBar.message = message;
            },
            errorUpdateHandler:function(e){
                this.showMessageInMessageBar("error", e);
            },
            successUpdateHandler:function(e){
                console.log(e);
                this.showMessageInMessageBar("success", e);
            }


        },





    });

 
   
</script> 
@endSection 