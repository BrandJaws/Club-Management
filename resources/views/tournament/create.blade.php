@extends('__layouts.admin') @section('main')

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="index.html">Home</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/tournament')}}">Tournament</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="#.">Create</a></li>
	</ul>
</div>

<h1 class="page-title">
	Create Tournament
</h1>

<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->


<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content" id="vue-container">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							{!! Form::open(['url' => route('tournament.store'), 'id'=>'form-tournament',
					'class'=>'tournament-form', 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
							@if(Session::has('serverError'))
								<div class="alert alert-warning" role="alert">
									{{Session::get('serverError')}}</div>
							@endif @if(Session::has('success'))
								<div class="alert alert-success" role="alert">
									{{Session::get('success')}}</div>
							@endif
							<div class="form-group {{($errors->has('name'))?'has-error':''}}">
								<label class="control-label">Tournament name</label>
								{!! Form::text('name',Input::old('name'), ['class'=>'form-control','placeholder'=>'Tournament name'] ) !!}
								@if($errors->has('name')) <span class="help-block">{{$errors->first('name') }}</span> @endif
							</div>

							<div class="form-group {{($errors->has('description'))?'has-error':''}}">
								<label class="control-label">Description</label>
								<textarea type="text" name="description" class="form-control" placeholder='Description'>{{Input::old('description')}}</textarea>
								@if($errors->has('description'))
									<span class="help-block">{{$errors->first('description') }}</span>
								@endif
							</div>
							<div class="form-group {{($errors->has('image'))?'has-error':''}}">
								<label class="control-label"> Image</label>
								<input type="file" name="image" accept="image/*" class="form-control" placeholder='Image'/>
								@if($errors->has('image'))
									<span class="help-block">{{$errors->first('image') }}</span>
								@endif
							</div>
                     		<events-form :events="events"></events-form>
                            
						 	<scheduling-form :scheduling-details="schedulingDetails" :courts="courts"></scheduling-form>
							

							<div class="form-group {{($errors->has('tournamentStartDate'))?'has-error':''}}">
								<label class="control-label">Tournament Start Date</label>
								<div class="input-group date form_datetime form_datetime bs-datetime datepickerFormat" >
									<input type="text" size="16" class="form-control" name="tournamentStartDate"  placeholder="Start Date" value="{{Input::old('tournamentStartDate') ? Input::old('tournamentStartDate') : '' }}">
                                    
									<span class="input-group-addon">
										<button class="date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
								@if($errors->has('tournamentStartDate')) <span class="help-block">{{$errors->first('tournamentStartDate') }}</span> @endif
							</div>
                            
							<div class="form-group {{($errors->has('numberOfWeeks'))?'has-error':''}}">
								<label class="control-label">Number of Weeks</label>
								{!! Form::number('numberOfWeeks',Input::old('numberOfWeeks'), ['class'=>'form-control','placeholder'=>'Number of weeks'] ) !!}
								@if($errors->has('numberOfWeeks')) <span class="help-block">{{$errors->first('numberOfWeeks') }}</span> @endif
							</div>

							<div class="form-group {{($errors->has('winning_criteria'))?'has-error':''}}">
								<label class="control-label">Winning Criteria</label>
								<select class='form-control' name="winning_criteria">
									@foreach(config('global.tournament.winning_criteria') as $winningCriteria)
										<option value="{{$winningCriteria}}" {{Input::old('winning_criteria') &&  Input::old('winning_criteria') == $winningCriteria ? 'selected' : ''}}>{{$winningCriteria}}</option>
									@endforeach
								</select>
								{{--{!!Form::select('winning_criteria', config('global.tournament.winning_criteria'),Input::old('winning_criteria'),['class'=>'form-control','placeholder'=>'Select Criteria'] ) !!}--}}
								@if($errors->has('winning_criteria')) <span class="help-block">{{$errors->first('winning_criteria') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('pointsPerWin'))?'has-error':''}}">
								<label class="control-label">Points Per Win</label>
								{!! Form::number('pointsPerWin',Input::old('pointsPerWin'), ['class'=>'form-control','placeholder'=>'Points Per Win'] ) !!}
								@if($errors->has('pointsPerWin')) <span class="help-block">{{$errors->first('pointsPerWin') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('pointsPerLoss'))?'has-error':''}}">
								<label class="control-label">Points Per Loss</label>
								{!! Form::number('pointsPerLoss',Input::old('pointsPerLoss'), ['class'=>'form-control','placeholder'=>'Points Per Loss'] ) !!}
								@if($errors->has('pointsPerLoss')) <span class="help-block">{{$errors->first('pointsPerLoss') }}</span> @endif
							</div>
							<fieldset border="1px solid">
								<div class="form-group {{($errors->has('registrationStartAt'))?'has-error':''}}">
									<label class="control-label">Registration Starts Date/Time</label>
									<div class="input-group date form_datetime form_datetime bs-datetime datepickerFormat">
										<input type="text" name="registrationStartAt" size="16" class="form-control"  placeholder="Starts Date" value="{{Input::old('registrationStartAt') ? Input::old('registrationStartAt') : '' }}">
									<span class="input-group-addon">
										<button class="date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
									</div>
									@if($errors->has('registrationStartAt')) <span class="help-block">{{$errors->first('registrationStartAt') }}</span> @endif
								</div>

								<div class="form-group {{($errors->has('registrationCloseAt'))?'has-error':''}}">
									<label class="control-label">Registration End Date/Time</label>
									<div class="input-group date form_datetime form_datetime bs-datetime datepickerFormat">
										<input type="text" size="16" class="form-control" name="registrationCloseAt"  placeholder="End Date" value="{{Input::old('registrationCloseAt') ? Input::old('registrationCloseAt') : '' }}">
									<span class="input-group-addon">
										<button class="date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
									</div>
									@if($errors->has('registrationCloseAt')) <span class="help-block">{{$errors->first('registrationCloseAt') }}</span> @endif
								</div>
							</fieldset>
							<div class="form-group m-t-30 text-right">
								{!! Form::button('Create Tournament', ['class'=>'btn red btn-lg btn-outline btn-circle','type'=>'submit']) !!}
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
@section('page-specific-scripts')


<link href="{{asset("assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css")}}" rel="stylesheet" type="text/css" />


<script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")}}" type="text/javascript"></script>


<script src="{{asset("assets/pages/scripts/components-date-time-pickers.js")}}" type="text/javascript"></script>
<link href="{{asset("assets/global/plugins/select2/css/select2.min.css")}}" rel="stylesheet" type="text/css" />
<link href="{{asset("assets/global/plugins/select2/css/select2-bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
<script src="{{asset("assets/global/plugins/select2/js/select2.full.min.js")}}" type="text/javascript"></script>
<script src="{{asset("assets/pages/scripts/components-select2.min.js")}}" type="text/javascript"></script>

@include("__vue_components.tournaments.events-form")
@include("__vue_components.tournaments.scheduling-form")

<script>

	
	var vue = new Vue({
		el:'#vue-container',
		data:{
			{{--structureTypes:{!! json_encode( array_values(config('global.league.structure_type') )) !!} ,--}}
			{{--selectedStructureType:"{!! Input::old('structure_type') ? Input::old('structure_type') : config('global.league.structure_type')["structured"] !!}",--}}
			events:{!! Input::old('tournament_events') && trim(Input::old('tournament_events')) != '[]' ? Input::old('tournament_events') : '[]' !!},
			schedulingDetails:{!! Input::old('scheduling_details') && trim(Input::old('scheduling_details')) != '[]' ? Input::old('scheduling_details') : '[]' !!},
			courts:{!! json_encode($courts) !!},


		},
		computed:{
			{{--structuredSelected:function(){--}}
				{{----}}
				{{--return this.selectedStructureType == "{{config('global.league.structure_type')["structured"]}}"--}}
			{{--}--}}

		},
		methods: {


		}


	});
</script>
@endSection
@stop
