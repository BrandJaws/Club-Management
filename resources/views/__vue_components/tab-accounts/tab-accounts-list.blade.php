<template id="tabAccountsListTemplate">

	<div class="portlet light">
		<div class="portlet-body">
  <table class="table customPaddingTable table-hover">
    <thead>
      <tr>
		<th> Member Id </th>
        <th> Email </th>
		<th> Name </th>
		<th> Current Balance </th>
        <th> Created at </th>
      </tr>
    </thead>
    <tbody v-if="tabAccountsList.length < 1">
      <tr>
        <td colspan="3">No Tab Accounts Found</td>
      </tr>
    </tbody>
    <tbody v-else>
	<tbody v-for="(tabAccount,tabAccountIndex) in tabAccountsList" :key="tabAccount.id">
		<tr v-if="!tabAccount.editModeOn">
			<td>@{{ tabAccount.member_id_local ?  tabAccount.member_id_local : '-' }}</td>
			<td>@{{ tabAccount.email }}</td>
			<td>@{{ tabAccount.name }}</td>
			<td>$ @{{ tabAccount.current_balance }}</td>
			<td>@{{ tabAccount.formatted_time }}</td>
			<td class="active-def">
				<div class="text-center">
					<a class="btn btn-outline btn-circle btn-sm red csEditBtn" title="Edit" @click="
                                                            editTabAccountClicked(tabAccount)"><i class="fa fa-pencil"></i> Edit</a>
					<a class="btn btn-outline btn-circle btn-sm green-jungle csEditBtn" title="Show" :href="baseUrl+'/tab-accounts/'+tabAccount.id+'/details'"><i class="fa fa-eye"></i> Show</a>
				</div>
			</td>
		</tr>
		<tr v-else>
			<td>
				<input class="form-control autocomplete-input input-sm"
					   v-model="tabAccount.editedData.member_id_local"
					   type="text"
				>
			</td>
			<td>
				<input class="form-control autocomplete-input input-sm"
					   v-model="tabAccount.editedData.email"
					   type="email"
				>
			</td>
			<td>
				<input class="form-control autocomplete-input input-sm"
					   v-model="tabAccount.editedData.name"
					   type="text"
				>
			</td>
			<td>$ @{{ tabAccount.current_balance }}</td>
			<td>@{{ tabAccount.formatted_time }}</td>
			<td class="active-def">
				<div class="text-center">
					<a @click="cancelEditClicked(tabAccount)" class="btn btn-outline btn-circle btn-sm red-thunderbird"><i class="fa fa-ban"></i></a>
					<a class="btn btn-outline btn-circle btn-sm green-jungle" title="Save" @click="saveTabAccountClicked(tabAccount)"><i class="fa fa-floppy-o"></i></a>


					{{--<a class="btn btn-outline btn-circle btn-sm red" @click="sendDeleteReservationRequest(reservation.reservations[0])"><i class="fa fa-trash"></i></a>--}}
				</div>
			</td>
		</tr>
	</tbody>

    </tbody>
  </table>
  </div>
</div>
</template>
<script>
	Vue.component('tab-accounts-list', {
		template: "#tabAccountsListTemplate",
		props: [
			"tabAccountsList",
            "baseUrl"
		],
		computed: {

		},
		data:function () {
			return {

			}
		},
		methods: {
			generateEdittabAccountRoute: function(baseRouteToCurrentPage,id){
				return baseRouteToCurrentPage+'/edit/'+id;
			},
			editTabAccountClicked:function(tabAccount){
				tabAccount.editModeOn = true;

			},
			cancelEditClicked:function(tabAccount){
				tabAccount.editModeOn = false;

			},
			saveTabAccountClicked:function(tabAccount){

				_url = this.baseUrl+'/tab-accounts'
				var request = $.ajax({

					url: _url,
					method: "POST",
					headers: {
						'X-CSRF-TOKEN': '{{csrf_token()}}',
					},
					data:{

						_method:"PUT",
						tab_account_id:tabAccount.id,
						member_id_local:tabAccount.editedData.member_id_local,
						name:tabAccount.editedData.name,
						email:tabAccount.editedData.email,
						_token: "{{ csrf_token() }}",

					},
					success:function(msg){

						this.$emit('success-update',msg);
						tabAccount.member_id_local=tabAccount.editedData.member_id_local;
						tabAccount.name=tabAccount.editedData.name;
						tabAccount.email=tabAccount.editedData.email;
						tabAccount.editModeOn = false;
					}.bind(this),
					error: function(jqXHR, textStatus ) {
						this.$emit('error-update',jqXHR.responseJSON);
					}.bind(this)
				});
			},
			deleteMemeber:function(baseRouteToCurrentPage,id,tabAccountIndex){

			},

		}
	});
</script>