<template>
	<div class="overflow-auto">
        <ResearchDesigned @data-sent="fetchData"></ResearchDesigned>
        <mdb-card-footer class="white d-flex justify-content-end">
        </mdb-card-footer> 
        <section  v-if="errored">
            <p>Nous sommes désolés, nous ne sommes pas en mesure de récupérer ces informations pour le moment. Veuillez réessayer ultérieurement.</p>
        </section>
        <section  v-else class="site-inner">
            <div v-if="loading">    
                <mdb-btn color="primary" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Chargement...
                </mdb-btn>
            </div>
            <b-row id="nb_results" class="z-depth-1">
                <b-col cols="8" class="detail-result">
                    <span>{{ totalResults }} résultats correspondent à votre recherche </span>
                    <li v-for="(value, name) in payload" :key="value">
                        {{ name }}: {{ value }}
                    </li>
                </b-col>
                <b-col cols="4">
                    <mdb-btn gradient="amy-crisp" class="black-text" icon="search" @click="resetResearch" rounded>Nouvelle recherche</mdb-btn>
                </b-col>
            </b-row>
            <div class="block-results"> 
                <div fluid class="side-bar">
                    Professionnels: {{ totalResults }}
                </div>
                <div fluid class="results">
                    <b-pagination
                    v-model="currentPage"
                    :total-rows="totalResults"
                    :per-page="perPage"
                    ></b-pagination>
                    <div v-for="healthWorker in healthWorkers" :key="healthWorker.id">
                        <div fluid class="displayResults z-depth-1">
                            <h2> <mdb-icon icon="user-md" size="lg" /> {{ healthWorker.nom_professionnel }}</h2>
                            <p class="ignore-css"> <mdb-icon icon="phone-alt" size="lg" /> {{ healthWorker.telephone }}</p>
                            <p class="ignore-css"> <mdb-icon icon="map-marker-alt" size="lg" /> {{ healthWorker.adresse }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
	</div>
</template>

<script>
import axios from 'axios';
import ResearchDesigned from '../components/ResearchDesigned';
import {
        mdbBtn,
        mdbCardFooter,
        mdbIcon
    } from "mdbvue";
export default {
    name: "ResearchWorkers",
    components: {
        ResearchDesigned,
        mdbBtn,
        mdbCardFooter,
        mdbIcon
    },
	props: {
        msg: String
    },
	data() {
		return {
            info: null,
            loading: false,
            errored: false,
            healthWorkers: [],
            totalPages: 0,
            totalResults: 0,
            currentPage: 1,
            perPage: 20,
            commune: '',
            civilite: '',
            profession: '',
            page: 1,
            payload: null
		}
    },
    computed: {
    },
    methods : {
        resetResearch(){
            this.healthWorkers = [];
            this.totalPages = 0;
            this.totalResults = 0;
        },
        fetchData(payload){
            console.log('payloads: '+payload.commune+' '+payload.civilite+' '+payload.profession+' '+payload.nom_professionnel+' '+this.currentPage);
            this.loading = true;
            this.errored = false;
            this.payload = payload;
            console.log('page '+this.page);
            if (this.payload.newRequest === true){
                console.log('Nouvelle requete - '+this.payload.newRequest);
                this.totalPages = 0;
                this.page = 1;
                this.getHealthWorkersByFilters();
                this.currentPage = 1;
                this.payload.newRequest = false;
            } 
            else {
                this.getHealthWorkersByFilters();
            }
        },
        getHealthWorkersByFilters(){
            console.log('page ici'+this.page);
            axios
            .get("http://localhost/annuairesante/backend/index.php", { params: {
                route: 'filters',
                commune: this.payload.commune,
                civilite: this.payload.civilite,
                profession: this.payload.profession,
                nom_professionnel: this.payload.nom_professionnel,
                page: this.page,
                totalPages: this.totalPages
                }}
            )
            .then( response => {
                this.healthWorkers = response.data.datas.healthworkers;
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
    created: function(){
    },
    watch: {
        currentPage: function(){
            console.log('New Request on current: '+this.payload.newRequest);
            this.page = this.currentPage;
            if( !(this.payload.newRequest)){
                this.fetchData(this.payload);
            }
        }
    },
    mounted() {
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
    width: 100%;
    color: #000;
    background-color: #e8eaf6;
    text-align: center;
    margin-bottom: 2%;
    border: 3px solid aliceblue;
}
#nb_results li{
    list-style: none;
}
#nb_results span{
    font-weight: normal;
}
.detail-result{
    text-align: left;
    padding-left: 3%;
}
.block-results{
    width: 100%;
    display: flex;
    justify-content: space-between;
}
.side-bar{
    width: 25%;
    background-color: #e8eaf6;
    border: 3px solid aliceblue;
}
.results{
    width: 70%;
}
.displayResults{
    margin: 3% 0 3% 0;
    padding: 3%;
    background-color: #e8eaf6;
    border-radius: 7px;
    height: 175px;
    border: 3px solid aliceblue;
}
.displayResults .fas{
    padding-right: 1%;
}
.displayResults h2{
    font-weight: normal;
    font-size: 1.4em;
    padding-bottom: 3%;
}
.ignore-css{
    font-size: 0.9em;
}
.pagination{
    padding-left: 35% !important;
}
</style>