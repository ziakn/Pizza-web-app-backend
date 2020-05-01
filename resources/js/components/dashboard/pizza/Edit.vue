<template>
	<v-content>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<v-toolbar color="transparent" flat>
				<v-toolbar-title >Add</v-toolbar-title>

				<v-spacer></v-spacer>

				<template >
					<v-btn large icon @click="back">
					<v-icon large color="error" >cancel</v-icon>
					</v-btn>
				</template>
			</v-toolbar>
			
			<v-row justify="center">    
 
                <v-col cols="12" lg="8">
					<v-row>
						<v-col cols=12>
							<v-card flat >
								<v-card-title> 
									<v-icon large left color="primary" >
										assignment
									</v-icon>
									<span class="title font-weight-light" ></span>
								</v-card-title>
								<v-card-text>
										<v-tabs >
											<v-tab  >
												english
											</v-tab>
											
											<v-tab-item >
												<v-card flat>
													<v-card-text>
														<v-row >
															<v-col cols="12"  >
																<v-text-field v-model="formValue.title" label="Pizza Name*"  filled :rules="nameRules" ></v-text-field>
															</v-col>
															<v-col  cols="12">
																<v-textarea v-model="formValue.description" label="Description*"  filled :rules="nameRules" ></v-textarea>
															</v-col>
														</v-row>
													</v-card-text>
												</v-card>
											</v-tab-item>
											</v-tabs>
											<v-divider></v-divider>
											<v-row>
												<v-col cols="12" >
													<v-text-field v-model="formValue.model" label="Model" filled></v-text-field>
												</v-col>
												<v-col cols="6" >
													<v-text-field v-model="formValue.point" label="Point"  type="number"  filled></v-text-field>
												</v-col>
												<v-col cols="6" >
													<v-text-field v-model="formValue.sort" label="Sort"  type="number"  filled></v-text-field>
												</v-col>
												<v-col cols="12" md="6" lg="6">
													<v-select
														v-model="formValue.veg"
														:items="dataVeg"
														item-text="name"
														item-value="value"
														filled
														label="Veg"
													></v-select>
												</v-col>
												<v-col cols="12" md="6" lg="6">
													<v-select
														v-model="formValue.status"
														:items="dataStatus"
														item-text="name"
														item-value="value"
														filled
														label="Status"
													></v-select>
												</v-col>
												<v-col cols="12" md="6" lg="6">
													<v-select
														v-model="formValue.priceType"
														:items="priceType"
														item-text="name"
														item-value="value"
														filled
														label="Price Type"
													></v-select>
												</v-col>
												<v-col cols="12" md="6" lg="6">
													<v-text-field v-model="formValue.price" label="Price"  type="number"  filled></v-text-field>
												</v-col>
											</v-row>
									
								</v-card-text>
							</v-card>
						</v-col>
						<v-col cols="12">
							<v-card flat>
								<v-card-title> 
									<v-icon large left color="primary" >
										attach_file
									</v-icon>
									<span class="title font-weight-light" ></span>
								</v-card-title>
								<v-card-text> 
									<Media :formValue="formValue" @files="filesValue"></Media>
								</v-card-text>
							</v-card>
						</v-col>
					</v-row>
                </v-col>
                 <v-col cols="12" lg="4">
					 <v-row>
						 <v-col cols="12">
							<v-card flat>
								<v-card-title> 
									<v-icon large left color="primary" >
										bookmarks
									</v-icon>
									<span class="title font-weight-light" ></span>
								</v-card-title>
								<v-card-text> 
									<v-row>
										<v-col cols="12">
											<v-select
												v-model="formValue.category_id"
												:items="dataCategory"
												item-text="title"
												item-value="id"
												required
												label="Categories"
												filled
												chips
											>
											</v-select>
										</v-col>
										
										<v-col cols="12">
											<v-card outlined >
												<v-card-title>
													<v-icon large left color="primary" >
														monetization_on
													</v-icon>
													<span class="title font-weight-light" ></span>
												</v-card-title>
												<v-card-text>
													<v-row>
														<v-col cols="6">
															<span class="title">Size</span>
															<v-radio-group v-model="formValue.size_type" row>
																<v-radio label="Single" value="single"></v-radio>
																<v-radio label="Many" value="many"></v-radio>
															</v-radio-group>
														</v-col>
													</v-row>
													
										
												</v-card-text>
											</v-card>
										</v-col>
										<v-col cols="12">
											<v-select
												v-model="cuisine"
												:items="dataCuisine"
												item-text="title"
												return-object
												label="Cuisine"
												multiple
												filled
												chips
											>
											</v-select>
										</v-col>
										<v-col cols="12">
											<v-select
												v-model="ingredient"
												:items="dataIngredient"
												item-text="title"
												return-object
												label="Ingredient"
												multiple
												filled
												chips
											>
											</v-select>
										</v-col>
										<v-col cols="12">
											<v-select
												v-model="formValue.dimension"
												:items="dimensionType"
												item-text="name"
												item-value="value"
												label="Diemesion"
												filled
												chips
											>
											</v-select>
										</v-col>
										
									</v-row>
								</v-card-text>
							</v-card>
						 </v-col>
						 <v-col cols="12">
							<v-card flat>
								<v-card-title> 
									<v-icon large left color="primary" >
										web
									</v-icon>
									<span class="title font-weight-light" ></span>
								</v-card-title>
								<v-card-text> 
									<v-row>
										<v-col cols="12" >
											<v-text-field v-model="formValue.meta_title" label="Meta Title*" :rules="nameRules" filled></v-text-field>
										</v-col>
										<v-col cols="12" >
											<v-textarea v-model="formValue.meta_description" label="Meta Description" filled></v-textarea>
										</v-col>
										<v-col cols="12" >
											<v-text-field v-model="formValue.meta_keyword" label="Meta Tags" filled></v-text-field>
										</v-col>
										
									</v-row>
								</v-card-text>
							</v-card>
						 </v-col>
					 </v-row>

                 </v-col>

			</v-row>
			<v-btn  bottom color="green  darken-3" dark fab fixed right @click="save">
				<v-icon>check</v-icon>
			</v-btn>
		</v-container>
		<v-snackbar
			v-model="snackbar"
			:vertical="snackvertical"
			:timeout="snacktimeout"
			:top="snacktop"
			:right="snackright"
			:color="snackcolor"
		>
			{{ snacktext }}
			<v-btn color="white" text @click="snackbar = false">Close</v-btn>
		</v-snackbar>
	</v-content>
</template>

<script>
import Media from './Media'
export default {
	components:
	{
		Media
	},
	data: () => ({
		setting:{},
		absolute:false,
		branch:[],
		cuisine:[],
		tag:[],
		ingredient:[],
		dataCategory:[],
		dataCuisine:[],
		dataIngredient:[],
		category:[],
		loading: false,
		media:[],
	
		formValue: {
			title:'',
			category_id:'',
			priceType:'',
			model:'',
			point:'',
			dimension:'',
			description:'',
			sort:0,
			status: 1,
			image:[],
			priceType:"",
			price:"",
			meta_title:'',
			meta_description:'',
			meta_keyword:'',
		}, 
		nameRules: [
			v => !!v || 'This Field is required'
			],
		defaultItem: {
			title:'',
			category_id:'',
			priceType:'',
			model:'',
			point:'',
			dimension:'',
			description:'',
			sort:0,
			status: 1,
			image:[],
			priceType:"",
			price:"",
			meta_title:'',
			meta_description:'',
			meta_keyword:'',
		},
		dataStatus: [
			{ name: "Active", value: 1 },
			{ name: "Disable", value: 0 }
		],
		dataVeg: [
			{ name: "Veg", value: 'veg' },
			{ name: "Non-Veg", value: 'nonvege' }
		],
		priceType: [
			{ name: "Dollar", value: 'dollar'},
			{ name: "Euro", value: 'euro' }
		],
		dimensionType: [
			{ name: "Square", value: 'square'},
			{ name: "Round", value: 'round' },
			{ name: "Triangle", value: 'triangle' },
		]
	}),

	props: {
		source: String
	},
	computed: {
		
		
	
		
		
	},
	watch: {},
	created() {
		
	this.initialize();
	},
	methods: {
		addField(i)
		{
			this.branch[i].price.push({
							tag:'',
							price:''
							
						});

		},
		removePrice(i,j)
		{
			if(this.branch[i].price.length>1)
			this.branch[i].price.splice(j, 1);
			else
			this.snacks("Minimum 1 field required, cannot remove this last field", "red");


		},
		setAll(item)
		{
			var _price=item
			
			for(let d of this.branch)
			{
				d.price=JSON.parse(JSON.stringify(item));

			}

		},
		
		filesValue(item)
		{
			this.media=item;
		},
	
		async initialize() {
			this.start()
			this.setting=this.$store.state.setting
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/category"
				});
				this.dataCategory = data;
			} catch (e) {
				this.fail();
                
			}
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/cuisine"
				});
				this.dataCuisine = data;
			} catch (e) {
				this.fail();                
			}
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/ingredient"
				});
				this.dataIngredient = data;
			} catch (e) {
				this.fail();                
            }
            

            try {
				let { data } = await axios({
					method: "get",
					url: "/app/pizza/"+this.$route.params.id
				});
                this.formValue = data;
				for(let d of data.cuisine)
                {
                    this.cuisine.push(d.cuisine)

				}
				for(let d of data.ingredient)
                {
                    this.ingredient.push(d.ingredient)

				}
				
			} catch (e) {
				this.fail();
                
            }
			this.finish();
			
		},

	
		back()
		{
			this.$router.push('/dashboard/pizza/list');
		},
		close() {
			this.dialog = false;
			this.loading = false;
			this.back();
		},
		async save() {
			this.loading = true;
			
				try {
					
						const formData = new FormData();
					for ( var key in this.formValue ) {
						formData.append(key,this.formValue[key]);
					}
					this.category.forEach(file => {
						formData.append("categoryEdit[]", JSON.stringify(file));
					});
					this.cuisine.forEach(file => {
						formData.append("cuisineEdit[]", JSON.stringify(file));
					});
					this.ingredient.forEach(file => {
						formData.append("ingredientEdit[]", JSON.stringify(file));
					});
					this.media.forEach(file => {
						formData.append("media[]", file, file.name);
					});
					this.formValue.image.forEach(file => {
						formData.append("imageEdit[]", JSON.stringify(file));
					});

					formData.append("_method", "put");
					let { data } = await axios({
						method: "post",
						url: "/app/pizza/"+this.$route.params.id,
                        data: formData,

					});
					if (data.status) {
						this.snacks("Successfully Edited", "green");
						this.close();
					} else {
						this.snacks("Failed", "red");
						this.loading = false;
					}
				} catch (e) {
					this.snacks(data.data, "red");
					this.loading = false;
				}
		}
	}
};
</script>