@extends('__layouts.admin')
@section('heading')
    Add Product
    @endSection
@section('main') 

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
  <ul class="page-breadcrumb">
    <li><i class="fa fa-home"></i> <a href="{{url('/dashboard')}}">Home</a> <i
                    class="fa fa-angle-right"></i></li>
    <li><a href="{{url('/restaurant')}}">Restaurant Product</a> <i class="fa fa-angle-right"></i></li>
    <li><a href="#">Create</a></li>
  </ul>
</div>
<h1 class="page-title"> Add Product</h1>

<!-- END PAGE HEADER--> 
<!-- BEGIN PAGE CONTENT--> 

<!-- BEGIN PROFILE CONTENT -->
<div class="app-body" id="vue-container"> 
  <!-- ############ PAGE START-->
  <div class="profile-content padding" id="selectionDepHidden">
    <div class="row details-section">
      <div class="col-md-12">
        <div class="portlet light ">
          <div class="portlet-body">
            <form action="{{route('restaurant.store_product')}}"  method="post" enctype="multipart/form-data">
              @if(Session::has('serverError'))
              <div class="alert alert-warning" role="alert"> {{Session::get('serverError')}} </div>
              @endif
              @if(Session::has('success'))
              <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div>
              @endif
              <input type="hidden" name="_method" value="POST" />
              {{ csrf_field() }}
              <div class="portlet-body">
                <div class="form-group {{($errors->has('name'))?'has-error':''}}">
                  <label class="form-control-label">Product Name</label>
                  <input type="text" class="form-control" name="name" value="{{old('name')}}" />
                  @if($errors->has('name')) <span class="help-block errorProfilePic">{{$errors->first('name') }}</span> @endif </div>
                <div class="form-group {{($errors->has('restaurant_sub_category_id'))?'has-error':''}}">
                  <label class="form-control-label">Category</label>
                  <select name="restaurant_sub_category_id" id="" class="form-control">
                    <option value="0">Please Select</option>
                    
                  @if($categories && count($categories)>0)
            @foreach($categories as $key=>$category)
                  
                    <option value="{{$category['id']}}" {{(old('restaurant_sub_category_id') && old('restaurant_sub_category_id')==$category['id'])?'selected="selected"':($category['id'] == $selectedCategory ? 'selected="selected"' : '')}}>
                    
                  {{$category['name']}}
                  
                    </option>
                    
                   @endforeach @endif
                
                  </select>
                  @if($errors->has('restaurant_sub_category_id')) <span class="help-block errorProfilePic">{{$errors->first('restaurant_sub_category_id') }}</span> @endif </div>
                <div class="form-group {{($errors->has('description'))?'has-error':''}}">
                  <label class="form-control-label">Product Description</label>
                  <textarea name="description"  id="" class="form-control" rows="8">{{old('description')}}</textarea>
                  @if($errors->has('description')) <span class="help-block errorProfilePic">{{$errors->first('description') }}</span> @endif </div>
                <div class="form-group  {{($errors->has('image'))?'has-error':''}}">
                  <label class="form-control-label">Select Image File</label>
                  <input type="file" class="form-control" name="image" value=""/>
                  @if($errors->has('image')) <span class="help-block errorProfilePic">{{$errors->first('image') }}</span> @endif </div>
                <ingredients :ingredient-list="ingredientList"></ingredients>
                <div class="form-group {{($errors->has('price'))?'has-error':''}}">
                  <label class="form-control-label">Price</label>
                  <input type="number" class="form-control" name="price" value="{{old('price')}}" step=".01" />
                  @if($errors->has('price')) <span class="help-block errorProfilePic">{{$errors->first('price') }}</span> @endif </div>
                <div class="form-group {{($errors->has('in_stock'))?'has-error':''}}">
                  <label class="form-control-label">In Stock</label>
                  <select name="in_stock" id="" class="form-control">
                    <option value="YES" {{(old('in_stock') && old('in_stock')=="YES")?'selected="selected"':'' }}>
                    
                  Yes
                  
                    </option>
                    <option value="NO" {{(old('in_stock') && old('in_stock')=="NO")?'selected="selected"':'' }}>
                    
                  No
                  
                    </option>
                  </select>
                  @if($errors->has('in_stock')) <span class="help-block errorProfilePic">{{$errors->first('in_stock') }}</span> @endif </div>
                <div class="form-group {{($errors->has('visible'))?'has-error':''}}">
                  <label class="form-control-label">Visible</label>
                  <select name="visible" id="" class="form-control">
                    <option value="YES" {{(old('in_stock') && old('visible')=="YES")?'selected="selected"':'' }}>Yes</option>
                    <option value="NO" {{(old('in_stock') && old('visible')=="NO")?'selected="selected"':'' }}>No</option>
                  </select>
                  @if($errors->has('visible')) <span class="help-block errorProfilePic">{{$errors->first('visible') }}</span> @endif </div>
                <div class="fom-group text-right m-t-30">
                  <button class="btn btn-lg red btn-outline btn-circle"> <i class="fa fa-floppy-o"></i> &nbsp;Add Product </button>
                  <a href="{{route("restaurant.restaurant")}}" class="btn btn-lg grey btn-outline btn-circle"> <i class="fa fa-ban"></i> &nbsp;Cancel </a> </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-specific-scripts')
    @include("__vue_components.restaurant.ingredients") 
    <script>
        {{--var _reservationsParent = {!!$reservations!!};--}}

        var vue = new Vue({
            el: "#vue-container",
            data: {

                ingredientList:[],
            },
            computed:{

            },
            methods:{


            }

        });



    </script> 
    @endSection 