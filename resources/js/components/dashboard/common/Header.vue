<template>
  <v-app-bar  color="accent" :clipped-left="$vuetify.breakpoint.lgAndUp" app dark flat >
    <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
      <v-app-bar-nav-icon @click="drawerTrigger"></v-app-bar-nav-icon>
      <span class="hidden-sm-and-down">Pizza Delivery App</span>
    </v-toolbar-title>
    <v-progress-linear
      :active="showFullLoading"
      :indeterminate="showFullLoading"
      absolute
      bottom
      color="accent"
    ></v-progress-linear>
    <!-- <v-text-field
      flat
      solo-inverted
      hide-details
      prepend-inner-icon="search"
      label="Search"
      class="hidden-sm-and-down"
    ></v-text-field> -->
    <div class="flex-grow-1"></div>
    
    <v-btn icon>
      <v-icon>mdi-apps</v-icon>
    </v-btn>
    <v-btn icon>
      <v-icon>mdi-bell</v-icon>
    </v-btn>
    <!-- <p>{{dataUser.name}}</p> -->
    <v-btn icon large>
      <v-avatar size="32px" item>
        <v-img :src="dataUser.image" :alt="dataUser.name"></v-img>
      </v-avatar>
    </v-btn>
  </v-app-bar>
</template>

<script>
export default {
  props: {
    source: String
  },
  data: () => ({
    drawer: false,
    dialog: false,
    dataUser: {}
  }),
  created() {
    this.dataUser = this.$store.state.authUser;
  },
  methods: {
    drawerTrigger() {
      this.drawer = !this.drawer;
      this.$emit("send", this.drawer);
    }
  }
};
</script>