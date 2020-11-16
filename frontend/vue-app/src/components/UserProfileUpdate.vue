<template>
    <div class="row">
        <div class="col-md-12">
            <div id="content" class="content content-full-width">
                <!-- begin profile -->
                <div class="profile">
                    <div class="profile-header">
                        <!-- BEGIN profile-header-cover -->
                        <div class="profile-header-cover"></div>
                        <!-- END profile-header-cover -->
                        <!-- BEGIN profile-header-content -->
                        <div class="profile-header-content" id="profilcontent">
                            <!-- BEGIN profile-header-img -->
                            <div class="profile-header-img">
                                <img src="images/avatar7.png" alt="">
                            </div>
                            <!-- END profile-header-img -->
                            <!-- BEGIN profile-header-info -->
                            <div class="profile-header-info">
                                <h4 class="m-t-10 m-b-5">{{ myUserLogged.pseudo }}</h4>
                                <p class="m-b-10" v-if="myUserLogged.role_id == 2"> Membre </p>
                                <p v-else > Administrateur </p>
                            </div>
                            <!-- END profile-header-info -->
                        </div>
                        <!-- END profile-header-content -->
                    </div>
                </div>
                <!-- end profile -->
                <!-- begin profile-content -->
                <div class="profile-content">
                    <!-- begin tab-content -->
                    <div class="tab-content p-0">
                        <!-- begin #profile-about tab -->
                        <div class="tab-pane fade in active show" id="profile-about">
                            <!-- begin table -->
                            <section>
                                <div class="row justify-form">
                                    <div class="col-md-6 mb-4">
                                        <div class="pr-1">
                                            <div class="card">
                                                <h5 class="card-header info-color white-text text-center py-4">
                                                    <strong>Modifier Utilisateur</strong>
                                                </h5>
                                                <div class="card-body px-lg-5 pt-0">
                                                    <form v-on:submit.prevent="updateUser" action='/' class="text-center" style="color: #757575;">
                                                        <!-- First name -->
                                                        <div class="md-form">
                                                            <label for="materialRegisterFormFirstName" class="active">Pseudo</label>
                                                            <input type="text" v-model="myUserToUpdate.pseudo" id="materialRegisterFormFirstName"
                                                                class="form-control">
                                                            <small id="materialRegisterFormPasswordHelpBlock"
                                                                class="return-error" v-if="this.errorPseudo"><i class="fas fa-exclamation-circle"></i> {{ errorPseudo }}
                                                            </small>
                                                                <small id="materialRegisterFormPasswordHelpBlock"
                                                                class="return-error" v-if="this.pseudoNotAvailable"><i class="fas fa-exclamation-circle"></i> {{ pseudoNotAvailable }}
                                                            </small>
                                                        </div>

                                                        <!-- E-mail -->
                                                        <div class="md-form">
                                                            <label for="materialRegisterFormEmail" class="active">E-mail</label>
                                                            <input type="email" v-model="myUserToUpdate.email" id="materialRegisterFormEmail" class="form-control">
                                                            <small id="materialRegisterFormPasswordHelpBlock"
                                                                class="return-error" v-if="this.errorEmail"><i class="fas fa-exclamation-circle"></i> {{ errorEmail }} 
                                                            </small>                                    
                                                        </div>
                                                        <div class="submitUpdate">
                                                            <div class="type-1">
                                                                <button type="submit" class="btn btn-1 validation">
                                                                <span class="txt">Modifier</span>
                                                                <span class="round"><i class="fa fa-chevron-right"></i></span>
                                                                </button>
                                                            </div>
                                                            <div class="type-1">
                                                                <button type="cancel" @click="cancelUpdate" class="btn btn-1 cancellation">
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
                            <!-- end table -->
                        </div>
                        <!-- end #profile-about tab -->
                    </div>
                    <!-- end tab-content -->
                </div>
                <!-- end profile-content -->
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import Axios from 'axios';
import VueCookies from 'vue-cookies';

export default {
    name: 'UserProfileUpdate',
    data(){
        return {
            errorPseudo: null,
            errorEmail: null,
            pseudoNotAvailable: null,
            emailNotAvailable: null
        }
    },
    computed: {
        ...mapGetters({myUserLogged: "getCurrentUser"}),
        ...mapGetters({myUserToUpdate: "getUserToUpdate"}),
        name(){
            return this.myUserLogged.pseudo;
        },
        mail(){
            return this.myUserLogged.email;
        }
    },
    methods:{
        /*-- Mettre les informations du profil --*/
        updateUser(){
            /*-- Vérification en frontEnd que les champs renseignés ne sont pas vides --*/
            if (!this.myUserToUpdate.pseudo || !this.myUserToUpdate.email){
                alert('Renseignez les champs');
            }
            else {
                Axios
                .post(process.env.VUE_APP_API_URL, {
                    route: 'updateUser',
                    userLoggedPseudo: this.myUserLogged.pseudo,
                    id: this.myUserToUpdate.id,
                    pseudo: this.myUserToUpdate.pseudo,
                    email: this.myUserToUpdate.email
                })
                .then( response => {
                    if (response.data.errors){
                        this.errorPseudo = response.data.errors.pseudo;
                        this.errorEmail = response.data.errors.email;
                    }
                    else {
                        /*-- Si le profil est mis à jour par l'administrateur --*/
                        if(this.myUserLogged.role_id == 1){
                            this.$session.set('userUpdatedByAdmin', 'L\'utilisateur a été mis à jour');
                            this.$router.push({ path: '/AdminView' });
                        }
                        /*-- Si le profil est mis à jour par l'utilisateur --*/
                        else {
                            this.$session.set('userUpdate', 'Vos informations ont été mises à jour.');
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
        /*-- Annuler la modificiation et revenir à la page de profil ou d'administration --*/
        cancelUpdate(){
            if (VueCookies.get("previousUrl") == '/adminview'){
                this.$router.push({ path: '/adminview' });
            } else { 
                this.$router.push({ path: '/userprofile' });
            }
        }
    }
};
</script>

<style scoped>
.submitUpdate {
    display: flex;
    justify-content: space-evenly;
    margin-top: 4%;
}
.validation{
  background-color: #28a745 !important;
}
.cancellation{
  background-color: #17a2b8 !important;
}
</style>