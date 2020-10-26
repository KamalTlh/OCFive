<template>
    <section id="register-form">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="pr-1">
                    <div class="card">
                        <h5 class="card-header info-color white-text text-center py-4">
                            <strong>Modifier mot de passe</strong>
                        </h5>
                        <div class="card-body px-lg-5 pt-0 mt-4">
                            <form v-on:submit.prevent="updatePassword" action='/' class="text-center"
                                style="color: #757575;">
                                <div v-if="errorData === true" class="alert alert-danger" role="alert">
                                    <div>Les champs suivi d'une * sont obligatoires.</div>
                                </div>
                                <!-- First name -->
                                <div class="md-form">
                                    <label for="materialRegisterFormFirstName" class="active">Mot de passe
                                        actuel *</label>
                                    <input type="password" v-model="currentPassword" id="materialRegisterFormFirstName"
                                        class="form-control">
                                    <small id="materialRegisterFormPasswordHelpBlock" class="return-error"
                                        v-if="errorPassword"><i class="fas fa-exclamation-circle"></i> {{ errorPassword }}
                                    </small>
                                    
                                </div>

                                <!-- E-mail -->
                                <div class="md-form">
                                    <label for="materialRegisterFormEmail" class="active">Nouveau mot de passe *</label>
                                    <input type="password" v-model="newPasswordOne" id="materialRegisterFormEmail"
                                        class="form-control">
                                    <small id="materialRegisterFormPasswordHelpBlock" class="return-error"
                                        v-if="errornewPasswordOne"><i class="fas fa-exclamation-circle"></i> {{ errornewPasswordOne }}
                                    </small>
                                </div>

                                <!-- Password -->
                                <div class="md-form">
                                    <label for="materialRegisterFormPassword" class="active">Confirmer nouveau mot de
                                        passe *</label>
                                    <input type="password" v-model="newPasswordTwo" id="materialRegisterFormPassword"
                                        class="form-control" aria-describedby="materialRegisterFormPasswordHelpBlock">
                                    <small id="materialRegisterFormPasswordHelpBlock" class="return-error"
                                        v-if="errornewPasswordTwo"><i class="fas fa-exclamation-circle"></i> {{ errornewPasswordTwo }}
                                    </small>
                                    <small id="materialRegisterFormPasswordHelpBlock" class="return-error"
                                        v-if="notMatch"><i class="fas fa-exclamation-circle"></i> Le mot de passe ne correspond pas
                                    </small>
                                </div>
                                <div class="submitUpdate">
                                    <div class="type-1">
                                        <button id="validation" type="submit" class="btn btn-1">
                                        <span class="txt">Modifier</span>
                                        <span class="round"><i class="fa fa-chevron-right"></i></span>
                                        </button>
                                    </div>
                                    <div class="type-1">
                                        <button id="cancellation" type="cancel" @click="cancelUpdate" class="btn btn-1">
                                        <span class="txt">Annuler</span>
                                        <span class="round"><i class="fa fa-chevron-right"></i></span>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import {mapGetters} from 'vuex';
import Axios from 'axios';
export default {
    name: 'UpdatePassword',
    data(){
        return {
            currentPassword: null,
            newPasswordOne: null,
            newPasswordTwo: null,
            passwordCorrect: false,
            errorCurrentPassword: null,
            errornewPasswordOne: null,
            errornewPasswordTwo: null,
            errorPassword: null,
            errorData: null,
            notMatch: false
        }
    },
    computed: {
        ...mapGetters({myUserLogged: "getCurrentUser"})
    },
    methods:{
        updatePassword(){
            if ( this.newPasswordTwo != this.newPasswordOne){
                this.notMatch = true;
            } else {
                Axios
                .post("http://localhost/annuairesante/backend/index.php", {
                    route: "updatePassword",
                    userId: this.myUserLogged.id,
                    password: this.currentPassword,
                    passwordOne: this.newPasswordOne,
                    passwordTwo: this.newPasswordTwo
                })
                .then( response => {
                    if (response.data.errors){
                        this.errorPassword = response.data.error;
                        this.errorCurrentPassword = response.data.errors.password;
                        this.errornewPasswordOne = response.data.errors.passwordOne;
                        this.errornewPasswordTwo = response.data.errors.passwordTwo;
                    }
                    else if( response.data.errorData){
                        this.errorData = response.data.errorData;
                    }
                    else {
                    this.passwordCorrect = response.data.update.passwordUpdated;
                    if (this.passwordCorrect){
                        this.$router.push({ path: '/userprofile' });
                    }
                    }
                })  
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })
            }
        },
        
        cancelUpdate(){
            this.$router.push({ path: '/userprofile' });
        }
    }
};
</script>

<style>
</style>