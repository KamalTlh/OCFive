<template>
	<div>
		<form v-on:submit.prevent="sendConnection" method="post" class="px-4 py-3" role="form">
			<div class="form-group">
			<label for="pseudo">Pseudo</label>
			<input v-model="pseudo" type="text" class="form-control" id="pseudo" name="pseudo">
			</div>
			<div class="form-group">
			<label for="password">Mot de passe</label>
			<input v-model="password" type="password" class="form-control" id="password" name="password" placeholder="*******">
			</div>
			<button type="submit" class="btn btn-warning" >Connexion</button>
		</form>
		<div class="dropdown-divider"></div>
		<a type="button" class="btn btn-primary m-1" href="#">
			Inscription !
		</a>
		<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#forgetPassword">
			Mot de passe oublié ?
		</button>
	</div>
</template>

<script>
export default {
	name: "Login",
	data() { 
		return {
			pseudo: null,
			password: null
		};
	},
	methods: {
		sendConnection() {
			this.$emit('data-sent', { 'pseudo': this.pseudo, 'password': this.password});	
		},
	}
}
</script>

<style>
</style>
