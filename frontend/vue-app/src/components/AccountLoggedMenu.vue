<template>
      <!-- account connexion -->
            <div class="btn-group dropdown">
              <button type="button" id="dropdownMenuButton" class="btn account right tooltipped dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Mon compte <i class="fas fa-user-circle user-pic"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right">
                  <router-link to="/userprofile" class="btn account right tooltipped dropdown-item" @click="display">
                    Profil<i class="fas fa-user user-pic"></i>
                  </router-link>
                  <router-link to="/adminview" class="btn account right tooltipped dropdown-item" v-if="checkSession === true && checkRole == 1 " >
                    Administration<i class="fas fa-user-lock user-pic"></i>
                  </router-link>
                  <button type="button" class="btn account right tooltipped dropdown-item" @click="logout">
                    Déconnection <i class="fas fa-sign-out-alt user-pic"></i>
                  </button>
              </div>
            </div>

</template>

<script>
import Axios from 'axios';
  export default {
    name: 'Logout',
    data() {
      return {
        error: false,
        currentRoute: window.location.pathname
      };
    },
    computed: {
      checkSession(){
        return this.$store.state.sessionConnected;
      },
      checkRole(){
        return this.$store.state.userLogged.role_id;
      }
    },
    methods: {
      logout(){
        Axios
          .post("http://localhost/annuairesante/backend/index.php", {
            route: 'logout'
          })
          .then( response => {
            this.$store.commit("changeSessionState", response.data.sessionConnected );
            this.$store.commit("setUserLogged", null );
            this.$store.commit("changeUser", null );
            this.$session.set('Logout', 'Merci à bientôt');
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            localStorage.removeItem('expiration');
            if ( this.$router.currentRoute.name != 'Home'){
              this.$router.push({ path: '/'});
            }
          })
          .catch(error => {
              console.log(error)
              this.errored = true
          })
      },
      display(){
        this.$store.commit("changeUser", this.$store.state.userLogged);
      }	
    }
  };
</script>

<style scoped>
</style>
