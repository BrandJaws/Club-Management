@extends('__layouts.admin')
@section('heading') Add Training @endSection
@section('main')
    <!-- BEGIN PAGE HEADER-->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a> <i
                        class="fa fa-angle-right"></i></li>
            <li><a href="{{url('/trainings')}}">Trainings</a> <i class="fa fa-angle-right"></i></li>
            @if(isset($trainingId))
                <li><a href="#">Update</a></li>
            @else
                <li><a href="#">Create</a></li>
            @endif
        </ul>
    </div>

    <h1 class="page-title">
        @if(isset($trainingId)) Update @else Create @endif Training
    </h1>


    <div class="profile-content">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-body">
                    	@if(isset($trainingId))
                    	{!! Form::open(['url' => route('trainings.update', $trainingId), 'id'=>'member-form', 'class'=>'login-form', 'method'=>'PUT', 'enctype'=>'multipart/form-data']) !!}
                    	@else
                        {!! Form::open(['url' => route('trainings.store'), 'id'=>'member-form', 'class'=>'login-form', 'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
                        @endif
                        @if(Session::has('serverError'))
                            <div class="alert alert-warning" role="alert"> {{Session::get('serverError')}} </div>
                        @endif
                        @if(Session::has('success'))
                            <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div>
                        @endif
                        <div id="example-basic">
                            <h3>General Info</h3>
                            <section>
                                <div class="form-group {{($errors->has('title'))?'has-error':''}}">
                                    <label class="control-label">Title (required)</label>
                                    {!! Form::text('name', array_get($data,'name',''), ['class'=>'form-control', 'placeholder'=>'Title'] ) !!}
                                    @if($errors->has('name')) <span class="help-block">{{$errors->first('title') }}</span> @endif
                                </div>
                                <div class="form-group {{($errors->has('price'))?'has-error':''}}">
                                    <label class="control-label">Training Fee (required)</label>
                                    {!! Form::text('price', array_get($data,'price',''), ['class'=>'form-control', 'placeholder'=>'Training Fee'] ) !!}
                                    @if($errors->has('price')) <span class="help-block">{{$errors->first('price') }}</span> @endif
                                </div>
                                <div class="form-group {{($errors->has('description'))?'has-error':''}}">
                                    <label class="control-label">Description (required)</label>
                                    {!! Form::textarea('description', array_get($data,'description',''), ['class'=>'form-control','id'=>'wysiwigEditor', 'placeholder'=>'Description','rows'=>'8'] ) !!}
                                    @if($errors->has('description')) <span class="help-block">{{$errors->first('description') }}</span> @endif
                                </div>
                                <div class="form-group {{($errors->has('package'))?'has-error':''}}">
                                    <label class="control-label">Package</label> <br />
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" value="{{config('global.package.packaged')}}" id="packaged" name="package" class="md-radiobtn" {{(array_get($data,'package','') =='' || array_get($data,'package','') == config('global.package.packaged'))?'checked="checked"':'' }} />
                                            <label for="packaged">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Packaged
                                            </label>
                                        </div>
                                        <div class="md-radio">
                                            <input type="radio" value="{{config('global.package.individual')}}" id="individual" name="package" class="md-radiobtn" {{(array_get($data,'package','') == config('global.package.individual'))?'checked="checked"':'' }}>
                                            <label for="individual">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Individual
                                            </label>
                                        </div>
                                    </div>
                                    @if($errors->has('package')) <span class="help-block">{{$errors->first('package') }}</span> @endif
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Training Media</label>
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" value="{{config('global.contentType.image')}}" id="tpic" name="promotionType" class="md-radiobtn promoType" {{(array_get($data,'promotionType','') =='' || array_get($data,'promotionType','') == config('global.contentType.image'))?'checked="checked"':'' }}>
                                            <label for="tpic">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Image
                                            </label>
                                        </div>
                                        <div class="md-radio">
                                            <input type="radio" value="{{config('global.contentType.video')}}" id="tvideo" name="promotionType" class="md-radiobtn promoType" {{(array_get($data,'promotionType','') == config('global.contentType.video'))?'checked="checked"':'' }}>
                                            <label for="tvideo">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Video
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{($errors->has('promotionImage'))?'has-error':''}}" id="trainingPic" >
                                    <label for="" class="control-label">Choose Images</label>
                                    <input type="file" name="promotionImage" class="form-control" />
                                     @if($errors->has('promotionImage')) <span class="help-block">{{$errors->first('promotionImage') }}</span> @endif
                                </div>
                                <div class="form-group {{($errors->has('promotionImage'))?'has-error':''}}" id="trainingVid" style="display: none;">
                                    <label for="" class="control-label">Paste URL of Youtube/Vimeo Video</label>
                                    <input type="url" name="videoUrl" value="{{array_get($data,'videoUrl','')}}" placeholder="e.g., https://www.youtube.com/watch?v=YE7VzlLtp-4" class="form-control" />
                                     @if($errors->has('videoUrl')) <span class="help-block">{{$errors->first('videoUrl') }}</span> @endif
                                </div>
                                <div class="form-group {{($errors->has('numberOfSlots'))?'has-error':''}}">
                                    <label class="control-label">Court slots booked</label>
                                    {!! Form::number('numberOfSlots',  array_get($data,'numberOfSlots',''), ['class'=>'form-control', 'placeholder'=>'Total Bookings', 'min'=>'1'] ) !!}
                                    @if($errors->has('numberOfSlots')) <span class="help-block">{{$errors->first('numberOfSlots') }}</span> @endif
                                </div>
                                <div class="form-group {{($errors->has('numberOfSessions'))?'has-error':''}}">
                                    <label class="control-label">Total Numer of classes?</label>
                                    {!! Form::number('numberOfSessions',  array_get($data,'numberOfSessions',''), ['class'=>'form-control', 'placeholder'=>'Total Number of classes', 'min'=>'1'] ) !!}
                                    @if($errors->has('numberOfSessions')) <span class="help-block">{{$errors->first('numberOfSessions') }}</span> @endif
                                </div>
                                
                                <div class="form-group {{($errors->has('instructor'))?'has-error':''}}">
                                    <label class="control-label" for="trainingInstructor">Instructor</label>
                                     {!! Form::select('instructor',$coaches ,array_get($data,'instructor',''), ['class'=>'col-md-12 form-control input-lg select2','tabindex'=>"-1",'aria-hidden'=>"true" ,'placeholder'=>'Select Coach'] ) !!}
                                     @if($errors->has('instructor')) <span class="help-block">{{$errors->first('instructor') }}</span> @endif
                                </div>

                                <div class="form-group {{($errors->has('court'))?'has-error':''}}">
                                    <label class="control-label" for="CourtSelection">Court(s)</label>
                                    <select name="court[]" class="form-control select2-multiple"  multiple="multiple" tabindex="-1" aria-hidden="true" id="courtSelection">
                                        @foreach($courts as $court)
                                        <option value="{{$court["id"] }}" {{(in_array( $court["id"],array_get($data,'slectedCourts',[])))? 'selected="selected"':''}}>{{$court["name"] }}</option>
                                        @endforeach
                                    </select>
                                      @if($errors->has('court')) <span class="help-block">{{$errors->first('court') }}</span> @endif
                                </div>
                            </section>
                            <h3>Training Details</h3>
                            <section>
                               
                                
                                <fieldset border="1px solid">
                                    <legends>When Will you like to open bookings? (required)</legends>
                                    <div class="form-group {{($errors->has('registrationStartAt'))?'has-error':''}}">
                                        <label class="control-label">Registration starts at?</label>
                                        <div class="input-group date form_datetime ">
                                            <input type="text" name="registrationStartAt" size="16" class="form-control" value="{{(array_get($data,'registrationStartAt','') !='')? date('Y-m-d H:i',strtotime(array_get($data,'registrationStartAt',''))): ''}}">
                                            <span class="input-group-addon">
                                            <button class="date-set" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                        </div>
                                         @if($errors->has('registrationStartAt')) <span class="help-block">{{$errors->first('registrationStartAt') }}</span> @endif
                                    </div>
                                    <div class="form-group {{($errors->has('registrationCloseAt'))?'has-error':''}}">
                                        <label class="control-label">Registration closed at?</label>
                                        <div class="input-group date form_datetime form_datetime bs-datetime">
                                            <input type="text" size="16" class="form-control" name="registrationCloseAt" value="{{(array_get($data,'registrationCloseAt','') !='')? date('Y-m-d H:i',strtotime(array_get($data,'registrationCloseAt',''))): ''}}" />
                                            <span class="input-group-addon">
                                            <button class="date-set" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                        </div>
                                         @if($errors->has('registrationCloseAt')) <span class="help-block">{{$errors->first('registrationCloseAt') }}</span> @endif
                                    </div>
                                </fieldset>
                                <div class="form-group {{($errors->has('trainingStart'))?'has-error':''}}">
                                    <label class="control-label">Training Date Time (required)</label>
                                    <div class="input-group date form_datetime form_datetime bs-datetime " >
                                        <input type="text" size="16" class="form-control" name="trainingStart"  value="{{(array_get($data,'trainingStart','') !='')? date('Y-m-d H:i',strtotime(array_get($data,'trainingStart',''))): ''}}">
                                        <span class="input-group-addon">
                                            <button class="date-set" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                     @if($errors->has('trainingStart')) <span class="help-block">{{$errors->first('trainingStart') }}</span> @endif
                                </div>
                                <div class="form-group {{($errors->has('minRegistrations'))?'has-error':''}}">
                                    <label class="control-label">Minimum Registration required for this training</label>
                                    {!! Form::number('minRegistrations', array_get($data,'minRegistrations',''), ['class'=>'form-control', 'placeholder'=>'Minimum Registrations', 'min'=>'0'] ) !!}
                                    @if($errors->has('minRegistrations')) <span class="help-block">{{$errors->first('minRegistrations') }}</span> @endif
                                </div>
                                <div class="form-group {{($errors->has('maxRegistrations'))?'has-error':''}}">
                                    <label class="control-label">Close booking when total registrations reached?</label>
                                    {!! Form::text('maxRegistrations', array_get($data,'maxRegistrations', ''), ['class'=>'form-control', 'placeholder'=>'Maximum Registrations', 'min'=>'0'] ) !!}
                                    @if($errors->has('maxRegistrations')) <span class="help-block">{{$errors->first('maxRegistrations') }}</span> @endif
                                </div>
                                <div class="form-group {{($errors->has('repeat'))?'has-error':''}}">
                                    <label class="control-label">Will Training Repeats?</label> <br />
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" value="{{config('global.repeatTraining.no_repeat')}}" id="no-repeat" name="repeatTraining" class="md-radiobtn" {{(array_get($data,'repeatTraining','') == '' || array_get($data,'repeatTraining','') == config('global.repeatTraining.no_repeat'))?'checked="checked"':'' }} />
                                            <label for="no-repeat">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> No Repeat
                                            </label>
                                        </div>
                                        <div class="md-radio">
                                            <input type="radio" value="{{config('global.repeatTraining.repeat_daily')}}" id="repeat-daily" name="repeatTraining" class="md-radiobtn" {{(array_get($data,'repeatTraining','') == config('global.repeatTraining.repeat_daily'))?'checked="checked"':'' }} />
                                            <label for="repeat-daily">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Repeat Daily
                                            </label>
                                        </div>
                                        <div class="md-radio">
                                            <input type="radio" value="{{config('global.repeatTraining.repeat_weekly')}}" id="repeat-weekly" name="repeatTraining" class="md-radiobtn" {{(array_get($data,'repeatTraining','') == config('global.repeatTraining.repeat_weekly'))?'checked="checked"':'' }} />
                                            <label for="repeat-weekly">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Repeat Weekly
                                            </label>
                                        </div>
                                        <div class="md-radio">
                                            <input type="radio" value="{{config('global.repeatTraining.repeat_monthly')}}" id="repeat-monthly" name="repeatTraining" class="md-radiobtn" {{(array_get($data,'repeatTraining','') == config('global.repeatTraining.repeat_monthly'))?'checked="checked"':'' }} />
                                            <label for="repeat-monthly">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Repeat Monthly
                                            </label>
                                        </div>
                                        <div class="md-radio">
                                            <input type="radio" value="{{config('global.repeatTraining.repeat_yearly')}}" id="repeat-yearly" name="repeatTraining" class="md-radiobtn" {{(array_get($data,'repeatTraining','') == config('global.repeatTraining.repeat_yearly'))?'checked="checked"':'' }} />
                                            <label for="repeat-yearly">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Repeat Yearly
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <h3>Policies/Restrictions</h3>
                            <section>
                                <div class="form-group">
                                    <div class="md-radio-inline">
                                        <div class="md-radio">
                                            <input type="radio" value="{{config('global.gender.all')}}" id="all" name="gender" class="md-radiobtn" {{(array_get($data,'gender','') == '' || array_get($data,'gender','') == config('global.gender.all'))?'checked="checked"':'' }} />
                                            <label for="all">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> All
                                            </label>
                                        </div>
                                        <div class="md-radio">
                                            <input type="radio" value="{{config('global.gender.male')}}" id="male" name="gender" class="md-radiobtn" {{(array_get($data,'gender','') == config('global.gender.male'))?'checked="checked"':'' }} />
                                            <label for="male">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Male
                                            </label>
                                        </div>
                                        <div class="md-radio">
                                            <input type="radio" value="{{config('global.gender.female')}}" id="female" name="gender" class="md-radiobtn" {{(array_get($data,'gender','') == config('global.gender.female'))?'checked="checked"':'' }} />
                                            <label for="female">
                                                <span class="inc"></span>
                                                <span class="check"></span>
                                                <span class="box"></span> Female
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="checkbox1" class="md-check" name="allowMemberToViewParticipants" value="{{config('global.status.yes')}}" {{(array_get($data,'allowMemberToViewParticipants','') == config('global.status.yes'))?'checked="checked"':'' }} />
                                        <label for="checkbox1">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Allow members to view other participants <participants></participants>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="ageRestriction" class="md-check" name="ageRestriction" value="{{config('global.status.yes')}}" {{(array_get($data,'ageRestriction','') == config('global.status.yes'))?'checked="checked"':''}} />
                                        <label for="ageRestriction">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Age Restriction <participants></participants>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="display: none;" id="ageRestrictionSelector">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" id="ageRestrictionSlider" name="age" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="playerAbility" class="md-check" name="playerAbilityRestriction" value="{{config('global.status.yes')}}" {{(array_get($data,'playerAbilityRestriction','') == config('global.status.yes'))?'checked="checked"':''}} />
                                        <label for="playerAbility">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Player Ability Restriction <participants></participants>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" id="playerAbilityRestrictionBox" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" id="playerAbilityRestrictionSlider" name="playerAbility" name="example_name" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="disallowCancelation" class="md-check" name="disablePlayerCancellation" value="{{config('global.status.yes')}}" {{(array_get($data,'disablePlayerCancellation','') == config('global.status.yes'))?'checked="checked"':''}}>
                                        <label for="disallowCancelation">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Disable Cancellation By Member <participants></participants>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="cancelPolicyActive" class="md-check" name="applyCancellationPolicy" value="{{config('global.status.yes')}}" {{(array_get($data,'applyCancellationPolicy','') == config('global.status.yes'))?'checked="checked"':''}}>
                                        <label for="cancelPolicyActive">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Activate Following Cancellation Policy(s) <participants></participants>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group mt-repeater">
                                    <div data-repeater-list="group-b">
                                        <div data-repeater-item="" class="mt-repeater-item mt-overflow">
                                            <div class="mt-repeater-cell">
                                                <div class="row">
                                                    <div class="col-md-3">If a member cancels within:</div>
                                                    <div class="col-md-1">
                                                        <input type="number" class="form-control" name="time[]" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select class="form-control" name="type[]">
                                                            <option value="hours">Hours</option>
                                                            <option value="minutes">Minutes</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select class="form-control" name="when[]">
                                                            <option value="prior">Prior to</option>
                                                            <option value="after">After</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        class start time,
                                                    </div>
                                                    <div class="col-md-2">

                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        then the member will be charged
                                                    </div>
                                                    <div class="col-md-1">
                                                        <input type="text" class="form-control" name="price[]" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        % of class fee.
                                                    </div>
                                                </div>
                                                <a href="javascript:;" data-repeater-delete="" class="btn btn-danger mt-repeater-delete mt-repeater-del-right mt-repeater-btn-inline">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:;" data-repeater-create="" class="btn red mt-repeater-add">
                                    <i class="fa fa-plus"></i> Add new cancellation policy</a>
                                </div>
                            </section>
                        </div>
                        {{--<div class="margiv-top-10">--}}
                            {{--{!! Form::button('Save Changes', ['class'=>'btn green-haze','type'=>'submit']) !!}--}}
                        {{--</div>--}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection
@section('page-specific-scripts')
    <link rel="stylesheet" href="{{asset("assets/jquery.steps.css")}}" />
    <script src="{{asset("assets/custom/jquery.steps.min.js")}}"></script>
    <link href="{{asset("assets/global/plugins/ion.rangeslider/css/ion.rangeSlider.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("assets/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinFlat.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js")}}" type="text/javascript"></script>
    <link href="{{asset("assets/global/plugins/select2/css/select2.min.css")}}" rel="stylesheet" type="text/css" />
    <link href="{{asset("assets/global/plugins/select2/css/select2-bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/select2/js/select2.full.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/pages/scripts/components-select2.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/pages/scripts/form-repeater.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/jquery-repeater/jquery.repeater.js")}}" type="text/javascript"></script>
    <link href="{{asset("assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")   }}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/pages/scripts/components-date-time-pickers.js")}}" type="text/javascript"></script>
    <script>
        @if(isset($trainingId))
            $(document).ready(function(){
//                $(".actions ul").append('<li><a id="updateForm">Update</a></li>');
            $(".actions ul li").last().css("display","block");
            $(".actions ul li a").addClass("btn-circle");
            });
        @endif
        //for jquery steps
        $("#example-basic").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "fade",
            autoFocus: true,
            labels: {
                finish: "Save Changes"
            },
            onFinished: function (event, currentIndex) {
                $(this).submit();
            },
            @if(isset($trainingId))
            onStepChanged: function(event, currentIndex) {
                $(".actions ul li").last().css("display","block");
            }
            @endif
        });


        //to submit form when finish button is clicked
        $("a[href='#finish']").click(function(){
           $(".login-form").submit();
        });


//        $("#updateForm").click(function(){
//            $(".login-form").submit();
//        });


        //for number fields to prevent the -ve value
        var numInput = document.querySelector('input[type=number]');

        // Listen for input event on numInput.
        numInput.addEventListener('input', function(){
            // Let's match only digits.
            var num = this.value.match(/^\d+$/);
            if (num === null) {
                // If we have no match, value will be empty.
                this.value = "";
            }
        }, false)

        //for age restriction checkbox
        $("#genderRestriction").change(function(){
        	genderBoxSlectionState();
        });
        function genderBoxSlectionState(){
        	if($("#genderRestriction").is(':checked')){
            	$("#genderSelectionBox").show();
            }else{
            	$("#genderSelectionBox").hide();
            }
        }
        //for age restriction checkbox
        $("#ageRestriction").change(function(){
        	showAgeResitrictionBox()
        });
        function showAgeResitrictionBox(){
            if($("#ageRestriction").is(':checked')){
            	$("#ageRestrictionSelector").show();
            }else{
            	$("#ageRestrictionSelector").hide();
            }
				
        }
        $("#ageRestrictionSlider").ionRangeSlider({
            type: "double",
            grid: true,
            min: 04,
            max: 80,
            from: {{array_get($data, 'ageFrom','18')}},
            to: {{array_get($data, 'ageTo','40')}},
            prefix: ""
        });

        //for player ability restriction
        $("#playerAbility").change(function(){
        	playerAbitlityBoxState();
        });
        function playerAbitlityBoxState(){
        	if($("#playerAbility").is(':checked')){
            	$("#playerAbilityRestrictionBox").show();
            }else{
            	$("#playerAbilityRestrictionBox").hide();
            }
        }
        $("#playerAbilityRestrictionSlider").ionRangeSlider({
            type: "double",
            grid: true,
            min: 1.0,
            max: 5.0,
            from: {{array_get($data, 'minLevel','1.5')}},
            to: {{array_get($data, 'maxLevel','4.5')}},
            step: 0.5
        });
        //for training media
        $('.promoType').bind('change',function(){
        	promotionType();
        });
       
		function promotionType(){
				var promoType = $('input[name="promotionType"]:checked').val();
				if(promoType == '{{config('global.contentType.video')}}'){
					$('#trainingPic').hide();
					$('#trainingVid').show();
				}else{
					$('#trainingPic').show();
					$('#trainingVid').hide();
				}
		}
        //select 2
      //  $("#trainingInstructor").select2();

        $(document).ready(function(){
        	promotionType();
        	showAgeResitrictionBox();
        	genderBoxSlectionState();
        	playerAbitlityBoxState();
        });
        $("#courtSelection").select2({placeholder:'Please Select a Court'});
    </script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
	<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
	<script>
	$(document).ready(function() {
		  $('#wysiwigEditor').summernote({height: 200});
	});

		</script>
@endSection