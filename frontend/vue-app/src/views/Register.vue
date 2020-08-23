<template>
    <div class="container my-4">
        <section id="register-form">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="pr-1">
                        <div class="card">
                            <h5 class="card-header info-color white-text text-center py-4">
                                <strong>Sign up</strong>
                            </h5>
                            <div class="card-body px-lg-5 pt-0">
                                <form v-on:submit.prevent="signIn" action='/' class="text-center" style="color: #757575;">
                                    <!-- First name -->
                                    <div class="md-form">
                                        <input type="text" v-model="pseudo" id="materialRegisterFormFirstName"
                                            class="form-control">
                                        <label for="materialRegisterFormFirstName">Pseudo</label>
                                    </div>

                                    <!-- E-mail -->
                                    <div class="md-form">
                                        <input type="email" v-model="email" id="materialRegisterFormEmail" class="form-control">
                                        <label for="materialRegisterFormEmail" class="active">E-mail</label>
                                    </div>

                                    <!-- Password -->
                                    <div class="md-form">
                                        <input type="password" v-model="password" id="materialRegisterFormPassword" class="form-control"
                                            aria-describedby="materialRegisterFormPasswordHelpBlock">
                                        <label for="materialRegisterFormPassword" class="active">Password</label>
                                        <small id="materialRegisterFormPasswordHelpBlock"
                                            class="form-text text-muted mb-4">
                                            At least 8 characters and 1 digit
                                        </small>
                                    </div>

                                    <!-- Sign up button -->
                                    <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
                                        type="submit" >Sign in</button>
                                    <hr>
                                    <!-- Terms of service -->
                                    <p>By clicking
                                        <em>Sign up</em> you agree to our
                                        <a href="" target="_blank">terms of service</a>

                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Axios from 'axios';
export default {
    name: 'register',
    data() {
        return {
            path: null,
            pseudo: null,
            email: null,
            password: null,
            registration: false
        }
    },
    methods: {
        signIn(){
        Axios
          .post("http://localhost/annuairesante/backend/index.php", {
            route: 'signIn',
            pseudo: this.pseudo,
            email: this.email,
            password: this.password
          })
          .then( response => {
            this.registration = response.data.registration;
            if ( this.registration === true ) {
                this.$session.set('signIn', 'Vous pouvez à présent vous connecter.');
                this.$router.push({ path: '/' });
                console.log(this.$session.get('signIn'));
            }
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
.row{
    justify-content: center;
}
</style>