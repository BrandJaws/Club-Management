@extends('__layouts.admin') @section('main')

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="/dashboard">Home</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/beacon')}}">List</a></li>
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
	Beacon List
</h1>

<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="actions">
						<a href="{{route('beacon.create')}}" class="btn red btn-outline btn-circle"> Configure Beacon</a>
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
									<th>Beacon Name</th>
									<th>Court</th>
									<th>Major</th>
									<th>Minor</th>
									<th>Check In Duration</th>
									<th>Status</th>
									<th style="width: 200px;">Action</th>
								</tr>
								</thead>
								<tbody>
								@if(!empty($data))
									@foreach((array)$data["data"] as $beacon)
										<tr>
											<td>{{$beacon["name"]}}</td>
											<td>{{$beacon["courtName"]}}</td>
											<td>{{$beacon["major"]}}</td>
											<td>{{$beacon["minor"]}}</td>
											<td>duration</td>
											<td>status</td>
											<td>
												<div class="btn-group btn-group-circle" style="">
													<a style="padding: 5px 20px;" href="{{route('beacon.edit',['id'=>$beacon['id']]) }}" class="btn btn-outline green btn-sm"> <i class="fa fa-pencil"></i></a>
													<a style="padding: 5px 20px;" href="{{route('beacon.delete',['id'=>$beacon['id']])}}" class="btn btn-outline red btn-sm"> <i class="fa fa-trash"></i></a>
													<a style="padding: 5px 20px;" href="{{route('beacon.edit',['id'=>$beacon['id']])}}" class="btn btn-outline green btn-sm"> <i class="fa fa-signal"></i></a>
												</div>
											</td>
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
