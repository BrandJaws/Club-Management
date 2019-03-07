@extends('__layouts.admin') @section('main') 

<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">Create News Feed </h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a> <i
                class="fa fa-angle-right"></i></li>
        <li><a href="{{url('/newsfeeds')}}">NewsFeeds</a> <i class="fa fa-angle-right"></i></li>
        <li><a href="#">{{$data["id"]}}</a></li>
    </ul>
</div>

<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->


<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-body">
                   
                        @if(Session::has('serverError'))
                        <div class="alert alert-warning" role="alert"> {{Session::get('serverError')}} </div>
                        @else
                       
                        <h3>{{$data["title"]}}</h3>
                        <img src="{{env('REST_API', "")."/".$data["image"]}}">
                        <p>{{$data["description"]}}</p>
                        @endif

                      
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PROFILE CONTENT --> 
<!-- END PAGE CONTENT--> 

@stop 