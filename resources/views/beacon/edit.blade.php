@extends('__layouts.admin') @section('main')

<!-- BEGIN PAGE HEADER-->

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="/dashboard">Home</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/beacon')}}">Configure Beacon</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="#.">Edit</a></li>
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
							{!! Form::open(['url' => route('beacon.update',['id'=>$data['id']]), 'id'=>'form-login',
					'class'=>'login-form', 'method'=>'put']) !!}
							@if(Session::has('serverError'))
								<div class="alert alert-warning" role="alert">
									{{Session::get('serverError')}}</div>
							@endif @if(Session::has('success'))
								<div class="alert alert-success" role="alert">
									{{Session::get('success')}}</div>
							@endif
						<!-- beacon fields starts from here  -->
							<div class="form-group {{($errors->has('beaconCourt'))?'has-error':''}}">
								<label class="control-label">Court</label>
								<select name="court_id" class="form-control">
									@foreach($courts as $court)
										<option value="{{$court["id"] }}" {{$data['court_id'] == $court["id"] ? "selected=selected":"" }}>{{$court["name"] }}</option>
									@endforeach
								</select>

								@if($errors->has('court_id')) <span class="help-block">{{$errors->first('court_id') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('name'))?'has-error':''}}">
								<label class="control-label">Beacon Name</label>
								{!! Form::text('name',(isset($data['name']))?$data['name']:'', ['class'=>'form-control','placeholder'=>'Beacon Name'] ) !!}
								@if($errors->has('name')) <span class="help-block">{{$errors->first('name') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('UUID'))?'has-error':''}}">
								<label class="control-label">UDID</label>
								{!! Form::text('UUID',(isset($data['UUID']))?$data['UUID']:'', ['class'=>'form-control','placeholder'=>'UUID'] ) !!}
								@if($errors->has('UUID')) <span class="help-block">{{$errors->first('udId') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('major'))?'has-error':''}}">
								<label class="control-label">Major</label>
								{!! Form::text('major',(isset($data['major']))?$data['major']:'', ['class'=>'form-control','placeholder'=>'Major'] ) !!}
								@if($errors->has('major')) <span class="help-block">{{$errors->first('major') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('minor'))?'has-error':''}}">
								<label class="control-label">Minor</label>
								{!! Form::text('minor',(isset($data['minor']))?$data['minor']:'', ['class'=>'form-control','placeholder'=>'Minor'] ) !!}
								@if($errors->has('minor')) <span class="help-block">{{$errors->first('minor') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('recordCheckin'))?'has-error':''}}">
								<label class="control-label">Record Check In</label>
								{!!Form::select('recordCheckin', array('NEAR' => 'Near', 'FAR' =>'Far', 'IMMEDIATE' => 'Immediate'),'',array('class' => 'form-control') ) !!}
								@if($errors->has('recordCheckin')) <span class="help-block">{{$errors->first('recordCheckin') }}</span> @endif
							</div>
							<div class="form-group">
								<div class="md-checkbox">
									<input type="checkbox" id="checkbox6" class="md-check">
									<label for="checkbox6">
										<span class="inc"></span>
										<span class="check"></span>
										<span class="box"></span> Activate Beacon </label>
								</div>
							</div>
							<div class="form-group m-t-30 text-right">
								{!! Form::button('Update Beacon', ['class'=>'btn red btn-outline btn-circle btn-lg','type'=>'submit']) !!}
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
