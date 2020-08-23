<template>
    <div class="row">
        <div class="col-8">
            <b-pagination v-model="currentPage" :total-rows="totalResults" :per-page="perPage" aria-controls="my-table">
            </b-pagination>
            <table data-toggle="table" data-search="true" data-show-columns="true"
                class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th data-sortable="true" data-field="id">ID</th>
                        <th data-sortable="true" data-field="pseudo">Pseudo</th>
                        <th data-sortable="true" data-field="email">Email</th>
                        <th data-sortable="true" data-field="date_creation">Date de Création</th>
                        <th data-sortable="true" data-field="role_id">Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody v-for="user in users" :key="user.id">
                    <tr>
                        <td>{{ user.id }}</td>
                        <td>{{ user.pseudo }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.date_creation }}</td>
                        <td v-if="user.role_id == 2">User</td>
                        <td v-else>Administrateur</td>
                        <td>
                            <a class="btn btn-primary"><i class="icon_plus_alt2">Ajouter</i></a>
                            <a class="btn btn-primary" @click="checkUser(user)"><i class="icon_plus_alt2">V</i></a>
                            <a class="btn btn-success"><i class="icon_check_alt2">Modifier</i></a>
                            <a class="btn btn-danger" @click="deleteUser(user.id)"><i
                                    class="icon_close_alt2">Suppprimer</i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import Axios from 'axios';
  export default {
    name: "TableUsers",
    data() {
      return {
        loading: false,
        errored: false,
        isDelete: false,
        users: [],
        totalPages: 0,
        totalResults: 0,
        currentPage: 1,
        perPage: 20,
        page: 1,
      }
    },
    methods: {
      deleteUser(id){
          Axios
            .post("http://localhost/annuairesante/backend/index.php", { 
                route: 'deleteUser',
                id: id
                }
            )
            .then( response => {
                this.isDelete = response.data.isDelete;
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })
            .finally(() => this.loading = false );
      },
      getUsers(){
          Axios
          .get("http://localhost/annuairesante/backend/index.php", { params: {
              route: 'users',
              page: this.page,
              totalPages: this.totalPages
              }}
          )
          .then( response => {
              this.users = response.data.datas.users;
              if(this.totalPages == 0){
                  this.totalResults = response.data.page.totalResults;
                  this.totalPages = response.data.page.totalPages;
              }
          })
          .catch(error => {
              console.log(error)
              this.errored = true
          })
          .finally(() => this.loading = false );
      },
      checkUser(user){
        this.$store.commit("changeUser", user);
        this.$router.push({ path: '/userprofile' });
      }
    },
    mounted (){
      this.getUsers();
    },
    watch: {
      isDelete: function(){
        if (this.isDelete === true){
          this.getUsers();
          this.isDelete = false;
        }
      },
      currentPage: function(){
        this.page = this.currentPage;
          this.getUsers();
      }
    },
  }
</script>

<style>
</style>