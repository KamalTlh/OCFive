<template>
	<div id="app" class="app">
           <mdb-navbar expand="large" dark>
      <mdb-navbar-brand href="#" center>
        Annuaire Santé
        <strong> {{ random }} </strong>
      </mdb-navbar-brand>
      <mdb-navbar-toggler>
        <mdb-navbar-nav center>
           <li class="nav-item">
              <router-link to="/" class="nav-link">Accueil</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/professionnelsante" class="nav-link">Trouver un professionnel de Sante</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/about" class="nav-link">About</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/contact" v-if="autorization === true" class="nav-link">Espace membre</router-link>
            </li>
            <b-button type="button" v-b-modal.modal-1 class="btn-connexion" v-show="autorization === false" navLink> Connexion <mdb-icon icon="sign-in-alt" /></b-button>
            <b-button type="button" v-b-modal.modal-1 class="btn-connexion" v-show="autorization === true" navLink> Déconnexion <mdb-icon icon="sign-out-alt" /></b-button>
            <b-modal id="modal-1" title="Connexion" v-if="autorization === false">
              <Login @data-sent="connection"></Login>
              <div class="return-error divider" v-show="autorization === false"><hr>Pseudo ou mot de passe incorrect</div>
            </b-modal>
            <!-- <b-modal id="modal-1" title="Bienvenue" v-if="autorization === true"> -->
              <Logout v-if="autorization === true"></Logout>
            <!-- </b-modal> -->
        </mdb-navbar-nav>
      </mdb-navbar-toggler>
    </mdb-navbar>
    <router-view />
	</div>
</template>

<script>
import { mdbNavbar, mdbNavbarBrand, mdbNavbarToggler, mdbNavbarNav, mdbIcon } from 'mdbvue';
import Login from '@/components/Login';
import Logout from '@/components/Logout';
import Axios from 'axios';
  export default {
    name: 'NavBar',
    components: {
      mdbNavbar,
      mdbNavbarBrand,
      mdbNavbarToggler,
      mdbNavbarNav,
      mdbIcon,
      Login,
      Logout
    },
    data(){
      return {
        random : Math.random(),
        pseudo: null,
        password: null,
        autorization: false
      }
    },
    methods: {
      connection(payload){
        console.log('Connexion en cours...');
        Axios
          .post("http://localhost/annuairesante/backend/index.php?route=login", {
            route: 'login',
            pseudo: payload.pseudo,
            password: payload.password
          })
          .then( response => {
              this.autorization = response.data.isPasswordValid;
              console.log('autorization: '+this.autorization);
          })
          .catch(error => {
              console.log(error)
              this.errored = true
          })
      },
      deconnection(){
        
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