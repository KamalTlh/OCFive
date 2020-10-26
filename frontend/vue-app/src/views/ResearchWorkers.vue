<template>
	<section class="page">
        <ResearchDesigned @data-sent="fetchData"></ResearchDesigned>
        <LeafleatMap ref="map"></LeafleatMap>
        <div v-if="showContent">
            <div class="loading" v-if="loading">
                    <mdb-btn color="primary" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Chargement...
                    </mdb-btn>
            </div>
            <div >
                <section  v-if="errored">
                    <p>Nous sommes désolés, nous ne sommes pas en mesure de récupérer ces informations pour le moment. Veuillez réessayer ultérieurement.</p>
                </section>
                <section  v-else class="container-lg">
                    <div id="nb_results" class="row">
                        <b-col cols="8" class="detail-result">
                            <p>{{ totalResults }} résultats correspondent à votre recherche </p>
                        </b-col>
                        <b-col cols="4">
                            <div class="type-1">
                                <button type="button" @click="resetResearch" class="btn btn-1">
                                <span class="txt">Nouvelle recherche</span>
                                <span class="round"><i class="fa fa-chevron-right"></i></span>
                                </button>
                            </div>
                        </b-col>
                    </div>
                    <div ref="researchResults" class="row">
                        <div class="col-12">
                            <b-pagination
                            v-model="currentPage"
                            :total-rows="totalResults"
                            :per-page="perPage"
                            ></b-pagination>
                            <div v-for="healthWorker in healthWorkers" :key="healthWorker.id">
                                <div class="displayResults z-depth-1">
                                    <div class="row sm-item-header">
                                        <div class="col-8 header-name-rate"> 
                                            <div class="name-worker">
                                                <span><mdb-icon icon="user-md" size="lg"/> {{ healthWorker.nom_professionnel }}</span>
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
                                        <div class="col-4">
                                            <div class="type-1">
                                                <button type="button" @click="seeCommentsOfWorker(healthWorker.id)" class="btn btn-1 seemore">
                                                <span class="txt">Voir tout les commentaires ({{healthWorker.nb_comments}})</span>
                                                <span class="round seemoreround"><i class="fa fa-chevron-right"></i></span>
                                                </button>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
	</section>
</template>

<script>
import Axios from 'axios';
import ResearchDesigned from '../components/ResearchDesigned';
import LeafleatMap from '../components/LeafleatMap';

import {
        mdbBtn,
        mdbIcon
    } from "mdbvue";
export default {
    name: "ResearchWorkers",
    components: {
        ResearchDesigned,
        LeafleatMap,
        mdbBtn,
        mdbIcon
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
        resetResearch(){
            this.healthWorkers = [];
            this.totalPages = 0;
            this.totalResults = 0;
            this.$refs.map.clearLayersOfResearch();
            this.showContent = false;            
        },
        fetchData(payload){
            this.showContent = true;
            this.errored = false;
            this.dataResearch = payload;
            if (this.dataResearch.newRequest === true){
                this.$refs.map.clearLayersOfResearch();
                this.loading = true;
                this.totalPages = 0;
                this.page = 1;
                this.getHealthWorkersByFilters();
                this.currentPage = 1;
            } 
            else {
                this.$refs.map.clearLayersOfResearch();
                this.getHealthWorkersByFilters();
            }
        },
        getHealthWorkersByFilters(){
            Axios
            .get("http://localhost/annuairesante/backend/index.php", { params: {
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
                if (response.data.errorData){
                    console.log('Veuillez renseigner des données avant de lancer la recherche.');
                }
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
                    this.$refs.researchResults.scrollIntoView();
                }
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })
            .finally(() => this.loading = false );
        },
        seeCommentsOfWorker(healthWorkerId){
            localStorage.setItem('healthWorkerId', healthWorkerId);
            this.$store.commit("changeWorker", healthWorkerId);
            this.$router.push({ path: '/workerdetailview' });
        }
    },
    watch: {
        currentPage: function(){
            this.page = this.currentPage;
            if( !(this.dataResearch.newRequest)){
                this.fetchData(this.dataResearch);
            }
        }
    }
}
</script>

<style>
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
.displayResults{
    margin: 3% 0 3% 0;
    color: inherit;
}
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
    color: #fff;
    padding: 1.5rem 0rem 1.5rem;
    align-items: center;
}
.sm-item-header .header-name-rate{
    display: flex;
    align-items: center;  
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
    height: 40px;
    background-color: #0c2050;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
}
.sm-item-header .rate-worker{
    color: orange;
}

/*--btn comments--*/
.type-1 .seemore {
    background-color: #b39800  !important;
}
.type-1 .seemore {
    padding: 7px 55px 7px 55px !important;
    text-transform: initial !important;
    font-weight: normal !important;
}
.type-1 button .seemoreround {
    width: 32px;
    height: 32px !important;
}
/*---*/

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

/*--Anchor scroll--*/
#anchor {
    position: absolute;
    top: 0;
}
.invisible-toolbar {
    display: flex;
    bottom: 20px;
    flex-direction: column-reverse;
    padding: 0;
    position: fixed;
    right: 50px;
    text-align: center;
    width: 40px;
    z-index: 10;
}
#scroll-top {
    background-color: #1000C1;
    display: block;
    text-align: center;
}
.action-link {
    height: 80px;
    width: 80px;
    background-color: #2962FF;
    border-radius: 50%;
    cursor: pointer;
    margin-top: 5px;
    transition: box-shadow 0.5s ease-out;
    -webkit-box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14),0 1px 10px 0 rgba(0,0,0,0.12),0 2px 4px -1px rgba(0,0,0,0.3);
    box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14),0 1px 10px 0 rgba(0,0,0,0.12),0 2px 4px -1px rgba(0,0,0,0.3);
}
.action-link:hover {
    -webkit-box-shadow: 0 24px 38px 3px rgba(0,0,0,0.14),0 9px 46px 8px rgba(0,0,0,0.12),0 11px 15px -7px rgba(0,0,0,0.2);
    box-shadow: 0 24px 38px 3px rgba(0,0,0,0.14),0 9px 46px 8px rgba(0,0,0,0.12),0 11px 15px -7px rgba(0,0,0,0.2);
}
.action-link#scroll-top i {
    font-size: 2.5rem;
    margin: 1.25rem;
}
#scroll-top i {
    color: #536DFE;
    font-size: 20px;
    line-height: 1;
    margin: 10px;
}
.action-link i {
    color: #fff;
    line-height: 40px;
    font-size: 1.25rem;
    text-align: center;
}
/*--*/
</style>