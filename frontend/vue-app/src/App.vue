<template>
	<div id="app">
    <strong> {{ random }} </strong>
    <div id="anchor"></div>
        <div v-if="showToolbar" class="invisible-toolbar">
            <a href="#anchor"><div id="scroll-top"  class="action-link"><i class="fas fa-chevron-up"></i></div></a>
    </div>
    <NavBar></NavBar>
    <Footer></Footer>
	</div>
</template>

<script>
  import NavBar from '@/components/NavBar';
  import Footer from '@/components/Footer';
  export default {
    name: 'HelloWorld',
    components: {
      NavBar,
      Footer
    },
    data(){
      return {
        random : Math.random(),
        showToolbar: false
      }
    },
    methods: {
      handleScroll() {
            if( window.scrollY > 500){
                this.showToolbar = true;
            }
            else {
                this.showToolbar = false;
            }
      }
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll);
    }
  }
</script>

<style>
@import url('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap');
html {
    font-family: arial,verdana,sans-serif;
    font-size: 1em;
    color: #000;
}
#app{
  background-color: rgb(245,255,250);
  padding-top: 3%;
}

#app #content .pageAdmin, #app #content .password-update {
  padding-top: 7%;
}

</style>
