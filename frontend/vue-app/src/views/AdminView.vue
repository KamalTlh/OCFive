<template>
  <div class="row">
    <div class="col-lg-12">
      <!-- <nav class="nav nav-tabs">
        <a class="nav-item nav-link active" href="#p1" data-toggle="tab">Medecins</a>
        <a class="nav-item nav-link" href="#p2" data-toggle="tab">Utilisateurs</a>
        <a class="nav-item nav-link" href="#p3" data-toggle="tab">Commentaires</a>
      </nav> -->
      <b-tabs content-class="mt-3"  align="center">
        <section class="panel">
          <header class="panel-heading">
          </header>
          <b-tab title="Utilisateurs" active>
              <TableUsers id="p2" ></TableUsers>
           </b-tab>
          <b-tab title="Professionnels de Sante">
          <TableHealthWorkers id="p1"></TableHealthWorkers>
          </b-tab>
        </section>
      </b-tabs>
    </div>
  </div>
</template>

<script>
  import TableUsers from '../components/TableUsers';
  import TableHealthWorkers from '../components/TableHealthWorkers';
  export default {
    name: "panelAdmin",
    components: {
      TableUsers,
      TableHealthWorkers
    }
  }
</script>

<style>

</style>