@extends('__layouts.admin')
@section('main')

<!-- BEGIN PAGE HEADER-->

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a>
			<i class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/club')}}">Profile</a></li>
	</ul>
</div>
<h3 class="page-title">Profile</h3>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row margin-top-20">
	<div class="col-md-12">
		<!-- BEGIN PROFILE SIDEBAR -->
		<div class="profile-sidebar">
			<!-- PORTLET MAIN -->
			<div class="portlet light profile-sidebar-portlet">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
			<img src="{{(isset($data['profilePic']) && $data['profilePic'])?asset($data['profilePic']):'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' }}" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">{{isset($data['firstName'])?$data['firstName']:''}}
						{{isset($data['lastName'])?$data['lastName']:''}}
					</div>
        		</div>
				<br />
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->

				<!-- END SIDEBAR BUTTONS -->
			</div>
			<!-- END PORTLET MAIN -->
			<!-- PORTLET MAIN -->

			<!-- END PORTLET MAIN -->
		</div>
		<!-- END BEGIN PROFILE SIDEBAR -->
		<!-- BEGIN PROFILE CONTENT -->
		<div class="profile-content">
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title tabbable-line">
							<div class="caption caption-md">
								<i class="icon-globe theme-font hide"></i> <span
									class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
							</div>
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1_1" data-toggle="tab">Personal Info</a></li>
								<!--<li><a href="#tab_1_2" data-toggle="tab">Create Court</a></li> -->
								<li><a href="#tab_1_3" data-toggle="tab">Change Password</a></li>
								<li><a href="#tab_1_4" data-toggle="tab">Club Settings</a></li>
							</ul>
						</div>

						<div class="portlet-body">
							<div class="tab-content">
								<!-- PERSONAL INFO TAB -->
								<div class="tab-pane active" id="tab_1_1">
									{!! Form::open(['route'=>['club.update'], 'id'=>'form-login','class'=>'login-form', 'method'=>'put','enctype'=>'multipart/form-data']) !!}
									@if(Session::has('serverError'))
									<div class="alert alert-warning" role="alert">
										{{Session::get('serverError')}}</div>
									@endif @if(Session::has('success'))
									<div class="alert alert-success" role="alert">
										{{Session::get('success')}}</div>
									@endif
									<div
										class="form-group {{($errors->has('firstName'))?'has-error':''}}">
										<label class="control-label">First Name</label>
										<!-- <input type="text" placeholder="John" class="form-control" name="firstName" value="{{isset($data['firstName'])?$data['firstName']:''}}"/> -->
										{!! Form::text('firstName', (Input::old('firstName'))?Input::old('firstName'):$data['firstName'],
										['class'=>'form-control', 'placeholder'=>'First Name'] ) !!}
										@if($errors->has('firstName')) 
											<span class="help-block">{{$errors->first('firstName') }}</span> 
										@endif
									</div>
									<div
										class="form-group {{($errors->has('lastName'))?'has-error':''}}">
										<label class="control-label">Last Name</label>
										<!-- <input type="text" placeholder="Doe" class="form-control" name="lastName" value="{{isset($data['lastName'])?$data['lastName']:''}}"/> -->
										{!! Form::text('lastName', (Input::old('lastName'))?Input::old('lastName'):$data['lastName'],['class'=>'form-control placeholder-no-fix','placeholder'=>'Last Name'] ) !!}
										@if($errors->has('lastName')) 
											<span class="help-block">{{$errors->first('lastName') }}</span> 
										@endif
									</div>
									<div
										class="form-group {{($errors->has('phone'))?'has-error':''}}">
										<label class="control-label">Mobile Number</label>
										<!-- <input type="text" placeholder="+1 646 580 DEMO (6284)" class="form-control" value="{{isset($data['phone'])?$data['phone']:''}}"/> -->
										{!! Form::number('phone', (Input::old('phone'))?Input::old('phone'):$data['phone'],['class'=>'form-control placeholder-no-fix','placeholder'=>'+1 646 580 DEMO (6284)'] ) !!}
										@if($errors->has('phone')) 
										<span class="help-block">
												{{$errors->first('phone') }}
										</span> 
										@endif
									</div>
									<div
										class="form-group {{($errors->has('email'))?'has-error':''}}">
										<label class="control-label">Email</label>
										<!-- <input type="text" placeholder="Email" class="form-control" value="{{isset($data['email'])?$data['email']:''}}"/> -->
										{!! Form::email('email', (Input::old('email'))?Input::old('email'):$data['email'],['class'=>'form-control placeholder-no-fix','placeholder'=>'Email'] ) !!} 
										@if($errors->has('email')) 
												<span class="help-block">{{ $errors->first('email') }}</span>
										@endif
									</div>
									<?php /*?>
									<div
										class="form-group {{($errors->has('gender'))?'has-error':''}}">
										<label class="control-label">Gender</label> {!!
										Form::select('gender', array('Male' => 'Male', 'Female' =>
										'Female'),(Input::old('gender'))?Input::old('gender'):$data['gender'],array('class' => 'form-control') ) !!}
										<!--  Form::select('gender', array(
    'Male' => array('male' => 'Male'),
    'Female' => array('female' => 'Female'),
)); -->
									</div>
									<?php */?>
									<div class="form-group {{($errors->has('profilePic'))?'has-error':''}}">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
												<img id="profilePicPreviewImage" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail"
												 style="max-width: 200px; max-height: 150px;"></div>
											<div>
												<span class="btn default btn-file"> <span
															class="fileinput-new"> Select image </span> <span
															class="fileinput-exists"> Change </span> <input type="file"
																											name="profilePic">
												</span> <a href="javascript:;"
														   class="btn default fileinput-exists"
														   data-dismiss="fileinput"> Remove </a>
											</div>
										</div>
										<div class="clearfix margin-top-10">
											<span class="label label-danger">NOTE!</span> <span>Attached
												image thumbnail is supported in Latest Firefox,
												Chrome,Opera, Safari and Internet Explorer 10 only </span>
										</div>
										@if($errors->has('profilePic'))
											<span class="help-block">{{ $errors->first('profilePic') }}</span>
										@endif
									</div>

									<div class="margiv-top-10">
										<!-- <button class="btn green-haze" type="submit"> Save Changes </button> -->
										{!! Form::button('Save Changes', ['class'=>'btn red btn-outline btn-circle',
										'type'=>'submit']) !!}
									</div>
									{!! Form::close() !!}
								</div>
								<!-- END PERSONAL INFO TAB -->



								<!-- CHANGE PASSWORD TAB -->
								<div class="tab-pane" id="tab_1_3">
									<form action="#">
										<div class="form-group">
											<label class="control-label">Current Password</label> <input
												type="password" class="form-control" />
										</div>
										<div class="form-group">
											<label class="control-label">New Password</label> <input
												type="password" class="form-control" />
										</div>
										<div class="form-group">
											<label class="control-label">Re-type New Password</label> <input
												type="password" class="form-control" />
										</div>
										<div class="margin-top-10">
											<a href="javascript:;" class="btn red btn-outline btn-circle"> Change
												Password </a> <a href="javascript:;" class="btn red btn-circle">
												Cancel </a>
										</div>
									</form>
								</div>
								<!-- END CHANGE PASSWORD TAB -->
								
								<!-- Club Settings Tab -->
								
									<div class="tab-pane" id="tab_1_4">
									{!! Form::open(['route'=>['club.settings'], 'id'=>'update-club-settings','class'=>'login-form', 'method'=>'put','enctype'=>'multipart/form-data']) !!}
										<div class="form-group {{($errors->has('email'))?'has-error':''}}">
											<label class="control-label">Main Member Hours (min)</label>
											<input name="mainMember" type="text" class="form-control" value="{!! (isset($club['mainMember']))?$club['mainMember']/60:0 !!}" />
											@if($errors->has('email')) 
												<span class="help-block">{{ $errors->first('email') }}</span>
											@endif
										</div>
										<div class="form-group {{($errors->has('email'))?'has-error':''}}">
											<label class="control-label">Spouse Hours (min)</label> 
											<input name="spouse" type="text" class="form-control" value="{!! (isset($club['spouse']))?$club['spouse']/60:0 !!}"/>
											@if($errors->has('email')) 
												<span class="help-block">{{ $errors->first('email') }}</span>
											@endif
										</div>
										<div class="form-group {{($errors->has('email'))?'has-error':''}}">
											<label class="control-label">Child Hours (min)</label> 
											<input name="child" type="text" class="form-control" value="{!! (isset($club['child']))?$club['child']/60:0 !!}"/>
											@if($errors->has('email')) 
												<span class="help-block">{{ $errors->first('email') }}</span>
											@endif
										</div>
										<div class="margin-top-10">
											{!! Form::button('Save Changes', ['class'=>'btn red btn-outline btn-circle','type'=>'submit']) !!}
											<!-- <a href="javascript:;" class="btn default"> Cancel </a> -->
										</div>
									{!! Form::close() !!}
								</div>
								
								<!-- End Club Settings Tab -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END PROFILE CONTENT -->
	</div>
</div>

@endsection

@section('page-specific-scripts')
<!-- END PAGE CONTENT-->
<link href="{{asset("assets/pages/css/profile.min.css")}}" rel="stylesheet" type="text/css" />
<script src="{{asset("assets/pages/scripts/profile.min.js")}}" type="text/javascript"></script>
<link href="{{asset("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css")}}" rel="stylesheet" type="text/css" />-
<script src="{{asset("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/global/plugins/jquery.sparkline.min.js")}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>

<script>
    jQuery(document).ready(function() {

        new Morris.Bar({
            element: "graph",
            data: [{
                y: "2006",
                a: 100,
                b: 90
            }, {
                y: "2007",
                a: 75,
                b: 65
            }, {
                y: "2008",
                a: 50,
                b: 40
            }, {
                y: "2009",
                a: 75,
                b: 65
            }, {
                y: "2010",
                a: 50,
                b: 40
            }, {
                y: "2011",
                a: 75,
                b: 65
            }, {
                y: "2012",
                a: 100,
                b: 90
            }],
            xkey: "y",
            ykeys: ["a", "b"],
            labels: ["Series A", "Series B"]
        }), new Morris.Donut({
            element: "morris_chart_4",
            data: [{
                label: "Download Sales",
                value: 12
            }, {
                label: "In-Store Sales",
                value: 30
            }, {
                label: "Mail-Order Sales",
                value: 20
            }]
        })
    });

	$("#profilePic").change(function() {
		readURL(this);
	});

	function readURL(input) {

		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#profilePicPreviewImage').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}


</script>
@endsection


