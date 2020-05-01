<template>
	<v-content>
		<v-container fluid>
			<v-overlay :value="showFullLoading" :absolute="absolute">
				<v-progress-circular indeterminate size="64"></v-progress-circular>
			</v-overlay>
			<v-row justify="center">
				<v-col sm="12" md="12" lg="12">
                    <v-row >
                        <v-col cols="6">
                            <v-select
                                v-model="filters.category_id"
                                :items="dataCategory"
                                item-text="title"
                                item-value="id"
                                label="Category"
                                required
                                filled
								@change="getpizza"
								clearable
                            ></v-select>                            
                        </v-col>
                        <v-col cols="6">
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
						<v-toolbar-title>Pizza  List</v-toolbar-title>
						<v-divider class="mx-2" inset vertical></v-divider>
						<v-spacer></v-spacer>

					</v-toolbar>
                    <v-card flat>
                        <v-card-text>
                            <v-data-table  :headers="headers" :items="dataList" :search="search"
                                hide-default-footer :items-per-page="15"
                            >
                                <template v-slot:item.image="{ item }">
									<v-img
										:src="item.image.length>0?item.image[0].src:'/no_image.png'"
										lazy-src="no_image.png"
										aspect-ratio="1"
										class="grey lighten-2"
										width="80"
										height="80"
									></v-img>
                                </template>
							
                               <template v-slot:item.category="{ item }">
                                 {{item.category.title}}
                                </template>
                                
                                <template v-slot:item.status="{ item }">
                                    <v-switch v-model="item.status" @change="changeStatus(item)" color="primary" inset></v-switch>
                                </template>
                                <template v-slot:item.action="{ item }">
                                    <v-icon color="blue"  @click="editItem(item)">edit</v-icon>
                                    <v-icon color="red"  @click="deleteItem(item)">delete</v-icon>
                                </template>
								<template v-slot:no-data>
									<NoDataList :loading="loading" @initialize="initialize"></NoDataList>
                                </template>
                            </v-data-table>
                            <div class="text-center">
                                <v-pagination
                                v-model="filters.page"
                                :length="pageCount"
                                @input="getpizza"
                                ></v-pagination>
                            </div>
                        </v-card-text>
                    </v-card>
				</v-col>
			</v-row>
			<DeleteModal :trigger="isDelete" :title="deleteTitle" :body="deleteBody" @request="remove"></DeleteModal>
			<v-btn bottom color="primary" dark fab fixed right @click="save">
				<v-icon>mdi-plus</v-icon>
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
import DeleteModal from "./../common/DeleteModal";
import NoDataList from "./../common/NoDataList"
export default {
	components: {
		DeleteModal,
		NoDataList
	},
	data: () => ({
		setting:{},
        itemsPerPage:1,
        pageCount:2,
		search: "",
		absolute: true,
		loading: false,
		edit: true,
		dialog: false,
        dataList: [],
        dataCategory:[],
		
        filters:
        {
            category_id:null,
            branch_id:null,
            page:1,

        },
		headers: [
			{ text: "ID", align: "left", value: "id" },
			{ text: "Image", value: "image" },
			{ text: "Name", value: "title" },
			{ text: "Category", value: "category" },
			{ text: "Description", value: "description" },
            { text: "Price", value: "price" },
            { text: "Status", value: "status" },
			{ text: "Action", value: "action" }
		],
		editedIndex: -1,
		editedItem: {
			name: "",
			description: "",
			parent_id: 0,
			status: 1,
			branch:[],
		},
		dataIndex: null,
		deleteTitle: "",
		deleteBody: "",
		isDelete:false,
		defaultItem: {
			name: "",
			description: "",
			parent_id: 0,
			status: 1,
			branch:[],
		},
		dataStatus: [
			{ name: "Active", value: 1 },
			{ name: "Disable", value: 0 }
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
			console.log(i.status)			
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/pizza/"+i.id+"/edit",
					params:{
						status: i.status
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
			this.loading=true;
			this.filters.category_id=''
			this.filters.page=1
			
			
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/category"
				});
				this.dataCategory = data;
			} catch (e) {
                
            }
			
			this.getpizza();

        },
        async getpizza()
        {
            this.loading=true;
            try {
				let { data } = await axios({
					method: "get",
                    url: "/app/pizza",
                    params: this.filters
				});
                this.dataList = data.data;
                this.itemsPerPage=data.per_page;
                this.pageCount=data.last_page;
				this.filters.page=data.current_page
				this.loading=false;
			} catch (e) {
				this.loading=false;

            }
        },
		editItem(item) {
			this.$router.push('/dashboard/pizza/edit/'+item.id);
		},
		save(item) {
			this.$router.push('/dashboard/pizza/add');
		},
		deleteItem(item) {
			this.dataIndex = this.dataList.indexOf(item);
			this.deleteTitle = "Are you sure you want to delete this item?";
			this.isDelete = !this.isDelete;
		},
		close() {
			this.dialog = false;
			this.loading = false;
		},
		async remove() {
			this.loading=true;
			try {
				let { data } = await axios({
					method: "delete",
					url: "/app/pizza/" + this.dataList[this.dataIndex].id
				});
				if (data.status) {
					this.snacks('Successfully Done','green')
					this.dataList.splice(this.dataIndex, 1);
					this.close();				
				}
				else
				{
					this.snacks(data.data,'red')
					this.loading = false;
				}

			} catch (e) {
				this.snacks('Operation Failed','red')
				this.loading = false;
			}
		}
	}
};
</script>