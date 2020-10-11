<template>
    <b-container>
        <!-- <div class="cantViewOnMap" v-if="cantViewOnMap">
            <p>Les résultats sont trop nombreux pour tous être affichés sur la carte. Seul 25 résultats sont indiqués!</p>
        </div> -->
        <div class="map" id="map">   
        </div>
    </b-container>
</template>

<script>
import L from 'leaflet';
import { mapGetters } from 'vuex';

export default{
    data() {
        return {
            map: null,
            tileLayer: null,
            layerGroup: null,
            placeList: [],
            markerIcon: L.icon({
                iconUrl: 'https://api.geoapify.com/v1/icon/?type=awesome&color=red&icon=clinic-medical&apiKey=9631b09f915244728e90c98a650d59f5'
            }),
            // cantViewOnMap: false,
            lat: null,
            long: null,
            cats: []
        }
    },
    computed: {
        ...mapGetters({ workerMarkers: "getMarkers" }),
    },
    mounted() {
        this.initMap(); 
    },
    methods: {
        initMap() { 
            // INIT MAP
            this.map= L.map('map').setView([48.8534, 2.3488], 5);
            this.tileLayer =  L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png');  
            this.tileLayer.addTo(this.map); 
        },

        initMarkers() {
            let latMarker, longMarker;
            let layers = [];
            const self = this;
            this.$store.state.markers.forEach((element) => {
                if (element.coordonnees != ''){
                    const coords = element.coordonnees.split(',');
                    latMarker = parseFloat(coords[0]);
                    longMarker = parseFloat(coords[1]);
                    let marker= L.marker([latMarker, longMarker], {icon: self.markerIcon});
                    layers.push(marker);
                    let popupContent = element.contact+' / '+element.profession;
                    marker.bindPopup(popupContent);
                }
            });
            this.layerGroup = L.layerGroup(layers);
            this.layerGroup.addTo(this.map);
            this.lat = latMarker;
            this.long = longMarker;
        },
        clearLayersOfResearch(){
            if(this.map.hasLayer(this.layerGroup)){
                this.layerGroup.clearLayers();
            }
            else {
                console.log('No Layers on Map!');
            }
        }, 
   },

   watch: {
        workerMarkers: function(){
            this.initMarkers();
        },
        lat: function(){
            this.map.setView([this.lat, this.long], 10);
        }
   }

}
</script>

<style>
#map {
    width: 70%;
    height: 450px;
    margin: 4% 15% 4% 15%;
    border: 1px solid black;
    z-index: 99 !important;
    position: relative;
}

.leaflet-popup-content-wrapper {
    border: 1px solid #929292 !important;
    box-shadow: 0px 2px 4px 2px rgba(0,0,0,.1) !important;
}

.leaflet-popup-content-wrapper div{
    position: relative !important;
    z-index: 5 !important;
}

.leaflet-popup-content-wrapper:before {
    content: '' !important;
    position: absolute !important;
    top: -webkit-calc(100% - 9px) !important;
    top: calc(100% - 9px) !important;
    left: calc(50% - 10px) !important; 
    height: 20px !important;
    width: 20px !important;
    background: white !important;
    transform: rotate(45deg) !important;
    border-bottom: inherit !important;
    border-right: inherit !important;
    box-shadow: 4px 4px 4px -1px rgba(0, 0, 0, 0.1) !important;
    z-index: 4 !important;
}

.leaflet-popup{
    left: -162px !important;
}
.cantViewOnMap{
    text-align: center;
    font-weight: bold;
}
</style>