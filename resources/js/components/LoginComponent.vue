<template>
  <v-app id="inspire">
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
              <v-toolbar color="info" dark flat>
                <v-toolbar-title>Login Form</v-toolbar-title>
                <v-spacer />
              </v-toolbar>

              <v-card-text>
                <v-progress-linear
                  :active="loading"
                  :indeterminate="loading"
                  absolute
                  bottom
                  color="deep-purple accent-4"
                ></v-progress-linear>
                <v-form ref="form" v-model="valid" :lazy-validation="lazy">
                  <v-text-field
                    v-model="email"
                    label="Login"
                    name="login"
                    prepend-icon="mdi-account-circle-outline"
                    type="text"
                    required
                    :rules="emailRules"
                  />
                  <v-text-field
                    v-model="password"
                    label="Password"
                    name="password"
                    prepend-icon="mdi-lock"
                    type="password"
                    required
                  />
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer />
                <v-btn :disabled="!valid" color="info" @click="Login">Login</v-btn>
              </v-card-actions>
            </v-card>
            <v-snackbar v-model="snackbar">
              {{ text }}
              <template v-slot:action="{ attrs }">
                <v-btn color="pink" text v-bind="attrs" @click="snackbar = false">Close</v-btn>
              </template>
            </v-snackbar>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      loading: false,
      snackbar: false,
      text: "",
    };
  },
  methods: {
    Login: function () {
      console.log(this.email);
      console.log(this.password);
      axios.interceptors.request.use(
        (config) => {
          this.loading = true;
          return config;
        },
        (error) => {
          this.loading = false;
          return Promise.reject(error);
        }
      );

      axios.interceptors.response.use(
        (response) => {
          this.loading = false;

          return response;
        },
        (error) => {
          this.loading = false;
          return Promise.reject(error);
        }
      );

      axios
        .post("/api/login", { email: this.email, password: this.password })
        .then((res) => {
          console.log(res);
          // this.snackbar = true;
          // this.text = err.response.token;
          localStorage.setItem("token", res.data.token);
          this.$router
            .push("/admin")
            .then((res) => console.log("You are logged in"))
            .catch((err) => console.log("error"));
        })
        .catch((err) => {
          this.loading = false;
          this.snackbar = true;
          this.text = err.response.data.status;
          console.dir(err);
        });
    },
  },
};
</script>

<style scoped></style>
