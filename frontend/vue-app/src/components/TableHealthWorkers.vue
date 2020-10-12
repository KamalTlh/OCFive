<template>
    <div class="row">
        <div class="col-8">
            <b-pagination v-model="currentPage" :total-rows="totalResults" :per-page="perPage" aria-controls="my-table">
            </b-pagination>
            <table data-toggle="table" data-search="true" data-show-columns="true"
                class="table table-bordered table-hover">
                <thead class="thead-dark">
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
                <tbody v-for="healthworker in healthworkers" :key="healthworker.id">
                    <tr>
                        <td>{{ healthworker.id }}</td>
                        <td>{{ healthworker.civilite }}</td>
                        <td>{{ healthworker.nom_professionnel }}</td>
                        <td>{{ healthworker.profession }}</td>
                        <td>{{ healthworker.adresse }}</td>
                        <td>{{ healthworker.telephone }}</td>
                        <td class="actions">
                            <!-- <a class="btn btn-primary"><i class="fas fa-plus-circle"></i></a> -->
                            <a class="btn btn-primary" @click="sendIdWorker(healthworker.id)"><i class="fas fa-eye"></i></a>
                            <a class="btn btn-success"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-danger" ><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
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
      getHealthWorkers(){
          Axios
          .get("http://localhost/annuairesante/backend/index.php", { params: {
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
      sendIdWorker(healthworkerId){
        this.$store.commit("changeWorker", healthworkerId);
        this.$router.push({ path: '/workerdetailview' });
      }
    },
    mounted (){
      this.getHealthWorkers();
    },
    watch: {
      currentPage: function(){
        this.page = this.currentPage;
          this.getHealthWorkers();
      }
    },
  }
</script>

<style>
</style>