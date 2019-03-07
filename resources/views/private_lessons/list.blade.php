@extends('__layouts.admin') @section('main')
<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="index.html">Home</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/private-lessons')}}">Private Lessons</a></li>
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
	Private Lessons
</h1>
<div class="profile-content">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-hover customPaddingTable text-center">
								<thead>
								<tr>
									<th>Parent Name</th>
									<th>Affiliates Name</th>
									<th>Phone</th>
									<th>Coach Name</th>
									<th>Days</th>
									<th>Duration</th>
									<th>Session</th>
								</tr>
								</thead>
								<tbody>
								@if(isset($data))
									@foreach((array)$data['data'] as $privateLesson)
										<tr>
											<td>{{$privateLesson["member"]["firstName"].' '.$privateLesson["member"]["lastName"]}}</td>
											<td>{{$privateLesson["affiliateNames"]}}</td>
											<td>{{$privateLesson['member']['phone']}}</td>
											<td>{{$privateLesson["coach"]["firstName"].' '.$privateLesson["coach"]["lastName"]}}</td>
											<td>{{$privateLesson["dayNames"]}}</td>
											<td>{{$privateLesson['duration']}} Minutes</td>
											<td>{{$privateLesson['session']}}</td>
										</tr>
									@endforeach @else
									<tr>
										<td colspan="6" style="text-align: center">Tournament are not available</td>
									</tr>
								@endif
										{{--<tr>--}}
											{{--<td>Todd</td>--}}
											{{--<td>Hailey</td>--}}
											{{--<td>+92 411543 8</td>--}}
											{{--<td>John</td>--}}
											{{--<td>60 Minutes</td>--}}
											{{--<td>Morning</td>--}}
										{{--</tr>--}}
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
<!-- END PROFILE CONTENT -->
<nav aria-label="Page navigation" class="text-center">
	{!! (isset($paginator))? $paginator->paginate():'' !!}
</nav>

@stop


