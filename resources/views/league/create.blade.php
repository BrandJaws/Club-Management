@extends('__layouts.admin') @section('main')

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="index.html">Home</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/court')}}">Leagues</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="#.">Create</a></li>
	</ul>
</div>

<h1 class="page-title">
	Create Leagues
</h1>

<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->


<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content" id="league-vue-container">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							{!! Form::open(['url' => route('league.store'), 'id'=>'form-leagues',
					'class'=>'leagues-form', 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
							@if(Session::has('serverError'))
								<div class="alert alert-warning" role="alert">
									{{Session::get('serverError')}}</div>
							@endif @if(Session::has('success'))
								<div class="alert alert-success" role="alert">
									{{Session::get('success')}}</div>
							@endif
							<div class="form-group {{($errors->has('name'))?'has-error':''}}">
								<label class="control-label">League name</label>
								{!! Form::text('name',Input::old('name'), ['class'=>'form-control','placeholder'=>'League name'] ) !!}
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
							<div class="form-group {{($errors->has('league_type'))?'has-error':''}}">
								<label class="control-label">League type</label>
								{!!Form::select('league_type', config('global.league.league_types'),Input::old('league_type'),['class'=>'form-control','placeholder'=>'Select Type'] ) !!}
								@if($errors->has('league_type')) <span class="help-block">{{$errors->first('league_type') }}</span> @endif
							</div>

							<div class="form-group ">
							<label class="control-label">
								<div class="form-group ">
									<label class="control-label">Structure Type</label> <br>

									<div class="md-radio-inline">

											<div class="md-radio" v-for="(structureType,structureTypeIndex) in structureTypes">
												<input type="radio" :value="structureType" :id="structureType" name="structure_type" class="md-radiobtn" v-model="selectedStructureType">
												<label :for="structureType">
													<span class="inc"></span>
													<span class="check"></span>
													<span class="box"></span> @{{structureType}}
												</label>
											</div>

									</div>
								</div>
							</label>
							</div>
							<div class="form-group {{($errors->has('unstructuredLeagueVariant'))?'has-error':''}}" v-show="!structuredSelected">
								<label class="control-label">League Variant</label>
								{!!Form::select('unstructuredLeagueVariant', config('global.league.unstructuredLeagueVariant'),Input::old('unstructuredLeagueVariant'),['class'=>'form-control','placeholder'=>'Select Variant', 'v-model'=>'selectedUnstructuredLeagueVariant'] ) !!}
								@if($errors->has('unstructuredLeagueVariant')) <span class="help-block">{{$errors->first('unstructuredLeagueVariant') }}</span> @endif
							</div>

							<div class="form-group {{($errors->has('days'))?'has-error':''}}" v-show="structuredSelected">
								<label class="control-label" for="days">Week Days</label>
								<select name="days[]" class="form-control select2-multiple"  multiple="multiple" tabindex="-1" aria-hidden="true" id="days">
									<option value="MONDAY" {{Input::old('days') ? (in_array("MONDAY",Input::old('days')) ? 'selected' : '') : '' }}>Monday</option>
									<option value="TUESDAY" {{Input::old('days') ? (in_array("TUESDAY",Input::old('days')) ? 'selected' : '') : '' }}>Tuesday</option>
									<option value="WEDNESDAY" {{Input::old('days') ? (in_array("WEDNESDAY",Input::old('days')) ? 'selected' : '') : '' }}>Wednesday</option>
									<option value="THURSDAY" {{Input::old('days') ? (in_array("THURSDAY",Input::old('days')) ? 'selected' : '') : '' }}>Thursday</option>
									<option value="FRIDAY" {{Input::old('days') ? (in_array("FRIDAY",Input::old('days')) ? 'selected' : '') : '' }}>Friday</option>
									<option value="SATURDAY" {{Input::old('days') ? (in_array("SATURDAY",Input::old('days')) ? 'selected' : '') : '' }}>Saturday</option>
									<option value="SUNDAY" {{Input::old('days') ? (in_array("SUNDAY",Input::old('days')) ? 'selected' : '') : '' }}>Sunday</option>
								</select>
								  @if($errors->has('days')) <span class="help-block">{{$errors->first('days') }}</span> @endif
							</div>
							

							{{--<div class="form-group ">--}}
								{{--<label class="control-label">Reservation Time Start</label>--}}
								{{--<div class="input-group date form_datetime form_datetime bs-datetime">--}}
									{{--<input type="text" name="reservationTimeStart" size="16" class="form-control"  placeholder="Starts Time" value="{{Input::old('reservationTimeStart') ? Input::old('reservationTimeStart') : '' }}">--}}
									{{--<span class="input-group-addon">--}}
										{{--<button class="date-set" type="button">--}}
										{{--<i class="fa fa-calendar"></i>--}}
										{{--</button>--}}
									{{--</span>--}}
								{{--</div>--}}
							{{--</div>--}}

							
							<div class="form-group"  v-show="structuredSelected">
								<label class="control-label">Reservation Time Start</label>
								<div class="input-group">
									<input type="text" name="reservationTimeStart" size="16" class="form-control timepicker timepicker-no-seconds" placeholder="Starts Time" value="{{Input::old('reservationTimeStart') ? Input::old('reservationTimeStart') : Carbon\Carbon::now()->format('g:i A') }}">
									<span class="input-group-addon">
										<button class="date-set" type="button">
											<i class="fa fa-clock-o"></i>
										</button>
									</span>
								</div>
							</div>
							
							

							<div class="form-group {{($errors->has('numberOfSlots'))?'has-error':''}}"  v-show="structuredSelected">
								<label class="control-label">Court slots booked</label>
								{!! Form::number('numberOfSlots',  '', ['class'=>'form-control', 'placeholder'=>'Total Bookings', 'min'=>'1'] ) !!}
								@if($errors->has('numberOfSlots')) <span class="help-block">{{$errors->first('numberOfSlots') }}</span> @endif
							</div>
							
							<div class="form-group {{($errors->has('court'))?'has-error':''}}"  v-show="structuredSelected">
								<label class="control-label" for="CourtSelection">Court(s)</label>

								<select name="court[]" class="form-control select2-multiple"  multiple="multiple" tabindex="-1" aria-hidden="true" id="courtSelection">
									@foreach($data["courts"] as $court)
										<option value='{{$court["id"]}}' {{Input::old('court') ? (in_array($court["id"],Input::old('court')) ? 'selected' : '') : '' }} >{{ $court["name"] }}</option>
									@endforeach

								</select>
								  @if($errors->has('court')) <span class="help-block">{{$errors->first('court') }}</span> @endif
							</div>
							
							<div class="form-group {{($errors->has('abilityLevel'))?'has-error':''}}">
								<label class="control-label">Player Expert level</label>
								{!!Form::select('abilityLevel', config('global.league.abilityLevel'),Input::old('abilityLevel'),['class'=>'form-control','placeholder'=>'Select Expert level'] ) !!}
								@if($errors->has('abilityLevel')) <span class="help-block">{{$errors->first('abilityLevel') }}</span> @endif
							</div>

							<div class="form-group {{($errors->has('minNumberOfPlayers'))?'has-error':''}}">
								<label class="control-label">Min Number of Participants</label>
								{!! Form::number('minNumberOfPlayers',Input::old('minNumberOfPlayers'), ['class'=>'form-control','placeholder'=>'Number of Participants'] ) !!}
								@if($errors->has('minNumberOfPlayers')) <span class="help-block">{{$errors->first('minNumberOfPlayers') }}</span> @endif
								
							</div>
							
							<div class="form-group {{($errors->has('maxNumberOfPlayers'))?'has-error':''}}">
								<label class="control-label">Max Number of Participants</label>
								{!! Form::number('maxNumberOfPlayers',Input::old('maxNumberOfPlayers'), ['class'=>'form-control','placeholder'=>'Number of Participants'] ) !!}
								@if($errors->has('maxNumberOfPlayers')) <span class="help-block">{{$errors->first('maxNumberOfPlayers') }}</span> @endif
								
							</div>

							<fieldset border="1px solid">
							<div class="form-group ">
								<label class="control-label">Registration Starts Date/Time</label>
								<div class="input-group date form_datetime form_datetime bs-datetime datepickerFormat">
									<input type="text" name="registrationStartAt" size="16" class="form-control"  placeholder="Starts Date" value="{{Input::old('registrationStartAt') ? Input::old('registrationStartAt') : '' }}">
									<span class="input-group-addon">
										<button class="date-set" type="button">
										<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>

							<div class="form-group ">
								<label class="control-label">Registration End Date/Time</label>
								<div class="input-group date form_datetime form_datetime bs-datetime datepickerFormat">
									<input type="text" size="16" class="form-control" name="registrationCloseAt"  placeholder="End Date" value="{{Input::old('registrationCloseAt') ? Input::old('registrationCloseAt') : '' }}">
									<span class="input-group-addon">
										<button class="date-set" type="button">
										<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
							</fieldset>

<!--
							<div class="form-group ">
								<label class="control-label">League Start Date</label>
								<div class="input-group date form_datetime form_datetime bs-datetime">
									<input type="text" size="16" class="form-control" name="leagueStartDate"  placeholder="Start Date" value="{{Input::old('leagueStartDate') ? Input::old('leagueStartDate') : '' }}">
									<span class="input-group-addon">
										<button class="date-set" type="button">
										<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
-->
							
							<div class="form-group">
								<label class="control-label">League Start Date</label>
								<div class="input-group date form_datetime form_datetime bs-datetime datepickerFormat" >
									<input type="text" size="16" class="form-control" name="leagueStartDate"  placeholder="Start Date" value="{{Input::old('leagueStartDate') ? Input::old('leagueStartDate') : '' }}">
                                    
									<span class="input-group-addon">
										<button class="date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
                            
                            {{--<div class="form-group">
								<label class="control-label">League Start Date</label>
								<div class="input-group date date-picker" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
									<input type="text" class="form-control date-picker" size="16" name="leagueStartDate"  placeholder="Start Date"  value="{{Input::old('leagueStartDate') ? Input::old('leagueStartDate') : '' }}">
									<span class="input-group-addon">
										<button class="date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div> --}}
							
							

							<div class="form-group {{($errors->has('numberOfWeeks'))?'has-error':''}}">
								<label class="control-label">Number of Weeks</label>
								{!! Form::number('numberOfWeeks',Input::old('numberOfWeeks'), ['class'=>'form-control','placeholder'=>'Number of weeks'] ) !!}
								@if($errors->has('numberOfWeeks')) <span class="help-block">{{$errors->first('numberOfWeeks') }}</span> @endif
							</div>

							<div class="form-group {{($errors->has('winning_criteria'))?'has-error':''}}" v-if="structuredSelected || unstructuredPointBasedSelected">
								<label class="control-label">Winning Criteria</label>
								{!!Form::select('winning_criteria', config('global.league.winning_criteria'),Input::old('winning_criteria'),['class'=>'form-control','placeholder'=>'Select Criteria'] ) !!}
								@if($errors->has('winning_criteria')) <span class="help-block">{{$errors->first('winning_criteria') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('pointsPerWin'))?'has-error':''}}" v-if="structuredSelected || unstructuredPointBasedSelected">
								<label class="control-label">Points Per Win</label>
								{!! Form::number('pointsPerWin',Input::old('pointsPerWin'), ['class'=>'form-control','placeholder'=>'Points Per Win'] ) !!}
								@if($errors->has('pointsPerWin')) <span class="help-block">{{$errors->first('pointsPerWin') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('pointsPerLoss'))?'has-error':''}}" v-if="structuredSelected || unstructuredPointBasedSelected">
								<label class="control-label">Points Per Loss</label>
								{!! Form::number('pointsPerLoss',Input::old('pointsPerLoss'), ['class'=>'form-control','placeholder'=>'Points Per Loss'] ) !!}
								@if($errors->has('pointsPerLoss')) <span class="help-block">{{$errors->first('pointsPerLoss') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('weeksToPenalty'))?'has-error':''}}"  v-if="!structuredSelected">
								<label class="control-label">Weeks To Penalty</label>
								{!! Form::number('weeksToPenalty',  '', ['class'=>'form-control', 'placeholder'=>'Number Of Weeks', 'min'=>'0'] ) !!}
								@if($errors->has('weeksToPenalty')) <span class="help-block">{{$errors->first('weeksToPenalty') }}</span> @endif
							</div>
							<div class="form-group m-t-30 text-right">
								{!! Form::button('Create League', ['class'=>'btn red btn-lg btn-outline btn-circle','type'=>'submit']) !!}
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

<script>
	var vue = new Vue({
		el:'#league-vue-container',
		data:{
			structureTypes:{!! json_encode( array_values(config('global.league.structure_type') )) !!} ,
			selectedStructureType:"{!! Input::old('structure_type') ? Input::old('structure_type') : config('global.league.structure_type')["structured"] !!}",
			selectedUnstructuredLeagueVariant: "{!! Input::old('unstructuredLeagueVariant') ? Input::old('unstructuredLeagueVariant') : 'LADDER' !!}",

		},
		computed:{
			structuredSelected:function(){

				return this.selectedStructureType == "{{config('global.league.structure_type')["structured"]}}"
			},
			unstructuredPointBasedSelected:function(){
				return this.selectedStructureType == "{{config('global.league.structure_type')["unstructured"]}}" && this.selectedUnstructuredLeagueVariant == "POINT BASED";
			}

		},
		methods: {


		}


	});
</script>
@endSection
@stop
