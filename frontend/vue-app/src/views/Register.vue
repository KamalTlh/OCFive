<template>
    <div class="container" id="registerview">
        <div class="card o-hidden border-0 shadow-lg">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Créez un compte!</h1>
                            </div>
                            <form v-on:submit.prevent="signIn" action='/' class="user">
                                <div class="form-group">
                                    <input type="text" v-model="pseudo" class="form-control form-control-user"
                                        id="exampleFirstName" placeholder="Pseudo">
                                    <small id="materialRegisterFormPasswordHelpBlock" class="return-error"
                                        v-if="errorsForm.pseudo"><i class="fas fa-exclamation-circle"></i>
                                        {{ errorsForm.pseudo }}
                                    </small>
                                </div>
                                <div class="form-group">
                                    <input type="email" v-model="email" class="form-control form-control-user"
                                        id="exampleInputEmail" placeholder="Adresse email">
                                    <small id="materialRegisterFormPasswordHelpBlock" class="return-error"
                                        v-if="errorsForm.email"><i class="fas fa-exclamation-circle"></i>
                                        {{ errorsForm.email }}
                                    </small>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input v-model="password" type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Mot de passe">
                                        <small id="materialRegisterFormPasswordHelpBlock" class="return-error"
                                            v-if="errorsForm.password"><i class="fas fa-exclamation-circle"></i>
                                            {{ errorsForm.password }}
                                        </small>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" v-model="passwordConfirmation"
                                            class="form-control form-control-user" id="exampleRepeatPassword"
                                            placeholder="Confirmer le mot de passe">
                                        <small id="materialRegisterFormPasswordHelpBlock" class="return-error"
                                            v-if="errorsForm.password"><i class="fas fa-exclamation-circle"></i>
                                            {{ errorsForm.password }}
                                        </small>
                                    </div>
                                    <small id="materialRegisterFormPasswordHelpBlock" class="return-error"
                                        v-if="errorConfirmation"><i class="fas fa-exclamation-circle"></i>
                                        Les mots de passe ne correspondent pas
                                    </small>
                                </div>
                                <button class="btn btn-primary btn-user btn-block" type="submit">S'enregistrer</button>
                                <small>En cliquant sur
                                    <em>S'enregistrer</em> vous acceptez les
                                    <a href="" target="_blank">conditions d'utilisations</a>
                                </small>
                            </form>
                            <hr>
                            <div class="text-center">
                                <router-link class="small" to="/login">Vous possédez déjà un compte? Connectez-vous!
                                </router-link>
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
import VueCookies from 'vue-cookies';

export default {
    name: 'register',
    data() {
        return {
            path: null,
            pseudo: null,
            email: null,
            password: null,
            passwordConfirmation: null,
            registration: false,
            errorsForm: {
                pseudo: null,
                email: null,
                password: null
            },
            errorConfirmation: false,
            emptyPseudo: false,
            emptyPassword: false,
            emptyEmail: false
        }
    },
    methods: {
        checkForm() {
			if ( !this.pseudo || this.pseudo == '' ) {
                this.errorsForm.pseudo = 'Le champ saisi est vide';
            } else {
                this.errorsForm.pseudo = null;
            }

            if (!this.email || this.email == ''){
                this.errorsForm.email = 'Le champ saisi est vide';
            } else {
                this.errorsForm.email = null;
            }

            if (!this.password || this.password == ''){
                this.errorsForm.password = 'Le champ saisi est vide';
            } else {
                this.errorsForm.password = null;
            }
            
            if (this.pseudo && this.email && this.password){
                return true;
            } else {
                return false;
            }
		},
        signIn(){
            if (this.checkForm()){
                if ( this.password == this.passwordConfirmation ) {
                    Axios
                    .post("http://localhost/annuairesante/backend/index.php", {
                        route: 'signIn',
                        pseudo: this.pseudo,
                        email: this.email,
                        password: this.password
                    })
                    .then( response => {
                        if (response.data.errors){
                            this.errorsForm = response.data.errors;
                        }
                        this.registration = response.data.registration;
                        if ( this.registration === true ) {
                            this.$session.set('signIn', 'Vous pouvez à présent vous connecter.');
                            const previousUrl = VueCookies.get("previousUrl");
                            if (previousUrl == '/adminview'){
                                this.$router.push({ path: '/adminview' });
                            } else {
                                console.log('ici');
                                this.$router.push({ path: '/login' });
                            }
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    })
                }
                else {
                    this.errorConfirmation = true;
                }
            }
        }
    }
}
</script>

<style scoped>
.row{
    justify-content: center;
}
.form-control{
    color: #6e707e !important;
}
.text-muted {
    color: #DC143C !important;
}
#registerview{
    min-height: 60vh;
    margin-top: 10rem;
}
</style>