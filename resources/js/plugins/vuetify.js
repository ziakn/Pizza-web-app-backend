
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css' 
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import colors from 'vuetify/lib/util/colors'
//  import '@fortawesome/fontawesome-free/css/all.css' 
Vue.use(Vuetify)

export default new Vuetify({ 
  icons: {
      iconfont: 'mdi' || 'mdiSvg' || 'md' || 'fa' 
    },
    theme: {
      themes: {
        light: {
          primary: colors.deepPurple.accent4, // #E53935
          secondary: colors.purple.base, // #FFCDD2
          accent: '#241d3b', // #3F51B5
        },
      },
    },
})