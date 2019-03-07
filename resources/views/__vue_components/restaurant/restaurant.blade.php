@include("__vue_components.popups.confirmation-popup")
@include("__vue_components.MessageBar.message-bar")
<template id="restaurantTemplate" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="">

    <confirmation-popup v-on:close-popup="closeConfirmationPopup"  v-if="showConfirmationPopup" :popup-message="dataHeldForConfirmation.confirmationMessage" :error-message="confirmationPopupErrorMessage" :confirm-callback="dataHeldForConfirmation.confirmCallback"></confirmation-popup>
    <message-bar v-if="messageBar.message" :type="messageBar.type" :message="messageBar.message"></message-bar>
    <div class="restaurant-main">
        <div class="row">
            <div class="shop-inner">
                <div class="">
                    <div class="col-md-11">
						<div id="shop-carousel" class="owl-carousel owl-theme">

                            <div :class="['item', selectedMainCategoryId == mainCategory.id ? 'active-item' : '']" v-for="mainCategory in mainCategoriesData" :key="mainCategory.id" v-on:click="mainCategorySelected(mainCategory)">

                                <div class="parent-category-box resturant-box">

                                    <div class="box p-a">
                                        <div class="pull-left m-r">
                                            <span class="w-53 rounded">

                                                    <img class="media-object" :src="servicesUrl+'/'+mainCategory.icon" alt="icon">

                                            </span>
                                        </div>
                                        <div class="clear">
                                            <h4 class="m-a-0 text-lg _300 heading">
                                                @{{mainCategory.name}}
                                            </h4>
                                            <small class="text-muted">
                                                <span>
                                               		<a href="#" class="del-icon pull-right" v-on:click="deleteMainCategory(mainCategory,false)">
                                                	    <i class="fa fa-trash"></i>
                                                    </a>
                                                </span>
                                                <span>
                                                	<a v-on:click.stop :href="baseUrl+'/restaurant/main-categories/'+mainCategory.id+'/edit'" class="del-icon pull-right">
                                                	    <i class="fa fa-pencil"></i>
                                                     </a>
                                                </span>
                                            </small>
                                        </div>
                                        <div class="media-body text-left">

                                                <!--<h4 class="media-heading">@{{mainCategory.name}}</h4>-->
                                                <!--<p class="media-sub">-</p>-->

                                        </div>



                                    </div>


                                </div>

                            </div>
                            <div id="inCarouselAddMainCategoryItem" class="col-md-4 item" v-show="!fixAddMainCategoryButton">
                                <div class="add-category-btn text-center">
                                    <a href="{{route('restaurant.create_main_category')}}"><i class="fa fa-plus"></i><br>More</a>
                                </div>
                            </div>

							
                        </div>
                        	
                        <!-- owl carousel -->

                    </div>
                    <div class="col-md-1" v-if="fixAddMainCategoryButton">
                        <div class="add-category-btn text-center">
                            <a href="{{route('restaurant.create_main_category')}}"><i class="fa fa-plus"></i><br>More</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- shop-inner ends here -->
        </div>
        <div class="row" v-if="this.mainCategoriesData.length < 1">
            <div class="col-md-12">
                <div class="box m-t p-a-sm">
                    No Categories Added Yet. Please Add One To Continue
                </div>
            </div>
        </div>
        <div class="row" v-else>
            <div class="main-padd">
                <div class="col-md-3">

                    <div class="menu-sidebar">

                        <div class="sidebar-heading">

                            <h3>Sub Categories</h3>

                            <span class="addCategoryButton">
                                <button v-on:click="showAddCategoryField()" title="Add Category"><i class="fa fa-plus"></i></button>
                                <button v-on:click.prevent="saveSortRankOrderForSubCategories()" title="Save Order">
                                    <i class="fa fa-save"></i>
                                </button>
                            </span>
                        </div>
                        <div v-if="addCategoryFieldVisible" class="addCategoryField">
                            <form action="" v-on:submit.prevent="addNewCategory">
                                <div class="form-group">
                                    <label for="">Category Name</label>
                                    <div class="row">
                                        <div class=" col-sm-9">
                                            <input type="text" class="form-control" v-model="newCategoryName"/>
                                        </div>
                                        <div class="col-sm-3">
                                            <button v-on:click.prevent="addNewCategory" title="Add Category" class="form-control"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="menu-list">

                            <ul>
                                <li  v-for="(category,categoryIndex) in mainCategoriesData[selectedMainCategoryIndex].sub_categories" :key="category.id" :class="[category.id == mainCategoriesData[selectedMainCategoryIndex].selectedSubCategoryId ? 'active-menu' : '', category.overClass ? 'over' : '']" v-on:click="categorySelected(category)" @dragover="dragOverSubCategory($event,category)" @dragenter="dragEnterSubCategory($event,category)" @dragleave="dragLeaveSubCategory($event,category)" @drop.prevent="dragDroppedSubCategory($event,category, categoryIndex)" draggable="true" @dragstart="dragSubCategoryStarted($event,category, categoryIndex) ">

                                    <div class="">
                                    <div class="col-sm-8">
                                        <a href="#." class="pull-left" v-if="!category.editModeOn">
                                        <span>
                                            <i class="fa fa-long-arrow-right"></i><span class="nameHeading">@{{category.name}}</span>
                                        </span>
                                        </a>
                                        <input v-if="category.editModeOn" type="text" class="form-control" v-model="category.editableName" />
                                    </div>

                                    <div class="col-sm-4">
                                    <a href="#." class="pull-right" v-on:click="deleteCategory(category,false)" v-if="!category.editModeOn">
                                        <span>
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </a>
                                    <a href="#." class="pull-right" v-on:click="switchEditModeForCategory(category)" v-if="!category.editModeOn">
                                        <span>
                                            <i class="fa fa-pencil"></i>
                                        </span>
                                    </a>
                                    <a href="#." class="pull-right" v-on:click="switchEditModeForCategory(category)" v-if="category.editModeOn">
                                        <span>
                                            <i class="fa fa-ban"></i>
                                        </span>
                                    </a>
                                    <a href="#." class="pull-right" v-on:click="updateCategory(category)" v-if="category.editModeOn">
                                        <span>
                                            <i class="fa fa-floppy-o"></i>
                                        </span>
                                    </a>
                                        </div>
                                    </div>
                                </li>
                                <li v-if="mainCategoriesData[selectedMainCategoryIndex].sub_categories.length < 1">
                                    <div class="col-sm-12">No Categories Found</div>
                                </li>


                            </ul>

                            <div class="clearfix"></div>

                        </div>

                    </div>

                </div>
                <div class="col-md-9">
                    <div class="segments-inner">
                        <div class="box">
                            <div class="inner-header">
                                <div class="">
                                    <div class="col-md-5">
                                        <div class="inner-page-heading text-left">
                                            <h3>@{{ selectedMainCategoryIndex != null && mainCategoriesData[selectedMainCategoryIndex].selectedSubCategoryIndex != -1 ?  mainCategoriesData[selectedMainCategoryIndex].sub_categories[mainCategoriesData[selectedMainCategoryIndex].selectedSubCategoryIndex].name : 'No Category Selected' }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="search-form text-right">
                                            <form action="#." method="post"  v-on:submit.prevent>
                                                <div class="search-field">
															<span class="search-box sm-box">
                                                                <input type="text" name="search" class="search-bar" v-model="searchQuery" v-on:input="performSearchQuery()">
																<button type="submit" class="search-btn">
                                                                    <i class="fa fa-search"></i>
                                                                </button>
															</span> <span class="">
																<a :href="addNewProductFormUrl">
                                                                    <button type="button" name="add-segment" class="btn-def">
                                                                        <i class="fa fa-plus-circle"></i>&nbsp;Add Item
                                                                    </button>

                                                                </a>
															</span>
                                                            <span class="">
                                                                <button type="button" class="btn-def" v-on:click.prevent="saveSortRankOrderForProducts">
                                                                        <i class="fa fa-save"></i>&nbsp;Save Order
                                                                </button>
															</span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- inner header -->
                            <div class="productsTableContainer" v-on:scroll="productsScrolled">
                                <table class="table table-hover b-t restaurantTable">
                                    <tbody v-if=" selectedMainCategoryIndex != null && mainCategoriesData[selectedMainCategoryIndex].selectedSubCategoryIndex != -1">
                                    <template v-if="mainCategoriesData[selectedMainCategoryIndex].sub_categories[mainCategoriesData[selectedMainCategoryIndex].selectedSubCategoryIndex].products.data.length > 0 ">
                                        <tr  v-for="(product,productIndex) in mainCategoriesData[selectedMainCategoryIndex].sub_categories[mainCategoriesData[selectedMainCategoryIndex].selectedSubCategoryIndex].products.data" :key="product.id" :class="[product.overClass ? 'over' : '']" @dragenter="dragEnterProduct($event,product)" @dragover="dragOverProduct($event,product)" @dragleave="dragLeaveProduct($event,product)" @drop.prevent="dragDroppedProduct($event,product, productIndex)" draggable="true" @dragstart="dragProductStarted($event,product, productIndex) ">
                                            <td width="100px">
                                                <div class="section-3 sec-style text-center">
                                                    <img :src="servicesUrl+'/'+product.image" class="shopProdImage"></imgsrc>
                                                </div>
                                            </td>
                                            <td width="250px">
                                                <div class="section-1 sec-style">
                                                    <h3>@{{ product.name }}</h3>
                                                    <p>Product Name</p>
                                                </div>
                                            </td>
                                            <td width="150px">
                                                <div class="section-3 sec-style">
                                                    <h3>@{{ '$ '+product.price }}</h3>
                                                    <p>Price</p>
                                                </div>
                                            </td>
                                            <td width="90px">
                                                <div class="section-3 sec-style">
                                                    <h3>@{{ product.in_stock }}</h3>
                                                    <p>In Stock</p>
                                                </div>
                                            </td>
                                            <td width="120px">
                                                <div class="section-3 sec-style">
                                                    <h3>@{{ product.visible }}</h3>
                                                    <p>Is Visible</p>
                                                </div>
                                            </td>
                                            <td width="100px">
                                                <div class="section-3 sec-style">
                                                    <p>
                                                        <span><a :href="baseUrl+'/restaurant/products/'+product.id+'/edit'" class="blue-cb">edit</a></span>&nbsp;&nbsp;&nbsp;
                                                        <span><a href="#." class="del-icon" v-on:click="deleteProduct(product,false)"><i
                                                                        class="fa fa-trash"></i></a></span>
                                                    </p>
                                                </div>
                                            </td>

                                        </tr>
                                    </template>
                                    <template v-else-if="mainCategoriesData[selectedMainCategoryIndex].sub_categories[mainCategoriesData[selectedMainCategoryIndex].selectedSubCategoryIndex].firstLoadDone">
                                        <tr >
                                            <td>
                                                No Products Found
                                            </td>

                                        </tr>
                                    </template>


                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td>
                                                No Category Selected
                                            </td>

                                        </tr>
                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- main padd ends here -->
        </div>
    </div>
    </div>
</template>

<script>

    Vue.component('restaurant',{
       template: "#restaurantTemplate",
       mounted:function(){
           var owlCarousel = $(".owl-carousel");
           owlCarousel.owlCarousel({
                onDragged: this.setValueForFixAddMainCategoryButtonFlag,
				autoplay: true,
                autoplayTimeout: 5000,
                items: 3,
                nav: true,
				margin: 20,
                smartSpeed: 500,
            });

           this.setValueForFixAddMainCategoryButtonFlag();
           owlCarousel.on('translated.owl.carousel', function(event) {
               this.setValueForFixAddMainCategoryButtonFlag(event);
           }.bind(this));


        },
        props:[
                'mainCategories',
                'categories',
                'baseUrl',
                'servicesUrl',
        ],
        data:function(){
            return {
                mainCategoriesData:this.processMainCategoriesForBinding(this.mainCategories),
                selectedMainCategoryId: this.mainCategories.length >0 ? this.mainCategories[0].id : null,
//                selectedCategoryId: this.categories.length >0 ? this.categories[0].id : null,
                deleteMainCategoryUrl:this.baseUrl+"/restaurant/main-categories/",
                productListPageUrl:this.baseUrl+"/restaurant/products/by-category",
                addNewSubCategoryUrl:this.baseUrl+"/restaurant/sub-categories",
                updateSubCategoryUrl:this.baseUrl+"/restaurant/sub-categories",
                deleteSubCategoryUrl:this.baseUrl+"/restaurant/sub-categories/",
                deleteProductUrl:this.baseUrl+"/restaurant/products/",
                updateProductSortRanksUrl:this.baseUrl+"/restaurant/products/update-sort-ranks",
                updateSubCategorySortRanksUrl:this.baseUrl+"/restaurant/sub-categories/update-sort-ranks",
                addCategoryFieldVisible: false,
                searchQuery:"",
                newCategoryName:"",
                showConfirmationPopup: false,
                confirmationPopupErrorMessage: "",
                dataHeldForConfirmation: {
                    confirmationMessage: null,
                    confirmCallback:null

                },
                fixAddMainCategoryButton:false,
                messageBar:{
                    type:"",
                    message:""
                },

            }
        },
        computed:{
            selectedMainCategoryIndex:function(){

                for(mainCategoryIndex in this.mainCategoriesData){
                    if(this.mainCategoriesData[mainCategoryIndex].id == this.selectedMainCategoryId){

                        return mainCategoryIndex;
                    }
                }
            },
//            selectedCategoryIndex:function(){
//
//                for(mainCategoryIndex in this.mainCategoriesData){
//                    for(subCategoryIndex in this.mainCategoriesData[mainCategoryIndex].sub_categories){
//                        if(this.mainCategoriesData[mainCategoryIndex].sub_categories[subCategoryIndex].id == this.selectedCategoryId){
//
//                            return subCategoryIndex;
//                        }
//                    }
//
//                }
//                return null;
//            },
            addNewProductFormUrl:function(){
                return this.baseUrl+"/restaurant/products/new?category="+(this.mainCategoriesData[mainCategoryIndex].selectedSubCategoryId)
            },
        },
        methods:{
            setValueForFixAddMainCategoryButtonFlag:function(event){
                if($('#inCarouselAddMainCategoryItem').parent().hasClass('active')){
                    this.fixAddMainCategoryButton = false;
                }else{
                    this.fixAddMainCategoryButton = true;
                }

            },
            showAddCategoryField:function(){
                if(this.addCategoryFieldVisible) {
                    this.addCategoryFieldVisible = false;
                } else {
                    this.addCategoryFieldVisible = true;
                }
            },
            mainCategorySelected:function(mainCategory){

                if(this.selectedMainCategoryId != mainCategory.id){

                    this.selectedMainCategoryId = mainCategory.id;
                    if(this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories.length > 0 && this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories[0].firstLoadDone === false){

                        this.loadNextPage(false,this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories[0]);

                    }

                    this.searchQuery = this.mainCategoriesData[this.selectedMainCategoryIndex].selectedSubCategoryIndex != -1 ? this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories[this.mainCategoriesData[this.selectedMainCategoryIndex].selectedSubCategoryIndex].searchQuery : "";

                }
            },
            categorySelected:function(category){

                //if(this.mainCategoriesData[mainCategoryIndex].selectedSubCategoryId != category.id){

                    this.selectSubCategoryAndIndexForAMainCategoryBySubCategoryId(category.id);
                    if(category.firstLoadDone === false){
                        //send ajax call
                        this.loadNextPage(false,category);

                    }

                    this.searchQuery = this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories[this.mainCategoriesData[this.selectedMainCategoryIndex].selectedSubCategoryIndex].searchQuery;



                //}
            },
            switchEditModeForCategory:function(category){

                if(category.editModeOn == true){
                    category.editModeOn = false;
                    category.editableName = category.name;
                }else{
                    category.editModeOn = true;
                }


            },
            productsScrolled:function(e){
                var selectedCategory = this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories[this.mainCategoriesData[this.selectedMainCategoryIndex].selectedSubCategoryIndex];
                var element = e.target;

                if (element.scrollHeight - element.scrollTop === element.clientHeight)
                {
                    // element is at the end of its scroll, load more content

                    this.loadNextPage(false,selectedCategory);
                }

            },
            performSearchQuery:function(){
                var selectedCategory = this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories[this.mainCategoriesData[this.selectedMainCategoryIndex].selectedSubCategoryIndex];
                selectedCategory.searchQuery = this.searchQuery;
                this.loadNextPage(true,selectedCategory);
            },
//            getCategoryIndexFromCategoryId(categoryId){
//                if(this.categoriesData[categoryIndex].id != null){
//                    for(categoryIndex in this.categoriesData){
//                        if(this.categoriesData[categoryIndex].id == categoryId){
//                            return categoryIndex;
//                        }
//                    }
//                }
//
//                return null;
//            },

            loadNextPage:function(isSearchQuery, category){


                queryParams = {restaurant_sub_category_id:category.id};

                if(isSearchQuery){
                    if(category.ajaxRequestInProcess){
                        category.searchRequestHeld=true;
                        return;
                    }
                    if(category.searchQuery !== category.lastSearchTerm){
                        category.nextAvailablePage = 1;
                    }
                    category.lastSearchTerm = category.searchQuery;

                    queryParams.search = category.searchQuery;
                    queryParams.current_page = category.nextAvailablePage;
                    //_url = baseUrl+'?search='+category.searchQuery+'&current_page='+(category.nextAvailablePage);


                }else if(category.searchQuery != ""){
                    queryParams.search = category.searchQuery;
                    queryParams.current_page = category.nextAvailablePage;
                    //_url = baseUrl+'?search='+category.searchQuery+'&current_page='+(category.nextAvailablePage);
                }else{
                    queryParams.current_page = category.nextAvailablePage;
               //     _url = baseUrl+'?current_page='+(category.nextAvailablePage);
                }


                if(category.nextAvailablePage === null){
                    return;
                }

                if(!category.ajaxRequestInProcess){

                    category.ajaxRequestInProcess = true;
                    var request = $.ajax({

                        url: this.productListPageUrl,
                        data:queryParams,
                        method: "GET",
                        success:function(msg){

                            category.ajaxRequestInProcess = false;
                            if(category.searchRequestHeld){

                                category.searchRequestHeld=false;
                                this.loadNextPage(true,category);

                            }

                            pageDataReceived = msg;

                            productsList = this.processProductsForBinding(pageDataReceived.data);

                            //Success code to follow
                            if(pageDataReceived.next_page_url !== null){
                                category.nextAvailablePage = pageDataReceived.current_page+1;
                            }else{
                                category.nextAvailablePage = null;
                            }

                            if(isSearchQuery){

                                categoryIndices = this.getMainAndSubCategoryIndexFromSubCategoryId(category.id);
                                this.mainCategoriesData[categoryIndices.mainCategoryIndex].sub_categories[categoryIndices.subCategoryIndex].products.data = productsList;
//                                this.updateBackupOfProductListForSelectedSubAndMainCategories(null);
                            }else{
                                categoryIndices = this.getMainAndSubCategoryIndexFromSubCategoryId(category.id);
                                appendArray(this.mainCategoriesData[categoryIndices.mainCategoryIndex].sub_categories[categoryIndices.subCategoryIndex].products.data,productsList);
//                                this.updateBackupOfProductListForSelectedSubAndMainCategories(productsList);
                            }

                            //Change flag property set to see if the data was ever loaded from the server to true
                            if(category.firstLoadDone != true){

                                category.firstLoadDone = true;
                            }

                        }.bind(this),

                        error: function(jqXHR, textStatus ) {
                            this.ajaxRequestInProcess = false;

                            //Error code to follow


                        }.bind(this)
                    });
                }
            },
            processMainCategoriesForBinding:function(categories){
                categories = JSON.parse(JSON.stringify(categories));

                for(mainCategoryIndex in categories){
                    categories[mainCategoryIndex].selectedSubCategoryId = categories[mainCategoryIndex].sub_categories.length >0 ? categories[mainCategoryIndex].sub_categories[0].id : null;
                    categories[mainCategoryIndex].selectedSubCategoryIndex = categories[mainCategoryIndex].sub_categories.length >0 ? 0 : -1;
//                    categories[mainCategoryIndex].subCategoriesBackup = JSON.parse(JSON.stringify(categories[mainCategoryIndex].sub_categories));

                    for(subCategoryIndex in categories[mainCategoryIndex].sub_categories){
                        categories[mainCategoryIndex].sub_categories[subCategoryIndex].editModeOn =  false;
                        categories[mainCategoryIndex].sub_categories[subCategoryIndex].editableName =  categories[mainCategoryIndex].sub_categories[subCategoryIndex].name;
                        categories[mainCategoryIndex].sub_categories[subCategoryIndex].searchQuery = "";
                        categories[mainCategoryIndex].sub_categories[subCategoryIndex].lastSearchTerm = "";
                        categories[mainCategoryIndex].sub_categories[subCategoryIndex].ajaxRequestInProcess = false;
                        categories[mainCategoryIndex].sub_categories[subCategoryIndex].searchRequestHeld = false;
                        categories[mainCategoryIndex].sub_categories[subCategoryIndex].overClass = false;

                        if(categories[mainCategoryIndex].sub_categories[subCategoryIndex].products == undefined){
                            //Flag property set to see if the data was ever loaded from the server to false. When the category is next selected
                            //this property will be checked against to load data from the server if it wasn't before
                            categories[mainCategoryIndex].sub_categories[subCategoryIndex].firstLoadDone = false;

                            categories[mainCategoryIndex].sub_categories[subCategoryIndex].nextAvailablePage = 1;
                            categories[mainCategoryIndex].sub_categories[subCategoryIndex].products = {
                                current_page:0,
                                data:[],
                                next_page_url:null,

                            };



                        }else{
                            categories[mainCategoryIndex].sub_categories[subCategoryIndex].products.data = this.processProductsForBinding(categories[mainCategoryIndex].sub_categories[subCategoryIndex].products.data);
                            categories[mainCategoryIndex].sub_categories[subCategoryIndex].firstLoadDone = true;
                            categories[mainCategoryIndex].sub_categories[subCategoryIndex].nextAvailablePage = categories[mainCategoryIndex].sub_categories[subCategoryIndex].products.next_page_url !== null ? 2 : null;

                        }
//                        categories[mainCategoryIndex].sub_categories[subCategoryIndex].products.dataBackup = JSON.parse(JSON.stringify(categories[mainCategoryIndex].sub_categories[subCategoryIndex].products.data));

                    }


                }

                return categories;
            },
            processCategoriesForBinding:function(categories){


                categories = JSON.parse(JSON.stringify(categories));

                for(categoryIndex in categories){
                    categories[categoryIndex].editModeOn =  false;
                    categories[categoryIndex].editableName =  categories[categoryIndex].name;
                    categories[categoryIndex].searchQuery = "";
                    categories[categoryIndex].lastSearchTerm = "";
                    categories[categoryIndex].ajaxRequestInProcess = false;
                    categories[categoryIndex].searchRequestHeld = false;
                    categories[categoryIndex] .overClass = false;

                    if(categories[categoryIndex].products == undefined){
                        //Flag property set to see if the data was ever loaded from the server to false. When the category is next selected
                        //this property will be checked against to load data from the server if it wasn't before
                        categories[categoryIndex].firstLoadDone = false;

                        categories[categoryIndex].nextAvailablePage = 1;
                        categories[categoryIndex].products = {
                            current_page:0,
                            data:[],
                            next_page_url:null,

                        };



                    }else{
                        categories[categoryIndex].firstLoadDone = true;
                        categories[categoryIndex].nextAvailablePage = categories[categoryIndex].products.next_page_url !== null ? 2 : null;
                    }





                }

                return categories;
            },
            processProductsForBinding:function(products){
                //console.log(products);
                products = JSON.parse(JSON.stringify(products));
                for(productIndex in products){
                    products[productIndex].overClass = false;
                }
                return products;
            },
            deleteMainCategory: function (category, confirmed) {

                categoryId = category.id;


                this.dataHeldForConfirmation.confirmCallback = function(){
                    var request = $.ajax({

                        url: this.deleteMainCategoryUrl + categoryId,
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        data: {
                            _method: "DELETE",


                        },
                        success: function (msg) {
                            console.log(msg);
                           for(mainCategoryIndex in this.mainCategoriesData){

                               if(this.mainCategoriesData[mainCategoryIndex].id == category.id){


                                   this.mainCategoriesData.splice(mainCategoryIndex,1);
                                   $(".owl-item").eq(mainCategoryIndex).remove();

                                   break;
                               }
                           }

                            if(this.mainCategoriesData.length > 0){
                                this.selectedMainCategoryId = this.mainCategoriesData[0].id;

                            }


                            this.closeConfirmationPopup();
                        }.bind(this),

                        error: function (jqXHR, textStatus) {
                            this.ajaxRequestInProcess = false;
                            //Error code to follow
                            if (jqXHR.hasOwnProperty("responseText")) {
                                this.confirmationPopupErrorMessage = JSON.parse(jqXHR.responseText);
                            }

                        }.bind(this)
                    });
                }.bind(this);

                if(!confirmed){
                    this.dataHeldForConfirmation.confirmationMessage = "Are you sure you want to delete this category?";
                    this.displayConfirmationPopup();

                }else{
                    this.dataHeldForConfirmation.confirmCallback();
                    this.dataHeldForConfirmation.confirmCallback = null;
                }





            },
            addNewCategory:function(){
                var request = $.ajax({

                    url: this.addNewSubCategoryUrl,
                    data:{name:this.newCategoryName, restaurant_main_category_id:this.selectedMainCategoryId},
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    method: "POST",
                    success:function(msg){

                        newCategory = msg;

                        //Success code to follow
                        newCategory = this.processCategoriesForBinding([newCategory]);
                        //Set first load done to true for te newly added category since the newly added category wont have products already
                        newCategory[0].firstLoadDone = true;
                        appendArray(this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories,newCategory);

//                        this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories.sort(function(a,b){
//
//                            if (a.name < b.name)
//                                return -1;
//                            if (a.name > b.name)
//                                return 1;
//                            return 0;
//                        });


                        //Select newly added category
                        this.selectSubCategoryAndIndexForAMainCategoryBySubCategoryId(newCategory[0].id);
                        this.newCategoryName = "";

//                        this.updateBackupOfSubCategoriesListForSelectedMainCategory([newCategory[0]]);

                    }.bind(this),

                    error: function(jqXHR, textStatus ) {
                        this.ajaxRequestInProcess = false;

                        //Error code to follow


                    }.bind(this)
                });
            },
            updateCategory:function(category){
                var request = $.ajax({

                    url: this.updateSubCategoryUrl,
                    data:{_method:"PUT",
                          restaurant_sub_category_id:category.id,
                          name:category.editableName},
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    method: "POST",
                    success:function(msg){

                        editedCategory = msg;
                        //Success code to follow

                       for(mainCategoryIndex in this.mainCategoriesData){
                           for(subCategoryIndex in this.mainCategoriesData[mainCategoryIndex].sub_categories){
                               if(this.mainCategoriesData[mainCategoryIndex].sub_categories[subCategoryIndex].id == editedCategory.id){
                                   this.mainCategoriesData[mainCategoryIndex].sub_categories[subCategoryIndex].name = editedCategory.name;
                                   break;

                               }
                           }

                       }
                        category.editModeOn = false;
//                        this.updateBackupOfSubCategoriesListForSelectedMainCategory([], null, [editedCategory]);

                    }.bind(this),

                    error: function(jqXHR, textStatus ) {
                        this.ajaxRequestInProcess = false;

                        //Error code to follow


                    }.bind(this)
                });
            },
            deleteCategory: function (category, confirmed) {

                categoryId = category.id;


                this.dataHeldForConfirmation.confirmCallback = function(){
                    var request = $.ajax({

                        url: this.deleteSubCategoryUrl + categoryId,
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        data: {
                            _method: "DELETE",


                        },
                        success: function (msg) {

                            mainAndSubCategoryIndices = this.getMainAndSubCategoryIndexFromSubCategoryId(category.id);

                            if(mainAndSubCategoryIndices.mainCategoryIndex != null && mainAndSubCategoryIndices.subCategoryIndex != null){
                                this.mainCategoriesData[mainAndSubCategoryIndices.mainCategoryIndex].sub_categories.splice(mainAndSubCategoryIndices.subCategoryIndex,1);
                                if(this.mainCategoriesData[mainAndSubCategoryIndices.mainCategoryIndex].sub_categories.length >0){
                                    this.selectSubCategoryAndIndexForAMainCategoryBySubCategoryId(this.mainCategoriesData[mainAndSubCategoryIndices.mainCategoryIndex].sub_categories[0].id);
                                }else{
                                    this.setSelectedSubCategoryAndIdToNullForAMainCategoryById(this.mainCategoriesData[mainAndSubCategoryIndices.mainCategoryIndex].id);
                                }
                            }
//                            this.updateBackupOfSubCategoriesListForSelectedMainCategory([], [category.id]);
                            this.closeConfirmationPopup();
                        }.bind(this),

                        error: function (jqXHR, textStatus) {
                            this.ajaxRequestInProcess = false;

                            //Error code to follow
                            if (jqXHR.hasOwnProperty("responseText")) {
                                this.confirmationPopupErrorMessage = JSON.parse(jqXHR.responseText);
                            }

                        }.bind(this)
                    });
                }.bind(this);

                if(!confirmed){
                    this.dataHeldForConfirmation.confirmationMessage = "Are you sure you want to delete this category?";
                    this.displayConfirmationPopup();

                }else{
                    this.dataHeldForConfirmation.confirmCallback();
                    this.dataHeldForConfirmation.confirmCallback = null;
                }





            },
            deleteProduct: function (product, confirmed) {

                productId = product.id;


                this.dataHeldForConfirmation.confirmCallback = function(){
                    var request = $.ajax({

                        url: this.deleteProductUrl + productId,
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        data: {
                            _method: "DELETE",


                        },
                        success: function (msg) {

                            categoryIndices = this.getMainAndSubCategoryIndexFromSubCategoryId(product.restaurant_sub_category_id);
                            categoryOfProduct = this.mainCategoriesData[categoryIndices.mainCategoryIndex].sub_categories[categoryIndices.subCategoryIndex];


                            for(productIndex in categoryOfProduct.products.data){
                                if(categoryOfProduct.products.data[productIndex].id == product.id){
                                    categoryOfProduct.products.data.splice(productIndex,1);
                                    break;
                                }
                            }

//                            this.updateBackupOfProductListForSelectedSubAndMainCategories([],[productId]);
                            this.closeConfirmationPopup();
                        }.bind(this),

                        error: function (jqXHR, textStatus) {
                            this.ajaxRequestInProcess = false;

                            //Error code to follow
                            if (jqXHR.hasOwnProperty("responseText")) {
                                this.confirmationPopupErrorMessage = JSON.parse(jqXHR.responseText).response;
                            }

                        }.bind(this)
                    });
                }.bind(this);

                if(!confirmed){
                    this.dataHeldForConfirmation.confirmationMessage = "Are you sure you want to delete this product?";
                    this.displayConfirmationPopup();

                }else{
                    this.dataHeldForConfirmation.confirmCallback();
                    this.dataHeldForConfirmation.confirmCallback = null;
                }





            },
            selectSubCategoryAndIndexForAMainCategoryBySubCategoryId(subCategoryId){
                var mainAndSubCategoryIndices = this.getMainAndSubCategoryIndexFromSubCategoryId(subCategoryId);
                this.mainCategoriesData[mainAndSubCategoryIndices.mainCategoryIndex].selectedSubCategoryId = subCategoryId;
                this.mainCategoriesData[mainAndSubCategoryIndices.mainCategoryIndex].selectedSubCategoryIndex = mainAndSubCategoryIndices.subCategoryIndex;
            },
            setSelectedSubCategoryAndIdToNullForAMainCategoryById(mainCategoryId){

                for(mainCategoryIndex in this.mainCategoriesData){

                        if(this.mainCategoriesData[mainCategoryIndex].id == mainCategoryId){
                            this.mainCategoriesData[mainCategoryIndex].selectedSubCategoryId = null;
                            this.mainCategoriesData[mainCategoryIndex].selectedSubCategoryIndex = -1;
                            return;

                        }


                }

            },
            getMainAndSubCategoryIndexFromSubCategoryId(subCategoryId){
                for(_mainCategoryIndex in this.mainCategoriesData){
                    for(_subCategoryIndex in this.mainCategoriesData[_mainCategoryIndex].sub_categories){
                        if(this.mainCategoriesData[_mainCategoryIndex].sub_categories[_subCategoryIndex].id == subCategoryId){
                            return {
                                mainCategoryIndex:_mainCategoryIndex,
                                subCategoryIndex:_subCategoryIndex

                            };

                        }
                    }

                }

                return {
                    mainCategoryIndex:null,
                    subCategoryIndex:null
                };
            },
            displayConfirmationPopup: function () {
                //            console.log('emit received');
                this.showConfirmationPopup = true;
            },
            closeConfirmationPopup: function () {
                //            console.log('emit received');
                this.showConfirmationPopup = false;
                this.confirmationPopupErrorMessage = "";
                this.dataHeldForConfirmation.confirmationMessage = null;
                this.dataHeldForConfirmation.confirmCallback = null;

            },
            dragOverProduct:function(event, product){
                //indicesObjectOfDraggedObject = JSON.parse(event.dataTransfer.getData("indicesObjectOfDraggedPlayer"));
//            console.log(event);
//            if(timeSlot.reservations[0].players.length >= 4 && indicesObjectOfDraggedObject.objectType === "player"){
//
//                return;
//            }
                product.overClass = true;
                event.preventDefault();
            },
            dragEnterProduct:function(event, product){
                //indicesObjectOfDraggedObject = JSON.parse(event.dataTransfer.getData("indicesObjectOfDraggedPlayer"));
//            console.log(event);
//            if(timeSlot.reservations[0].players.length >= 4 && indicesObjectOfDraggedObject.objectType === "player"){
//
//                return;
//            }
                product.overClass = true;
                event.preventDefault();
            },
            dragDroppedProduct:function (event, product, productIndex) {
                product.overClass = false;
                draggedProductInfo = JSON.parse(event.dataTransfer.getData("draggedProductInfo"));

                if( draggedProductInfo.productIndex == productIndex){

                    return;
                }

                var productsListActive = this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories[this.mainCategoriesData[this.selectedMainCategoryIndex].selectedSubCategoryIndex].products;
                productsListActive.data = this.getNewlyArrangedItemsAfterDrop(productsListActive.data,draggedProductInfo.product ,draggedProductInfo.productIndex, productIndex);


            },
            dragProductStarted:function(event,product, productIndex){

                event.stopPropagation();
                event.dataTransfer.setData("draggedProductInfo", JSON.stringify({product:product,productIndex:productIndex}));



            },
            dragLeaveProduct:function(event, product){
                //indicesObjectOfDraggedObject = JSON.parse(event.dataTransfer.getData("indicesObjectOfDraggedPlayer"));
//            console.log(event);
//            if(timeSlot.reservations[0].players.length >= 4 && indicesObjectOfDraggedObject.objectType === "player"){
//
//                return;
//            }
                product.overClass = false;
                event.preventDefault();
            },
            dragOverSubCategory:function(event, subCategory){
                //indicesObjectOfDraggedObject = JSON.parse(event.dataTransfer.getData("indicesObjectOfDraggedPlayer"));
//            console.log(event);
//            if(timeSlot.reservations[0].players.length >= 4 && indicesObjectOfDraggedObject.objectType === "player"){
//
//                return;
//            }
                subCategory.overClass = true;
                event.preventDefault();
            },
            dragEnterSubCategory:function(event, subCategory){
                //indicesObjectOfDraggedObject = JSON.parse(event.dataTransfer.getData("indicesObjectOfDraggedPlayer"));
//            console.log(event);
//            if(timeSlot.reservations[0].players.length >= 4 && indicesObjectOfDraggedObject.objectType === "player"){
//
//                return;
//            }
                subCategory.overClass = true;
                event.preventDefault();
            },
            dragLeaveSubCategory:function(event, subCategory){
                //indicesObjectOfDraggedObject = JSON.parse(event.dataTransfer.getData("indicesObjectOfDraggedPlayer"));
//            console.log(event);
//            if(timeSlot.reservations[0].players.length >= 4 && indicesObjectOfDraggedObject.objectType === "player"){
//
//                return;
//            }
                subCategory.overClass = false;
                event.preventDefault();
            },
            dragDroppedSubCategory:function (event, subCategory,subCategoryIndex) {
                subCategory.overClass = false;
                draggedSubCategoryInfo = JSON.parse(event.dataTransfer.getData("draggedSubCategoryInfo"));

                if( draggedSubCategoryInfo.subCategoryIndex == subCategoryIndex){

                    return;
                }

                var mainCategoryActive = this.mainCategoriesData[this.selectedMainCategoryIndex];
                mainCategoryActive.sub_categories = this.getNewlyArrangedItemsAfterDrop(mainCategoryActive.sub_categories,draggedSubCategoryInfo.subCategory ,draggedSubCategoryInfo.subCategoryIndex, subCategoryIndex);
                this.categorySelected(draggedSubCategoryInfo.subCategory);

            },
            dragSubCategoryStarted:function(event,subCategory, subCategoryIndex){

                event.stopPropagation();
                event.dataTransfer.setData("draggedSubCategoryInfo", JSON.stringify({subCategory:subCategory,subCategoryIndex:subCategoryIndex}));



            },
            updateBackupOfProductListForSelectedSubAndMainCategories:function(newProductsArray, deletedProductIds){

                //To reset products backup to current value of products list, pass null newProductsArray value


                var productsListActive = this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories[this.mainCategoriesData[this.selectedMainCategoryIndex].selectedSubCategoryIndex].products;

                if(newProductsArray !== undefined){
                    if(newProductsArray === null){
                        productsListActive.dataBackup = JSON.parse(JSON.stringify(productsListActive.data));
                    }
                    else if( newProductsArray.constructor === Array && newProductsArray.length > 0){

                        appendArray(productsListActive.dataBackup,JSON.parse(JSON.stringify(newProductsArray) ));
                    }

                }

                if(deletedProductIds !== undefined && deletedProductIds !== null && deletedProductIds.constructor === Array){

                    for(deletedProductIndex in deletedProductIds){
                        for(productIndex in productsListActive.dataBackup){
                            var product = productsListActive.dataBackup[productIndex];
                            if(deletedProductIds[deletedProductIndex] ==  product.id){
                                productsListActive.dataBackup.splice(productIndex, 1);
                                break;
                            }
                        }
                    }
                }



            },
            updateBackupOfSubCategoriesListForSelectedMainCategory:function(newSubCategoriesArray, deletedSubCategoryId, editedSubCategories){


                var mainCategoryActive = this.mainCategoriesData[this.selectedMainCategoryIndex];

                if(newSubCategoriesArray !== undefined){
                   if( newSubCategoriesArray.constructor === Array && newSubCategoriesArray.length > 0){

                        appendArray(mainCategoryActive.subCategoriesBackup,JSON.parse(JSON.stringify(newSubCategoriesArray) ));
                    }

                }

                if(deletedSubCategoryId !== undefined && deletedSubCategoryId !== null && deletedSubCategoryId.constructor === Array){
                    for(deletedCategoryIndex in deletedSubCategoryId){
                        for(subCategoryIndex in mainCategoryActive.subCategoriesBackup){
                            var subCategory = mainCategoryActive.subCategoriesBackup[subCategoryIndex];
                            if(deletedSubCategoryId[deletedCategoryIndex] ==  subCategory.id){
                                mainCategoryActive.subCategoriesBackup.splice(subCategoryIndex, 1);
                                break;
                            }
                        }
                    }

                }

                if(editedSubCategories !== undefined && editedSubCategories !== null && editedSubCategories.constructor === Array){
                    for(editedSubCategoryIndex in editedSubCategories){
                        for(subCategoryIndex in mainCategoryActive.subCategoriesBackup){
                            if(mainCategoryActive.subCategoriesBackup[subCategoryIndex].id == editedSubCategories[editedSubCategoryIndex].id){
                                mainCategoryActive.subCategoriesBackup[subCategoryIndex].name = editedSubCategories[editedSubCategoryIndex].name;
                                break;
                            }

                        }
                    }

                }


            },
            getNewlyArrangedItemsAfterDrop:function(itemsList,draggedItem,draggedItemIndex, draggedOnItemIndex){
                itemsTillTheDroppedItem = [];

                if( draggedItemIndex > draggedOnItemIndex){

                    //lower order to higher order should shift the items down
                    itemsTillTheDroppedItem = itemsList.slice(0,draggedOnItemIndex);
                    itemsAfterTheDroppedItem = itemsList.slice(draggedOnItemIndex);
                    itemsAfterTheDroppedItem.splice((draggedItemIndex - draggedOnItemIndex), 1);
                    itemsTillTheDroppedItem.push(draggedItem);
                    appendArray(itemsTillTheDroppedItem, itemsAfterTheDroppedItem)


                }else if(draggedItemIndex < draggedOnItemIndex){
                    //higher order to lower order should shift the items up
                    itemsTillTheDroppedItem = itemsList.slice(0,draggedOnItemIndex+1);
                    itemsAfterTheDroppedItem = itemsList.slice(draggedOnItemIndex +1);
                    itemsTillTheDroppedItem.splice(draggedItemIndex, 1);
                    itemsTillTheDroppedItem.push(draggedItem);
                    appendArray(itemsTillTheDroppedItem, itemsAfterTheDroppedItem)


                }

                return itemsTillTheDroppedItem;
            },
            saveSortRankOrderForProducts:function(){
                this.clearMessageBar();
//                Get only ids that have been displaced against each other
                var productsListActive = this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories[this.mainCategoriesData[this.selectedMainCategoryIndex].selectedSubCategoryIndex].products;
//                var rankDifferences = {
//                    idsActiveList:[],
//                    idsBackupList:[]
//                };
//                for(productIndex in productsListActive.data){
//                    if(productsListActive.data[productIndex].id !== productsListActive.dataBackup[productIndex].id){
//                        rankDifferences.idsActiveList.push(productsListActive.data[productIndex].id);
//                        rankDifferences.idsBackupList.push(productsListActive.dataBackup[productIndex].id);
//                    }
//
//                }

                var idsSortedByRanks = [];
                for(productIndex in productsListActive.data){
                    idsSortedByRanks.push(productsListActive.data[productIndex].id);

                }

                var request = $.ajax({

                    url: this.updateProductSortRanksUrl,
                    data:{idsSortedByRanks:idsSortedByRanks},
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    method: "POST",
                    success:function(msg){
                        this.showMessageInMessageBar('success',msg);
                    }.bind(this),

                    error: function(jqXHR, textStatus ) {
                        this.showMessageInMessageBar('error',jqXHR.responseJSON);
                    }.bind(this)
                });


            },
            saveSortRankOrderForSubCategories:function(){
                this.clearMessageBar();
//                Get only ids that have been displaced against each other
                var subCategoriesActive = this.mainCategoriesData[this.selectedMainCategoryIndex].sub_categories;//                var rankDifferences = {
//                    idsActiveList:[],
//                    idsBackupList:[]
//                };
//                for(productIndex in productsListActive.data){
//                    if(productsListActive.data[productIndex].id !== productsListActive.dataBackup[productIndex].id){
//                        rankDifferences.idsActiveList.push(productsListActive.data[productIndex].id);
//                        rankDifferences.idsBackupList.push(productsListActive.dataBackup[productIndex].id);
//                    }
//
//                }

                var idsSortedByRanks = [];
                for(subCategoryIndex in subCategoriesActive){
                    idsSortedByRanks.push(subCategoriesActive[subCategoryIndex].id);

                }

                var request = $.ajax({

                    url: this.updateSubCategorySortRanksUrl,
                    data:{idsSortedByRanks:idsSortedByRanks},
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}',
                    },
                    method: "POST",
                    success:function(msg){

                        this.showMessageInMessageBar('success',msg);
                    }.bind(this),

                    error: function(jqXHR, textStatus ) {
                        this.showMessageInMessageBar('error',jqXHR.responseJSON);
                    }.bind(this)
                });


            },
            showMessageInMessageBar:function(type,message){
                this.messageBar.type = type;
                this.messageBar.message = message;
            },
            clearMessageBar:function(){
                this.messageBar.type = '';
                this.messageBar.message = '';
            }






        },

    });

</script>