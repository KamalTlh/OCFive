<template>
  <div class="container-fluid">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Utilisateurs</h6>
      </div>
      <div class="card-body">
          <h5 class="alertUpdate">
          <button class="btn btn-primary" alt="Créer un utilisateur" @click="createUser">Créer un utilisateur <i
              class="fas fa-plus-circle"></i></button>
        </h5>
        <!-- Pagination du tableau -->
        <b-pagination v-model="currentPage" :total-rows="totalResults" :per-page="perPage" aria-controls="my-table">
        </b-pagination>

        <!-- Tableau administration des commentaires -->
        <div class="table-responsive">
          <table class="table table-bordered table-hover" role="grid" aria-discribedby="dataTable_info" id="dataTable"
            width="100%" cellspacing="0">
            <thead>
              <tr>
                <th data-sortable="true" data-field="id">ID</th>
                <th data-sortable="true" data-field="pseudo">Pseudo</th>
                <th data-sortable="true" data-field="email">Email</th>
                <th data-sortable="true" data-field="date_creation">Date de Création</th>
                <th data-sortable="true" data-field="role_id">Rôle</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th data-sortable="true" data-field="id">ID</th>
                <th data-sortable="true" data-field="pseudo">Pseudo</th>
                <th data-sortable="true" data-field="email">Email</th>
                <th data-sortable="true" data-field="date_creation">Date de Création</th>
                <th data-sortable="true" data-field="role_id">Rôle</th>
                <th>Actions</th>
              </tr>
            </tfoot>
            <tbody v-for="user in users" :key="user.id">
              <tr>
                <td>{{ user.id }}</td>
                <td>{{ user.pseudo }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.date_creation }}</td>
                <td v-if="user.role_id == 2">User</td>
                <td v-else>Administrateur</td>
                <!-- Boutons administration -->
                <td class="actions">
                  <a class="btn btn-primary" @click="checkUser(user)"><i class="fas fa-eye"></i></a>
                  <a class="btn btn-success" @click="updateUser(user)"><i class="fas fa-edit"></i></a>
                  <a class="btn btn-danger" @click="deleteUser(user.id)"><i class="fas fa-trash-alt"></i></a>
                </td>
                <!-- Fin boutons administration -->
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from 'axios';
 import VueCookies from 'vue-cookies';
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
      /*-- Récupération des utilisateurs --*/
      getUsers(){
          Axios
          .get(process.env.VUE_APP_API_URL, { params: {
              route: 'users',
              userLoggedRole: this.$store.state.userLogged.role_id,
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
      /*-- Créer un utilisateur --*/
      createUser(){
        VueCookies.set("previousUrl", window.location.pathname, "60s");
        this.$router.push({ path: '/register' });
      },
      /*-- Voir le profil d'un utilisateur --*/
      checkUser(user){
        this.$store.commit("changeUser", user);
        this.$router.push({ path: '/userprofile' });
      },
      /*-- Modifier un utilisateur --*/
      updateUser(user){
        VueCookies.set("previousUrl", window.location.pathname, "60s");
        this.$store.commit("changeUser", user);
        this.$router.push({ path: '/UserUpdate' });
      },
      /*-- Supprimer un utilisateur --*/
      deleteUser(id){
          Axios
            .post(process.env.VUE_APP_API_URL, { 
                route: 'deleteUser',
                userLoggedPseudo: this.$store.state.userLogged.pseudo,
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
      }
    },
    watch: {
      /*-- A chaque supression d'un utilisateur on reload le tableau des utilisateurs --*/
      isDelete: function(){
        if (this.isDelete === true){
          this.$store.commit('needRefresh', this.isDelete );
          this.getUsers();
          this.isDelete = false;
        }
      },
      /*-- A chaque changement de page on reload la nouvelle page des utilisateurs --*/
      currentPage: function(){
        this.page = this.currentPage;
          this.getUsers();
      }
    },
  }
</script>

<style>
</style>