<template>
	<v-content>
		<v-container fluid>
			<AdminOverView :dataList="dataList" ></AdminOverView>
		</v-container> 
	</v-content>
</template>

<script>
import AdminOverView from "./../common/AdminOverView";
export default {
	components: {
		AdminOverView,
    },
	data: () => ({
			dataList: {},	
	}),

	props: {
	},
	computed: {	

	},
	watch: {},

	created() {
		this.initialize();

	},
	methods: {
		async initialize() {
			
			try {
				let { data } = await axios({
					method: "get",
					url: "/app/dashboardoverview"
				});
				this.dataList = data;
				
			} catch (e) {
							this.loading=false;                
			}
			
        },
        
		
		
	
	
	
		
	}
};
</script>