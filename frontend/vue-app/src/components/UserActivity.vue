<template>
    <div class="tab-pane" id="profile-activity">
        <div  class="col-md-12">
            <div class="row gutters-sm">
                <!-- Début bloc liste de professionnels ajouter en favoris -->
                <div class="col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="d-flex align-items-center mb-3"><i
                                    class="material-icons text-info mr-2">Liste Favoris</i></h6>
                            <div class="favory" v-for="favorite in favorites" :key="favorite.id">
                                <small @click="viewWorkerDetail(favorite.workerId)"> {{ favorite.nom_professionnel }} </small>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin bloc favoris -->
                <!-- Début bloc liste de commentaires postés -->
                <div class="col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="d-flex align-items-center mb-3"><i
                                    class="material-icons text-info mr-2">Commentaires postés</i></h6>
                            <div @click="viewWorkerDetail(comment.workerId)" class="commentary" v-for="comment in comments" :key="comment.id">
                                <small class="commentarycontent" v-html="comment.content">...</small><br>
                                <small class="datecomment"> {{ new Date(comment.date_creation).toLocaleDateString("fr-FR", options) }} </small>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin bloc commentaires postés -->
            </div>
        </div>
    </div>
    <!-- end #profile-activity tab -->
</template>

<script>
import Axios from 'axios';
export default {
    name: 'UserActivity',
    data(){
        return {
            favorites: [],
            comments: [],
            options : { year: "numeric", month: "long", day: "numeric", hour: "numeric", minute: "numeric" }
        }
    },
    computed: {
        userLogged(){
            return this.$store.state.user.id;
        }
    },
    methods:{
        /*-- Récupération des professionnels ajouter en favoris par l'utilisateur --*/
        getFavoritesOfUser(){
            Axios
            .get(process.env.VUE_APP_API_URL, { params: {
                route: 'userFavorites',        
                userId: this.$store.state.user.id
                }}
            )
            .then( response => {
                if(response.status == 200){
                    this.favorites = response.data.favoritesOfUser;
                }
                else {
                    console.log('il y a erreur');
                }
            })  
            .catch(error => {
                console.log(error.response.data);
                this.errored = true
            })
        },
        /*-- Récupération des commentaires postés par l'utilisateur --*/
        getCommentsOfUser(){
            Axios
            .get(process.env.VUE_APP_API_URL, { params: {
                route: 'userComments',        
                userId: this.$store.state.user.id
                }}
            )
            .then( response => {
                this.comments = response.data.commentsOfUser;
            })  
            .catch(error => {
                console.log(error)
                this.errored = true
            })
        },
        /*-- Afficher page de profil du professionnel --*/
        viewWorkerDetail(workerId){
            localStorage.setItem('healthWorkerId', workerId);
            this.$store.commit("changeWorker", workerId);
            this.$router.push({ path: '/workerdetailview' });
        }
    },
    mounted(){
        if (this.$store.state.sessionConnected){
            this.getFavoritesOfUser();
            this.getCommentsOfUser();
        }
    },
    watch: {
        userLogged: function(){
            this.getFavoritesOfUser();
        }
    }
}
</script>

<style scoped>
.favory:hover, .commentary:hover{
    color: #2962ff;
    cursor: pointer;
}
.datecomment{
    display: flex;
    justify-content: center;
}
.commentarycontent{
    display: flex;
    justify-content: left;
}
</style>