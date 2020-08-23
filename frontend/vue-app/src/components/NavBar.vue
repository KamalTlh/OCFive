<template>
	<div id="app" class="app">
      <mdb-navbar expand="large" dark>
      <mdb-navbar-brand href="#" center>
        Annuaire Santé
      </mdb-navbar-brand>
      <mdb-navbar-toggler>
        <mdb-navbar-nav center>
           <li class="nav-item">
              <router-link to="/" class="nav-link">Accueil</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/researchworkers" class="nav-link">Trouver un professionnel de Sante</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/about" class="nav-link">About</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/userprofile" v-if="checkSession === true" class="nav-link" ><a @click="display">Profil Utilisateur</a></router-link>
            </li>
            <li class="nav-item">
              <router-link to="/adminview" v-if="checkSession === true" class="nav-link">Espace membre</router-link>
            </li>
            <Login v-if="checkSession === false" ></Login>
            <Logout v-if="checkSession === true" ></Logout>
        </mdb-navbar-nav>
      </mdb-navbar-toggler>
    </mdb-navbar>
    <router-view />
	</div>
</template>

<script>
import { mdbNavbar, mdbNavbarBrand, mdbNavbarToggler, mdbNavbarNav} from 'mdbvue';
import Login from '@/components/Login';
import Logout from '@/components/Logout';
  export default {
    name: 'NavBar',
    components: {
      mdbNavbar, 
      mdbNavbarBrand, 
      mdbNavbarToggler, 
      mdbNavbarNav,
      Login,
      Logout
    },
    data(){
      return {
      };
    },
    computed:{
      checkSession(){
        return this.$store.state.sessionConnected;
      }
    },
    methods: {
      display(){
        this.$store.commit("changeUser", this.$store.state.userLogged);
      }
    }
  }
</script>

<style>
.navbar-expand-lg .navbar-nav{
    align-items: center;
}
.navbar {
  background-color: #B0E0E6 !important;
  border-bottom: 0.3rem solid #BC8F8F;
}
.nav-link:hover{
  color: rgba(104, 112, 143, 0.94);
}
.btn-secondary.dropdown-toggle:hover{
  background-color: #7f15b3 !important;
}
.btn-secondary.dropdown-toggle{
  background-color: #B0E0E6 !important;
}

.btn.btn-outline-warning {
  color: #A0522D !important; 
}
.show > .btn-outline-warning.dropdown-toggle {
  background-color: #ff8c00 !important;
  color: rgba(0, 0, 0, 0.7) !important; 
}
.btn-connexion:hover{
  background-color: #7f15b3 !important;
  color: #fb3 !important;
}
.btn-connexion{
  background-color: #B0E0E6 !important;
  border: 3px solid #fb3 !important;
}

.ml-auto{
  margin-left: 35% !important;
}
.navbar-nav{
  padding-left: 10% !important;
}
.return-error{
  text-align: center;
  color: red;
}
</style>