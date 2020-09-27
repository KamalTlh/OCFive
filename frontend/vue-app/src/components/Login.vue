<template>
	<div>
		<div class="header-main-account account-wrapper">
			<button type="button" class="btn account right tooltipped"  @click="$bvModal.show('modal-1')" data-tooltip="Mon espace">
				<i class="fas fa-sign-in-alt user-pic"></i>
				<span>Connexion</span>
			</button>
		</div>
		<b-modal id="modal-1" ref="my-modal"  hide-footer title="Connection">
			<p class="return-error divider" v-if="this.errorPseudo === true">Pseudo requis</p>
			<p class="return-error divider" v-if="this.errorPassword === true">Mot de passe requis</p>
			<form v-on:submit.prevent="connection" method="post" class="px-4 py-3" role="form">
				<div class="form-group">
				<label for="pseudo">Pseudo</label>
				<input v-model="pseudo" type="text" class="form-control" id="pseudo" name="pseudo" >
				</div>
				<div class="form-group">
				<label for="password">Mot de passe</label>
				<input v-model="password" type="password" class="form-control" id="password" name="password">
				</div>
				<button type="submit" class="btn btn-warning" >Connexion</button>
				<button type="button" class="btn btn-info" @click="hideModal">Annuler</button>
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
import Axios from 'axios';
export default {
	name: "Login",
	data() {
		return {
			pseudo: null,
			password: null,
			error: false,
			errorData: false,
			errorPseudo: null,
			errorPassword: null
		};
	},
	methods: {
		hideModal(){
			this.$refs['my-modal'].hide();
			this.pseudo = null;
			this.password = null;
			this.errorPseudo = null;
			this.errorPassword = null;
			this.error= false;
			this.errorData = false;
		},
		registrationRouting(){
			this.$router.push({ path: '/Register' });
			this.$refs['my-modal'].hide();
		},

		checkForm() {
			if (this.pseudo){
			this.errorPseudo=false;
			}
			if (this.password) {
				this.errorPassword=false;
			}
			if (this.pseudo && this.password) {
				return true;
			}
			else {
				if (!this.pseudo && !this.errorPseudo) {
					this.errorPseudo=true;
				}
				if (!this.password && !this.errorPassword) {
					this.errorPassword=true;
				}
				return false;
			}
		},
		connection(){
			if (this.checkForm()){
				Axios
					.post("http://localhost/annuairesante/backend/index.php", {
						route: 'login',
						pseudo: this.pseudo,
						password: this.password
					})
					.then( response => {
						if (response.data.isPasswordValid === false){
							this.error = true;
						}
						else if(response.data.errorData) {
							this.errorData = response.data.errorData;
						}
						else {
							this.$store.commit("changeSessionState", response.data.sessionConnected );
							this.$store.commit("setUserLogged", response.data.user );
							this.$store.commit("changeUser", response.data.user );
							localStorage.setItem('UserLog', response.data.user );
							localStorage.setItem('sessionLog', response.data.sessionConnected );
						}
					})
					.catch(error => {
						console.log(error)
						this.errored = true
					})
			}
		}
	}
}
</script>

<style>

</style>
