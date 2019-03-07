@extends('__layouts.admin')
@section('main')
	
	<!-- BEGIN PAGE HEADER-->
	
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li><i class="fa fa-home"></i> <a href="index.html">Home</a> <i
					class="fa fa-angle-right"></i></li>
			<li><a href="{{url('/court')}}">Trainers</a> <i
					class="fa fa-angle-right"></i></li>
			<li><a href="#.">Edit</a></li>
		</ul>
	</div>
	
	<h1 class="page-title">
		Edit Trainer
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
								{!! Form::open(['url' => route('court.update',['id'=>$data['id']]), 'id'=>'form-login', 'class'=>'login-form', 'method'=>'put']) !!}
								@if(Session::has('serverError'))
									<div class="alert alert-warning"
									     role="alert"> {{Session::get('serverError')}} </div>
								@endif
								@if(Session::has('success'))
									<div class="alert alert-success" role="alert"> {{Session::get('success')}} </div>
								@endif
								<div class="form-group {{($errors->has('name'))?'has-error':''}}">
									<label class="control-label">Name</label>
									{!! Form::text('name', (isset($data['name']))?$data['name']:'', ['class'=>'form-control', 'placeholder'=>'Trainer Name'] ) !!}
									@if($errors->has('name')) <span
										class="help-block">{{$errors->first('name') }}</span> @endif
								</div>
								<div class="form-group {{($errors->has('openTime'))?'has-error':''}}">
									<label class="control-label">Opening Time</label>
									<!-- <input type="text" name="opening-time" placeholder="Opening Time" class="form-control timepicker timepicker-default"/> -->
									{!! Form::text('openTime', (isset($data['openTime']))?Carbon\Carbon::parse($data['openTime'])->format('h:i A'):'', ['class'=>'form-control timepicker timepicker-default', 'placeholder'=>'Opening Time'] ) !!}
									@if($errors->has('openTime')) <span
										class="help-block">{{$errors->first('openTime') }}</span> @endif
								</div>
								<div class="form-group {{($errors->has('closeTime'))?'has-error':''}}">
									<label class="control-label">Closing Time</label>
									<!-- <input type="text" name="closing-time" placeholder="Closing Time" class="form-control timepicker timepicker-default"/> -->
									{!! Form::text('closeTime', (isset($data['closeTime']))?Carbon\Carbon::parse($data['closeTime'])->format('h:i A'):'', ['class'=>'form-control timepicker timepicker-default', 'placeholder'=>'Closing Time'] ) !!}
									@if($errors->has('closeTime')) <span
										class="help-block">{{$errors->first('closeTime') }}</span> @endif
								</div>
								
								<div class="form-group {{($errors->has('environment'))?'has-error':''}}">
									<label class="control-label">Select Environment</label>
									{!!Form::select('environment', array_flip(\Config::get('global.court.environment')),(isset($data['environment']))?$data['environment']:'',['class'=>'form-control','placeholder'=>'Select Environment'] ) !!}
									@if($errors->has('environment')) <span
										class="help-block">{{$errors->first('environment') }}</span> @endif
								</div>
								<div class="form-group {{($errors->has('ballMachineAvailable'))?'has-error':''}}">
									<label class="control-label">Ball Machine Available?</label>
									{!!Form::select('ballMachineAvailable', \Config::get('global.court.ballmachinestatus'),(isset($data['ballMachineAvailable']))?$data['ballMachineAvailable']:'',['class'=>'form-control','placeholder'=>'Ball Machine Available?'] ) !!}
									@if($errors->has('ballMachineAvailable')) <span
										class="help-block">{{$errors->first('ballMachineAvailable') }}</span> @endif
								</div>
								<div class="form-group {{($errors->has('status'))?'has-error':''}}">
									<label class="control-label">Status</label>
									{!! Form::select('status', array('OPEN' => 'Open', 'CLOSED' => 'Closed'),(isset($data['status']))?$data['status']:'',array('class' => 'form-control') ) !!}
									@if($errors->has('status')) <span
										class="help-block">{{$errors->first('status') }}</span> @endif
								</div>
								<div class="form-group m-t-30 text-right">
									{!! Form::button('Update Trainer', ['class'=>'btn red btn-lg btn-outline btn-circle', 'type'=>'submit']) !!}
								</div>
								<!-- </form> -->
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
