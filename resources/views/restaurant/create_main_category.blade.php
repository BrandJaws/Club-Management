@extends('__layouts.admin')
@section('heading')
    Add Main Category
    @endSection
@section('main') 

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
  <ul class="page-breadcrumb">
    <li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a> <i
                    class="fa fa-angle-right"></i></li>
    <li><a href="{{url('/restaurant')}}">Restaurant Main Category</a> <i class="fa fa-angle-right"></i></li>
    <li><a href="#">Create</a></li>
  </ul>
</div>
<h1 class="page-title"> Add Main Category</h1>

<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT-->
<div class="app-body" id="view"> 
  <!-- ############ PAGE START-->
  <div class="profile-content padding" id="selectionDepHidden">
    <div class="row details-section">
      <div class="col-md-12">
        <div class="portlet light">
          <div class="portlet-body">
            <form action="{{route('restaurant.store_main_category')}}"  method="post" enctype="multipart/form-data">
              @if(Session::has('serverError'))
              <div class="alert alert-warning" role="alert"> {{Session::get('serverError')}}</div>
              @endif @if(Session::has('success'))
              <div class="alert alert-success" role="alert"> {{Session::get('success')}}</div>
              @endif
              <input type="hidden" name="_method" value="POST" />
              {{ csrf_field() }}
              <div class="form-group {{($errors->has('name'))?'has-error':''}}">
                <label class="form-control-label">Main Category Name</label>
                <input type="text" class="form-control" name="name" value="{{old('name')}}" />
                @if($errors->has('name')) <span class="help-block errorProfilePic">{{$errors->first('name') }}</span> @endif </div>
              <div class="form-group  {{($errors->has('icon'))?'has-error':''}}">
                <label class="form-control-label">Select Icon</label>
                <input type="file" class="form-control" name="icon" value=""/>
                @if($errors->has('icon')) <span class="help-block errorProfilePic">{{$errors->first('icon') }}</span> @endif </div>
                <div class="form-group  {{($errors->has('menu_icon'))?'has-error':''}}">
                  <label class="form-control-label">Select Menu Icon</label>
                  <input type="file" class="form-control" name="menu_icon" value=""/>
                  @if($errors->has('menu_icon')) <span class="help-block errorProfilePic">{{$errors->first('menu_icon') }}</span> @endif </div>
              <div class="fom-group text-right m-t-30">
                <button class="btn btn-lg red btn-outline btn-circle"> <i class="fa fa-floppy-o"></i> &nbsp;Add Main Category </button>
                <a href="{{route("restaurant.restaurant")}}" class="btn btn-lg grey btn-outline btn-circle"> <i class="fa fa-ban"></i> &nbsp;Cancel </a> </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-specific-scripts')

@endSection 