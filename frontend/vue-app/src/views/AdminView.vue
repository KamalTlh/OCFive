<template>
  <section class="pageAdmin">
    <div class="row">
      <div class="col-lg-12">
        <b-tabs content-class="mt-3"  align="center">
          <section class="panel">
            <header class="panel-heading">
            </header>
            <b-tab title="Utilisateurs" active>
              <TableUsers ref="users" id="p2"></TableUsers>
            </b-tab>
            <b-tab title="Commentaires">
              <TableComments ref="comments" id="p3"></TableComments>
            </b-tab>
            <b-tab title="Professionnels de Sante">
              <TableHealthWorkers ref="workers" id="p1"></TableHealthWorkers>
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
  import TableComments from '../components/TableComments';

  export default {
    name: "panelAdmin",
    components: {
      TableUsers,
      TableHealthWorkers,
      TableComments
    },
    data() {
      return {
      }
    },
    computed: {
      needRefresh(){
        return this.$store.state.needRefresh
      }
    },
    methods: {
    },
    watch: {
      needRefresh: function(){
        if (this.needRefresh === true){
          this.$refs.users.getUsers();
          this.$refs.comments.getComments();
          this.$store.commit('needRefresh' , false);
        }
      },
    }
  }
</script>

<style>
.alertUpdate{
  text-align: center;
  font-weight: bold;
}
.actions{
    display: flex;
    justify-content: space-between;
}
</style>