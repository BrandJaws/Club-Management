@extends('__layouts.admin')
@section('heading')
	Restaurant
	@endSection
@section('main')
	<div ui-view class="app-body" id="view">

		<!-- ############ PAGE START-->

		<div class="padding" id="shopPage">
			<restaurant :services-url="servicesUrl" :main-categories="mainCategories" :categories="categories" :base-url="baseUrl"></restaurant>
			<!-- Segments Page End -->
		</div>


	</div>

@endsection
@section('page-specific-scripts')
<link rel="stylesheet" href="{{asset('assets/global/plugins/owl-carousel/owl.carousel.css')}}" type="text/css">
<script src="{{asset("assets/global/plugins/owl-carousel/owl.carousel.js")}}" type="text/javascript"></script>
{{--@include("admin.__vue_components.shop.shop-scroller");--}}
{{--@include("admin.__vue_components.shop.shop-menu");--}}
@include("__vue_components.restaurant.restaurant");
<script>
	var _mainCategories = {!!$mainCategories!!};
	var _categories = {!!$categories!!};
	var vue = new Vue({
	   el: "#shopPage",
	   data: {
		   mainCategories: _mainCategories,
		   categories:_categories,
		   baseUrl :"{{url('')}}",
		   servicesUrl:'{{env('REST_API')}}',
	   }
	});
</script>
@endSection
