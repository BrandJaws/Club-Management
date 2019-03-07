@extends('__layouts.admin') 
@section('main')

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a>
			<i class="fa fa-angle-right"></i></li>
		<li><a href="{{url('/newsfeeds')}}">News Feeds</a></li>
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
	News Feeds
</h1>

<!-- END PAGE HEADER-->


<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="actions">
						<a href="{{route('newsfeeds.create')}}" class="btn red btn-outline btn-circle"> Create News Feed</a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-md-12">
							<div class="clearfix"></div>
							@if(Session::has('serverError'))
								<div class="alert alert-warning" role="alert">
									{{Session::get('serverError')}}</div>
							@endif
							@if(Session::has('success'))
								<div class="alert alert-success" role="alert">
									{{Session::get('success')}}</div>
							@endif

							<table class="table customPaddingTable newsFeed">
								{{--<thead>--}}
									{{--<tr>--}}
										{{--<th>Title</th>--}}
										{{--<th>Description</th>--}}
										<?php /*<th>Image</th> */?>
										{{--<th>Created At</th>--}}
										{{--<th style="width: 200px;">Actions</th>--}}
									{{--</tr>--}}
								{{--</thead>--}}
								<tbody>
								@if(isset($data['data']) && count($data['data']) >0)
									@foreach((array)$data['data'] as $newsfeed)
										<tr>
											<td>
												<div class="widget-news ">
													<img class="widget-news-left-elem" src="{{$newsfeed['image']}}" alt="">
													<div class="widget-news-right-body">
														<h3 class="widget-news-right-body-title">{{$newsfeed['title']}}
															<span class="label label-default"> {{$newsfeed['created_at']}} </span>
														</h3>
														<p style="margin: 10px 0;">{{$newsfeed['description']}}</p>
													</div>
												</div>
												<div class="col-md-12 text-right">

												</div>
											</td>
											<td style="width: 200px;" class="text-right">
												<form action="{{route('newsfeeds.delete',['id'=>$newsfeed['id']])}}" method="post">
													{{csrf_field()}}
													{{method_field('DELETE')}}
													<div class="btn-group btn-group-circle" style="">
														<a style="padding: 5px 16px; width: 85px" href="{{route('newsfeeds.edit',['id'=>$newsfeed['id']])}}" class="btn btn-outline green btn-sm"> <i class="fa fa-pencil"></i>&nbsp;Edit</a>
														<button style="padding: 5px 16px; width: 85px" type="submit" class="btn btn-outline red btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</button>
													</div>
												</form>
											</td>
											{{--<td class="action-btns"><span> <a--}}
															{{--href="{{route('newsfeeds.edit',['id'=>$newsfeed['id']])}}"--}}
															{{--class="btn red btn-sm"> <i class="fa fa-pencil"></i>&nbsp;Edit--}}
                                                            {{--</a></span> <span>--}}
                                                            {{--<form action="{{route('newsfeeds.delete',['id'=>$newsfeed['id']])}}" method="post">--}}
                                                                {{--{{csrf_field()}}--}}
																{{--{{method_field('DELETE')}}--}}
																{{--<button type="submit" class="btn red btn-sm">--}}
                                                                    {{--<i class="fa fa-trash"></i>&nbspDelete--}}
                                                                {{--</button>--}}
                                                            {{--</form>--}}

						{{--</span></td>--}}
										</tr>
									@endforeach @else
									<tr>
										<td colspan="6" style="text-align: center">Nothing to show in news</td>
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
{!! $paginator->paginate() !!}
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
