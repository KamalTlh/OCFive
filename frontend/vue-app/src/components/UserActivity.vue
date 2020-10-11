<template>
    <!-- begin #profile-activity tab -->
    <div class="tab-pane" id="profile-activity">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h5>Listes de médecins favoris</h5>
                    <div v-for="favorite in favorites" :key="favorite.id">
                        <a href="#" @click="viewWorkerDetail(favorite.workerId)"> {{ favorite.nom_professionnel }} </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h5>Commentaires postés</h5>
                    <div v-for="comment in comments" :key="comment.id">
                        <a href="#" @click="viewWorkerDetail(comment.workerId)"> {{ comment.content }} </a>
                    </div>
                </div>
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
            comments: []
        }
    },
    computed: {
        userLogged(){
            return this.$store.state.user.id;
        }
    },
    methods:{
        getFavoritesOfUser(){
            Axios
            .get("http://localhost/annuairesante/backend/index.php", { params: {
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
        getCommentsOfUser(){
            Axios
            .get("http://localhost/annuairesante/backend/index.php", { params: {
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
        viewWorkerDetail(workerId){
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