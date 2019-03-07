<template id="tabAccountDepositsListTemplate">

	<div class="portlet light">
		<div class="portlet-body">
  <table class="table customPaddingTable table-hover">
    <thead>
      <tr>
		<th> Member Id </th>
        <th> Email </th>
		<th> Deposited Amount </th>
        <th> Created at </th>
      </tr>
    </thead>
    <tbody v-if="tabAccountDepositsList.length < 1">
      <tr>
        <td colspan="3">No Tab Accounts Found</td>
      </tr>
    </tbody>
    <tbody v-else>
      <tr v-for="(tabAccountDeposit,tabAccountDepositIndex) in tabAccountDepositsList">
		 <td>@{{ tabAccountDeposit.member_id_local != null ? tabAccountDeposit.member_id_local : '-' }}</td>
        <td>@{{ tabAccountDeposit.email }}</td>
        <td>$ @{{ tabAccountDeposit.amount }}</td>
        <td>@{{ tabAccountDeposit.formatted_time }}</td>
      </tr>
    </tbody>
  </table>
  </div>
</div>
</template>
<script>
	Vue.component('tab-account-deposits-list', {
		template: "#tabAccountDepositsListTemplate",
		props: [
			"tabAccountDepositsList",
            "baseUrl"
		],
		computed: {
			tabAccountDepositsListData: function () {
				return this.tabAccountDepositsList;
			}
		},
		methods: {
			generateEdittabAccountDepositRoute: function(baseRouteToCurrentPage,id){
				return baseRouteToCurrentPage+'/edit/'+id;
			},
			deleteMemeber:function(baseRouteToCurrentPage,id,tabAccountDepositIndex){
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
						  this.tabAccountDepositsListData.splice(tabAccountDepositIndex,1);
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