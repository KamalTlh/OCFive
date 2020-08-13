<template>
	<div class="overflow-auto">
        <ResearchDesigned @data-sent="getHealthWorkersByFilters"></ResearchDesigned>
        <mdb-card-footer class="white d-flex justify-content-end">
        <mdb-btn gradient="amy-crisp" class="black-text" icon="paper-plane" @click="resetResearch" rounded>Reset</mdb-btn>
        </mdb-card-footer> 
        <section  v-if="errored">
            <p>Nous sommes désolés, nous ne sommes pas en mesure de récupérer ces informations pour le moment. Veuillez réessayer ultérieurement.</p>
        </section>
        <section  v-else>
            <div v-if="loading">Chargement...</div>
            <p class="mt-3">Nombre total de resultats: {{ this.totalResults }}</P>
            <b-pagination
            v-model="currentPage"
            :total-rows="totalResults"
            :per-page="perPage"
            ></b-pagination>
 
            <b-table
            id="my-table"
            size="md"
            :items="healthWorkers"
            :per-page=0
            :current-page="currentPage"
            small
            class="table table-bordered table-responsive-sm"
            ></b-table>
        </section>
	</div>
</template>

<script>
import axios from 'axios';
import ResearchDesigned from '../components/ResearchDesigned';
import {
        mdbBtn,
        mdbCardFooter
    } from "mdbvue";
export default {
    name: "ListeMedecins",
    components: {
        ResearchDesigned,
        mdbBtn,
        mdbCardFooter
    },
	props: {
        msg: String
    },
	data() {
		return {
            info: null,
            loading: true,
            errored: false,
            healthWorkers: [],
            totalPages: 0,
            totalResults: 0,
            currentPage: 1,
            perPage: 20,
            commune: '',
            civilite: '',
            profession: '',
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
        getHealthWorkersByFilters(payload){
            this.errored = false;
            this.payload = payload;
            console.log('New Request: '+this.payload.newRequest);
            if (this.payload.newRequest === true){
                this.totalPages = 0;
                this.currentPage = 1;
            }
            console.log('payloads: '+payload.commune+' '+payload.civilite+' '+payload.profession+' '+payload.nom_professionnel+' '+this.currentPage);
            axios
            .get("http://localhost/annuairesante/backend/index.php", { params: {
                route: 'filters',
                commune: payload.commune,
                civilite: payload.civilite,
                profession: payload.profession,
                nom_professionnel: payload.nom_professionnel,
                page: this.currentPage,
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
            if ( this.payload.newRequest ){
                this.payload.newRequest = false;
            }
            else {
                this.getHealthWorkersByFilters(this.payload);
            }
        }
    },
    mounted() {
    }
}
</script>

<style>
</style>