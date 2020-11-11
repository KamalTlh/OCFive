<template>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Commentaires</h6>
        </div>
        <div class="card-body">
            <h5 class="alertUpdate"> {{ this.$session.get('userUpdated') }}</h5>
            <b-pagination v-model="currentPage" :total-rows="totalResults" :per-page="perPage" aria-controls="my-table">
            </b-pagination>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" role="grid" aria-discribedby="dataTable_info"
                    id="dataTable" width="100%" cellspacing="0">
                    <thead>
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
                    <tfoot>
                        <tr>
                            <th data-sortable="true" data-field="id">ID</th>
                            <th data-sortable="true" data-field="email">Commentaire</th>
                            <th data-sortable="true" data-field="date_creation">Date de Création</th>
                            <th data-sortable="true" data-field="role_id">Signalement</th>
                            <th data-sortable="true" data-field="role_id">ID Utilisateur</th>
                            <th data-sortable="true" data-field="pseudo">ID Médecin</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody v-for="comment in comments" :key="comment.id">
                        <tr>
                            <td>{{ comment.id }}</td>
                            <td>{{ comment.content.substr(0, 40) }} ...</td>
                            <td>{{ comment.date_creation }}</td>
                            <td>{{ comment.flag }}</td>
                            <td>{{ comment.userId }}</td>
                            <td>{{ comment.workerId }}</td>
                            <td class="actions">
                                <button @click="showComment(comment.content, comment.id)" type="button" alt="Voir"
                                    class="btn btn-primary" data-toggle="modal" data-target="#showComment">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button @click="showComment(comment.content, comment.id)" type="button"
                                    class="btn btn-success" alt="Modifier" data-toggle="modal"
                                    data-target="#updateComment">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fas fa-check-square"></i>
                                </button>
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                Etes-vous sûr de vouloir retirer le signalement du commentaire ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="unflagComment(comment.id)">Valider</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-danger" alt="Supprimer" @click="deleteComment(comment.id)">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <ReadComment :commentContent.sync="content" />
                        <UpdateComment :commentContent.sync="content" :commentId.sync="id" />
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
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
            .get("https://apiannuaire.jean-forteroche-dwj.fr/index.php", { params: {
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
            .post("https://apiannuaire.jean-forteroche-dwj.fr/index.php", { 
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
            .get("https://apiannuaire.jean-forteroche-dwj.fr/index.php", { params: {
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
        },
        unflagComment(commentId){
            Axios
            .post("https://apiannuaire.jean-forteroche-dwj.fr/index.php", {
                route: "unflagComment",
                commentId: commentId
            })
            .then( response => {
                this.commentFlagged = response.data.commentFlagged;
                this.getComments();
            })  
            .catch(error => {
                console.log(error)
                this.errored = true
            })
        }
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