<template>
    <div class="container" id="loginview">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Connectez-vous!</h1>
                                    </div>
                                    <div v-if="error === true" class="alert alert-danger" role="alert">
                                        <div>L&#039;identifiant ou le mot de passe est incorrect</div>
                                    </div>
                                    <form class="user" v-on:submit.prevent="connection" method="post" role="form">
                                        <div class="form-group">
                                            <input v-model="pseudo" type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Entrez votre pseudo...">
                                            <small class="return-error" v-if="this.errorPseudo === true"><i class="fas fa-exclamation-circle"></i> 
                                                Cette valeur ne doit pas être vide.</small>
                                        </div>
                                        <div class="form-group">
                                            <input v-model="password" type="password"
                                                class="form-control form-control-user" id="exampleInputPassword"
                                                placeholder="Password">
                                            <small class="return-error" v-if="this.errorPassword === true"> <i class="fas fa-exclamation-circle"></i> 
                                                Cette valeur ne doit pas être vide.</small>
                                        </div>
                                        <input type="submit" name="submit" class="btn btn-primary btn-user btn-block"
                                            value="Se connecter"> 
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <router-link to="/register" class="text-info">Créer un compte!</router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            errorPassword: null,
            user: []
		};
	},
	methods: {
        /*-- Vérification que les champs du formulaire ne sont pas vides --*/
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
        /*-- Connection au site --*/
		connection(){
			if (this.checkForm()){
				Axios
                    .post(process.env.VUE_APP_API_URL, {
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
                            this.user = response.data.user;
                            this.$store.commit("changeSessionState", response.data.sessionConnected );
                            this.$store.commit("setUserLogged", response.data.user );
                            this.$store.commit("changeUser", response.data.user );
                            localStorage.setItem('token',JSON.stringify(response.data.jwt) );
                            localStorage.setItem('expiration',JSON.stringify(response.data.expireAt) );
                            localStorage.setItem('user', JSON.stringify(this.user) );
                            this.$router.push({ path: '/'});
                        }

                    })
                    .catch(error => {
                        console.log(error.status)
                        this.errored = true
                    })
			}
        }
	}
}
</script>

<style scoped>
.alert-danger{ 
    position: relative;
    color: #ffffff !important;
    background-color: #fd565e !important;
    border-color: #ebccd1;
    text-align: center;
    font-family: "Noto serif", arial, sans-serif;
}
.alert-danger::before, .alert-danger::after{
    top: 100%;
    left: 260px;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
}
.alert-danger::after {
    border-top-color: #fd565e;
    border-width: 10px;
    margin-left: -10px;
}
.divider{
    padding-top: 3%;
}
#loginview{
    margin-top: 10rem;
    min-height: 60vh;
}
</style>
