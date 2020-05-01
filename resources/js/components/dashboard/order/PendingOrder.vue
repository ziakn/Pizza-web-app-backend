<template>
	<v-content>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="11">
                    <v-row >
                       
                        <v-col cols="12">
                        <v-text-field
                            
							v-model="search"
							append-icon="search"
							label="Search"
							hide-details
							outlined

						></v-text-field>
                        </v-col>
                    </v-row>
					<v-toolbar flat color="white">
						<v-toolbar-title>Order List</v-toolbar-title>
						<v-divider class="mx-2" inset vertical></v-divider>
						<v-spacer></v-spacer>

					</v-toolbar>
                    <v-card flat>
                        <v-card-text>
                            <v-data-table  :headers="headers" :items="dataList" :search="search"
                                hide-default-footer
                            >
                                <template v-slot:item.created_at="{ item }">
                                    <span>{{ item.created_at | moment("from") }}</span>
                                </template>   
								 <template v-slot:item.pizza_id="{ item }">
                                    <span>{{ item.pizza.title }}</span>
                                </template> 
								<template v-slot:item.total="{ item }">
                                    <span>{{ item.pizza.price }}</span>
                                </template>      
                                <template v-slot:item.order_status_id="{ item }">
									<v-select
										v-model="item.order_status_id"
										:items="dataStatus"
										item-text="name"
										item-value="id"
										solo
										dense
										class="mt-3"
										style="max-width: 150px"
										@change="changeStatus(item)"
									></v-select>   
                                </template> 
                                <template v-slot:no-data>
                                    <v-skeleton-loader type="table-tbody"></v-skeleton-loader>
                                    <v-btn color="primary" @click="initialize" class="ma-3">Reset</v-btn>
                                </template>
                            </v-data-table>
                            <div class="text-center">
                                <v-pagination
                                v-model="filters.page"
                                :length="pageCount"
                                @input="getOrder"
                                ></v-pagination>
                            </div>
                        </v-card-text>
                    </v-card>
				</v-col>
			</v-row>
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
export default {
	components: {
	},
	data: () => ({
		isAssign:false,
		setting:{},
        itemsPerPage:1,
        pageCount:2,
		search: "",
		absolute: true,
		loading: false,
		edit: true,
		dialog: false,
        dataList: [],
        filters:
        {
            category_id:null,
            branch_id:null,
			page:1,
			show:10,
			order_status_id:1,

        },
		headers: [
			{ text: "ID", align: "left", value: "id" },
			{ text: "Order Time", value: "created_at" },
			{ text: "Pizza", value: "pizza_id" },
			{ text: "Total", value: "total" },
		],
		editedIndex: -1,
		editedItem: {
			customer_name: "",
			total: "",
			address: '',
			status: 1,
		},
		dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
		isView:false,
		defaultItem: {
			customer_name: "",
			total: "",
			address: '',
			status: 1,
		},
		dataStatus: [
			
		]
	}),

	props: {
		source: String
	},
	computed: {
		formTitle() {
			return this.editedIndex === -1 ? "New Item" : "Edit Item";
		}
	},
	watch: {},
	created() {
        this.initialize();

	},
	methods: {
		async changeStatus(i)
		{
			this.loading = true;
			console.log(i)		
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/order/"+i.id+"/edit",
					params:{
						order_status_id: i.order_status_id
					},

				});
				if (data.status) {
					this.snacks("Successfully Changed", "green");
					this.close();
				} else {
					this.snacks("Failed", "red");
					this.loading = false;
				}
			} catch (e) {
				this.snacks("Error, Server issue", "red");
				this.loading = false;
			}


		},

		async initialize() {
			this.filters.page=1
			
			this.getOrder();

        },
        async getOrder()
        {
            this.load=true;
            try {
				let { data } = await axios({
					method: "get",
                    url: "/app/order",
                    params: this.filters
				});
                this.dataList = data.data;
                this.itemsPerPage=data.per_page;
                this.pageCount=data.last_page;
                this.filters.page=data.current_page
			} catch (e) {
                
            }
		},
	
		
	
	}
};
</script>