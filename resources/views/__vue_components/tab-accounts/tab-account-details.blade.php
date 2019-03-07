<template id="tabAccountDetailsTemplate">

	<div>
		<div class="row">
			<div class="col-sm-12">
				<div class="portlet light">
					<div class="portlet-title">
						<h3 class="caption m-t-0 fw-600">
							Deposits
						</h3>
					</div>

					<div class="portlet-body">
						<table class="table customPaddingTable table-hover">
							<thead>
							<tr>
								<th width="35%"> Item Name </th>
								<th width="25%"> Created at </th>
								<th width="25%"> Payment Method </th>
								<th width="15%"> Amount </th>
							</tr>
							</thead>
							<tbody v-if="tabAccount.tab_account_deposits.length < 1">
							<tr>
								<td colspan="4" class="text-center">No Tab Account Deposit Details Found</td>
							</tr>
							</tbody>
							<tbody v-else>
							<tr v-for="tabAccountDeposit in tabAccount.tab_account_deposits">
								<td>Deposit</td>
								<td>@{{ tabAccountDeposit.time }}</td>
								<td>@{{ tabAccountDeposit.deposit_method }}</td>
								<td>$ @{{ tabAccountDeposit.amount }}</td>
							</tr>
							</tbody>
							<tbody>
							<tr>
								<td colspan="3"><strong>Net Total</strong></td>
								<td colspan="1"><strong>$ @{{ depositsTotal }}</strong></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="portlet light">
					<div class="portlet-title">
						<h3 class="caption m-t-0 fw-600">
							Purchases
						</h3>
					</div>
					<div class="portlet-body">
						<table class="table customPaddingTable table-hover">
							<thead>
							<tr>
								<th width="35%"> Item Name </th>
								<th width="25%"> Created at </th>
								<th width="25%"> Payment Method </th>
								<th width="15%"> Amount </th>
							</tr>
							</thead>
							<tbody  v-if="tabAccount.tab_account_withdrawls.length < 1">
							<tr>
								<td colspan="4" class="text-center">No Tab Account Purchase Details Found</td>
							</tr>
							</tbody>
							<tbody v-else  v-for="tabAccountWithdrawl in tabAccount.tab_account_withdrawls">
							<tr v-if="tabAccountWithdrawl.sale_invoice.invoiceable_type === 'App\\Http\\Models\\MiscellaneousReceipt'">
								<td>Miscellaneous Receipt</td>
								<td >@{{ tabAccountWithdrawl.time }}</td>
								<td >@{{ tabAccountWithdrawl.sale_invoice.payment_method }}</td>
								<td >@{{ tabAccountWithdrawl.sale_invoice.invoiceable.gross_amount }}</td>
							</tr>
							<tr v-else-if="tabAccountWithdrawl.sale_invoice.invoiceable_type === 'App\\Http\\Models\\RestaurantOrder'" v-for="orderDetail in tabAccountWithdrawl.sale_invoice.invoiceable.order_details">
								<td>@{{ orderDetail.restaurant_product.name }}</td>
								<td >@{{ tabAccountWithdrawl.time }}</td>
								<td >@{{ tabAccountWithdrawl.sale_invoice.payment_method }}</td>
								<td>@{{ orderDetail.sale_total }}</td>
							</tr>
							</tbody>
							<tbody>
							<tr>
								<td colspan="3"><strong>Net Total</strong></td>
								<td colspan="1"><strong>$ @{{ withdrawlsTotal }}</strong></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>

</template>
<script>
	Vue.component('tab-account-details', {
		template: "#tabAccountDetailsTemplate",
		props: [
			"tabAccount",
            "baseUrl"
		],
		computed: {
			depositsTotal:function(){
				var depositsTotal = 0;

				for(tabDepositIndex in this.tabAccount.tab_account_deposits){
					if(!isNaN(this.tabAccount.tab_account_deposits[tabDepositIndex].amount)){
						depositsTotal += parseFloat(this.tabAccount.tab_account_deposits[tabDepositIndex].amount);

					}

				}
				return depositsTotal;
			},
			withdrawlsTotal:function(){
				var withdrawlsTotal = 0;
				for(tabWithdrawlIndex in this.tabAccount.tab_account_withdrawls){
					if(!isNaN(this.tabAccount.tab_account_withdrawls[tabWithdrawlIndex].sale_invoice.gross_total)){
						withdrawlsTotal += parseFloat(this.tabAccount.tab_account_withdrawls[tabWithdrawlIndex].sale_invoice.gross_total);
					}
				}
				return withdrawlsTotal;
			},
		},
		data:function () {
			return {

			}
		},
		methods: {


		}
	});
</script>