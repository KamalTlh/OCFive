<template>
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Professionnels de sante</h6>
    </div>
    <div class="card-body">
      <!-- Pagination du tableau -->
      <b-pagination v-model="currentPage" :total-rows="totalResults" :per-page="perPage" aria-controls="my-table">
      </b-pagination>

      <!-- Tableau administration des commentaires -->
      <div class="table-responsive">
        <table class="table table-bordered table-hover" role="grid" aria-discribedby="dataTable_info" id="dataTable"
          width="100%" cellspacing="0">
          <thead>
            <tr>
              <th data-sortable="true" data-field="id">ID</th>
              <th data-sortable="true" data-field="civilite">Civilite</th>
              <th data-sortable="true" data-field="nom_professionnel">Nom</th>
              <th data-sortable="true" data-field="profession">Profession</th>
              <th data-sortable="true" data-field="adresse">Adresse</th>
              <th data-sortable="true" data-field="telephone">Telephone</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th data-sortable="true" data-field="id">ID</th>
              <th data-sortable="true" data-field="civilite">Civilite</th>
              <th data-sortable="true" data-field="nom_professionnel">Nom</th>
              <th data-sortable="true" data-field="profession">Profession</th>
              <th data-sortable="true" data-field="adresse">Adresse</th>
              <th data-sortable="true" data-field="telephone">Telephone</th>
              <th>Actions</th>
            </tr>
          </tfoot>
          <tbody v-for="healthworker in healthworkers" :key="healthworker.id">
            <tr>
              <td>{{ healthworker.id }}</td>
              <td>{{ healthworker.civilite }}</td>
              <td>{{ healthworker.nom_professionnel }}</td>
              <td>{{ healthworker.profession }}</td>
              <td>{{ healthworker.adresse }}</td>
              <td>{{ healthworker.telephone }}</td>
              <!-- Boutons administration -->
              <td class="actions">
                <a class="btn btn-primary" @click="sendIdWorker(healthworker.id)"><i class="fas fa-eye"></i></a>
              </td>
              <!-- Fin boutons administration -->
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import Axios from 'axios';
  export default {
    name: "TableHealthWorkers",
    data() {
      return {
        loading: false,
        errored: false,
        healthworkers: [],
        totalPages: 0,
        totalResults: 0,
        currentPage: 1,
        perPage: 20,
        page: 1,
      }
    },
    methods: {
      /*-- Récupération des professionnels de santé --*/
      getHealthWorkers(){
          Axios
          .get(process.env.VUE_APP_API_URL, { params: {
              route: 'healthworkers',
              page: this.page,
              totalPages: this.totalPages
              }}
          )
          .then( response => {
              this.healthworkers = response.data.datas.healthworkers;
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
      /*-- Stockage en local et en store de l'id d'un professionnel pour afficher son profil --*/
      sendIdWorker(healthworkerId){
        localStorage.setItem('healthWorkerId', healthworkerId);
        this.$store.commit("changeWorker", healthworkerId);
        this.$router.push({ path: '/workerdetailview' });
      }
    },
    watch: {
      /*-- A chaque changement de page on reload la nouvelle page de professionnels --*/
      currentPage: function(){
        this.page = this.currentPage;
          this.getHealthWorkers();
      }
    },
  }
</script>

<style>
</style>