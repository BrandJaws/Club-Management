<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
<meta charset="utf-8"/>
<title>Grit Dashboard - Login</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/global/plugins/font-awesome/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/global/plugins/simple-line-icons/simple-line-icons.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/global/plugins/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css")}}" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="{{asset("assets/global/plugins/select2/css/select2.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/global/plugins/select2/css/select2-bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="{{asset("assets/global/css/components.min.css")}}" rel="stylesheet" id="style_components" type="text/css" />
<link href="{{asset("assets/global/css/plugins.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/custom.css")}}" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="{{asset("assets/pages/css/login.min.css")}}" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<!-- END THEME LAYOUT STYLES -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
	<a href="">
	<img src="{{asset('assets/img/logo.png')}}" alt=""/>
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
        
	{!! Form::open(['url' => '/login', 'id'=>'form-login', 'class'=>'login-form', 'method'=>'post']) !!}
		<h3 class="form-title">Login to your account</h3>
		@if(Session::has('serverError'))
          <div class="alert alert-danger" role="alert">
  			{{Session::get('serverError')}}
		  </div>
        @endif
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			Enter any username and password. </span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			
			{!! Form::label('email', 'Username', array('class' => 'control-label visible-ie8 visible-ie9')) !!}
			<div class="input-icon">
				<i class="fa fa-user"></i>
			{!! Form::email('email', Input::old('email'), ['id'=>'loginEmail' ,'class'=>'form-control placeholder-no-fix',  'placeholder'=>'Username'] ) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('password', 'Password', array('class' => 'control-label visible-ie8 visible-ie9')) !!}
			<div class="input-icon">
				<i class="fa fa-lock"></i>
			{!! Form::password('password', ['id'=>'sucrity' , 'class'=>'form-control placeholder-no-fix', 'autocomplete'=>'off', 'placeholder'=>'Password' ] ) !!}
			</div>
		</div>
		<div class="form-actions customLoginFormAction">
			{!! Form::button('Login <i class="fa fa-arrow-circle-o-right"></i>', ['class'=>'btn btn-outline btn-circle red', 'type'=>'submit']) !!}
			<label class="rememberme pull-right check mt-checkbox mt-checkbox-outline" style="margin-top: 10px;">
				<input id="rem" type="checkbox" name="remember" value="1" />Remember Me
				<span></span>
			</label>
		</div>
		{{--<div class="form-actions">--}}
			{{--<label class="checkbox">--}}
			{{--<input type="checkbox" name="remember" value="1"/> Remember me </label>--}}
			{{--{!! Form::button('Login <i class="m-icon-swapright m-icon-white"></i>', ['class'=>'btn red pull-right', 'type'=>'submit']) !!}--}}
		{{--</div>--}}
		
		<div class="forget-password">
			<h4>Forgot your password ?</h4>
			<p>
				 no worries, click <a href="javascript:;" id="forget-password">
				here </a>
				to reset your password.
			</p>
		</div>
	{!! Form::close() !!} 
	<!-- END LOGIN FORM -->
	<!-- BEGIN FORGOT PASSWORD FORM -->

	{!! Form::open(['url' => '/forget', 'class'=>'forget-form', 'method'=>'post']) !!}
		<h3>Forgot Password ?</h3>
		<p>
			 Enter your e-mail address below to reset your password.
		</p>
		<div class="form-group">
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				{!! Form::email('email', '', ['class'=>'form-control placeholder-no-fix', 'autocomplete'=>'off', 'placeholder'=>'email'] ) !!}
			</div>
		</div>
		<div class="form-actions customLoginFormAction">
			{!! Form::button('Back <i class="m-icon-swapleft"></i>', ['class'=>'btn btn-outline btn-circle','id'=>'back-btn','type'=>'button']) !!}
			{!! Form::button('Submit <i class="fa fa-arrow-circle-o-right"></i>', ['class'=>'btn red btn-circle btn-outline pull-right', 'type'=>'submit']) !!}
		</div>
	
	<!-- END FORGOT PASSWORD FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
	&copy;&nbsp;2016. Design and Developed for Grit
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN CORE PLUGINS -->
<script src="{{asset("assets/global/plugins/jquery.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/global/plugins/bootstrap/js/bootstrap.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/global/plugins/js.cookie.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/global/plugins/jquery.blockui.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset("assets/global/plugins/jquery-validation/js/jquery.validate.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/global/plugins/jquery-validation/js/additional-methods.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/global/plugins/select2/js/select2.full.min.js")}}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{asset("assets/global/scripts/app.min.js")}}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset("assets/pages/scripts/login.min.js")}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
<script>
    $(document).ready(function()
    {
        $('#clickmewow').click(function()
        {
            $('#radio1003').attr('checked', 'checked');
        });
    })

	// Remeber me functionality

	$(document).ready(function(){
		$('#form-login').submit(function() {
			if ($('#rem').is(':checked')) {

				var username = $('#loginEmail').val();
				var password = $('#sucrity').val();
				// set cookies to expire in 14 days
				Cookies.set('username', username, { expires: 14 });
				Cookies.set('password', password, { expires: 14 });
				Cookies.set('remember', true, { expires: 14 });
			} else {
				// reset cookies
				Cookies.remove('username');
				Cookies.remove('password');
				Cookies.remove('remember');
			}
			return true;
		});

		var remember = Cookies.get('remember');

		if(remember == 'true'){
			var username = Cookies.get('username');
			var password = Cookies.get('password');
			$('#loginEmail').attr("value", username);
			$('#sucrity').attr("value", password);
			$('#rem').prop('checked', true);
		}

	});

</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>