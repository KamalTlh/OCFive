<template>
    <div id="login-row" class="container">
        <div class="row">
            <div id="login-column" class="col-md-5">
                <div id="login-box">
                    <h3 class="text-center text-info">Login</h3>
                    <div class="errorMessage">
                        <p class="return-error divider" v-if="this.errorPseudo === true">Pseudo requis</p>
                        <p class="return-error divider" v-if="this.errorPassword === true">Mot de passe requis</p>
                    </div>
                    <form v-on:submit.prevent="connection" method="post" class="px-4 py-3" role="form">
                        <div class="form-group">
                            <label for="pseudo" class="text-info">Pseudo</label>
                            <input v-model="pseudo" type="text" class="form-control" id="pseudo" name="pseudo">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Mot de passe</label>
                            <input v-model="password" type="password" class="form-control" id="password"
                                name="password">
                        </div>
                        <div class="form-group">
                            <label for="remember-me" class="text-info"><span>Remember me</span> <span><input
                                        id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                            <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                        </div>
                        <div id="register-link" class="text-right">
                            <router-link to="/register" class="text-info">Register here</router-link>
                        </div>
                        <div class="return-error divider" v-if="error === true">
                        Pseudo ou mot de passe incorrect
                    </div>
                    </form>
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
                        if (response.status == 200){
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
                                localStorage.setItem('user', JSON.stringify(this.user) );
                                this.$router.push({ path: '/'});
                            }
                        } else {
                            this.$router.push({ path: '/error500'});
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

<style>
#login-row {
  margin: 0;
  padding: 0;
  background-color: #17a2b8;
  height: 70vh;
}
#login-box {
    display: flex;
    flex-direction: column;
    margin-top: 120px;
    max-width: 500px;
    height: 100%;
    border: 1px solid #9C9C9C;
    background-color: #EAEAEA;
}
#login .container #login-row #login-column #login-box {
  margin-top: 120px;
  max-width: 500px;
  height: 350px;
  border: 1px solid #9C9C9C;
  background-color: #EAEAEA;
}
#login-box h3{
    padding-top: 2%;
}
#login-form {
  padding: 20px;
}
#register-link {
  margin-top: -85px;
}
.text-center {
    text-align: center !important;
}
.text-info {
    color: #17a2b8 !important;
    font-weight: normal;
}
.errorMessage{
    display: flex;
    flex-direction: column;
    align-items: center;
}
.return-error{
    color: red;
    display: flex;
    justify-content: center;
    position: relative;
    top: 30%;
}
</style>
