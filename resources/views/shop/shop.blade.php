@extends('admin.__layouts.admin-layout')
@section('heading')
	Shop
	@endSection
@section('main')
	<div ui-view class="app-body" id="view">

		<!-- ############ PAGE START-->

		<div class="padding" id="shopPage">
			<shop :categories="categories" :base-url="baseUrl"></shop>
			<!-- Segments Page End -->
		</div>


	</div>

@endsection

@section('page-specific-scripts')
{{--@include("admin.__vue_components.shop.shop-scroller");--}}
{{--@include("admin.__vue_components.shop.shop-menu");--}}
@include("admin.__vue_components.shop.shop");
<script>


		var _categories = {!!$categories!!};

        var vue = new Vue({
           el: "#shopPage",
           data: {
               categories:_categories,
			   baseUrl :"{{url('')}}",
           }

        });

    </script>

@endSection
