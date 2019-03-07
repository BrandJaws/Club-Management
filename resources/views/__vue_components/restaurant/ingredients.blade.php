<template id="ingredientsTemplate">
    <div>
        <label class="left form-control-label">
            <span>Ingredients</span>
            <a href="#" class="btn btn-def" v-on:click.prevent="addMoreIngredients">
                <i class="fa fa-plus"></i>
            </a>
        </label>
        <div class="form-group {{($errors->has('name'))?'has-error':''}}" v-for="(ingredient,ingredientIndex) in ingredientListData">
            <input type="text" class="form-control" name="ingredients[]" v-model="ingredientListData[ingredientIndex]" />
        </div>
    </div>
</template>
<script>
	


	Vue.component('ingredients', {
		template: "#ingredientsTemplate",
		props: [
            'ingredientList'
		],
        data:function(){
            return {
                ingredientListData: this.ingredientList,
            }
        },
        mounted:function(){
            if(this.ingredientListData == null || this.ingredientListData.length == 0){
                this.ingredientListData = [""];
            }
        },
        computed: {

        },
		methods: {
            addMoreIngredients:function(){
                this.ingredientListData.push("");
            }
		}
	});
</script>