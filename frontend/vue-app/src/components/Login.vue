<template>
	<div>
		<b-button type="button" class="btn-connexion" @click="$bvModal.show('modal-1')" navLink> Connexion <mdb-icon icon="sign-in-alt" /></b-button>
		<b-modal id="modal-1" ref="my-modal" title="Connection">
			<form v-on:submit.prevent="connection" method="post" class="px-4 py-3" role="form">
				<div class="form-group">
				<label for="pseudo">Pseudo</label>
				<input v-model="pseudo" type="text" class="form-control" id="pseudo" name="pseudo" >
				</div>
				<div class="form-group">
				<label for="password">Mot de passe</label>
				<input v-model="password" type="password" class="form-control" id="password" name="password" placeholder="*******">
				</div>
				<button type="submit" class="btn btn-warning" >Connexion</button>
			</form>
			<div class="return-error divider" v-if="error === true"><hr>Pseudo ou mot de passe incorrect</div>
			<div class="dropdown-divider"></div>
			<button class="btn btn-primary m-1" @click="registrationRouting">Inscription</button>
			<button type="button" class="btn btn-primary m-1" @click="$bvModal.hide('modal-1')" data-toggle="modal" data-target="#forgetPassword">
				Mot de passe oublié ?
			</button>
		</b-modal>
	</div>
</template>

<script>
import { mdbIcon } from 'mdbvue';
import Axios from 'axios';
export default {
	name: "Login",
	components: {
		mdbIcon
	},
	data() {
		return {
			pseudo: null,
			password: null,
			error: false
		};
	},
	methods: {
		hideModal(){
			this.$refs['my-modal'].hide();
		},
		registrationRouting(){
			this.$router.push({ path: '/Register' });
			this.$refs['my-modal'].hide();
		},
		connection(){
        Axios
          .post("http://localhost/annuairesante/backend/index.php", {
            route: 'login',
            pseudo: this.pseudo,
            password: this.password
          })
          .then( response => {
			this.$store.commit("changeSessionState", response.data.sessionConnected );
			this.$store.commit("setUserLogged", response.data.user );
			this.$store.commit("changeUser", response.data.user );
          })
          .catch(error => {
              console.log(error)
              this.errored = true
          })
		}		
	}
}
</script>

<style>
</style>
