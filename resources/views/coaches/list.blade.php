@extends('__layouts.admin') @section('main')

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a>
			<i class="fa fa-angle-right"></i></li>
		<li><a href="{{route('coaches.create')}}">Coach</a></li>
	</ul>
	<div class="page-toolbar">
		<div id="" class="pull-right tooltips btn btn-fit-height" data-placement="top" data-original-title="Search Members">
			<div class="input-icon right">
				<i class="icon-magnifier"></i>
				<input type="text" class="form-control form-control-solid input-circle" placeholder="search...">
			</div>
		</div>
	</div>
</div>

<h1 class="page-title">
	Manage coaches
</h1>

<!-- END PAGE HEADER-->


<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
	<div class="row">
		<div class="col-md-12">


			<div class="portlet light ">
				<div class="portlet-title">
					<div class="actions">
						<a href="{{route('coaches.create')}}" class="btn red btn-outline btn-circle"> Create Coach</a>
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
									<th style="width: 200px;">Action</th>
								</tr>
								</thead>
								<tbody>
								@if(isset($data)) @foreach((array)$data['data'] as $coach)
									<tr>
										<td>{{$coach['firstName']}} {{$coach['lastName']}}</td>
										<td>{{$coach['email']}}</td>
										<td>{{$coach['phone']}}</td>
										<td class="action-btns">
											{!! Form::open(array('route' => array('coaches.delete', $coach['id']), 'method' => 'delete')) !!}
											<div class="btn-group btn-group-circle" style="">
												<a style="padding: 5px 16px; width: 85px" href="{{route('coaches.edit',['id'=>$coach['id']])}}" class="btn btn-outline green btn-sm"> <i class="fa fa-pencil"></i>&nbsp;Edit</a>
												<button style="padding: 5px 16px; width: 85px" type="submit" class="btn btn-outline red btn-sm"> <i class="fa fa-trash"></i>&nbsp;Delete </button>
											</div>
											{!! Form::close() !!}
										</td>
									</tr>
								@endforeach @else
									<tr>
										<td colspan="6" style="text-align: center">Coaches are not available</td>
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
 <!--  <ul class="pagination">
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul> -->
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
