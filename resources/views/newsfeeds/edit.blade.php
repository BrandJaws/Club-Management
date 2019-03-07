@extends('__layouts.admin') @section('main') 

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a> <i
                    class="fa fa-angle-right"></i></li>
        <li><a href="{{url('/newsfeeds')}}">NewsFeeds</a> <i class="fa fa-angle-right"></i></li>
        <li><a href="#">Create</a></li>
    </ul>
</div>

<h1 class="page-title">
    Edit News Feed
</h1>

<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->


<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-body">
                   
                    <form action="{{route('newsfeeds.update')}}" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <input type="hidden" name="newsfeed_id" value="{{$data["id"]}}"/>
                        @if(Session::has('serverError'))
                        <div class="alert alert-warning" role="alert"> {{Session::get('serverError')}} </div>
                        @endif
                        @if(Session::has('success'))
                        <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div>
                        @endif

                        <div class="form-group {{($errors->has('title'))?'has-error':''}}">
                            <label class="control-label"> Title</label>
                            <input type="text" name="title" value="{{Input::old('title') ? Input::old('title') : $data["title"] }}" class="form-control" placeholder='First Name'/>
                            @if($errors->has('title')) 
                                <span class="help-block">{{$errors->first('firstName') }}</span> 
                            @endif
                        </div>
                        <div class="form-group {{($errors->has('description'))?'has-error':''}}">
                            <label class="control-label">Description</label>
                            <textarea  id="wysiwigEditor"  type="text" name="description" class="form-control" placeholder='Description'>{{Input::old('description') ? Input::old('description') : $data["description"] }}</textarea>
                            @if($errors->has('description')) 
                                <span class="help-block">{{$errors->first('firstName') }}</span> 
                            @endif
                        </div>
                        <div class="form-group " >
                            <img class="widget-news-left-elem" src="{{env('REST_API').$data['image']}}" alt="">
                        </div>
                        <div class="form-group {{($errors->has('image'))?'has-error':''}}">
                            <label class="control-label"> Image</label>
                            <input type="file" name="image" accept="image/*" class="form-control" placeholder='Image'/>
                            @if($errors->has('image')) 
                                <span class="help-block">{{$errors->first('image') }}</span> 
                            @endif
                        </div>
                        <div class="form-group m-t-30 text-right">
                            <button class="btn red btn-outline btn-circle" >Update NewsFeed</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PROFILE CONTENT --> 
<!-- END PAGE CONTENT-->

@endsection
@section('page-specific-scripts')
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
    <script>
        $(document).ready(function() {
            $('#wysiwigEditor').summernote({height: 200});
        });

    </script>
@endSection