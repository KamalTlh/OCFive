<template>
<div class="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
      </a>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <!-- Heading -->
      <div class="sidebar-heading">
        Modération
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav nav-item nav-pills">
        <a class="nav-link collapsed" href="#p1" data-toggle="tab">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Utilisateurs</span>
        </a>
        <a class="nav-link collapsed" href="#p2" data-toggle="tab">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Commentaires</span>
        </a>
        <a class="nav-link collapsed" href="#p3" data-toggle="tab">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Professionnels</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
    </ul>
    <!-- End of Sidebar -->
    
    <!-- Tabs -->
    <div class="tab-content">
      <TableUsers ref="users" class="tab-pane active" id="p1"></TableUsers>
      <TableComments ref="comments" class="tab-pane" id="p2"></TableComments>
      <TableHealthWorkers ref="workers" class="tab-pane" id="p3"></TableHealthWorkers>
    </div>
    <!-- End of Tabs -->
</div>
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
    mounted(){
      this.$refs.users.getUsers();
      this.$refs.comments.getComments();
      this.$refs.workers.getHealthWorkers();
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

<style scoped>
@import '../../public/assets/css/sb-admin-2.css';
</style>