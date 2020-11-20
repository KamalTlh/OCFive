<template>
	<section class="page">
        <!-- Récupération des éléments de la recherche -->
        <ResearchDesigned @data-sent="fetchData"></ResearchDesigned>
        <!-- Affichage de la carte -->
        <LeafleatMap ref="map"></LeafleatMap>
        <div v-if="showContent">
            <div class="loading" v-if="loading">
                    <button color="primary" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Chargement...
                    </button>
            </div>
            <div >
                <!-- Si aucuns résultats retournés -->
                <section  v-if="errored">
                    <p>Nous sommes désolés, nous ne sommes pas en mesure de récupérer ces informations pour le moment. Veuillez réessayer ultérieurement.</p>
                </section>
                <!-- Début affichage des résultats -->
                <section ref="researchResults" v-else class="container-lg">
                    <div id="nb_results" class="row">
                        <div class="detail-result">
                            <p>{{ totalResults }} résultats correspondent à votre recherche </p>
                        </div>
                        <div>
                            <div class="type-1">
                                <button type="button" @click="resetResearch" class="btn btn-1">
                                <span class="txt">Nouvelle recherche</span>
                                <span class="round"><i class="fa fa-chevron-right"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <b-pagination
                            v-model="currentPage"
                            :total-rows="totalResults"
                            :per-page="perPage"
                            ></b-pagination>
                            <div class="container displayResults z-depth-1" v-for="healthWorker in healthWorkers" :key="healthWorker.id">
                                <div class="row sm-item-header">
                                    <div class="col header-name-rate"> 
                                        <div class="name-worker">
                                            <span><i class="fas fa-user-md"></i> {{ healthWorker.nom_professionnel }}</span>
                                        </div>
                                        <div class="rate-worker">
                                            <i v-if="healthWorker.note >= 1" class="fas fa-star"></i> <i v-else class="far fa-star"></i>
                                            <i v-if="healthWorker.note >= 2" class="fas fa-star"></i> <i v-else class="far fa-star"></i>
                                            <i v-if="healthWorker.note >= 3" class="fas fa-star"></i> <i v-else class="far fa-star"></i>
                                            <i v-if="healthWorker.note >= 4" class="fas fa-star"></i> <i v-else class="far fa-star"></i>
                                            <i v-if="healthWorker.note >= 5" class="fas fa-star"></i> <i v-else class="far fa-star"></i>
                                            <span>({{healthWorker.nb_notes}})</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sm-item-body">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div>
                                                <label>Tél: </label> <span> {{ healthWorker.telephone }}</span>
                                            </div>
                                            <div>
                                                <label>Adresse: </label> <span> {{ healthWorker.adresse }}</span>
                                            </div>
                                            <div>
                                                <label>Commune: </label> <span> {{ healthWorker.commune }}</span>
                                            </div>
                                            <div>
                                                <label>Région: </label> <span> {{ healthWorker.region }}</span>
                                            </div>
                                            <div>
                                                <label>Statut: </label> <span> {{ healthWorker.nature_exercice }}</span>
                                            </div>
                                            <div>
                                                <label>Mode d'exerice particulier: </label> <span> {{ healthWorker.mode_exercice }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div>
                                                <label>Profession: </label> <span> {{ healthWorker.profession }}</span>
                                            </div>
                                            <div>
                                                <label>Regroupement: </label> <span> {{ healthWorker.regroupement }}</span>
                                            </div>
                                            <div>
                                                <label>Type Acte: </label> <span> {{ healthWorker.type_acte_realise }}</span>
                                            </div>
                                            <div>
                                                <label>Carte vitale: </label> <span> {{ healthWorker.sesam_vital }}</span>
                                            </div>
                                            <div>
                                                <label>Convention: </label> <span> {{ healthWorker.convention_cacs }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sm-item-footer">
                                    <div class="type-1">
                                        <button type="button" @click="seeCommentsOfWorker(healthWorker.id)" class="btn btn-1">
                                        <span class="txt">commentaires ({{healthWorker.nb_comments}})</span>
                                        <span class="round"><i class="fa fa-chevron-right"></i></span>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Fin affichage des résultats -->
            </div>
        </div>
	</section>
</template>

<script>
import Axios from 'axios';
import ResearchDesigned from '../components/ResearchDesigned';
import LeafleatMap from '../components/LeafleatMap';

export default {
    name: "ResearchWorkers",
    components: {
        ResearchDesigned,
        LeafleatMap
    },
	data() {
		return {
            loading: null,
            errored: false,
            healthWorkers: [],
            markers: [],
            totalPages: 0,
            totalResults: 0,
            currentPage: 1,
            perPage: 20,
            page: 1,
            payload: null,
            dataResearch: null,
            favoriteAdded: null,
            showContent: false,
            workerId: null,
            nb_comments: null
		}
    },
    methods : {
        /*-- Supprimer les résultats afficher sur la page et la carte et relancer une nouvelle recherche --*/
        resetResearch(){
            window.location.reload();
            window.scroll(0,0);    
        },
        /*-- Récupérer les résultats de la recherche avec les éléments renseignés --*/
        fetchData(payload){
            this.showContent = true;
            this.errored = false;
            this.dataResearch = payload;
            /*-- Si c'est une nouvelle recherche on effectue une recherche qui récupérera le total des résultats
                pour effectuer notre pagination --*/
            if (this.dataResearch.newRequest === true){
                this.$refs.map.clearLayersOfResearch();
                this.loading = true;
                this.totalPages = 0;
                this.page = 1;
                this.getHealthWorkersByFilters();
                this.currentPage = 1;
            } 
            /*-- sinon on envoi une recherche simple qui renvoie les résultats par page --*/
            else {
                this.$refs.map.clearLayersOfResearch();
                this.getHealthWorkersByFilters();
            }
        },
        /*-- Récupération des résultats avec les filtres de recherche --*/
        getHealthWorkersByFilters(){
            Axios
            .get(process.env.VUE_APP_API_URL, { params: {
                route: 'filters',
                commune: this.dataResearch.commune,
                civilite: this.dataResearch.selected_civilite,
                profession: this.dataResearch.selected_profession,
                nom_professionnel: this.dataResearch.nom_professionnel,
                prenom_professionnel: this.dataResearch.prenom_professionnel,
                regroupement: this.dataResearch.selected_groupement,
                nature_exercice: this.dataResearch.selected_status,
                mode_exercice: this.dataResearch.selected_mode_exercice,
                region: this.dataResearch.selected_region,
                departement: this.dataResearch.selected_departement,
                page: this.page,
                totalPages: this.totalPages
                }}
            )
            .then( response => {
                /*-- Vérification qu'au moins un champ de recherche est renseigné --*/
                if (response.data.errorData){
                    console.log('Veuillez renseigner des données avant de lancer la recherche.');
                }
                /*--*/
                else {
                    this.healthWorkers = response.data.datas.healthworkers;
                    this.markers = response.data.datas.coordinates;
                    this.$store.commit("setMarkers", this.markers);
                    if (this.dataResearch.newRequest === true){
                        this.dataResearch.newRequest = false;
                    }
                    if(this.totalPages == 0){
                        this.totalResults = response.data.page.totalResults;
                        this.totalPages = response.data.page.totalPages;
                    }
                    this.$refs.researchResults.scrollIntoView({
                        block: 'start',
                        behavior: 'smooth',
                        inline: 'nearest'
                    });
                }
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })
            .finally(() => this.loading = false );
        },
        /*-- Aller à la page de profil du professionnel pour voir les commentaires --*/
        seeCommentsOfWorker(healthWorkerId){
            localStorage.setItem('healthWorkerId', healthWorkerId);
            this.$store.commit("changeWorker", healthWorkerId);
            this.$router.push({ path: '/workerdetailview' });
        }
    },
    watch: {
        /*-- A chaque changement de page on effectue un appel Axios pour retourner les résultats selon la page --*/
        currentPage: function(){
            this.page = this.currentPage;
            if( !(this.dataResearch.newRequest)){
                this.fetchData(this.dataResearch);
            }
        }
    }
}
</script>

<style scoped>
.site-inner{
    width: 979px;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0 auto;
}
#nb_results{
    align-items: baseline;
    background-color: #e8eaf6;
    text-align: center;
    margin-bottom: 2%;
    border: 3px solid aliceblue;
    display: flex;
    justify-content: space-between;
}
.detail-result{
    font-weight: bold;
    text-align: left;
    padding-left: 3%;
}
.block-results{
    width: 100%;
    display: flex;
    justify-content: space-between;
}
/*-- Design Results --*/
.displayResults h2{
    font-weight: normal;
    font-size: 1.4em;
    padding-bottom: 3%;
}
.ignore-css{
    font-size: 0.9em;
}
.sm-item-header{
    background-color: #0c2050;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    color: #fff;
    padding: 1.5rem 0rem 1.5rem;
    align-items: center;
}
.sm-item-header .header-name-rate{
    display: flex;
    align-items: center; 
    justify-content: space-between;
}
.sm-item-header .name-worker{
    padding-right: 2%;
    font-size: 18px;
}
.sm-item-header .rate-worker{
    display: flex;
    align-items: center;
}
.sm-item-body {
    border: 1px solid rgba(41,98,255,0.1);
    background-color: #fff;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    padding: 1.5rem;
}
.sm-item-footer {
    height: 4rem;
    background-color: #0c2050;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.sm-item-header .rate-worker{
    color: orange;
}


label {
    display: inline-block;
    margin-bottom: 0.5rem;
    font-weight: bold;
}
.sm-item-body label + span {
    margin-left: 0.4rem;
}
.rate-worker span {
    margin-left: 5%;
}
/*---*/

.pagination{
    justify-content: center;
}

.loading {
    position: absolute;
    left: 45%;
    bottom: 0;
    z-index: 100 !important;
}

/* -- breakpoints mediaqueries -- */
@media all and (max-width: 768px) {
    /* .sm-item-footer .type-1{
        margin-top: 3% !important;
    } */
    .sm-item-footer .txt{
        font-weight: normal !important;
    }
    #nb_results{
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .detail-result{
        text-align: center;
        padding-left: 0;
    }
    .displayResults[data-v-9fad0b60] {
        margin: auto !important;
    }
}
</style>