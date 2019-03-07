@extends('__layouts.admin') @section('main') 

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a> <i
                    class="fa fa-angle-right"></i></li>
        <li><a href="{{url('/member')}}">members</a> <i class="fa fa-angle-right"></i></li>
        <li><a href="#">Create</a></li>
    </ul>
</div>

<h1 class="page-title">
    Create Member
</h1>

<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->


<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content" id="selectionDepHidden">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['url' => route('member.store'), 'id'=>'member-form', 'class'=>'login-form', 'method'=>'post']) !!}
                            @if(Session::has('serverError'))
                                <div class="alert alert-warning" role="alert"> {{Session::get('serverError')}} </div>
                            @endif
                            @if(Session::has('success'))
                                <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div>
                            @endif
                            <div class="form-group {{($errors->has('firstName'))?'has-error':''}}">
                                <label class="control-label"> First Name</label>
                                {!! Form::text('firstName', Input::old('firstName'), ['class'=>'form-control', 'placeholder'=>'First Name'] ) !!}
                                @if($errors->has('firstName')) <span class="help-block">{{$errors->first('firstName') }}</span> @endif
                            </div>
                            <div class="form-group {{($errors->has('lastName'))?'has-error':''}}">
                                <label class="control-label"> Last Name</label>
                                {!! Form::text('lastName', Input::old('lastName'), ['class'=>'form-control', 'placeholder'=>'Last Name'] ) !!}
                                @if($errors->has('lastName')) <span class="help-block">{{$errors->first('lastName') }}</span> @endif
                            </div>
                            <div class="form-group {{($errors->has('email'))?'has-error':''}}">
                                <label class="control-label">Email</label>

                                {!! Form::text('email', Input::old('email'), ['class'=>'form-control', 'placeholder'=>'Email'] ) !!}
                                @if($errors->has('email')) <span class="help-block">{{$errors->first('email') }}</span> @endif
                            </div>
                            <div class="form-group {{($errors->has('phone'))?'has-error':''}}">
                                <label class="control-label">Phone</label>
                                {!! Form::text('phone', Input::old('phone'), ['class'=>'form-control', 'placeholder'=>'Phone'] ) !!}
                                @if($errors->has('phone')) <span class="help-block">{{$errors->first('phone') }}</span> @endif
                            </div>
                            <div class="form-group {{($errors->has('password'))?'has-error':''}}">
                                <label class="control-label">Password</label>
                                {!! Form::password('password',  ['class'=>'form-control ', 'placeholder'=>'Password'] ) !!}
                                @if($errors->has('password')) <span class="help-block">{{$errors->first('password') }}</span> @endif
                            </div>

                            <div class="form-group {{($errors->has('gender'))?'has-error':''}}">
                                <label class="control-label">Gender</label>
                                {!! Form::select('gender', array('MALE' => 'Male', 'FEMALE' => 'Female'),'',array('class' => 'form-control') ) !!}
                                @if($errors->has('gender')) <span class="help-block">{{$errors->first('gender') }}</span> @endif
                            </div>

<!--
                            <div class="form-group {{($errors->has('dob'))?'has-error':''}}">
                                <label class="control-label">DOB</label>
                                {!! Form::text('dob', Input::old('dob'), ['class'=>'form-control date-picker', 'placeholder'=>'Date of Birth'] ) !!}
                                @if($errors->has('dob')) <span class="help-block">{{$errors->first('dob') }}</span> @endif
                            </div>
-->
                            
                            
                            <div class="form-group {{($errors->has('dob'))?'has-error':''}}">
								<label class="control-label">DOB</label>
								<div class="input-group date date-picker" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
									{!! Form::text('dob', Input::old('dob'), ['class'=>'form-control date-picker', 'placeholder'=>'Date of Birth'] ) !!}
									<span class="input-group-addon">
										<button class="date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
                            
                            
                            <div class="row row-sm">
							<div class="col-md-3">
								<div class="form-group form-group-inline">
									<label class="form-control-label">Member Type</label>
								</div>
							</div>
							<div class="col-md-8">
								<div class="row row-sm">
									<div class="col-md-3">
										<div class="form-group">
											<div class="radio">
												<label class="ui-check"> 
												<input v-model="memberType" type="radio" name="relation" value="parent" class="has-value" @change="affiliate()" /> <i class="dark-white"></i> Parent
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<div class="radio">
												<label class="ui-check"> <input v-model="memberType"
													type="radio" name="relation" value="affiliate"
													class="has-value" @change="affiliate()" /> <i
													class="dark-white"></i> Affiliate Member
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- End Layout for membertype -->
							
							<!-- Start of VU componenet -->
							<div class="row-sm animated fadeInUp" v-cloak v-if="showParentSelector">
							
							<div class="col-md-12">
							<div class="row row-sm">
                                	<div class="col-md-3">
                                    <div class="form-group form-group-inline">
                                        <label class="form-control-label">Relation</label>
                                    </div>
                                   </div>
                                	<div class="col-md-3">
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label class="ui-check"> 
                                                    <input v-model="affiliate_type"  type="radio" name="type" value="SPOUSE"  class="has-value" /> 
                                                    	<i class="dark-white"></i> Spouse
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label class="ui-check"> 
                                                    <input v-model="affiliate_type"  type="radio" name="type" value="CHILD"  class="has-value"  /> <i
                                                                class="dark-white"></i> Child
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                	</div>
								<div class="row row-sm">
									<div class="col-md-4">
										<div class="form-group">
											<label class="form-control-label">Select Parent Member</label>
										</div>
									</div>
									<div class="col-md-8">
										<div class="form-group {{($errors->has('parentMember'))?'has-error':''}}" id="membersPageAutoCom">
											 <auto-complete-box url="{{url('member/list')}}" property-for-id="id" property-for-name="name"
                                                                   filtered-from-source="true" include-id-in-list="true"
                                                                   v-model="selectedId" initial-text-value="" search-query-key="search" field-name="parentMember"></auto-complete-box>
												@if($errors->has('parentMember')) <span class="help-block errorProfilePic">{{$errors->first('parentMember') }}</span> @endif
										</div>
									</div>
								</div>
							</div>
						</div>
							
							
							<!-- End of VU componenent -->
							
						</div>
                            <div class="fom-group text-right m-t-30">
                                {!! Form::button('Create Member', ['class'=>'btn btn-lg red btn-outline btn-circle', 'type'=>'submit']) !!}
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PROFILE CONTENT --> 
<!-- END PAGE CONTENT--> 
@stop 
@section('page-specific-scripts')
<!--
    <link href="{{asset("assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")   }}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/pages/scripts/components-date-time-pickers.min.js")}}" type="text/javascript"></script>
-->

<!-- <link href="{{asset("assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css")}}" rel="stylesheet" type="text/css" />


<script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")}}" type="text/javascript"></script>


<script src="{{asset("assets/pages/scripts/components-date-time-pickers.js")}}" type="text/javascript"></script>
 -->

<link href="{{asset("assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js")}}" type="text/javascript"></script>
    
    <link href="{{asset("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")   }}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/pages/scripts/components-date-time-pickers.js")}}" type="text/javascript"></script>
    

@include("__vue_components.autocomplete.autocomplete")
<script>
	var parentSelectionError =  "{{$errors->has('parentMember')  ? $errors->first('parentMember'): '' }}" ;
	var main_member = '';

        var vue = new Vue({
            el: "#selectionDepHidden",
            data: {
                memberType:'{{(old('relation') == 'affiliate')?'affiliate':'parent'}}',
                selectedId: '',
                affiliate_type:'{{(old('relation') == 'affiliate' )?old('type'):'SPOUSE'}}'
            },
			computed:{
				showParentSelector:function(){
					if (this.memberType == 'affiliate') {
						return true;
					}
					else {
						return false;
					}
				}
			},
            methods: {

            }
        });
    </script>
@endSection