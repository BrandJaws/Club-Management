@extends('__layouts.admin')
@section('heading')
	Add Employee
	@endSection
@section('main')
<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a>
			<i class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/employees')}}">Manage Employee</a><i class="fa fa-angle-right"></i></li></li>
		<li>Create Employee</li>
	</ul>
</div>
<h3 class="page-title">Employee</h3>
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
						<span class="caption-subject bold uppercase">Employee Profile</span>
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
                            {!! Form::open(['route'=>['employee.store'], 'id'=>'form-login','class'=>'login-form', 'method'=>'POST','enctype'=>'multipart/form-data']) !!}
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
                            <div class="form-group {{($errors->has('password'))?'has-error':''}}">
                                <label class="control-label">Password</label>
                                
                                <input type="password" placeholder="Password" class="form-control" value="" name="password"/>
                                {{-- Form::text('password', (Input::old('password'))?Input::old('password'):'',['class'=>'form-control placeholder-no-fix','placeholder'=>'Password'] ) --}}
                                @if($errors->has('password'))
                                    <span class="help-block">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group {{($errors->has('phone'))?'has-error':''}}">
                                <label class="control-label">Phone</label>
                                {!! Form::text('phone', (Input::old('phone'))?Input::old('phone'):'',['class'=>'form-control placeholder-no-fix','placeholder'=>'646 580 (6284)'] ) !!}
                                @if($errors->has('phone'))
                                    <span class="help-block">
												{{$errors->first('phone') }}
										</span>
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
                            
                            <div class="form-group portlet {{($errors->has('permissions'))?'has-error':''}}">

                                <div class="portlet-title tabbable-line mb30">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject bold uppercase">Permissions</span>
                                    </div>
                                </div>
                                <div class="row">
                                    @foreach(config('global.clubPermissions') as $permissionKey=>$permissionCaption)
                                        @canAccess($permissionKey)
                                            <div class="col-sm-3">

                                                <div class="form-group"> <div class="md-checkbox">
                                                        <input type="checkbox" id="{{$permissionKey}}" class="md-check" value="{{$permissionKey}}" name="permissions[]" {{(Request::old('permissions')  && array_key_exists($permissionKey,array_flip(Request::old('permissions'))))?'checked':''}}>
                                                        <label for='{{$permissionKey}}'>
                                                            <span class="inc"></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span> {{$permissionCaption}} </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @endforeach
                                </div>
                                {{--<div class="row">--}}
                                    {{--<div class="col-sm-3">--}}
                                        {{--<div class="form-group"> <div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="reservations" class="md-check" value="reservations" name="permissions[]" {{(Request::old('permissions')  && array_key_exists('reservations',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="reservations">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Reservations </label>--}}
                                            {{--</div></div>--}}

                                        {{--<div class="form-group"> <div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="reports" class="md-check" value="reports" name="permissions[]" {{(Request::old('permissions') && array_key_exists('reports',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="reports">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Reports </label>--}}
                                            {{--</div></div>--}}
                                        {{--<div class="form-group"> <div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="members" class="md-check" value="members" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('members',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="members">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Members </label>--}}
                                            {{--</div></div>--}}
                                        {{--<div class="form-group"> <div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="employees" class="md-check" value="employees" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('employees',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="employees">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Employees </label>--}}
                                            {{--</div></div>--}}

                                    {{--</div>--}}

                                    {{--<div class="col-sm-3">--}}

                                        {{--<div class="form-group"> <div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="beacons" class="md-check" value="beacons" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('beacons',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="beacons">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Beacons </label>--}}
                                            {{--</div></div>--}}

                                        {{--<div class="form-group"> <div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="courts" class="md-check" value="courts" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('courts',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="courts">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Courts </label>--}}
                                            {{--</div></div>--}}
                                        {{--<div class="form-group"> <div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="coaches" class="md-check" value="coaches" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('coaches',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="coaches">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Coaches </label>--}}
                                            {{--</div></div>--}}
                                        {{--<div class="form-group"> <div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="trainings" class="md-check" value="trainings" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('trainings',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="trainings">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Trainings </label>--}}
                                            {{--</div></div>--}}

                                    {{--</div>--}}

                                    {{--<div class="col-sm-3">--}}
                                        {{--<div class="form-group"> <div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="photoGallery" class="md-check" value="photoGallery" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('photoGallery',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="photoGallery">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Photo Gallery </label>--}}
                                            {{--</div></div>--}}

                                        {{--<div class="form-group"> <div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="news" class="md-check" value="news" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('news',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="news">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> News/Events </label>--}}
                                            {{--</div></div>--}}
                                        {{--<div class="form-group"> <div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="clubWall" class="md-check" value="clubWall" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('clubWall',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="clubWall">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Club Wall </label>--}}
                                            {{--</div></div>--}}
                                        {{--<div class="form-group"> <div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="communication" class="md-check" value="communication" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('communication',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="communication">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Communication </label>--}}
                                            {{--</div></div>--}}
                                    {{--</div>--}}

                                    {{--<div class="col-sm-3">--}}

                                        {{--<div class="form-group">--}}
                                            {{--<div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="leagues" class="md-check" value="leagues" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('leagues',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="leagues">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Leagues </label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="tournaments" class="md-check" value="tournaments" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('tournaments',array_flip(Request::old('permissions'))))?'checked':''}}>--}}
                                                {{--<label for="tournaments">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Tournaments </label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="restaurant" class="md-check" value="restaurant" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('restaurant',array_flip(Request::old('restaurant'))))?'checked':''}}>--}}
                                                {{--<label for="restaurant">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> Restaurant </label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<div class="md-checkbox">--}}
                                                {{--<input type="checkbox" id="posClient" class="md-check" value="posClient" name="permissions[]" {{(is_array(Request::old('permissions')) && array_key_exists('posClient',array_flip(Request::old('posClient'))))?'checked':''}}>--}}
                                                {{--<label for="posClient">--}}
                                                    {{--<span class="inc"></span>--}}
                                                    {{--<span class="check"></span>--}}
                                                    {{--<span class="box"></span> POS Client </label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
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
        $("#employeeSpecialities").tagsinput({
            tagClass: 'label label-danger',
            confirmKeys: [13, 44],
            trimValue: true
        });
        $("#employeeSpecialities").on('itemAdded', function(event) {
            var $field = $(this).siblings('.bootstrap-tagsinput').find('input')
            setTimeout(function(){
                $field.val('');
            }, 1);
        });
	</script>

@endsection