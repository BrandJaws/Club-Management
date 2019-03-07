@extends('__layouts.admin') @section('main')
<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="index.html">Home</a> <i
					class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/tournament')}}">Tournament</a></li>
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
	Tournament
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
						<a href="{{route('tournament.create')}}" class="btn red btn-outline btn-circle"> Create Tournament</a>
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
									<th>Tournament Name</th>
									<th>Registration Starts</th>
									<th>Registration Ends</th>
									<th>Tournament Start Date</th>
									<th>Tournament Duration(Weeks)</th>
									<th style="width: 200px">Action</th>
								</tr>
								</thead>
								<tbody>
								@if(isset($data))
									@foreach((array)$data['data'] as $tournament)
										<tr>
											<td>{{$tournament['name']}} <!--{{$tournament['name']}}--></td>
											<td>{{$tournament['registrationStartAt']}}</td>
											<td>{{$tournament['registrationCloseAt']}}</td>
											<td>{{$tournament['tournamentStartDate']}}</td>
											<td>{{$tournament['numberOfWeeks']}}</td>
											<td class="action-btns">
												{!! Form::open(array('route' => array('tournament.delete', $tournament['id']), 'method' => 'delete')) !!}
													<div class="btn-group btn-group-circle" style="">
														<a style="padding: 5px 16px; width: 85px" href="{{route('tournament.edit',['id'=>$tournament['id']])}}" class="btn btn-outline green btn-sm"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
														<a href="{{route('tournament.show',['id'=>$tournament['id']])}}" style="padding: 5px 16px; width: 85px" type="submit" class="btn btn-outline green-jungle btn-sm"><i class="fa fa-eye"></i>&nbsp;View</a>
														<button style="padding: 5px 16px; width: 85px" type="submit" class="btn btn-outline red btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</button>
													</div>
												{!! Form::close() !!}
											</td>
										</tr>
									@endforeach @else
									<tr>
										<td colspan="6" style="text-align: center">Tournament are not available</td>
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
<!-- END PROFILE CONTENT -->
<nav aria-label="Page navigation" class="text-center">
	{!! (isset($paginator))? $paginator->paginate():'' !!}
</nav>

@stop


