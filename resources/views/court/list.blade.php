@extends('__layouts.admin') @section('main')
<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="index.html">Home</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/court')}}">Courts</a></li>
	</ul>
	{{--<div class="page-toolbar">--}}
	{{--<div id="" class="pull-right tooltips btn btn-fit-height" data-placement="top" data-original-title="Search Members">--}}
	{{--<div class="input-icon right">--}}
	{{--<i class="icon-magnifier"></i>--}}
	{{--<input type="text" class="form-control form-control-solid input-circle" placeholder="search..."> </div>--}}
	{{--</div>--}}
	{{--</div>--}}
</div>

<h1 class="page-title">
	Courts
</h1>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
<div class="profile-content">
	<div class="row">
		<div class="col-md-12">

			<div class="portlet light ">
				<div class="portlet-title">
					<div class="actions">
						<a href="{{route('court.create')}}" class="btn red btn-outline btn-circle"> Create Court</a>
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
									<th>Court Name</th>
									<th>Opening Time</th>
									<th>Closing Time</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
								</thead>
								<tbody>
								@if(!empty($data))
									@foreach((array)$data as $court)
										<tr>
											<td>{{$court['name']}}</td>
											<td>{{Carbon\Carbon::parse($court['openTime'])->format('h:i A')}}</td>
											<td>{{Carbon\Carbon::parse($court['closeTime'])->format('h:i A')}}</td>
											<td>{{ucfirst(strtolower($court['status']))}}</td>
											<td><a style="padding: 5px 16px; width: 85px" href="{{route('court.edit',['id'=>$court['id']])}}"
												   class="btn red btn-sm btn-circle btn-outline"> <i class="fa fa-pencil"></i>&nbsp;Edit
												</a></td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="6" style="text-align: center">Nothing to show here</td>
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

@stop
