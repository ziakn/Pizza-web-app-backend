import Vue from "vue";
import Router from 'vue-router'
import dashboard from './components/dashboard/overview/Home.vue'




import pizza from './components/dashboard/pizza/Home.vue'
import order from './components/dashboard/order/Home.vue'



import list from './components/dashboard/pizza/List.vue'
import add from './components/dashboard/pizza/Add.vue'
import category from './components/dashboard/pizza/Category.vue'
import cusine from './components/dashboard/pizza/Cusine.vue'
import ingredient from './components/dashboard/pizza/Ingredient.vue'
import edit from './components/dashboard/pizza/Edit.vue'



import pendingorder from './components/dashboard/order/PendingOrder.vue'




import profile from './components/dashboard/profile/Profile.vue'
import dashboardoverview from './components/dashboard/overview/OverView.vue'



let adminOnly=[1]

Vue.use(Router)
export default new Router({
    mode: "history",
    routes: [ 
        {
            path: '/dashboard',
            component: dashboard,
            meta: {
                title: 'Dashboard',
                type: adminOnly,
            },
            children: [
                {
                    path: '/',
                    component: dashboardoverview,    
                    meta: {
                        title: 'Overview',
                        type: adminOnly,
                    }
                },
              
            ]
        },


        {
            path: '/dashboard/pizza',
            component: pizza,
            meta: {
                title: 'Pizza',
                type: adminOnly,
            },
            children: [
                {
                    path: 'list',
                    component: list,             
                    meta: {
                        title: 'List',
                        type: adminOnly,
                    }
                },
                {
                    path: 'add',
                    component: add,              
                    meta: {
                        title: 'Add',
                        type: adminOnly,
                    }
                },
                {
                    path: 'category',
                    component: category,       
                    meta: {
                        title: 'Category',
                        type: adminOnly,
                    }
                },
                {
                    path: 'cusine',
                    component: cusine,         
                    meta: {
                        title: 'Cusine',
                        type: adminOnly,
                    }
                },
                {
                    path: 'ingredient',
                    component: ingredient,      
                    meta: {
                        title: 'Cusine',
                        type: adminOnly,
                    }
                },
                {
                    path: 'edit/:id',
                    component: edit,      
                    meta: {
                        title: 'Cusine',
                        type: adminOnly,
                    }
                },
                
            ]
        },



        {
            path: '/dashboard/order',
            component: order,
            meta: {
                title: 'order',
                type: adminOnly,
            },
            children: [
            {
                path: 'pending',
                component: pendingorder,
                meta: {
                    title: 'list',
                    type: adminOnly,
                }
            },
           
            ]

        },




        {
            path: '/dashboard/profile',
            name: 'Profile',
            component: profile,
            meta: {
                 title: 'Profile',
                 type: adminOnly, 
                }
        },
      

        

        

        
       
       

       
       ]
})