<template id="ordersArchiveTemplate">

	<div class="portlet light">
		<div class="portlet-body">
  <table class="table customPaddingTable table-hover">
    <thead>
      <tr>
        <th> Main Category </th>
		<th> Sub Category </th>
        <th> Product </th>
		<th> Sale Total </th>
        <th> Created at </th>
        <th> Payment Method </th>
      </tr>
    </thead>
    <tbody v-if="ordersList.length < 1">
      <tr>
        <td>No Orders Found</td>
      </tr>
    </tbody>
    <tbody v-else>
      <tr v-for="(order,orderIndex) in ordersList">
        <td>@{{ order.mainCategoryName ? order.mainCategoryName : '-' }}</td>
		<td>@{{ order.subCategoryName ? order.subCategoryName : '-' }}</td>
		  <td>@{{ order.productName }}</td>
        <td>$ @{{ order.saleTotal }}</td>
        <td>@{{ order.createdAt }}</td>
		<td>@{{ order.paymentMethod }}</td>
      </tr>
    </tbody>
  </table>
  </div>
</div>
</template>
<script>
	Vue.component('orders-archive', {
		template: "#ordersArchiveTemplate",
		props: [
			"ordersList",
            "baseUrl"
		],
		computed: {
			ordersListData: function () {
				return this.ordersList;
			}
		},
		methods: {
			generateEditorderRoute: function(baseRouteToCurrentPage,id){
				return baseRouteToCurrentPage+'/edit/'+id;
			},
			deleteMemeber:function(baseRouteToCurrentPage,id,orderIndex){
				_url = baseRouteToCurrentPage+'/'+id
				var request = $.ajax({
					
					url: _url,
					method: "POST",
					headers: {
						'X-CSRF-TOKEN': '{{csrf_token()}}',
					},
					data:{
						
						_method:"DELETE",
						_token: "{{ csrf_token() }}",
						
					},
					success:function(msg){
						
						if(msg=="success"){
						  this.ordersListData.splice(orderIndex,1);
						}else{ 
						}
						}.bind(this),
					error: function(jqXHR, textStatus ) {
						this.ajaxRequestInProcess = false;
						$("body").append(jqXHR.responseText);
						//Error code to follow
					}.bind(this)
				}); 
			}
		}
	});
</script>