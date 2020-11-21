<template>
    <div class="row justify-content-md-center">
        <div class="col-md-10">
            <div id="content" class="content content-full-width">
                <!-- begin profile -->
                <div class="profile">
                    <div class="profile-header">
                        <!-- BEGIN profile-header-cover -->
                        <div class="profile-header-cover"></div>
                        <!-- END profile-header-cover -->
                        <!-- BEGIN profile-header-content -->
                        <div class="profile-header-content">
                            <!-- BEGIN profile-header-info -->
                            <div class="row">
                                <div class="col-md-12 worker">
                                    <div>
                                        <h4 class="m-t-10 m-b-5">{{ healthworker.nom_professionnel }}</h4>
                                        <p class="m-b-10" > {{ healthworker.profession }} </p>
                                    </div>
                                    <div>
                                        <div v-if="token != null" class="">
                                            <div v-if="ifFavorite >= 1" class="type-1">
                                                <button to="/researchworkers" @click="deleteFromFavorites(healthworker.id)" class="btn btn-1">
                                                <span class="txt">Supprimer des Favoris</span>
                                                <span class="round"><i class="fa fa-chevron-right"></i></span>
                                                </button>
                                            </div>
                                            <div v-if="this.$store.state.userLogged.role_id == 1" class="type-1">
                                                <router-link to="/adminview" class="btn btn-1">
                                                <span class="txt">Panneau administration</span>
                                                <span class="round"><i class="fa fa-chevron-right"></i></span>
                                                </router-link>
                                            </div>
                                        </div>
                                        <div class="type-1">
                                            <router-link to="/researchworkers" class="btn btn-1">
                                            <span class="txt">Retour</span>
                                            <span class="round"><i class="fa fa-chevron-right"></i></span>
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END profile-header-info -->
                        </div>
                        <!-- END profile-header-content -->
                    </div>
                </div>
                <!-- end profile -->
                <!-- begin profile-content -->
                <div class="profile-content">
                    <!-- begin tab-content -->
                    <div class="tab-content p-0">
                        <!-- begin #profile-about tab -->
                        <div class="tab-pane fade in active show" id="profile-about">
                            <!-- begin table -->
                            <div class="table-responsive">
                                <table class="table table-profile">
                                    <tbody>
                                        <tr class="highlight">
                                            <td class="field">Adresse</td>
                                            <td>{{ healthworker.adresse }}</td>
                                        </tr>
                                        <tr class="divider">
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td class="field">Mobile</td>
                                            <td><i class="fa fa-mobile fa-lg m-r-5"></i> {{ healthworker.telephone }}</td>
                                        </tr>
                                        <tr class="divider">
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Profession</td>
                                            <td>{{ healthworker.profession }}</td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Commune</td>
                                            <td>{{ healthworker.commune }}</td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Departement</td>
                                            <td>{{ healthworker.departement }}</td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Region</td>
                                            <td>{{ healthworker.region }}</td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Carte Vitale</td>
                                            <td>{{ healthworker.sesam_vital }}</td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Convention</td>
                                            <td>{{ healthworker.convention_cacs }}</td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Mode exercice</td>
                                            <td>{{ healthworker.mode_exercice }}</td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Nature exercice</td>
                                            <td>{{ healthworker.nature_exercice }}</td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Regroupement</td>
                                            <td>{{ healthworker.regroupement }}</td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Type Acte Realise</td>
                                            <td>{{ healthworker.type_acte_realise }}</td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Acte Technique Realise</td>
                                            <td>{{ healthworker.acte_technique_realise }}</td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Famille Acte Technique Realise</td>
                                            <td>{{ healthworker.famille_acte_technique_realise }}</td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Contact</td>
                                            <td>{{ healthworker.contact }}</td>
                                        </tr> 
                                        <tr class="divider">
                                            <td colspan="2"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Affichage des boutons favoris/note/commentaire selon si on est connecté ou non -->
                            <div v-if="token != null" class="button-interactions">
                                <div v-if="ifRated == 0" class="type-1">
                                    <button id="rate-btn" type="button" class="btn btn-1" data-toggle="modal" data-target="#form-rate">
                                    <span class="txt">Noter <i class="far fa-star"></i></span>
                                    <span class="round"><i class="fa fa-chevron-right"></i></span>
                                    </button>
                                </div>
                                <div class="modal fade" id="form-rate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="text-right cross" data-toggle="modal" data-target="#form-rate"> <i class="fa fa-times mr-2"></i> </div>
                                            <div class="card-body text-center"> <img src=" https://i.imgur.com/d2dKtI7.png" height="100" width="100">
                                                <div class="comment-box text-center">
                                                    <!-- <h4>Add a rate</h4> -->
                                                    <div class="rating"> <input v-model="rating" type="radio" name="rating" value="5" id="5"><label for="5">☆</label> <input v-model="rating" type="radio" name="rating" value="4" id="4"><label for="4">☆</label> <input v-model="rating" type="radio" name="rating" value="3" id="3"><label for="3">☆</label> <input v-model="rating" type="radio" name="rating" value="2" id="2"><label for="2">☆</label> <input v-model="rating" type="radio" name="rating" value="1" id="1"><label for="1">☆</label> </div> 
                                                    <div class="text-center mt-4"> <button class="sendrate px-5" data-toggle="modal" data-target="#form-rate" type="submit" @click="addRate(healthworker.id)" >Valider note<i class="fas fa-long-arrow-alt-right ml-1"></i></button> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="ifFavorite == 0" class="type-1">
                                    <button id="favory-btn" type="button" @click="addFavorite(healthworker.id)" class="btn btn-1">
                                    <span class="txt">Ajouter un favoris <i class="far fa-star"></i></span>
                                    <span class="round"><i class="fa fa-chevron-right"></i></span>
                                    </button>
                                </div>
                                <div class="type-1">
                                    <button id="comment-btn" type="button" class="btn btn-1" data-toggle="modal" data-target="#form">
                                    <span class="txt">Ajouter un commentaire <i class="far fa-comments"></i></span>
                                    <span class="round"><i class="fa fa-chevron-right"></i></span>
                                    </button>
                                    <!-- Fenetre modale pour rajouter un commentaire -->
                                    <AddComment @data-commentSent="addComment"/>
                                </div>
                            </div>
                            <!-- Fin boutons interactions -->
                            <hr>
                            <!-- end table -->
                            <!-- Affichage des commentaires -->
                            <div v-for="commentWorker in commentsOfWorker" :key="commentWorker.id" class="comments-worker">
                                <h5>Commentaires</h5>
                                <div class="media mb-4">
                                    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ commentWorker.pseudo }}</h5>
                                        <div v-html="commentWorker.content"></div>
                                    </div>
                                    <p class="date_comment"> {{ new Date(commentWorker.date_creation).toLocaleDateString("fr-FR", options) }} </p>
                                </div>
                                <!-- Signaler un commentaire si connecté -->
                                <div v-if="token">
                                    <div v-if="commentWorker.flag != 1" class="flag">
                                        <a @click="flagComment(commentWorker.id)" class="nav-link">
                                        <span>Signaler le commentaire</span>
                                        </a>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <!-- end #profile-about tab -->
                    </div>
                    <!-- end tab-content -->
                </div>
                <!-- end profile-content -->
            </div>
        </div>
    </div>
</template>

<script>
import Axios from 'axios';
import AddComment from '../components/AddComment';

export default {
    name: 'workerDetailView',
    components: {
        AddComment
    },
    data(){
        return {
            healthworker: [],
            commentsOfWorker: [],
            addedComment: {},
            deleteFavorite: null,
            rating: null,
            ifFavorite: null,
            ifRated: null,
            id: null,
            favoriteAdded: null,
            rateAdded: null,
            token: localStorage.getItem('token'),
            options : { year: "numeric", month: "long", day: "numeric", hour: "numeric", minute: "numeric" },
            commentFlagged: null
        }
    },
    computed: {
        commented(){
            return this.addedComment;
        }
    },
    methods:{
        /*-- Récupérer les informations du professionnel --*/
        getHealthWorker(){
            Axios
            .get(process.env.VUE_APP_API_URL, { params: {
                route: 'healthworkerById',
                id: localStorage.getItem('healthWorkerId')
                }}
            )
            .then( response => {
                this.healthworker = response.data.healthworker;
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })
            .finally(() => this.loading = false );
        },
        /*-- Récupérer les commentaires liés au professionnel --*/
        getCommentsOfWorker(){
            Axios
            .get(process.env.VUE_APP_API_URL, { params: {
                route: 'workerComments',
                workerId: localStorage.getItem('healthWorkerId')
                }}
            )
            .then( response => {
                this.commentsOfWorker = response.data.commentsOfWorker;
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })
        },
        /*-- Ajouter en favoris de l'utilisateur --*/
        addFavorite(healthworkerId){
            Axios
            .post(process.env.VUE_APP_API_URL, {
                route: "addFavorite",
                userId: this.$store.state.userLogged.id,
                workerId: healthworkerId
            })
            .then( response => {
                this.favoriteAdded = response.data.FavoriteAddeed;
            })  
            .catch(error => {
                console.log(error)
                this.errored = true
            })
        },
        /*-- Supprimer des favoris de l'utilisateur --*/
        deleteFromFavorites(healthworkerId){
            Axios
            .post(process.env.VUE_APP_API_URL, {
                route: "deleteFavorite",
                userId: this.$store.state.userLogged.id,
                workerId: healthworkerId
            })
            .then( response => {
                this.deleteFavorite = response.data.deleteFavorite;
                if (this.deleteFavorite) {
                    this.$router.push('/userprofile');
                }
            })  
            .catch(error => {
                console.log(error)
                this.errored = true
            })
        },
        /*-- Ajouter un commentaire --*/
        addComment(payload){
            Axios
            .post(process.env.VUE_APP_API_URL, {
                route: "addComment",
                userId: this.$store.state.userLogged.id,
                workerId: this.$store.state.healthworkerId,
                comment: payload.textComment,
                rate: payload.rating
            })
            .then( response => {
                this.addedComment = response.data.commentAdded;
                this.commentsOfWorker.push(this.addedComment);
            })  
            .catch(error => {
                console.log(error)
                this.errored = true
            })
        },
        /*-- Ajouter une note au professionnel --*/
        addRate(){
            Axios
            .post(process.env.VUE_APP_API_URL, {
                route: "addRate",
                userId: this.$store.state.userLogged.id,
                workerId: this.$store.state.healthworkerId,
                rate: this.rating
            })
            .then( response => {
                this.rateAdded = response.data.rateAdded;
            })  
            .catch(error => {
                console.log(error)
                this.errored = true
            })
        },
        /*-- Récupérer les préférences d'un utilisateur (note/favoris) pour un professionnel,
            pour ne pas permettre de mettre des notes ou favoris à l'infini.. --*/
        checkUserPreferences(){
            Axios
            .get(process.env.VUE_APP_API_URL, { params: {
                route: 'userPreferences',
                userId: this.$store.state.userLogged.id,
                workerId: localStorage.getItem('healthWorkerId')
                }}
            )
            .then( response => {
                this.ifFavorite = response.data.ifFavorite.ifFavorite;
                this.ifRated = response.data.ifRated.ifRated;
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })
        },
        /*-- Signaler un commentaire --*/
        flagComment(commentId){
            Axios
            .post(process.env.VUE_APP_API_URL, {
                route: "flagComment",
                commentId: commentId
            })
            .then( response => {
                this.commentFlagged = response.data.commentFlag;
            })  
            .catch(error => {
                console.log(error)
                this.errored = true
            })
        }
    },
    beforeMount(){
        this.getHealthWorker();
        this.getCommentsOfWorker();
        let token = localStorage.getItem('token');
        if (token){
            this.checkUserPreferences();
        }
    },
    watch: {
        rateAdded: function(){
            this.checkUserPreferences();
        },
        favoriteAdded: function(){
            this.checkUserPreferences();
        },
        commentFlagged: function(){
            this.getCommentsOfWorker();
        }
    }
}
</script>

<style scoped>
.worker{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.button-interactions{
    display: flex;
    justify-content: space-evenly;
}
#rate-btn{
    background-color: #0D2E62 !important;
}
#favory-btn{
    background-color: #ffc107 !important;
} 
#comment-btn{
    background-color: #dc3545 !important;
}
.type-1{
    margin-top: 1%;
}
.flag{
    display: flex;
    justify-content: flex-end;
    cursor: pointer;
}
.sendrate {
    color: #fff;
    background-color: #ff0000;
    border-color: #ff0000;
    display: inline-block;
    font-weight: 400;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
    padding: .375rem .75rem;
        padding-right: 0.75rem;
        padding-left: 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.sendrate:hover {
    color: #fff;
    background-color: #f50202;
    border-color: #f50202;
} 
.rating {
    display: inline-flex;
    margin-top: -10px;
    flex-direction: row-reverse
}

.rating>input {
    display: none
}

.rating>label {
    position: relative;
    width: 28px;
    font-size: 35px;
    color: #ff0000;
    cursor: pointer
}

.rating>label::before {
    content: "\2605";
    position: absolute;
    opacity: 0
}

.rating>label:hover:before,
.rating>label:hover~label:before {
    opacity: 1 !important
}

.rating>input:checked~label:before {
    opacity: 1
}

.rating:hover>input:checked~label:before {
    opacity: 0.4
}                            
</style>