<template>
  <div>
    <v-navigation-drawer
      v-model="trigger"
      :clipped="$vuetify.breakpoint.lgAndUp"
      color="accent"
      dark
      app
    >
      <v-list shaped dense>
        <template v-for="(item,index) in items" >
          <v-row v-if="item.heading" :key="item.heading"  align="center">
            <v-col cols="6">
              <v-subheader v-if="item.heading">{{ item.heading }}</v-subheader>
            </v-col>
            <v-col cols="6" class="text-center">
              <a href="#!" class="body-2 black--text">EDIT</a>
            </v-col>
          </v-row>
          <v-list-group
            v-else-if="item.children"
            :key="index"
            v-model="item.model"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
            append-icon
            v-show="handleGoToMenus(item)"
            active-class="black white--text"
          >
            <template v-slot:activator>
              <v-list-item  >
                <v-list-item-content>
                  <v-list-item-title>{{ item.text }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>
            <v-list-item
              v-for="(child, i) in item.children"
              :key="i"
              :to="handleGoToMenu('/dashboard/'+child.link)"
               v-show="showChild(child)"
              active-class="deep-purple white--text"
            >
            <v-flex>
              <v-list-item-action v-if="child.icon">
                <v-icon >{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title >{{ child.text }}</v-list-item-title>
              </v-list-item-content>
              </v-flex>
            </v-list-item>
          </v-list-group>
          <v-list-item v-else :key="item.text" >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{ item.text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
      <template v-slot:append>
        <div class="pa-2">
          <v-btn block href="/logoutuser">Logout</v-btn>
        </div>
      </template>
    </v-navigation-drawer>
  </div>
</template>

<script>
export default {
  props: {
    trigger: true
  },
  data: () => ({
    drawer: null,
    userType:null,
    items: [
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "dashboard",
        text: "Dashboard",
        model: false,
        
        children: [
          { text: "Overview", link: "" },
          ]
      },
       {
        icon: "keyboard_arrow_down",
        "icon-alt": "face",
        text: "Pizza",
        model: false,
    
        children: [
          {  text: "Add Pizza", link: "pizza/add"  },
          {  text: "Pizza List", link: "pizza/list" },
          {  text: "Category List", link: "pizza/category" },
          {  text: "Cusine List", link: "pizza/cusine" },
          {  text: "Ingredient List", link: "pizza/ingredient" },
        ]
      },
      {
        icon: "keyboard_arrow_down",
        "icon-alt": "done_all",
        text: "Order",
        model: false,
       
        children: [
          {  text: "Pending Orders", link: "order/pending" , },
        ]
      },
          {
        icon: "keyboard_arrow_down",
        "icon-alt": "settings_applications",
        text: "Setting",
        model: false,
        children: [
          { text: "Profile", link: "profile" },
        ]
      },

   

    ]
  }),
  methods: {
    handleGoToMenu(d) {
      return d;
    },
    handleGoToMenus(item) {
        return item
    },
    showChild(child) {
      return child;
    },

  },
    created() {
  },
};
</script>