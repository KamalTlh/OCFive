<template>
	<div id="content">
    <nav class="navbar navbar-expand-lg navbar-blue bg-blue fixed-top">
      <div class="container">
        <router-link to="/" class="nav-link">
          <span class="cursive">APS</span>
        </router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
          aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <router-link to="/" class="nav-link">Accueil</router-link>
              </li>
              <li class="nav-item">
                <router-link to="/researchworkers" class="nav-link">Trouver un professionnel de Sante</router-link>
              </li>
              <li class="nav-item">
                <div class="logregister">
                  <div v-if="checkSession === false" class="header-main-account account-wrapper">
                    <router-link to="/login" class="btn account right tooltipped"> <i class="fas fa-sign-in-alt user-pic"></i>
                      <span>Connexion</span> </router-link> 
                  </div>
                  <AccountLoggedMenu v-if="checkSession === true" />
                </div>
              </li>
          </ul>
        </div>
      </div>
    </nav>
    <router-view />
	</div>
</template>

<script>
import AccountLoggedMenu from '@/components/AccountLoggedMenu';
  export default {
    name: 'NavBar',
    components: {
      AccountLoggedMenu
    },
    data(){
      return {
        userConnect: localStorage.getItem('token')
      };
    },
    computed:{
      checkSession(){
        return this.$store.state.sessionConnected;
      },
      checkRole(){
        return this.$store.state.userLogged.role_id;
      }
    },
    methods: {
      display(){
        this.$store.commit("changeUser", this.$store.state.userLogged);
      }
    },
    watch: {
      userConnect: function(){
        console.log('we check');
        return this.checkSession();
      }
    }
  }
</script>

<style scoped>
</style>