<template>
    <section id="register-form">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="pr-1">
                    <div class="card">
                        <h5 class="card-header info-color white-text text-center py-4">
                            <strong>Modifier mot de passe</strong>
                        </h5>
                        <div class="card-body px-lg-5 pt-0">
                            <form v-on:submit.prevent="updateUser" action='/' class="text-center" style="color: #757575;">
                                <!-- First name -->
                                <div class="md-form">
                                    <label for="materialRegisterFormFirstName" class="active">Mot de passe actuel</label>
                                    <input type="password" v-model="currentPassword" id="materialRegisterFormFirstName"
                                        class="form-control">
                                    <small id="materialRegisterFormPasswordHelpBlock"
                                        class="form-text text-muted mb-4" v-if="errorPassword"> {{ errorPassword }}
                                    </small>
                                </div>

                                <!-- E-mail -->
                                <div class="md-form">
                                    <label for="materialRegisterFormEmail" class="active">Nouveau mot de passe</label>
                                    <input type="password" v-model="newPasswordOne" id="materialRegisterFormEmail" class="form-control">
                                    <small id="materialRegisterFormPasswordHelpBlock"
                                        class="form-text text-muted mb-4" v-if="errorPassword"> {{ errorPassword }} 
                                    </small>                                    
                                </div>

                                <!-- Password -->
                                <div class="md-form">
                                    <input type="password" v-model="newPasswordTwo" id="materialRegisterFormPassword" class="form-control"
                                        aria-describedby="materialRegisterFormPasswordHelpBlock">
                                    <label for="materialRegisterFormPassword" class="active">Confirmer nouveau mot de passe</label>
                                    <small id="materialRegisterFormPasswordHelpBlock"
                                        class="form-text text-muted mb-4" v-if="errorPassword"> {{ errorPassword }}
                                    </small>
                                </div>

                                <!-- Sign up button -->
                                <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
                                    type="submit">Modifier</button>
                                <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
                                    type="cancel" @click="cancelUpdate" >Annuler</button>
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
    name: 'PasswordUpdate',
    data(){
        return {
            currentPassword: null,
            newPasswordOne: null,
            newPasswordTwo: null,
            passwordCorrect: false,
            errorPassword: null
        }
    },
    computed:{
        ...mapGetters({myUserLogged: "getCurrentUser"})
    },
    methods: {
        // updatePassword(){
        //     Axios
        //     .post("http://localhost/annuairesante/backend/index.php", {
        //         route: 'updatePassword',
        //         userId: this.$store.state.user.role_id,
        //         currentPassword: this.currentPassword,
        //         newPasswordOne: this.newPasswordOne,
        //         newPasswordTwo: this.newPasswordTwo
        //     })
        //     .then( response => {
        //         if (response.data.errors){
        //             this.errorPassword = response.data.errors.password;
        //         }
        //         console.log('ok');
        //     })  
        //     .catch(error => {
        //         console.log(error)
        //         this.errored = true
        //     })
        // },
        updateUser(){
            if(this.$store.state.userLogged.role_id == 1){
                this.password = this.myUserLogged.password
            }
            Axios
            .post("http://localhost/annuairesante/backend/index.php", {
                route: 'updatePassword',
                userId: this.myUserLogged.id,
                currentPassword: this.myUserLogged.pseudo,
                newPasswordOne: this.myUserLogged.email,
                newPasswordTwo: this.password
            })
            .then( response => {
                if (response.data.errors){
                    this.errorPseudo = response.data.errors.pseudo;
                    this.errorEmail = response.data.errors.email;
                    this.errorPassword = response.data.errors.password;
                }
                else {
                    console.log(response.data);
                    // if(this.$store.state.userLogged.role_id == 1){
                    //     this.$session.set('userUpdatedByAdmin', 'L\'utilisateur a été mis à jour');
                    //     this.$router.push({ path: '/AdminView' });
                    // }
                    // else {
                    //     this.$session.set('userUpdate', 'Vos informations ont été mises à jour.');
                    //     this.$router.push({ path: '/userprofile' });
                    // }
                }
            })  
            .catch(error => {
                console.log(error)
                this.errored = true
            })
        },
        
        cancelUpdate(){
            this.$router.push({ path: '/userprofile' });
        }
    }
}
</script>

<style>

</style>