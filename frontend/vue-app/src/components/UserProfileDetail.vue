<template>
    <div class="row row justify-content-md-center">
        <div class="col-md-12">
            <div id="content" class="content content-full-width">
                <!-- begin profile -->
                <div class="profile">
                    <div class="profile-header">
                        <!-- BEGIN profile-header-cover -->
                        <div class="profile-header-cover"></div>
                        <!-- END profile-header-cover -->
                        <!-- BEGIN profile-header-content -->
                        <div class="profile-header-content">
                            <!-- BEGIN profile-header-img -->
                            <div class="profile-header-img">
                                <img src="images/avatar7.png" alt="">
                            </div>
                            <!-- END profile-header-img -->
                            <!-- BEGIN profile-header-info -->
                            <div class="profile-header-info">
                                <h4 class="m-t-10 m-b-5">{{ userProfile.pseudo }}</h4>
                                <div class="content-header-info" v-if="userProfile.role_id == 2">
                                    <div>
                                        <p class="m-b-10" > Membre </p>
                                        <div class="type-1">
                                            <button @click="userUpdate(userProfile)" class="btn btn-1">
                                            <span class="txt">Editer profil</span>
                                            <span class="round"><i class="fa fa-chevron-right"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div v-if="this.$store.state.userLogged.role_id == 1" class="btn-backAdmin">
                                        <div class="type-1 adminbtn">
                                            <button type="button" @click="setAdminProfil" class="btn btn-1">
                                            <span class="txt">Retour au profil Administrateur</span>
                                            <span class="round"><i class="fa fa-chevron-right"></i></span>
                                            </button>
                                        </div>
                                        <div class="type-1 adminbtn">
                                            <router-link to="/adminview" class="btn btn-1">
                                            <span class="txt">Panneau administration</span>
                                            <span class="round"><i class="fa fa-chevron-right"></i></span>
                                            </router-link>
                                        </div>
                                    </div>
                                    <div v-if="this.$store.state.userLogged.role_id == 2" class="type-1">
                                        <router-link to="/updatepassword" class="btn btn-1">
                                        <span class="txt">Modifier mot de passe</span>
                                        <span class="round"><i class="fa fa-chevron-right"></i></span>
                                        </router-link>
                                    </div>
                                </div>
                                <div v-else>
                                    <p class="m-b-10" > Administrateur </p>
                                    <div class="type-1">
                                        <router-link to="/updatepassword" class="btn btn-1">
                                        <span class="txt">Modifier mot de passe</span>
                                        <span class="round"><i class="fa fa-chevron-right"></i></span>
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                            <!-- END profile-header-info -->
                        </div>
                        <!-- END profile-header-content -->
                        <ul class="profile-header-tab nav nav-tabs">
                            <li class="nav-item"><a href="#profile-about" class="nav-link active show"
                                    data-toggle="tab">PROFIL</a></li>
                            <li class="nav-item"><a href="#profile-activity" class="nav-link"
                                    data-toggle="tab">ACTIVITE</a></li>
                        </ul>
                    </div>
                </div>
                <!-- end profile -->
                <!-- begin profile-content -->
                <div class="profile-content">
                    <div class="tab-content p-0">
                        <div class="tab-pane fade in active show" id="profile-about">
                            <div class="table-responsive">
                                <table class="table table-profile">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>
                                                <h4> {{ userProfile.pseudo }} <small> Membre </small></h4>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="highlight">
                                            <td class="field">Email</td>
                                            <td> {{ userProfile.email }} </td>
                                        </tr>
                                        <tr class="divider">
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td class="field">Status</td>
                                            <td v-if="userProfile.role_id == 1"> Administrateur </td>
                                            <td v-if="userProfile.role_id == 2"> Membre </td>
                                        </tr>
                                        <tr class="divider">
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr class="highlight">
                                            <td class="field">Date de création</td>
                                            <td> {{ dateConverted.toLocaleDateString("fr-FR", options) }} </td>
                                        </tr>
                                        <tr class="divider">
                                            <td colspan="2"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- begin #profile-activity tab -->
                        <UserActivity/>
                        <!-- end #profile-activity tab -->
                    </div>
                </div>
                <!-- end profile-content -->
            </div>
        </div>
    </div>
</template>

<script>
import UserActivity from '../components/UserActivity';

export default {
    name: 'UserProfileDetail',
    components: {
        UserActivity
    }, 
    data(){
        return {
            dateConverted: new Date(this.$store.state.user.date_creation),
            options : { year: "numeric", month: "long", day: "numeric", hour: "numeric", minute: "numeric" }
        }
    },
    computed: {
        userProfile(){
            return this.$store.state.user;
        },
        convertDate(){
            return this.dateConverted
        }
    },
    methods: {
        setAdminProfil(){
            this.$store.commit("changeUser", this.$store.state.userLogged);
        },
        userUpdate(){
            this.$store.commit("changeUser", this.$store.state.user);
            this.$router.push("/userupdate");
        }
    }
};
</script>

<style scoped>
.adminbtn{
    margin-top: 1%;
}
</style>