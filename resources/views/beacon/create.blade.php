@extends('__layouts.admin') @section('main')

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="/dashboard">Home</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/beacon')}}">Configure Beacon</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="#.">Create</a></li>
	</ul>
</div>

<h1 class="page-title">
	Configure Beacon
</h1>

<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->


<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							{!! Form::open(['url' => route('beacon.store'), 'id'=>'form-login',
					'class'=>'login-form', 'method'=>'post']) !!}
							@if(Session::has('serverError'))
								<div class="alert alert-warning" role="alert">
									{{Session::get('serverError')}}</div>
							@endif @if(Session::has('success'))
								<div class="alert alert-success" role="alert">
									{{Session::get('success')}}</div>
							@endif
						<!-- beacon fields starts from here  -->
							<div class="form-group {{($errors->has('court_id'))?'has-error':''}}">
								<label class="control-label">Court</label>

								<select name="court_id" class="form-control">
									@foreach($data as $court)
										<option value="{{$court["id"] }}">{{$court["name"] }}</option>
									@endforeach
								</select>
								@if($errors->has('beaconCourt')) <span class="help-block">{{$errors->first('beaconCourt') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('beaconName'))?'has-error':''}}">
								<label class="control-label">Beacon Name</label>
								{!! Form::text('name',Input::old('name'), ['class'=>'form-control','placeholder'=>'Beacon Name'] ) !!}
								@if($errors->has('name')) <span class="help-block">{{$errors->first('beaconName') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('udId'))?'has-error':''}}">
								<label class="control-label">UDID</label>
								{!! Form::text('UUID',Input::old('beaconName'), ['class'=>'form-control','placeholder'=>'UUID'] ) !!}
								@if($errors->has('UUID')) <span class="help-block">{{$errors->first('udId') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('major'))?'has-error':''}}">
								<label class="control-label">Major</label>
								{!! Form::text('major',Input::old('major'), ['class'=>'form-control','placeholder'=>'Major'] ) !!}
								@if($errors->has('major')) <span class="help-block">{{$errors->first('major') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('minor'))?'has-error':''}}">
								<label class="control-label">Minor</label>
								{!! Form::text('minor',Input::old('minor'), ['class'=>'form-control','placeholder'=>'Minor'] ) !!}
								@if($errors->has('minor')) <span class="help-block">{{$errors->first('minor') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('recordCheckin'))?'has-error':''}}">
								<label class="control-label">Record Check In</label>
								{!!Form::select('recordCheckin', array('NEAR' => 'Near', 'FAR' =>'Far', 'IMMEDIATE' => 'Immediate'),'',array('class' => 'form-control') ) !!}
								@if($errors->has('recordCheckin')) <span class="help-block">{{$errors->first('recordCheckin') }}</span> @endif
							</div>
							{{--<div class="form-group">--}}
								{{--<label class="checkbox-inline"><input type="checkbox" value="">Activate Beacon</label>--}}
							{{--</div>--}}
							<div class="form-group">
								<div class="md-checkbox">
									<input type="checkbox" id="checkbox6" class="md-check">
									<label for="checkbox6">
										<span class="inc"></span>
										<span class="check"></span>
										<span class="box"></span> Activate Beacon </label>
								</div>
							</div>
							<!--  beacon fields ends here -->
						<!-- 					<div class="form-group {{($errors->has('name'))?'has-error':''}}"> -->
							<!-- 						<label class="control-label">Name</label>  -->
						<!--                         {!! Form::text('name',Input::old('name'), ['class'=>'form-control','placeholder'=>'Court Name'] ) !!} -->
						<!--                         @if($errors->has('name')) <span class="help-block">{{$errors->first('name') }}</span> @endif -->
							<!-- 					</div> -->
						<!-- 					<div class="form-group {{($errors->has('openTime'))?'has-error':''}}"> -->
							<!-- 						<label class="control-label">Opening Time</label>  -->
						<!--                         {!!Form::text('openTime', Input::old('openTime'),['class'=>'form-control timepicker timepicker-default','placeholder'=>'Opening Time'] ) !!} -->
						<!--                         @if($errors->has('openTime')) <span class="help-block">{{$errors->first('openTime') }}</span> @endif -->
							<!-- 					</div> -->
						<!-- 					<div class="form-group {{($errors->has('closeTime'))?'has-error':''}}"> -->
							<!-- 						<label class="control-label">Closing Time</label>  -->
						<!--                         {!! Form::text('closeTime', Input::old('closeTime'),['class'=>'form-control timepicker timepicker-default','placeholder'=>'Closing Time'] ) !!} -->
						<!--                         @if($errors->has('closeTime')) <span class="help-block">{{$errors->first('closeTime') }}</span> @endif -->
							<!-- 					</div> -->
						<!-- 					<div class="form-group {{($errors->has('bookingDuration'))?'has-error':''}}"> -->
							<!-- 						<label class="control-label">Booking Duration</label>  -->
						<!--                         {!!Form::select('bookingDuration', array('60' => '1hr', '120' =>'2hr'),Input::old('bookingDuration'),['class'=>'form-control','placeholder'=>'Selected Time'] ) !!} -->
						<!--                         @if($errors->has('bookingDuration')) <span class="help-block">{{$errors->first('bookingDuration') }}</span> @endif -->
							<!-- 					</div> -->
						<!-- 					<div class="form-group {{($errors->has('environment'))?'has-error':''}}"> -->
							<!--                         <label class="control-label">Select Environment</label> -->
						<!--                         {!!Form::select('environment', array_flip(\Config::get('global.court.environment')),Input::old('environment'),['class'=>'form-control','placeholder'=>'Select Environment'] ) !!} -->
						<!--                         @if($errors->has('environment')) <span class="help-block">{{$errors->first('environment') }}</span> @endif -->
							<!--                     </div> -->

						<!--                     <div class="form-group {{($errors->has('ballMachineAvailable'))?'has-error':''}}"> -->
							<!--                         <label class="control-label">Ball Machine Available?</label> -->
						<!--                         {!!Form::select('ballMachineAvailable', \Config::get('global.court.ballmachinestatus'),Input::old('ballMachineAvailable'),['class'=>'form-control','placeholder'=>'Ball Machine Available?'] ) !!} -->
						<!--                         @if($errors->has('ballMachineAvailable')) <span class="help-block">{{$errors->first('ballMachineAvailable') }}</span> @endif -->
							<!--                     </div> -->
						<!-- 					<div class="form-group {{($errors->has('status'))?'has-error':''}}"> -->
							<!-- 						<label class="control-label">Status</label>  -->
						<!--                         {!!Form::select('status', array('OPEN' => 'Open', 'CLOSED' =>'Closed'),'',array('class' => 'form-control') ) !!} -->
						<!--                         @if($errors->has('status')) <span class="help-block">{{$errors->first('status') }}</span> @endif -->
							<!-- 					</div> -->

							<div class="m-t-30 text-right">
								{!! Form::button('Configure Beacon', ['class'=>'btn btn-lg btn-circle btn-outline red','type'=>'submit']) !!}
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
