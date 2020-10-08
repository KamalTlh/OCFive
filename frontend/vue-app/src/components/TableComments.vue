<template>
    <div class="row">
        <div class="col-8">
            <h5 class="alertUpdate"> {{ this.$session.get('userUpdated') }}</h5>
            <b-pagination v-model="currentPage" :total-rows="totalResults" :per-page="perPage" aria-controls="my-table">
            </b-pagination>
            <table data-toggle="table" data-search="true" data-show-columns="true"
                class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th data-sortable="true" data-field="id">ID</th>
                        <th data-sortable="true" data-field="email">Commentaire</th>
                        <th data-sortable="true" data-field="date_creation">Date de Création</th>
                        <th data-sortable="true" data-field="role_id">Signalement</th>
                        <th data-sortable="true" data-field="role_id">ID Utilisateur</th>
                        <th data-sortable="true" data-field="pseudo">ID Médecin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody v-for="comment in comments" :key="comment.id">
                    <tr>
                        <td>{{ comment.id }}</td>
                        <td>{{ comment.content }}</td>
                        <td>{{ comment.date_creation }}</td>
                        <td>{{ comment.flag }}</td>
                        <td>{{ comment.userId }}</td>
                        <td>{{ comment.workerId }}</td>
                        <td>
                            <a class="btn btn-primary"><i class="icon_plus_alt2">Ajouter</i></a>
                            <a class="btn btn-primary" ><i class="icon_plus_alt2">V</i></a>
                            <a class="btn btn-success" ><i class="icon_check_alt2">Modifier</i></a>
                            <a class="btn btn-danger" @click="deleteComment(comment.id)"><i
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
    name: "TableComments",
    data() {
      return {
        loading: false,
        errored: false,
        isDelete: false,
        comments: [],
        totalPages: 0,
        totalResults: 0,
        currentPage: 1,
        perPage: 20,
        page: 1,
      }
    },
    methods: {
        deleteComment(commentId){
            Axios
            .post("http://localhost/annuairesante/backend/index.php", { 
                route: 'deleteComment',
                id: commentId
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
        getComments(){
            Axios
            .get("http://localhost/annuairesante/backend/index.php", { params: {
                route: 'comments',
                userLoggedRole: this.$store.state.userLogged.role_id,
                page: this.page,
                totalPages: this.totalPages
                }}
            )
            .then( response => {
                this.comments = response.data.comments;
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
        }
    },
    mounted (){
      this.getComments();
    },
    watch: {
      isDelete: function(){
        if (this.isDelete === true){
          this.getComments();
          this.isDelete = false;
        }
      },
      currentPage: function(){
        this.page = this.currentPage;
          this.getComments();
      }
    },
  }
</script>

<style>
</style>