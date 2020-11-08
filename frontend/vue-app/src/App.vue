<template>
	<div id="app">
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
     background: #007bff;
  background: linear-gradient(to right, #0062E6, #33AEFF);

}
#app{
  background-color: rgb(245,255,250);
  padding-top: 3%;
}

#app #content .pageAdmin, #app #content .password-update {
  padding-top: 7%;
}
body {
  background: #007bff;
  background: linear-gradient(to right, #0062E6, #33AEFF);
}

/*--Anchor scroll--*/
#anchor {
    position: absolute;
    top: 0;
}
.invisible-toolbar {
    display: flex;
    bottom: 20px;
    flex-direction: column-reverse;
    padding: 0;
    position: fixed;
    right: 50px;
    text-align: center;
    width: 40px;
    z-index: 10;
}
#scroll-top {
    background-color: #1000C1;
    display: block;
    text-align: center;
}
.action-link {
    height: 80px;
    width: 80px;
    background-color: #2962FF;
    border-radius: 50%;
    cursor: pointer;
    margin-top: 5px;
    transition: box-shadow 0.5s ease-out;
    -webkit-box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14),0 1px 10px 0 rgba(0,0,0,0.12),0 2px 4px -1px rgba(0,0,0,0.3);
    box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14),0 1px 10px 0 rgba(0,0,0,0.12),0 2px 4px -1px rgba(0,0,0,0.3);
}
.action-link:hover {
    -webkit-box-shadow: 0 24px 38px 3px rgba(0,0,0,0.14),0 9px 46px 8px rgba(0,0,0,0.12),0 11px 15px -7px rgba(0,0,0,0.2);
    box-shadow: 0 24px 38px 3px rgba(0,0,0,0.14),0 9px 46px 8px rgba(0,0,0,0.12),0 11px 15px -7px rgba(0,0,0,0.2);
}
.action-link#scroll-top i {
    font-size: 2.5rem;
    margin: 1.25rem;
}
#scroll-top i {
    color: #536DFE;
    font-size: 20px;
    line-height: 1;
    margin: 10px;
}
.action-link i {
    color: #fff;
    line-height: 40px;
    font-size: 1.25rem;
    text-align: center;
}
/*--*/

@media all and (max-width: 768px) {
    .invisible-toolbar {
      right: 25px;
    } 
    .action-link {
      height: 50px;
      width: 50px;
    }
    .action-link#scroll-top i {
      font-size: 1.5rem;
      margin: 0.75rem;
    }
}

</style>
