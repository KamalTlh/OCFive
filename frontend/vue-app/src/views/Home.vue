<template>
	<div id="app" class="app">
    <section>
      <Slider></Slider>
    </section>
    <section>
      <hr>
      <!-- Carte de France interactive -->
      <article class="container mt-5 map" id="map">
        <div class="map__image col-lg-6 p-5">
          <MapFr @afficher="viewdep"></MapFr>
        </div>
          <!-- Liste des régions -->
        <div class="map__list col-lg-3 d-flex flex-column justify-content-center p-5">
          <ul class="list-group">
            <li id="li-GES" class="list-group-item"><a href="/region/index/Grand-Est" id="list-GES">Grand-Est</a></li>
            <li id="li-NAQ" class="list-group-item"><a href="/region/index/Nouvelle-Aquitaine"
                id="list-NAQ">Nouvelle-Aquitaine</a></li>
            <li id="li-ARA" class="list-group-item"><a href="/region/index/Auvergne-Rhone-Alpes"
                id="list-ARA">Auvergne-Rhône-Alpes</a></li>
            <li id="li-BFC" class="list-group-item"><a href="/region/index/Bourgogne-Franche-Comte"
                id="list-BFC">Bourgogne-Franche-Comté</a></li>
            <li id="li-BRE" class="list-group-item"><a href="/region/index/Bretagne" id="list-BRE">Bretagne</a></li>
            <li id="li-CVL" class="list-group-item"><a href="/region/index/Centre-Val-de-Loire"
                id="list-CVL">Centre-Val-de-Loire</a></li>
            <li id="li-COR" class="list-group-item"><a href="/region/index/Corse" id="list-COR">Corse</a></li>
            <li id="li-IDF" class="list-group-item"><a href="/region/index/Ile-de-France"
                id="list-IDF">Île-de-France</a></li>
            <li id="li-OCC" class="list-group-item"><a href="/region/index/Occitanie" id="list-OCC">Occitanie</a></li>
            <li id="li-HDF" class="list-group-item"><a href="/region/index/Hauts-de-France"
                id="list-HDF">Hauts-de-France</a></li>
            <li id="li-NOR" class="list-group-item"><a href="/region/index/Normandie" id="list-NOR">Normandie</a></li>
            <li id="li-PDL" class="list-group-item"><a href="/region/index/Pays-de-la-Loire"
                id="list-PDL">Pays-de-la-Loire</a></li>
            <li id="li-PAC" class="list-group-item"><a href="/region/index/Provence-Alpes-Cote-d'Azur"
                id="list-PAC">Provence-Alpes-Côte-d'Azur</a></li>
          </ul>
      </div>
      </article>
    </section>
    <!-- inclusion du footer -->
    <footer class="mt-5">
    </footer>
    <!--/.footer-->
    <p class="text-center"><small>&copy; 2018 - Tout droits réservés / SIte réalisé par Kamal Tallih.</small></p>
	</div>
</template>

<script>
import MapFr from '../components/MapFr';
import Slider from '../components/Slider';
export default {
	name: "Contact",
	components: {
    MapFr,
    Slider
	},
	methods: {
		viewdep(payload){
			alert ('Message: '+payload.message);
		}
	}
}
</script>

<style>
#map{
  display: flex;
}
.col-lg-3 {
    padding: 0 !important; 
}
  
@media all and (max-width: 575px) {
  img.float-right {
    float: none !important; }

  .col-sm-3 {
    display: flex;
    justify-content: center; } }
@media all and (max-width: 991px) {
  .col-lg-9 {
    margin-top: 1rem; } }
/*---------MAP----------*/
.map__list{
  background-color: rgb(245,255,250) !important;
}

.map__list a {
  color: inherit;
  text-decoration: none;
  transition: color 0.3s;
  display: block;
  padding: 0;
  margin: 0; 
}
.map__list a:hover{
    text-decoration: none;
}
.list-group{
  background: url("/images/maintenance_bas.gif") no-repeat scroll 0 0 #0000004d;
  clear: both;
  height: 430px;  
}

.list-group-item {
  background-color: rgb(245,255,250) !important;
  padding: .3rem 1rem !important;
  border: none !important;
}
</style>