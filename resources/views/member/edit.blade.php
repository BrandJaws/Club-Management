@extends('__layouts.admin') @section('main')

<!-- BEGIN PAGE HEADER-->

<div class="page-bar">
	<ul class="page-breadcrumb">

		<li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a>
			<i class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/member')}}">Members</a> <i
			class="fa fa-angle-right"></i></li>
		<li><a href="#">Edit</a></li>

	</ul>
</div>

<h1 class="page-title">
	Edit Member
</h1>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->


<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content" id="selectionDepHidden">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light">
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							{!! Form::open(['url' =>route('member.update',['id'=>$data['id']]),
                        'id'=>'member-form','class'=>'login-form', 'method'=>'put']) !!}
							@if(Session::has('serverError'))
								<div class="alert alert-warning" role="alert">
									{{Session::get('serverError')}}</div>
							@endif @if(Session::has('success'))
								<div class="alert alert-success" role="alert">
									{{Session::get('success')}}</div>
							@endif
							<div class="form-group">
								<label class="control-label"> First Name</label> {!!
						Form::text('firstName',(isset($data['firstName']))?$data['firstName']:'',['class'=>'form-control',
						'placeholder'=>'First Name'] ) !!}
							</div>
							<div class="form-group">
								<label class="control-label"> Last Name</label>
								{!!Form::text('lastName',(isset($data['lastName']))?$data['lastName']:'',['class'=>'form-control',
                                'placeholder'=>'Last Name']) !!}
							</div>
							<div class="form-group">
								<label class="control-label">Email</label> {!!
						Form::text('email',(isset($data['email']))?$data['email']:'',['class'=>'form-control',
						'placeholder'=>'Email'] ) !!}
							</div>
							<div class="form-group">
								<label class="control-label">Phone</label> {!!
						Form::text('phone',(isset($data['phone']))?$data['phone']:'',['class'=>'form-control',
						'placeholder'=>'Phone'] ) !!}
							</div>
							<div class="form-group">
								<label class="control-label">Password</label> {!!
						Form::password('password', ['class'=>'form-control
						','placeholder'=>'Password'] ) !!}
							</div>
							<div class="form-group">
								<label class="control-label">Gender</label> {!!
						Form::select('gender', array('MALE' => 'Male', 'FEMALE'
						=>'Female'),(isset($data['gender']))?$data['gender']:'',array('class'=>
						'form-control') ) !!}

							</div>
							<div class="form-group">
								<label class="control-label">DOB</label> 
								{!! Form::text('dob',(isset($data['dob']))?$data['dob']:'',['class'=>'form-control date-picker','placeholder'=>'Date of Birth'] ) !!}
							</div>
						 <div class="row row-sm">
                                <div class="col-md-3">
                                    <div class="form-group form-group-inline">
                                        <label class="form-control-label">Member Type</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row row-sm">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label class="ui-check"> <input v-model="memberType"  type="radio" name="relation" value="parent"  class="has-value" /> <i class="dark-white"></i> Parent
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label class="ui-check"> 
                                                    <input v-model="memberType"  type="radio" name="relation" value="affiliate"  class="has-value"  /> <i
                                                                class="dark-white"></i> Affiliate Member
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm animated fadeInUp" v-cloak v-if="showParentSelector">
                                <div class="col-md-12">
                                	<div class="row row-sm">
                                	<div class="col-md-3">
                                    <div class="form-group form-group-inline">
                                        <label class="form-control-label">Relation</label>
                                    </div>
                                   </div>
                                	<div class="col-md-3">
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label class="ui-check"> 
                                                    <input v-model="affiliate_type"  type="radio" name="type" value="SPOUSE"  class="has-value" /> 
                                                    	<i class="dark-white"></i> Spouse
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="radio">
                                                    <label class="ui-check"> 
                                                    <input v-model="affiliate_type"  type="radio" name="type" value="CHILD"  class="has-value"  /> <i
                                                                class="dark-white"></i> Child
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                	</div>
                                    <div class="row row-sm">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Select Parent Member</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group {{($errors->has('parentMember'))?'has-error':''}}" id="membersPageAutoCom">
                                                <auto-complete-box url="{{url('member/list')}}" property-for-id="id" property-for-name="name"
                                                                   filtered-from-source="true" include-id-in-list="true"
                                                                   v-model="selectedId" :initial-text-value="initialTextForParentInput" search-query-key="search" field-name="parentMember"> </auto-complete-box>
                                            	@if($errors->has('parentMember')) <span class="help-block errorProfilePic">{{$errors->first('parentMember') }}</span> @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="m-t-30 text-right">
								{!! Form::button('Update Member',['class'=>'btn red btn-lg btn-outline btn-circle', 'type'=>'submit']) !!}
							</div>
							{!! Form::close() !!}
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@if(isset($data['affiliate_members']) && is_array($data['affiliate_members']))
<h1 class="page-title">
    Affiliate Members
</h1>
<div class="profile-content">

	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="actions">
						<a href="{{route('member.create')}}" class="btn red btn-outline btn-circle"> Add Member</a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							<div class="clearfix"></div>
							@if(Session::has('serverError'))
								<div class="alert alert-warning" role="alert">
									{{Session::get('serverError')}}</div>
							@endif @if(Session::has('success'))
								<div class="alert alert-success" role="alert">
									{{Session::get('success')}}</div>
							@endif

							<table class="table table-hover customPaddingTable">
								<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Edit</th>
								</tr>
								</thead>
								<tbody>
									@foreach((array)$data['affiliate_members'] as $affiliate)
										<tr>
											<td>{{$affiliate['firstName'].' '.$affiliate['lastName']}}</td>
											<td>{{$affiliate['email']}}</td>
											<td>{{$affiliate['phone']}}</td>
											<td><a style="padding: 5px 16px; width: 85px" href="{{route('member.edit',['id'=>$affiliate['id']])}}" class="btn btn-outline green btn-sm btn-circle"><i class="fa fa-pencil"></i>&nbsp;Edit</a></td>
										</tr>
									@endforeach 
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif

@if(isset($data['trainings']) && is_array($data['trainings']) && count($data['trainings']))
<h1 class="page-title">
    Trainings
</h1>
<div class="portlet light ">
    {{--<div class="portlet-title">--}}
        {{--<div class="actions">--}}
            {{--<a href="#." class="btn red btn-outline btn-circle"> Create Training</a>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <div class="clearfix"></div>
                    <!-- <div class="alert alert-warning" role="alert">
                    </div>
                    <div class="alert alert-success" role="alert">
                    </div> -->
                <table class="table table-hover customPaddingTable">
                    <thead>
                    <tr>
                        <th>For</th>
                        <th>Name</th>
                        <th>Training Date</th>
                        <th>Coach</th>
                        <th>Bookings</th>
                        <th style="width: 200px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach((array)$data['trainings'] as $training)
                        <tr>
                            <td>{{$training['memberName']}}</td>
                            <td>{{$training['trainingName']}}</td>
                            <td>{{date('Y-m-d',strtotime($training['trainingStart']))}}</td>
                            <td>{{$training['coach']}}</td>
                            <td>{{$training['seatsReserved']}}</td>
                            <td class="action-btns">
                                    <a style="padding: 5px 16px; width: 85px" href="#." class="btn btn-outline green btn-sm btn-circle" ><i class="fa fa-pencil"></i>&nbsp;Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endif

@if(isset($data['leagues']) && is_array($data['leagues']) && count($data['leagues']))
<!--League-->
<h1 class="page-title">
    Leagues
</h1>
<div class="portlet light ">
    {{--<div class="portlet-title">--}}
        {{--<div class="actions">--}}
            {{--<a href="#." class="btn red btn-outline btn-circle"> Create Leagues</a>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <div class="clearfix"></div>
                    <!-- <div class="alert alert-warning" role="alert">
                    </div>
                    <div class="alert alert-success" role="alert">
                    </div> -->
                <table class="table table-hover customPaddingTable">
                    <thead>
                    <tr>
                        <th>For</th>
                        <th>League Name</th>
                        <th>League Type</th>
                        <th>Structure Type</th>
                        <th>Player Expert Level</th>
                        <th>League Start Date</th>
                        <th style="width: 200px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach((array)$data['leagues'] as $league)
                        @foreach($league["league_players"] as $leaguePlayer)
                            <tr>
                                <td>{{$leaguePlayer["member"]['firstName'].' '.$leaguePlayer["member"]['lastName']}} </td>
                                <td>{{$league['name']}}</td>
                                <td>{{$league['league_type']}}</td>
                                <td>{{$league['structure_type']}}</td>
                                <td>{{$league['abilityLevel']}}</td>
                                <td>{{$league['leagueStartDate']}}</td>
                                <td class="action-btns"><a style="padding: 5px 16px; width: 85px" href="#." class="btn btn-outline green btn-sm btn-circle"><i class="fa fa-pencil"></i>&nbsp;Edit</a></td>
                            </tr>
                        @endforeach
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endif



<!-- END PROFILE CONTENT -->
<!-- END PAGE CONTENT-->

@stop
@section('page-specific-scripts')
    <link href="{{asset("assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js")}}" type="text/javascript"></script>
    
    <link href="{{asset("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css")}}" rel="stylesheet" type="text/css" />
    <script src="{{asset("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")   }}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/pages/scripts/components-date-time-pickers.js")}}" type="text/javascript"></script>
    
    @include("__vue_components.autocomplete.autocomplete")
   
    <script>

        var main_member = {!!  isset($data['main_member']) && $data['main_member'] != null ? json_encode($data['main_member']): "''" !!} ;
        var parentSelectionError =  "{{$errors->has('parentMember')  ? $errors->first('parentMember'): '' }}" ;

        var baseUrl = "{{url('')}}";
        _warnings = [{name:'FORES',description:'Lorem impsul dolar esmit...',date:'Dec 9 2016 - 2:13:00 AM'},
                    {name:'NINE',description:'Lorem impsul dolar esmit...',date:'Dec 6 2016 - 2:13:00 AM'},
                    {name:'SOD',description:'Lorem impsul dolar esmit...',date:'Dec 2 2016 - 2:13:00 AM'},
                    {name:'APRON',description:'Lorem impsul dolar esmit...',date:'Jan 9 2017 - 2:13:00 AM'},
                    {name:'PAR',description:'Lorem impsul dolar esmit...',date:'Jan 4 2017 - 2:13:00 AM'},
                    {name:'PLAYBY',description:'Lorem impsul dolar esmit...',date:'Jan 10 2017 - 2:13:00 AM'},
                    {name:'TEE',description:'Lorem impsul dolar esmit...',date:'Jan 12 2017 - 2:13:00 AM'},
                    {name:'ROUGH',description:'Lorem impsul dolar esmit...',date:'Jan 19 2017 - 2:13:00 AM'},
                    ];

        var vue = new Vue({
            el: "#selectionDepHidden",
            data: {

                memberType:'{{($data['main_member_id'] != 0 || $errors->has('parentMember')  )?'affiliate':'parent'}}',
                selectedId: main_member != '' ? main_member.id :false,
                warnings:[],
                latestPageLoaded:0,
                ajaxRequestInProcess:false,
                initialTextForParentInput: main_member != '' ? main_member.firstName+' '+main_member.lastName :'',
                affiliate_type:'{{($data['type'] == 'PARENT' )?'':$data['type']}}' 
                      
            },
            computed:{
                showParentSelector:function(){
                    if (this.memberType == 'affiliate') {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            },
            methods: {

                loadNextPage:function() {
                    //add sample data to array to check scroll functionality
                    if (this.latestPageLoaded == 0) {
                        for (x = 0; x < _warnings.length; x++) {
                            this.warnings.push(_warnings[x]);
                        }

                    }
                    return;
                }
            }
        });
        $(document).ready(function() {
            vue.loadNextPage();

        });
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() == $(document).height()) {
                vue.loadNextPage();
            }
        });

    </script>
   
    @endSection
