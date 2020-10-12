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
                        <td>{{ comment.content.substr(0, 40) }} ...</td>
                        <td>{{ comment.date_creation }}</td>
                        <td>{{ comment.flag }}</td>
                        <td>{{ comment.userId }}</td>
                        <td>{{ comment.workerId }}</td>
                        <td class="actions">
                            <!-- <a class="btn btn-primary" alt="Ajouter"><i class="fas fa-plus-circle"></i></a> -->
                            <button @click="showComment(comment.content, comment.id)" type="button" alt="Voir" class="btn btn-primary" data-toggle="modal" data-target="#showComment">
                                <i class="fas fa-eye"></i>
                            </button>
                            <!-- <a class="btn btn-primary" alt="Voir" @click="readComment(comment.id, comment.workerId)" ><i class="fas fa-eye"></i></a> -->
                            <button @click="showComment(comment.content, comment.id)" type="button" class="btn btn-primary" alt="Modifier" data-toggle="modal" data-target="#updateComment">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a class="btn btn-danger" alt="Supprimer" @click="deleteComment(comment.id)"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <ReadComment :commentContent.sync="content" />
                    <UpdateComment :commentContent.sync="content" :commentId.sync="id"/>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import Axios from 'axios';
import ReadComment from '../components/ReadComment';
import UpdateComment from '../components/UpdateComment';

  export default {
    name: "TableComments",
    components:{
        ReadComment,
        UpdateComment
    },
    props: {
        commentContent: String,
        commentId: Number
    },
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
        content: null,
        id: null
      }
    },
    methods: {
        showComment(comment, id){
            this.content = comment;
            this.id = id;
        },
        readComment(commentId, workerId){
            Axios
            .get("http://localhost/annuairesante/backend/index.php", { params: {
                route: 'comments',
                userLoggedRole: this.$store.state.userLogged.role_id,
                id: commentId,
                workerId: workerId
                }}
            )
            .then( response => {
                this.comments = response.data.datas.comments;
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
        deleteComment(commentId){
            Axios
            .post("http://localhost/annuairesante/backend/index.php", { 
                route: 'deleteComment',
                id: commentId
                }
            )
            .then( response => {
                this.isDelete = response.data.commentDeleted;
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
                this.comments = response.data.datas.comments;
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