@extends('__layouts.admin') @section('main')

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a>
				<i class="fa fa-angle-right"></i></li>
			<li><a href="{{url('/member')}}">Member</a></li>
		</ul>
		<div class="page-toolbar">
			<div id="" class="pull-right tooltips btn btn-fit-height" data-placement="top" data-original-title="Search Members">
				<form action="{{route( 'member.list' )}}" method="GET" class="searchWithForm">
					<div class="input-icon right">
						
						<input type="text" class="form-control form-control-solid input-circle" placeholder="search..." name="search" value="{{Request::get('search')}}">
                        <Button>
							<i class="icon-magnifier"></i>
						</Button>
                    </div>
				</form>

			</div>
		</div>
	</div>

	<h1 class="page-title">
		Member's List
	</h1>

<!-- END PAGE HEADER-->


<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="row">
					<div class="col-sm-9">
						<div class=" {{($errors->has('firstName'))?'has-error':''}}">
							<form action="{{ route( 'member.import' )  }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label"> Import Members</label>
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<input type="file" name="csv_import" class="form-control">
											@if($errors->has('csv_import')) <span class="help-block">{{$errors->first('csv_import') }}</span> @endif
										</div>
									</div>
									<div class="col-sm-8">
										<label class="control-label col-sm-12"> &nbsp; </label>
										<button type="submit" class="btn red btn-outline btn-circle">Send it</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="actions">
							<label class="control-label col-sm-12"> &nbsp; </label>
							<a href="{{route('member.create')}}" class="btn red btn-outline btn-circle pull-right"> CREATE MEMBER</a>
						</div>
					</div>
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
									<th>Gender</th>
									<th>Date of Birth</th>
									<th style="width: 200px">Action</th>
								</tr>
								</thead>
								<tbody>
								@if(isset($data))
									@foreach((array)$data['data'] as $member)
										<tr>
											<td>{{$member['firstName']}} {{$member['lastName']}}</td>
											<td>{{$member['email']}}</td>
											<td>{{$member['phone']}}</td>
											<td>{{$member['gender']}}</td>
											<td>{{$member['dob']}}</td>
											<td class="action-btns">
												{!! Form::open(array('route' => array('member.delete', $member['id']), 'method' => 'delete')) !!}
													<div class="btn-group btn-group-circle" style="">
														<a style="padding: 5px 16px; width: 85px" href="{{route('member.edit',['id'=>$member['id']])}}" class="btn btn-outline green btn-sm"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
														<button style="padding: 5px 16px; width: 85px" type="submit" class="btn btn-outline red btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</button>
													</div>
												{!! Form::close() !!}
											</td>
										</tr>
									@endforeach @else
									<tr>
										<td colspan="6" style="text-align: center">Members are not
											available</td>
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
<nav aria-label="Page navigation" class="text-center">
{!! (isset($paginator))? $paginator->paginate():'' !!}
</nav>

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
