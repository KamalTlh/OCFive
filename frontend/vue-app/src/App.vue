<template>
	<div id="app" class="app">
    <NavBar></NavBar>

	</div>
</template>

<script>
  import NavBar from '@/components/NavBar';
  export default {
    name: 'HelloWorld',
    components: {
      NavBar
    },
    data(){
      return {
        random : Math.random(),
      }
    },
  }
</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap');
html {
    font-family: arial,verdana,sans-serif;
    font-size: 1em;
    color: #000;
}
#app{
  background-color: rgb(245,255,250);
}
.navbar {
  background-color: #B0E0E6 !important;
  border-bottom: 0.3rem solid #BC8F8F;
}
.nav-link:hover{
  color: rgba(104, 112, 143, 0.94);
}
.btn-secondary.dropdown-toggle:hover{
  background-color: #7f15b3 !important;
}
.btn-secondary.dropdown-toggle{
  background-color: #B0E0E6 !important;
}

.btn.btn-outline-warning {
  color: #A0522D !important; 
}
.show > .btn-outline-warning.dropdown-toggle {
  background-color: #ff8c00 !important;
  color: rgba(0, 0, 0, 0.7) !important; 
}
.btn-connexion:hover{
  background-color: #7f15b3 !important;
  color: #fb3 !important;
}
.btn-connexion{
  background-color: #B0E0E6 !important;
  border: 3px solid #fb3 !important;
}

.ml-auto{
  margin-left: 35% !important;
}
.navbar-nav{
  padding-left: 10% !important;
}
</style>
