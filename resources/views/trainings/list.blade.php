@extends('__layouts.admin') @section('main')


<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a>
			<i class="fa fa-angle-right"></i></li>
		<li><a href="{{route('trainings.create')}}">Trainings</a></li>
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
	Manage Trainings 
</h1>

<!-- END PAGE HEADER-->


<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="actions">
						<a href="{{route('trainings.create')}}" class="btn red btn-outline btn-circle"> Create Training</a>
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
									<th>Training Date</th>
									<th>Coach</th>
									<th>Bookings</th>
									<th style="width: 200px;">Action</th>
								</tr>
								</thead>
								<tbody>
								@if(isset($data)) @foreach((array)$data['data'] as $training)
									<tr>
										<td>{{$training['name']}}</td>
										<td>{{date('Y-m-d H:i',strtotime($training['trainingStart']))}}</td>
										<td>{{$training['coach']}}</td>
										<td>{{$training['seatsReserved']}}</td>
										<td class="action-btns">
											
											<div class="btn-group btn-group-circle" style="">
												<a style="padding: 5px 10px; width: 55px" href="{{route('trainings.edit',['id'=>$training['id']])}}" class="btn btn-outline green btn-sm"> <i class="fa fa-pencil"></i>&nbsp;Edit</a>
												<a style="padding: 5px 5px; width: 60px" href="{{route('trainings.participants',['id'=>$training['id']])}}" class="btn btn-outline green-jungle btn-sm"> <i class="fa fa-eye"></i>&nbsp;Show</a>
												<div style="display:inline-block;">
                                                {!! Form::open(array('route' =>array('trainings.delete', $training['id']), 'method' => 'delete')) !!}
												<button style="padding: 5px 5px; width: 60px; border-radius: 0 25px 25px 0!important;" type="submit" class="btn btn-outline red btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</button>
												{!! Form::close() !!}
                                                </div>
												<div style="display:inline-block;float: left;">
                                                {!! Form::open(array('route' =>array('trainings.clone', $training['id']), 'method' => 'post')) !!}
												<button style="padding: 5px 5px; width: 60px;" type="submit" class="btn btn-outline red btn-sm"><i class="fa fa-clone"></i>&nbsp;Clone</button>
												{!! Form::close() !!}
                                                </div>
											</div>
											
										</td>
									</tr>
								@endforeach @else
									<tr>
										<td colspan="6" style="text-align: center">Trainings are not available</td>
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
