<template>
<header>
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
      <!-- Slide One - Set the background image for this slide in the line below -->
      <div class="carousel-item active" style="background-image: url('images/yoga-4541268_1920.jpg')">
        <div class="carousel-caption d-md-block">
          <h2 class="display-4">Bien-être</h2>
          <p class="lead">Prenez soin de votre corps et esprit.</p>
        </div>
      </div>
      <!-- Slide Two - Set the background image for this slide in the line below -->
      <div class="carousel-item" style="background-image: url('images/vaccine-5103088_1920.jpg')">
        <div class="carousel-caption d-md-block">
          <h2 class="display-4">Des professionnels de santé à votre service.</h2>
          <p class="lead">Contactez un médecin professionnel et prenez rendez-vous auprès de lui.</p>
        </div>
      </div>
      <!-- Slide Three - Set the background image for this slide in the line below -->
      <div class="carousel-item" style="background-image: url('images/stethoscope-2617701_1920.jpg')">
        <div class="carousel-caption d-md-block">
          <h2 class="display-4">Des professionnels de santé à votre service.</h2>
          <p class="lead">Contactez un médecin professionnel et prenez rendez-vous auprès de lui.</p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
  </div>
</header>
</template>

<script>
  export default {
    name: "Slider",
    data() {
      return {
        slide: 0,
        sliding: null
      }
    },
    methods: {
    }
  }
</script>

<style scoped>
.carousel-item {
  height: 60vh;
  min-height: 350px;
  background: no-repeat center center scroll;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>