<template>
	<div class="overflow-auto">
        <Research @data-sent="getHealthWorkersByDepartement"></Research>
        <section  v-if="errored">
            <p>Nous sommes désolés, nous ne sommes pas en mesure de récupérer ces informations pour le moment. Veuillez réessayer ultérieurement.</p>
        </section>
        <section  v-else>
            <div v-if="loading">Chargement...</div>
            <button @click="getHealthWorkers">Reload</button>
            <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="my-table"
            ></b-pagination>

            <p class="mt-3">Current Page: {{ currentPage }}</p>

            <b-table
            id="my-table"
            :items="healthWorkers"
            :per-page="perPage"
            :current-page="currentPage"
            small
            class="table table-bordered table-responsive-sm"
            ></b-table>
        </section>
	</div>
</template>

<script>
import axios from 'axios';
import Research from '../components/Research';
export default {
    name: "ListeMedecins",
    components: {
        Research
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
            totalPages: null,
            commune: '',
            civilite: '',
            profession: ''
		}
    },
    computed: {
        rows() {
        return this.healthWorkers.length
        },
        updateHealthWorkers() {
            return this.healthWorkers;
        },
        updateTotalPages() {
            return this.totalPages;
        }
    },
    methods : {
        getHealthWorkers(){
            this.errored = false;
            axios
            .get("http://localhost/myproject/index.php?route=medecins"
            )
            .then( response => {
                this.healthWorkers = response.data.healthworkers;
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })
            .finally(() => this.loading = false );
        },
        getHealthWorkersByDepartement(payload){
            this.errored = false;
            console.log('payloads: '+payload.commune+' '+payload.civilite+' '+payload.profession);
            this.commune = payload.commune;
            this.civilite = payload.civilite;
            this.profession = payload.profession;
            axios
            .get("http://localhost/myproject/index.php", { params: {
                route: 'filters',
                commune: this.commune,
                civilite: this.civilite,
                profession: this.profession
                }}
            )
            .then( response => {
                this.healthWorkers = response.data.healthworkers;
                this.totalPages = response.data.healthworkers.totalPages;
                console.log('Pages totales: '+this.healthWorkers);
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })
            .finally(() => this.loading = false );
        }
    },
    mounted() {
        this.getHealthWorkers();
    }
}
</script>

<style>
</style>