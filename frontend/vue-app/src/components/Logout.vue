<template>
    <div>
      <b-button type="button" v-b-modal.modal-2 class="btn-connexion" @click="deconnection" navLink> Déconnection <mdb-icon icon="sign-out-alt" /></b-button>
    </div>
</template>

<script>
  import { mdbIcon } from 'mdbvue';
import Axios from 'axios';
  export default {
    name: 'Logout',
    components: {
      mdbIcon
    },
    data() {
      return {
        error: false
      };
    },
    methods: {
      deconnection(){
        Axios
          .post("http://localhost/annuairesante/backend/index.php", {
            route: 'logout'
          })
          .then( response => {
            this.$store.commit("changeSessionState", response.data.sessionConnected );
            this.$store.commit("setUserLogged", null );
            this.$store.commit("changeUser", null );
          })
          .catch(error => {
              console.log(error)
              this.errored = true
          })
      }	
    }
  };
</script>

<style>
</style>
