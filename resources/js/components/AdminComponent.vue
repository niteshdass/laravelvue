<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app clipped>
      <v-list dense>
        <v-list-item v-for="item in items" :key="item.text" :to="item.action" link>
          <v-list-item-action>
            <v-icon>mdi-{{item.icon}}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{item.text}}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-subheader class="mt-4 grey--text text--darken-1">SUBSCRIPTION</v-subheader>
        <v-list>
          <v-list-item v-for="item in items2" :key="item.text" link>
            <v-list-item-avatar>
              <img
                :src="`https://st.depositphotos.com/2101611/4338/v/600/depositphotos_43381243-stock-illustration-male-avatar-profile-picture.jpg`"
                alt="h"
              />
            </v-list-item-avatar>
            <v-list-item-title v-text="item.text" />
          </v-list-item>
        </v-list>

        <v-list-item class="mt-4" link>
          <v-list-item-action>
            <v-icon color="grey darken-1">mdi-plus-circle-outline</v-icon>
          </v-list-item-action>
          <v-list-item-title class="grey--text text--darken-1">Browse Channel</v-list-item-title>
        </v-list-item>

        <v-list-item @click="logout" class="mt-4" link>
          <v-list-item-action>
            <v-icon color="grey darken-1">mdi-plus-circle-outline</v-icon>
          </v-list-item-action>
          <v-list-item-title class="grey--text text--darken-1">Logout</v-list-item-title>
        </v-list-item>

        <v-list-item link>
          <v-list-item-action>
            <v-icon color="grey darken-1">mdi-setting</v-icon>
          </v-list-item-action>
          <v-list-item-title class="grey--text text--darken-1">Manage Subsription</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar app clipped-left color="blue" dense>
      <v-app-bar-nav-icon @click.stop="drawar = !drawar" />
      <v-toolbar-title class="mr-12 align-center">
        <v-btn outlined to="/admin">Youtube</v-btn>
      </v-toolbar-title>
      <v-spacer />
      <v-row align="center" style="max-width:650px">
        <v-text-field
          :append-icon-cb="()=>{}"
          placeholder="Search"
          single-line
          append-icon="mdi-search"
          color="black"
          hide-details=" "
        />
      </v-row>
    </v-app-bar>

    <v-content>
      <v-container class>
        <v-row justify="center" align="center">
          <router-view></router-view>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  props: {
    source: String,
  },
  data: () => ({
    drawer: null,
    items: [
      { icon: "account", text: "Users", action: "users" },
      { icon: "post-outline", text: "Posts", action: "admin/posts" },
      { icon: "circle-edit-outline", text: "Pages", action: "admin/pages" },
      {
        icon: "briefcase-edit-outline",
        text: "Categories",
        action: "categories",
      },
      { icon: "account-badge-outline", text: "Roles", action: "rules" },
      { icon: "account", text: "Account", action: "Account" },
    ],
    items2: [
      { picture: 28, text: "Nitesh" },
      { picture: 38, text: "Iqval" },
      { picture: 48, text: "Naeem" },
      { picture: 28, text: "Nitesh" },
      { picture: 38, text: "Iqval" },
      { picture: 48, text: "Naeem" },
    ],
  }),
  methods: {
    logout: function () {
      localStorage.removeItem("token");
      this.$router
        .push("/login")
        .then((res) => console.log("You are logout"))
        .catch((err) => console.log("error"));
    },
  },
  created() {
    this.$vuetify.theme.dark = true;
  },
};
</script>

<style scoped>
</style>