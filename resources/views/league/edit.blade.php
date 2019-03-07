@extends('__layouts.admin') @section('main')

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="index.html">Home</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/court')}}">Leagues</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="#.">Edit</a></li>
	</ul>
</div>

<h1 class="page-title">
	Edit Leagues
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

							{!! Form::open(['url' => route('league.update', $data["league"]['id']), 'id'=>'form-leagues ',
					'class'=>'leagues-form', 'method'=>'put', 'enctype'=>'multipart/form-data']) !!}
							@if(Session::has('serverError'))
								<div class="alert alert-warning" role="alert">
									{{Session::get('serverError')}}</div>
							@endif @if(Session::has('success'))
								<div class="alert alert-success" role="alert">
									{{Session::get('success')}}</div>
							@endif
							<div class="form-group {{($errors->has('name'))?'has-error':''}}">
								<label class="control-label">League name</label>
								{!! Form::text('name', Input::old('name') ? Input::old('name') : (isset($data["league"]['name']) ? $data["league"]['name'] : '') , ['class'=>'form-control','placeholder'=>'League name'] ) !!}
								@if($errors->has('name')) <span class="help-block">{{$errors->first('name') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('description'))?'has-error':''}}">
								<label class="control-label">Description</label>
								<textarea type="text" name="description" class="form-control" placeholder='Description'>{{Input::old('description') ? Input::old('description') : $data["league"]["description"] }}</textarea>
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
                                {!!Form::select('league_type', config('global.league.league_types'),Input::old('league_type')? Input::old('league_type') : (isset($data["league"]['league_type']) ? $data["league"]['league_type'] : ''),['class'=>'form-control','placeholder'=>'Select Type'] ) !!}
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
								{!!Form::select('unstructuredLeagueVariant', config('global.league.unstructuredLeagueVariant'),Input::old('unstructuredLeagueVariant')? Input::old('unstructuredLeagueVariant') : (isset($data["league"]['unstructuredLeagueVariant']) ? $data["league"]['unstructuredLeagueVariant'] : ''),['class'=>'form-control','placeholder'=>'Select Variant', 'v-model'=>'selectedUnstructuredLeagueVariant'] ) !!}
								@if($errors->has('unstructuredLeagueVariant')) <span class="help-block">{{$errors->first('unstructuredLeagueVariant') }}</span> @endif
							</div>


							<div class="form-group {{($errors->has('days'))?'has-error':''}}" v-show="structuredSelected">
								<label class="control-label" for="days">Week Days</label>
								<select name="days[]" class="form-control select2-multiple"  multiple="multiple" tabindex="-1" aria-hidden="true" id="days">
									@foreach(\Illuminate\Support\Facades\Config::get('global.league.days') as $day)
										<option value='{{$day}}' {{Input::old('days') ? (in_array($day,Input::old('days')) ? 'selected' : '') : $data["league"]['days'] && in_array($day,$data["league"]['days']) ?  'selected'  : ''  }} >{{ $day }}</option>
									@endforeach

								</select>
								@if($errors->has('days')) <span class="help-block">{{$errors->first('days') }}</span> @endif
							</div>


							<div class="form-group" v-show="structuredSelected">
								<label class="control-label">Reservation Time Start</label>
								<div class="input-group">
									<input type="text" name="reservationTimeStart" size="16" class="form-control timepicker timepicker-no-seconds" placeholder="Starts Time" value="{{Input::old('reservationTimeStart') ? Input::old('reservationTimeStart') : $data['league']['reservationTimeStart'] }}">
									<span class="input-group-addon">
										<button class="date-set" type="button">
											<i class="fa fa-clock-o"></i>
										</button>
									</span>
								</div>
							</div>
							<div class="form-group {{($errors->has('numberOfSlots'))?'has-error':''}}"  v-show="structuredSelected">
								<label class="control-label">Court slots booked</label>
								{!! Form::number('numberOfSlots',  Input::old('numberOfSlots') ? Input::old('numberOfSlots') : ($data['league']['numberOfSlots'] ?: 1), ['class'=>'form-control', 'placeholder'=>'Total Bookings', 'min'=>'1'] ) !!}
								@if($errors->has('numberOfSlots')) <span class="help-block">{{$errors->first('numberOfSlots') }}</span> @endif
							</div>

							<div class="form-group {{($errors->has('court'))?'has-error':''}}" v-show="structuredSelected">
								<label class="control-label" for="CourtSelection">Court(s)</label>

								<select name="court[]" class="form-control select2-multiple"  multiple="multiple" tabindex="-1" aria-hidden="true" id="courtSelection">
									@foreach($data["courts"] as $court)
										<option value='{{$court["id"]}}' {{Input::old('court') ? (in_array($court["id"],Input::old('court')) ? 'selected' : '') : $data["league"]['court'] &&  in_array($court["id"],$data["league"]['court']) ?  'selected'  : ''  }} >{{ $court["name"] }}</option>
									@endforeach

								</select>
								@if($errors->has('court')) <span class="help-block">{{$errors->first('court') }}</span> @endif
							</div>

							<div class="form-group {{($errors->has('abilityLevel'))?'has-error':''}}">
								<label class="control-label">Player Expert level</label>
                                {!!Form::select('abilityLevel', config('global.league.abilityLevel'),Input::old('abilityLevel')? Input::old('abilityLevel') : (isset($data["league"]['abilityLevel']) ? $data["league"]['abilityLevel'] : ''),['class'=>'form-control','placeholder'=>'Select Expert level'] ) !!}
								@if($errors->has('abilityLevel')) <span class="help-block">{{$errors->first('abilityLevel') }}</span> @endif
							</div>

							<div class="form-group {{($errors->has('minNumberOfPlayers'))?'has-error':''}}">
								<label class="control-label">Min Number of Participants</label>
								{!! Form::number('minNumberOfPlayers',Input::old('minNumberOfPlayers')? Input::old('minNumberOfPlayers') : (isset($data["league"]['minNumberOfPlayers']) ? $data["league"]['minNumberOfPlayers'] : ''), ['class'=>'form-control','placeholder'=>'Number of Participants'] ) !!}
								@if($errors->has('minNumberOfPlayers')) <span class="help-block">{{$errors->first('minNumberOfPlayers') }}</span> @endif
								
							</div>
							<div class="form-group {{($errors->has('maxNumberOfPlayers'))?'has-error':''}}">
								<label class="control-label">Max Number of Participants</label>
								{!! Form::number('maxNumberOfPlayers',Input::old('maxNumberOfPlayers')? Input::old('maxNumberOfPlayers') : (isset($data["league"]['maxNumberOfPlayers']) ? $data["league"]['maxNumberOfPlayers'] : ''), ['class'=>'form-control','placeholder'=>'Number of Participants'] ) !!}
								@if($errors->has('maxNumberOfPlayers')) <span class="help-block">{{$errors->first('maxNumberOfPlayers') }}</span> @endif
								
							</div>

							<fieldset border="1px solid">
							<div class="form-group ">
								<label class="control-label">Registration Starts Date/Time</label>
								<div class="input-group date form_datetime form_datetime bs-datetime datepickerFormat">
									<input type="text" name="registrationStartAt" size="16" class="form-control"  placeholder="Starts Date" value="{{Input::old('registrationStartAt') ? date('Y-m-d H:i',strtotime(Input::old('registrationStartAt'))) : ($data["league"]['registrationStartAt'] ? date('Y-m-d H:i',strtotime($data["league"]['registrationStartAt'])) : '') }}">
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
									<input type="text" size="16" class="form-control" name="registrationCloseAt"  placeholder="End Date" value="{{Input::old('registrationCloseAt') ? date('Y-m-d H:i',strtotime(Input::old('registrationCloseAt'))) : ($data["league"]['registrationCloseAt'] ? date('Y-m-d H:i',strtotime($data["league"]['registrationCloseAt'])) : '') }}">
									<span class="input-group-addon">
										<button class="date-set" type="button">
										<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
							</fieldset>

					
							<div class="form-group">
								<label class="control-label">League Start Date</label>
								<div class="input-group date form_datetime form_datetime bs-datetime datepickerFormat" >
									<input type="text" class="form-control" size="16" name="leagueStartDate"  placeholder="Start Date"  value="{{Input::old('leagueStartDate') ? date('Y-m-d H:i',strtotime(Input::old('leagueStartDate'))) : ($data["league"]['leagueStartDate'] ? date('Y-m-d H:i',strtotime($data["league"]['leagueStartDate'])) : '') }}">
									<span class="input-group-addon">
										<button class="date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>
                            
                            <!--<div class="form-group">
								<label class="control-label">League Start Date</label>
								<div class="input-group date date-picker" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
									<input type="text" class="form-control date-picker" size="16" name="leagueStartDate"  placeholder="Start Date"  value="{{Input::old('leagueStartDate') ? date('Y-m-d H:i',strtotime(Input::old('leagueStartDate'))) : ($data["league"]['leagueStartDate'] ? date('Y-m-d H:i',strtotime($data["league"]['leagueStartDate'])) : '') }}">
									<span class="input-group-addon">
										<button class="date-set" type="button">
											<i class="fa fa-calendar"></i>
										</button>
									</span>
								</div>
							</div>-->

							<div class="form-group {{($errors->has('numberOfWeeks'))?'has-error':''}}">
								<label class="control-label">Number of Weeks</label>
								{!! Form::number('numberOfWeeks',Input::old('numberOfWeeks') ? Input::old('numberOfWeeks') : (isset($data["league"]['numberOfWeeks']) ? $data["league"]['numberOfWeeks'] : ''), ['class'=>'form-control','placeholder'=>'Number of weeks'] ) !!}
								@if($errors->has('numberOfWeeks')) <span class="help-block">{{$errors->first('numberOfWeeks') }}</span> @endif
							</div>

							<div class="form-group {{($errors->has('winning_criteria'))?'has-error':''}}" v-if="structuredSelected || unstructuredPointBasedSelected">
								<label class="control-label">Winning Criteria</label>
								<select class = 'form-control' placeholder = 'Select Criteria' name="winning_criteria">
									@foreach(config('global.league.winning_criteria') as $criteria)
										<option value='{{$criteria}}' {{Input::old('winning_criteria') ? ( Input::old('winning_criteria') == $criteria ? 'selected' : '') : $data["league"]["winning_criteria"] == $criteria ?  'selected'  : ''  }} >{{ $criteria }}</option>
									@endforeach

								</select>

								@if($errors->has('winning_criteria')) <span class="help-block">{{$errors->first('winning_criteria') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('pointsPerWin'))?'has-error':''}}"  v-if="structuredSelected || unstructuredPointBasedSelected">
								<label class="control-label">Points Per Win</label>
								{!! Form::number('pointsPerWin',Input::old('pointsPerWin') ? Input::old('pointsPerWin') : (isset($data["league"]['pointsPerWin']) ? $data["league"]['pointsPerWin'] : ''), ['class'=>'form-control','placeholder'=>'Points Per Win'] ) !!}
								@if($errors->has('pointsPerWin')) <span class="help-block">{{$errors->first('pointsPerWin') }}</span> @endif
							</div>
							<div class="form-group {{($errors->has('pointsPerLoss'))?'has-error':''}}"  v-if="structuredSelected || unstructuredPointBasedSelected">
								<label class="control-label">Points Per Loss</label>
								{!! Form::number('pointsPerLoss',Input::old('pointsPerLoss') ? Input::old('pointsPerLoss') : (isset($data["league"]['pointsPerLoss']) ? $data["league"]['pointsPerLoss'] : ''), ['class'=>'form-control','placeholder'=>'Points Per Loss'] ) !!}
								@if($errors->has('pointsPerLoss')) <span class="help-block">{{$errors->first('pointsPerLoss') }}</span> @endif
							</div>

							<div class="form-group {{($errors->has('weeksToPenalty'))?'has-error':''}}" v-if="!structuredSelected">
								<label class="control-label">Weeks To Penalty</label>
								<input type="number" name="weeksToPenalty" min="0"  class="form-control"  placeholder="Number Of Weeks" value="{{Input::old('weeksToPenalty') ? Input::old('weeksToPenalty') : $data['league']['weeksToPenalty'] }}">
								@if($errors->has('weeksToPenalty')) <span class="help-block">{{$errors->first('weeksToPenalty') }}</span> @endif
							</div>
							
							<div class="form-group m-t-30 text-right">
								{!! Form::button('Update League', ['class'=>'btn red btn-lg btn-outline btn-circle','type'=>'submit']) !!}
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


	<script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")}}" type="text/javascript"></script>
	<script src="{{asset("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")}}" type="text/javascript"></script>
	<script src="{{asset("assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")}}" type="text/javascript"></script>


	<script src="{{asset("assets/pages/scripts/components-date-time-pickers.js")}}" type="text/javascript"></script>

<script>
$('.datepickerFormat').datetimepicker({
    format: 'dd MM yyyy hh:ii',
	autoclose: true,
	isRTL: App.isRTL(),
	pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left")
});
</script>

	<link href="{{asset("assets/global/plugins/select2/css/select2.min.css")}}" rel="stylesheet" type="text/css" />
	<link href="{{asset("assets/global/plugins/select2/css/select2-bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
	<script src="{{asset("assets/global/plugins/select2/js/select2.full.min.js")}}" type="text/javascript"></script>
	<script src="{{asset("assets/pages/scripts/components-select2.min.js")}}" type="text/javascript"></script>

	<script>
		var vue = new Vue({
			el:'#league-vue-container',
			data:{
				structureTypes:{!! json_encode( array_values(config('global.league.structure_type') )) !!} ,
				selectedStructureType:"{!! Input::old('structure_type') ? Input::old('structure_type') : ((isset($data["league"]['structure_type'])) ? $data["league"]['structure_type'] : config('global.league.structure_type')["structured"]) !!}",
				selectedUnstructuredLeagueVariant:"{!! Input::old('unstructuredLeagueVariant') ? Input::old('unstructuredLeagueVariant') : ((isset($data['league']['unstructuredLeagueVariant'])) ? $data['league']['unstructuredLeagueVariant'] : 'LADDER') !!}",


			},
			computed:{
				structuredSelected:function(){
					console.log(this.selectedStructureType);
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
