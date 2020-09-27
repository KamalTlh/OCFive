<template>
  <section class="pageAdmin">
    <div class="row">
      <div class="col-lg-12">
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
  </section>
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
.alertUpdate{
  text-align: center;
  font-weight: bold;
}
</style>