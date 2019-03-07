@extends('__layouts.admin') @section('main')

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a>
				<i class="fa fa-angle-right"></i></li>
			<li><a href="{{url('/member')}}">Reservations</a></li>
		</ul>
        <div class="page-toolbar">
        	<ul class="page-breadcrumb">
            	<li><a href="javascript:window.print()"><i class="fa fa-print"></i></a></li>
            </ul>
        </div>
		<!-- <div class="page-toolbar">
			<div id="" class="pull-right tooltips btn btn-fit-height" data-placement="top" data-original-title="Search Members">
				<div class="input-icon right">
					<i class="icon-magnifier"></i>
				<input type="text" class="form-control form-control-solid input-circle" placeholder="search..."> </div>
			</div>
		</div> -->
	</div>

	<h1 class="page-title">
		Reservation List
	</h1>

<!-- END PAGE HEADER-->

	@if(Session::has('serverError'))
		<div class="alert alert-warning" role="alert">
			{{Session::get('serverError')}}</div>
	@endif @if(Session::has('success'))
		<div class="alert alert-success" role="alert">
			{{Session::get('success')}}</div>
	@endif
<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content ReservationPrintScreen" id="selectionDepHidden">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				{!! Form::open(['url' => route('trainings.book'), 'id'=>'member-form', 'class'=>'login-form', 'method'=>'post']) !!}
				<div class="portlet-title">
					<div class="row">
						<div class="col-md-7">
							<h3>John Whick Chapter 2</h3>
						</div>
						<div class="col-md-5 hideInPrint">
							<div class="inputs text-right">
								<div class="form-group memberReservationSearchBar {{($errors->has('parentMember'))?'has-error':''}}" id="membersPageAutoCom">
									<auto-complete-box url="{{url('member/list')}}" property-for-id="id" property-for-name="name"
													   filtered-from-source="true" include-id-in-list="true"
													   v-model="selectedId" initial-text-value="" search-query-key="search" field-name="member_id"></auto-complete-box>

								</div>
								<input type="hidden" name="training_id" value="{{$trainingId}}" />
								<button  type="submit" class="btn red btn-outline btn-circle">Reserve Member</button>
							</div>
						</div>
					</div>
				</div>
				 {!! Form::close() !!}
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							<div class="clearfix"></div>
							<table class="table table-hover customPaddingTable">
								<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Parent</th>
									<th>Phone</th>
									<th>Gender</th>
									<th style="width: 200px" class="actionWrap">Action</th>
								</tr>
								</thead>
								<tbody>
								@if(isset($data) && is_array($data) && count($data)> 0)
									@foreach((array)$data as $member)
										<tr>
											<td>{{$member['firstName']}} {{$member['lastName']}}</td>
											<td>{{$member['email']}}</td>
											<td>{{(array_key_exists('parentMember', $member))?array_get($member, 'parentMember.firstName').' '.array_get($member, 'parentMember.lastName'):'--'}}</td>
											<td>{{$member['phone']}}</td>
											<td>{{$member['gender']}}</td>
											<td class="action-btns">
												{!! Form::open(array('route' => array('trainings.remove', $member['reservation_player_id']), 'method' => 'delete')) !!}

													<button style="padding: 5px 16px; width: 85px" type="submit" class="btn btn-outline btn-circle red btn-sm"><i class="fa fa-trash"></i>&nbsp;Remove</button>

												{!! Form::close() !!}
											</td>
										</tr>
									@endforeach @else
									<tr>
										<td colspan="6" style="text-align: center">No Reservations</td>
									</tr>
								@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END PROFILE CONTENT -->


<div class="clearfix"></div>
<style>
.action-btns span {
	float: left;
	margin-right: 5px;
}

.action-btns span button {
	border: 0;
}
</style>
@stop
@section('page-specific-scripts')
@include("__vue_components.autocomplete.autocomplete")
<!--Print Style File-->
<link href="{{asset('assets/printStyle.css')}}" rel="stylesheet" type="text/css" media="print" >

<script>
	    var vue = new Vue({
            el: "#selectionDepHidden",
            data: {
                
            },
			computed:{
				showParentSelector:function(){
					return true;
				}
			},
            methods: {

            }
        });
    </script>
@endSection