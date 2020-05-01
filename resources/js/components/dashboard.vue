<template>
  <v-app>
    <Leftbar :trigger="isLeftbar" v-show="this.$route.path!='/dashboard/login'"></Leftbar>
    <Header   @send="headerGet" v-show="this.$route.path!='/dashboard/login'"></Header>
    <router-view></router-view>
    <Footer v-show="this.$route.path!='/dashboard/login'"></Footer>

  </v-app>
</template>

<script>
import Header from './dashboard/common/Header'
import Footer from './dashboard/common/Footer'
import Leftbar from './dashboard/common/Leftbar'
export default {
    data: () => ({
      isLeftbar:false,
      items: []
      
    }),
    components:
    {
        Header,
        Footer,
        Leftbar
    },
    methods:{
      headerGet(item)
      {
          this.isLeftbar=item
      }

    },
        created() {
        this.$router.options.routes.forEach(route => {
            this.items.push({
                name: route.name,
                path: route.path,
                meta: route.meta,
                
            })
        })
    }
  }
</script>