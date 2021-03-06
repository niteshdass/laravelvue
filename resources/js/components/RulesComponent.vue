<template>
  <v-col>
    <v-data-table
      :headers="headers"
      :items="roles"
      sort-by="calories"
      item-key="name"
      class="elevation-1"
      loading
      loading-text="Loading... Please wait"
    >
      <template v-slot:top>
        <v-btn color="primary" @click="getData">GetUser</v-btn>
        <v-toolbar flat>
          <v-toolbar-title>Roles Management System</v-toolbar-title>

          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">New Item</v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="12">
                      <v-text-field v-model="editedItem.name" label="Roles Name"></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>
  </v-col>
</template>
<script>
export default {
  data: () => ({
    dialog: false,
    dialogDelete: false,
    loading: false,
    headers: [
      {
        text: "#",
        align: "left",
        sortable: false,
        value: "name",
      },
      { text: "Name", value: "name" },
      { text: "Created At", value: "created_at" },
      { text: "Updated At", value: "updated_at" },

      { text: "Actions", value: "actions", sortable: false },
    ],
    roles: [],
    editedIndex: -1,
    editedItem: {
      id: "",
      name: "",
    },
    defaultItem: {
      name: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
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
        .get("/api/roles", {})
        .then((res) => (this.roles = res.data.roles))
        .catch((err) => {
          if (err.response.status === 401) {
            localStorage.removeItem("token");
            this.$router.push("/login");
          }
        });
    },

    getData() {
      console.log("getdata clicked");
      axios
        .get("/api/userlist", {})
        .then((res) => console.log(res.data.users))
        .catch((err) => console.log("error from 156"));
    },

    editItem(item) {
      this.editedIndex = this.roles.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.roles.indexOf(item);
      axios.delete("/api/roles/" + item.id).then((res) => console.log(res));

      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.roles.splice(this.editedIndex, 1);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        console.log("id", this.editedItem.id);
        console.log("name", this.editedItem.name);
        axios
          .put("/api/roles/" + this.editedItem.id, {
            name: this.editedItem.name,
          })
          .then((res) =>
            Object.assign(this.roles[this.editedIndex], res.data.role)
          );
        //;
      } else {
        axios
          .post("/api/roles/create", { name: this.editedItem.name })
          .then((res) => console.log(this.roles.push({ name: res.data.role })));
      }
      this.close();
    },
  },
};
</script>
<style scoped>
</style>