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
    Create News
</h1>

<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->


<!-- BEGIN PROFILE CONTENT -->
<div class="profile-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-body">
                   
                    <form action="{{route('newsfeeds.store')}}" enctype="multipart/form-data" method="post">
                        @if(Session::has('serverError'))
                        <div class="alert alert-warning" role="alert"> {{Session::get('serverError')}} </div>
                        @endif
                        @if(Session::has('success'))
                        <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div>
                        @endif

                        <div class="form-group {{($errors->has('title'))?'has-error':''}}">
                            <label class="control-label"> Title</label>
                            <input type="text" name="title" value="{{Input::old('title')}}" class="form-control" placeholder='News Title'/>
                            @if($errors->has('title')) 
                                <span class="help-block">{{$errors->first('firstName') }}</span> 
                            @endif
                        </div>
                        <div class="form-group {{($errors->has('description'))?'has-error':''}}">
                            <label class="control-label">Description</label>
                            <textarea  id="wysiwigEditor" type="text" name="description" class="form-control" placeholder='Description' rows="8">{{Input::old('description')}}</textarea>
                            @if($errors->has('description')) 
                                <span class="help-block">{{$errors->first('firstName') }}</span> 
                            @endif
                        </div>
                        <div class="form-group {{($errors->has('image'))?'has-error':''}}">
                            <label class="control-label"> Image</label>
                            <input type="file" name="image" accept="image/*" class="form-control" placeholder='Image'/>
                            @if($errors->has('image')) 
                                <span class="help-block">{{$errors->first('image') }}</span> 
                            @endif
                        </div>
                        <div class="form-group m-t-30 text-right">
                            <button class="btn red btn-outline btn-circle" >Create News</button>
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