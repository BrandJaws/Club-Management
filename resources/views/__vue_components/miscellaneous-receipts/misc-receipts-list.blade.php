<template id="miscReceiptsListTemplate">

	<div class="portlet light">
		<div class="portlet-body">
  <table class="table customPaddingTable table-hover">
    <thead>
      <tr>
        <th> Description </th>
		<th> Amount </th>
        <th> Created at </th>
        <th> Payment Method </th>
      </tr>
    </thead>
    <tbody v-if="miscReceiptsList.length < 1">
      <tr>
        <td>No miscReceipts Found</td>
      </tr>
    </tbody>
    <tbody v-else>
      <tr v-for="(miscReceipt,miscReceiptIndex) in miscReceiptsList">
        <td>@{{ miscReceipt.description }}</td>
        <td>$ @{{ miscReceipt.net_amount }}</td>
        <td>@{{ miscReceipt.time }}</td>
		<td>@{{ miscReceipt.payment_method }}</td>
      </tr>
    </tbody>
  </table>
  </div>
</div>
</template>
<script>
	Vue.component('misc-receipts-list', {
		template: "#miscReceiptsListTemplate",
		props: [
			"miscReceiptsList",
            "baseUrl"
		],
		computed: {
			miscReceiptsListData: function () {
				return this.miscReceiptsList;
			}
		},
		methods: {
			generateEditmiscReceiptRoute: function(baseRouteToCurrentPage,id){
				return baseRouteToCurrentPage+'/edit/'+id;
			},
			deleteMemeber:function(baseRouteToCurrentPage,id,miscReceiptIndex){
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
						  this.miscReceiptsListData.splice(miscReceiptIndex,1);
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