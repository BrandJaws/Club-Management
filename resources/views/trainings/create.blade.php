@extends('__layouts.admin')
@section('heading') Add Training @endSection
@section('main')
<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">Create Member </h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a> <i
                class="fa fa-angle-right"></i></li>
        <li><a href="{{url('/trainings')}}">Trainings</a> <i class="fa fa-angle-right"></i></li>
        <li><a href="#">Create</a></li>
    </ul>
</div>
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-body">
                 {!! Form::open(['url' => route('member.store'), 'id'=>'member-form', 'class'=>'login-form', 'method'=>'post']) !!}
                    @if(Session::has('serverError'))
                    <div class="alert alert-warning" role="alert"> {{Session::get('serverError')}} </div>
                    @endif
                    @if(Session::has('success'))
                    <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div>
                    @endif
                     <div class="form-group {{($errors->has('title'))?'has-error':''}}">
                        <label class="control-label">Title</label>
                        {!! Form::text('title', Input::old('title'), ['class'=>'form-control', 'placeholder'=>'Title'] ) !!}
                   		@if($errors->has('title')) <span class="help-block">{{$errors->first('title') }}</span> @endif
                    </div>
                     <div class="form-group {{($errors->has('title'))?'has-error':''}}">
                        <label class="control-label">Training Fee</label>
                        {!! Form::text('fee', Input::old('fee'), ['class'=>'form-control', 'placeholder'=>'Training Fee'] ) !!}
                   		@if($errors->has('fee')) <span class="help-block">{{$errors->first('fee') }}</span> @endif
                    </div>
                    <div class="form-group {{($errors->has('description'))?'has-error':''}}">
                        <label class="control-label">Description</label>
                        {!! Form::textarea('description', Input::old('description'), ['class'=>'form-control', 'placeholder'=>'Description'] ) !!}
                   		@if($errors->has('description')) <span class="help-block">{{$errors->first('description') }}</span> @endif
                    </div>
                    <div class="form-group {{($errors->has('instructor'))?'has-error':''}}">
                        <label class="control-label">Instructor</label>
                        {!! Form::select('instructor',[] ,Input::old('instructor'), ['class'=>'form-control', 'placeholder'=>'Description'] ) !!}
                   		@if($errors->has('instructor')) <span class="help-block">{{$errors->first('instructor') }}</span> @endif
                    </div>
                    <div class="form-group {{($errors->has('package'))?'has-error':''}}">
                        <label class="control-label">Package</label> <br />
                        <label>{!! Form::radio('package','individual',(Input::old('instructor'))?:false, ['class'=>'form-control'] ) !!} Individual</label>
                        <label>{!! Form::radio('package','packaged',(Input::old('instructor'))?:false, ['class'=>'form-control'] ) !!} Packaged</label>
                   		@if($errors->has('package')) <span class="help-block">{{$errors->first('package') }}</span> @endif
                    </div>
                    <div class="form-group {{($errors->has('startDate'))?'has-error':''}}">
                        <label class="control-label">Training Date</label> 
                       {!! Form::text('startDate', Input::old('startDate'), ['class'=>'form-control', 'placeholder'=>'Class Start Date'] ) !!}
                   		@if($errors->has('startDate')) <span class="help-block">{{$errors->first('startDate') }}</span> @endif
                    </div>
                     <div class="form-group {{($errors->has('classTime'))?'has-error':''}}">
                        <label class="control-label">Training Time</label> 
                       {!! Form::text('trainingTime', Input::old('trainingTime'), ['class'=>'form-control', 'placeholder'=>'Training Time'] ) !!}
                   		@if($errors->has('trainingTime')) <span class="help-block">{{$errors->first('trainingTime') }}</span> @endif
                    </div>
                     <div class="form-group {{($errors->has('classDuration'))?'has-error':''}}">
                        <label class="control-label">Training Duration</label> 
                       {!! Form::text('trainingDuration', Input::old('trainingDuration'), ['class'=>'form-control', 'placeholder'=>'Training Duration'] ) !!}
                   		@if($errors->has('classTime')) <span class="help-block">{{$errors->first('classTime') }}</span> @endif
                    </div>
                    <div class="form-group {{($errors->has('repeat'))?'has-error':''}}">
                        <label class="control-label">Will Training Repeats?</label> <br />
                       <label>{!! Form::radio('repeat','no',(Input::old('repeat'))?:false, ['class'=>'form-control'] ) !!} No Repeat</label>
                       <label>{!! Form::radio('repeat','daily',(Input::old('repeat'))?:false, ['class'=>'form-control'] ) !!} Repeate Daily</label>
                       <label>{!! Form::radio('repeat','weekly',(Input::old('repeat'))?:false, ['class'=>'form-control'] ) !!} Repeate Weekly</label>
                       <label>{!! Form::radio('repeat','monthly',(Input::old('repeat'))?:false, ['class'=>'form-control'] ) !!} Repeate Monthly</label>
                       <label>{!! Form::radio('repeat','yearly',(Input::old('repeat'))?:false, ['class'=>'form-control'] ) !!} Repeate Yearly</label>
                   		@if($errors->has('repeat')) <span class="help-block">{{$errors->first('repeat') }}</span> @endif
                    </div>
                    <fieldset border="1px solid">
                    <legends>When Will you like to open bookings?</legends>
                    <div class="form-group {{($errors->has('registrationOpenDate'))?'has-error':''}}">
                        <label class="control-label">Registration starts at?</label> 
                       	{!! Form::text('registrationOpenDate', Input::old('registrationOpenDate'), ['class'=>'form-control', 'placeholder'=>'Registration Open Date'] ) !!}
                       	@if($errors->has('registrationOpenDate')) <span class="help-block">{{$errors->first('registrationOpenDate') }}</span> @endif
                       	At
                       	{!! Form::text('registrationOpenTime', Input::old('registrationOpenTime'), ['class'=>'form-control', 'placeholder'=>'Registration Open Time'] ) !!}
                   		@if($errors->has('registrationOpenTime')) <span class="help-block">{{$errors->first('registrationOpenTime') }}</span> @endif
                    </div>
                      <div class="form-group {{($errors->has('registrationEndDate'))?'has-error':''}}">
                        <label class="control-label">Registration closed at?</label> 
                       	{!! Form::text('registrationCloseDate', Input::old('registrationCloseDate'), ['class'=>'form-control', 'placeholder'=>'Registration close Date'] ) !!}
                       	@if($errors->has('registrationCloseDate')) <span class="help-block">{{$errors->first('registrationCloseDate') }}</span> @endif
                       	AT
                       	{!! Form::text('registrationCloseTime', Input::old('registrationCloseTime'), ['class'=>'form-control', 'placeholder'=>'Registration close time'] ) !!}
                   		@if($errors->has('registrationCloseTime')) <span class="help-block">{{$errors->first('registrationCloseTime') }}</span> @endif
                    </div>
                    </fieldset>
                    <div class="form-group {{($errors->has('minRequiredRegistrations'))?'has-error':''}}">
                        <label class="control-label">Mininmum Registration required for this training</label> 
                       {!! Form::text('minRequiredRegistrations', Input::old('minRequiredRegistrations'), ['class'=>'form-control', 'placeholder'=>'Training Duration'] ) !!}
                   		@if($errors->has('minRequiredRegistrations')) <span class="help-block">{{$errors->first('minRequiredRegistrations') }}</span> @endif
                    </div>
                    <div class="form-group {{($errors->has('maxRegistrations'))?'has-error':''}}">
                        <label class="control-label">Close booking when total registrations reached?</label> 
                       	{!! Form::text('maxRegistrations', Input::old('maxRegistrations'), ['class'=>'form-control', 'placeholder'=>'Training Duration'] ) !!}
                   		@if($errors->has('maxRegistrations')) <span class="help-block">{{$errors->first('maxRegistrations') }}</span> @endif
                    </div>
                     <div class="form-group {{($errors->has('playerMaxRegistrations'))?'has-error':''}}">
                        <label class="control-label">How many registration a single player can make?</label> 
                       	{!! Form::text('playerMaxRegistrations', Input::old('playerMaxRegistrations'), ['class'=>'form-control', 'placeholder'=>'Training Duration'] ) !!}
                   		@if($errors->has('playerMaxRegistrations')) <span class="help-block">{{$errors->first('playerMaxRegistrations') }}</span> @endif
                    </div>
                    <div class="form-group {{($errors->has('playerMaxRegistrations'))?'has-error':''}}">
                        <label class="control-label">How many registration admin can make?</label> 
                       	{!! Form::text('adminMaxRegistrations', Input::old('adminMaxRegistrations'), ['class'=>'form-control', 'placeholder'=>'Training Duration'] ) !!}
                   		@if($errors->has('adminMaxRegistrations')) <span class="help-block">{{$errors->first('adminMaxRegistrations') }}</span> @endif
                    </div>
                    <div class="form-group">
                       <label>{!! Form::checkbox('canMemberRegisterMembers','no',(Input::old('canMemberRegisterMembers'))?:false, ['class'=>'form-control'] ) !!} Allow members to register other members</label>
                       <label>{!! Form::checkbox('canMemberRegisterGuest','daily',(Input::old('canMemberRegisterGuest'))?:false, ['class'=>'form-control'] ) !!} Allow members to register guest</label>
                       <label>{!! Form::checkbox('canMemberViewParticipants','weekly',(Input::old('canMemberViewParticipants'))?:false, ['class'=>'form-control'] ) !!} Allow members to view other training participants</label>
                       <label>{!! Form::checkbox('allowAutomaticProcessing','monthly',(Input::old('allowAutomaticProcessing'))?:false, ['class'=>'form-control'] ) !!} Disable Automatic processing of waiting list</label>
                    </div>
                    <div class="form-group">
                    <label>{!! Form::checkbox('genderRestriction','no',(Input::old('genderRestriction'))?:false, ['class'=>'form-control'] ) !!} Gender Restriction</label>
                    </div>
                    <div class="form-group">
                    	<label>{!! Form::checkbox('ageRestriction','no',(Input::old('ageRestriction'))?:false, ['class'=>'form-control'] ) !!} Age Restriction</label>
                    </div>
                    <div class="form-group">
                    	<label>{!! Form::checkbox('playerRestriction','no',(Input::old('playerRestriction'))?:false, ['class'=>'form-control'] ) !!} Player Ability Restriction</label>
                    </div>
                    <div class="form-group">
                    	<label>{!! Form::checkbox('disallowCancelation','no',(Input::old('playerRestriction'))?:false, ['class'=>'form-control'] ) !!} Disable Concellations By Member</label>
                    </div>
                    <div class="form-group">
                    	<label>{!! Form::checkbox('cancelPolicyActive','no',(Input::old('playerRestriction'))?:false, ['class'=>'form-control'] ) !!} Activate Following Cancelation Policy(s)</label>
                    </div>
                    <div class="margiv-top-10">
						{!! Form::button('Save Changes', ['class'=>'btn green-haze','type'=>'submit']) !!}
					</div>
                  {!! Form::close() !!}   
                </div>
            </div>
        </div>
    </div>
</div>    
@endSection
