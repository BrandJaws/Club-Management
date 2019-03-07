@extends('__layouts.admin')
@section('heading')
	Add Coach
	@endSection
@section('main')
<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a>
			<i class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/coaches')}}">Manage Coach</a><i class="fa fa-angle-right"></i></li></li>
		<li>Create Coach</li>
	</ul>
</div>
<h3 class="page-title">Coach</h3>
<!-- END PAGE HEADER-->
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PROFILE SIDEBAR -->
		<div class="profile-sidebar">
			<!-- PORTLET MAIN -->
			<div class="portlet light profile-sidebar-portlet " style="padding: 30px 0 30px!important">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
                    <img src="{{(isset($data['profilePic']) && $data['profilePic'])?asset($data['profilePic']):'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image' }}" class="img-responsive" alt="">
                </div>
			</div>
			<!-- END PORTLET MAIN -->
		</div>
		<!-- END BEGIN PROFILE SIDEBAR -->
<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-title tabbable-line">
					<div class="caption caption-md">
						<i class="icon-globe theme-font hide"></i>
						<span class="caption-subject bold uppercase">Coach Profile</span>
					</div>
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#tab_1_1" data-toggle="tab">Personal Info</a>
						</li>
					</ul>
				</div>
				<div class="portlet-body">
					<div class="tab-content">
                        <!-- PERSONAL INFO TAB -->
                        <div class="tab-pane active" id="tab_1_1">
                            {!! Form::open(['route'=>['coaches.store'], 'id'=>'form-login','class'=>'login-form', 'method'=>'POST','enctype'=>'multipart/form-data']) !!}
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
                                {!! Form::text('firstName', (Input::old('firstName'))?Input::old('firstName'):'',['class'=>'form-control', 'placeholder'=>'First Name'] ) !!}
                                @if($errors->has('firstName'))
                                    <span class="help-block">{{$errors->first('firstName') }}</span>
                                @endif
                            </div>
                            <div
                                    class="form-group {{($errors->has('lastName'))?'has-error':''}}">
                                <label class="control-label">Last Name</label>
                            <!-- <input type="text" placeholder="Doe" class="form-control" name="lastName" value="{{isset($data['lastName'])?$data['lastName']:''}}"/> -->
                                {!! Form::text('lastName', (Input::old('lastName'))?Input::old('lastName'):'',['class'=>'form-control placeholder-no-fix','placeholder'=>'Last Name'] ) !!}
                                @if($errors->has('lastName'))
                                    <span class="help-block">{{$errors->first('lastName') }}</span>
                                @endif
                            </div>
                            <div class="form-group {{($errors->has('email'))?'has-error':''}}">
                                <label class="control-label">Email</label>
                            <!-- <input type="text" placeholder="Email" class="form-control" value="{{isset($data['email'])?$data['email']:''}}"/> -->
                                {!! Form::email('email', (Input::old('email'))?Input::old('email'):'',['class'=>'form-control placeholder-no-fix','placeholder'=>'Email'] ) !!}
                                @if($errors->has('email'))
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group {{($errors->has('phone'))?'has-error':''}}">
                                <label class="control-label">Mobile Number</label>
                                {!! Form::text('phone', (Input::old('phone'))?Input::old('phone'):'',['class'=>'form-control placeholder-no-fix','placeholder'=>'646 580 (6284)'] ) !!}
                                @if($errors->has('phone'))
                                    <span class="help-block">
												{{$errors->first('phone') }}
										</span>
                                @endif
                            </div>
                            <div class="form-group coachSpecialitiesCls {{($errors->has('specialities'))?'has-error':''}}">
                                <label class="control-label">Specialities</label>
                                {!! Form::text('specialities', (Input::old('specialities'))?Input::old('specialities'):'',['class'=>'form-control  placeholder-no-fix','placeholder'=>'Specialities', 'id'=>'coachSpecialities','data-role'=>'tagsinput'] ) !!}
                                @if($errors->has('specialities'))
                                    <span class="help-block">{{$errors->first('specialities') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{($errors->has('profilePic'))?'has-error':''}}">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                         style="max-width: 200px; max-height: 150px;"></div>
                                    <div>
												<span class="btn default btn-file"> <span
                                                            class="fileinput-new"> Select image </span> <span
                                                            class="fileinput-exists"> Change </span> <input class="" type="file"
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
                            <div class="form-group m-t-30 text-right">
                                <!-- <button class="btn green-haze" type="submit"> Save Changes </button> -->
                                {!! Form::button('Save Changes', ['class'=>'btn red btn-circle btn-lg btn-outline','type'=>'submit']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <!-- END PERSONAL INFO TAB -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END PROFILE CONTENT -->
<!-- END PAGE CONTENT-->
@endSection
@section('page-specific-scripts')
    <link href="{{asset("assets/pages/css/profile.min.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/pages/scripts/profile.min.js")}}" type="text/javascript"></script>
    <link href="{{asset("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css")}}" rel="stylesheet" type="text/css" />-
    <script src="{{asset("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/jquery.sparkline.min.js")}}" type="text/javascript"></script>
    <link href="{{asset("assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js")}}" type="text/javascript"></script>
    <script>
        $("#coachSpecialities").tagsinput({
            tagClass: 'label label-danger',
            confirmKeys: [13, 44],
            trimValue: true
        });
        $("#coachSpecialities").on('itemAdded', function(event) {
            var $field = $(this).siblings('.bootstrap-tagsinput').find('input')
            setTimeout(function(){
                $field.val('');
            }, 1);
        });
	</script>

@endsection