<template>
	<div id="content">
    <nav class="navbar navbar-expand-lg navbar-blue bg-blue fixed-top">
      <div class="container">
        <router-link to="/" class="nav-link">
          <span class="cursive">Annuaire Santé</span>
        </router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
          aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <router-link to="/" class="nav-link">Accueil</router-link>
              </li>
              <li class="nav-item">
                <router-link to="/researchworkers" class="nav-link">Trouver un professionnel de Sante</router-link>
              </li>
              <li class="nav-item">
                <router-link to="/about" class="nav-link">A propros</router-link>
              </li>
              <li class="nav-item">
                <Login v-if="checkSession === false" ></Login>
                <Logout v-if="checkSession === true" ></Logout>
              </li>
          </ul>
        </div>
      </div>
    </nav>
    <router-view />
	</div>
</template>

<script>
import Login from '@/components/Login';
import Logout from '@/components/Logout';
  export default {
    name: 'NavBar',
    components: {
      Login,
      Logout
    },
    data(){
      return {
      };
    },
    computed:{
      checkSession(){
        return this.$store.state.sessionConnected;
      },
      checkRole(){
        return this.$store.state.userLogged.role_id;
      }
    },
    methods: {
      display(){
        this.$store.commit("changeUser", this.$store.state.userLogged);
      }
    },
    // beforeMount(){
    //   if(localStorage.sessionLog){
    //     console.log('ok récup');
    //     this.$store.commit("changeSessionState", localStorage.sessionLog );
    //     this.$store.commit("setUserLogged", localStorage.user );
    //     this.$store.commit("changeUser", localStorage.user );
    //   }
    // },
  }
</script>

<style>
.navbar-expand-lg .navbar-nav {
    align-items: center;
}
.navbar {
  background-color: #2962FF !important;
}
.cursive{
	display: block;
	font-size: 2.5em;
	color: #fff;
	font-family: "Brush Script MT", cursive;
}

.navbar a{
  color: white !important;
  font-weight: 400;
}
.nav-link:hover{
  color: rgba(158, 154, 154, 0.94) !important;
}
.navbar ul{
  margin-top: none !important;
}
.ml-auto{
  margin-left: 35% !important;
  margin-top: none !important;
}
.return-error{
  text-align: center;
  color: red;
}
/*Buttons designs */
header .header.header-main {
    color: #fff;
}
.account-wrapper {
    align-self: center;
    display: flex;
    flex-direction: row-reverse;
}
.account.btn {
  background-color: #1000C1;
    color: #fff;
    border-radius: 30px;
    font-weight: 400;
  text-transform: inherit;
    margin-bottom: 0px;
    margin-left: 15px;
    margin-right: 0;
    padding-left: 25px;
    position: relative;
    z-index: 2;
    -webkit-box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14),0 1px 10px 0 rgba(0,0,0,0.12),0 2px 4px -1px rgba(0,0,0,0.3);
    box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14),0 1px 10px 0 rgba(0,0,0,0.12),0 2px 4px -1px rgba(0,0,0,0.3);
}
.account.btn i.user-pic {
    font-size: 25px;
    position: absolute;
    left: -15px;
    top: -2px;
    z-index: 2;
    border: 3px solid white;
    border-radius: 50%;
    padding: 10px 10px 10px 10px;
    background-color: #1000C1;
}
.account.btn:hover, .dropdown-menu a {
    background: #00BFA5;
    color: #fafbfd;
}

/*Account button design*/
.navbar-expand-lg .navbar-nav .dropdown-menu {
    align-items: center;
}
.dropdown .dropdown-menu {
    top: 100% !important;
    z-index: 1000;
    padding: .5rem 0;
    margin: .125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: center;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: .25rem;
    overflow: visible;
    width: 230px;
}
.dropdown-menu-right {
    right: -10px !important;
}
.btn-group > .btn,
.btn-group-vertical > .btn {
  position: relative;
  float: left;
}
/*---*/

@media (min-width: 320px) and (max-width: 990px) {
	.account.btn {
		margin-left: 0;
	}
}
/*---*/

@media (min-width: 991px) {
  .navbar {
    height: 90px;
  }
}
@media (min-width: 991px) and (max-width: 1090px) {
  .navbar-expand-lg .navbar-collapse {
    font-size: 14px;
  }
}
@media (min-width: 320px) and (max-width: 990px) {
  .navbar-expand-sm .navbar-toggler{
    display: inline-block !important;
  }
  .navbar-expand-sm {
    flex-flow: row nowrap;
    justify-content: flex-start;
  }
  .navbar-blue .navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.94)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E") !important;
  }
  .navbar-expand-lg .navbar-nav {
    align-items: flex-start !important;
    padding-left: 11px;
  }
}
</style>