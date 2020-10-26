<template>
  <section class="page">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1 class="h1">Trouver un professionnel de sante</h1>
        </div>
      </div>
    </div>
    <div class="liquid-container">
      <div class="breadcrumbs">
        <a class="breadcrumb-item breadcrumb-item-first" to="/">
          <i class="fas fa-home"></i>
        </a>
        <i class="fas fa-chevron-right breadcrumb-separator"></i>
        <span class="breadcrumb-item breadcrumb-item-last">Annuaire</span>
      </div>
    </div>
    <div class="container">
        <div class="search-med-advanced-form">
          <h3>Qualifications</h3>
          <div class="cn-form-group">
            <div class="row">
              <div class="col-lg-4">
                <div class="form-item form-type-select form-item-discipline">
                  <label for="edit-profession">Profession</label>
                  <select icon="user-md" name="profession" id="edit-profession" class="form-select form-control"  v-model="selected_profession">
                    <option value="" :selected="true">Selectionner une profession</option>
                    <option v-for="profession in options_professions" :key="profession">
                      {{ profession }}
                    </option>
                  </select><i class="select-icon fas fa-chevron-down"></i>
                </div>
              </div>
              <div class="col-lg-4">

                <div class="form-item form-type-select form-item-orientation">
                  <label for="edit-regroupement">Regroupement</label>
                  <select id="edit-regroupement" name="regroupement" class="form-select form-control" v-model="selected_groupement">
                    <option value="" selected="selected">Selectionner un regroupement</option>
                    <option v-for="groupement in options_groupementActs"  :key="groupement" >
                      {{ groupement }}
                    </option>
                  </select><i class="select-icon fas fa-chevron-down"></i>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-item form-type-select form-item-titres">
                  <label for="edit-mode_exercice">Mode d'exercice particulier </label>
                  <select id="edit-mode_exercice" name="mode_exercice" class="form-select form-control" v-model="selected_mode_exercice">
                    <option value="" selected="selected">Selectionner un mode d'exercice</option>
                    <option v-for="mode in options_mode_exercice"  :key="mode" >
                      {{ mode }}
                    </option>
                  </select><i class="select-icon fas fa-chevron-down"></i>
                </div>
              </div>
            </div>
          </div>
          <h3>Etat Civil</h3>
          <div class="cn-form-group">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-item form-type-textfield form-item-nom-exercice">
                  <label for="edit-nom-exercice">Nom exercice </label>
                  <input placeholder="Nom exercice" class="form-control form-text" type="text" id="edit-nom-exercice"
                    name="nom_professionnel" v-model="nom_professionnel" size="60" maxlength="255" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-item form-type-textfield form-item-prenom">
                  <label for="edit-prenom">Prénom </label>
                  <input placeholder="Prénom" class="form-control form-text" type="text" id="edit-prenom" name="prenom"
                    v-model="prenom_professionnel" size="60" maxlength="255" />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <h3>Statut</h3>
              <div class="cn-form-group">
                <div class="form-item form-type-radios form-item-statut">
                  <label class="element-invisible" for="edit-statut">Statut </label>
                  <div id="edit-statut" class="form-radios">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-item form-type-radio form-item-statut custom-control custom-radio"><input
                            type="radio" id="edit-statut-1" name="statut" v-model="selected_status" value="Libéral intégral"
                            class="form-radio custom-control-input" /> <label class="option custom-control-label"
                            for="edit-statut-1"><span>Libéral intégral </span></label>
                        </div>
                        <div class="form-item form-type-radio form-item-statut custom-control custom-radio"><input
                            type="radio" id="edit-statut-2" name="statut" v-model="selected_status" value="Libéral activité salariée"
                            class="form-radio custom-control-input" /> <label class="option custom-control-label"
                            for="edit-statut-2"><span>Libéral activité salariée </span></label>
                        </div>
                        <div class="form-item form-type-radio form-item-statut custom-control custom-radio"><input
                            type="radio" id="edit-statut-3" name="statut" v-model="selected_status" value="Libéral temps partiel hospitalier"
                            class="form-radio custom-control-input" /> <label class="option custom-control-label"
                            for="edit-statut-3"><span>Libéral temps partiel hospitalier </span></label>
                        </div>
                        <div class="form-item form-type-radio form-item-statut custom-control custom-radio"><input
                            type="radio" id="edit-statut-4" name="statut" v-model="selected_status" value="Libéral temps plein hospitalier"
                            class="form-radio custom-control-input" /> <label class="option custom-control-label"
                            for="edit-statut-4"><span>Libéral temps plein hospitalier </span></label>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-item form-type-radio form-item-statut custom-control custom-radio"><input
                            type="radio" id="edit-statut-5" name="statut" v-model="selected_status" value="T. plein hosp. contrat mixte"
                            class="form-radio custom-control-input" /> <label class="option custom-control-label"
                            for="edit-statut-5"><span>T. plein hosp. contrat mixte </span></label>
                        </div>
                        <div class="form-item form-type-radio form-item-statut custom-control custom-radio"><input
                            type="radio" id="edit-statut-6" name="statut" v-model="selected_status" value="T. plein hosp./mal. aut. med"
                            class="form-radio custom-control-input" /> <label class="option custom-control-label"
                            for="edit-statut-6"><span>T. plein hosp./mal. aut. med </span></label>
                        </div>
                        <div class="form-item form-type-radio form-item-statut custom-control custom-radio"><input
                            type="radio" id="edit-statut-7" name="statut" v-model="selected_status" value="N’exerce pas actuellement"
                            class="form-radio custom-control-input" /> <label class="option custom-control-label"
                            for="edit-statut-7"><span>N’exerce pas actuellement </span></label>
                        </div>
                        <div class="form-item form-type-radio form-item-statut custom-control custom-radio"><input
                            type="radio" id="edit-statut-8" name="statut" v-model="selected_status" checked="checked"
                            class="form-radio custom-control-input" /> <label class="option custom-control-label"
                            for="edit-statut-8"><span>Indifférent </span></label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h3>Sexe</h3>
              <div class="cn-form-group">
                <div class="form-item form-type-radios form-item-sexe">
                  <label class="element-invisible" for="edit-sexe">Sexe </label>
                  <div id="edit-sexe" class="form-radios">
                    <div class="form-item form-type-radio form-item-sexe custom-control custom-radio"><input
                        type="radio" id="edit-sexe-1" name="sexe" v-model="selected_civilite" value="Homme" class="form-radio custom-control-input" />
                      <label class="option custom-control-label" for="edit-sexe-1"><span>Masculin </span></label>
                    </div>
                    <div class="form-item form-type-radio form-item-sexe custom-control custom-radio"><input
                        type="radio" id="edit-sexe-2" name="sexe" v-model="selected_civilite" value="Femme" class="form-radio custom-control-input" />
                      <label class="option custom-control-label" for="edit-sexe-2"><span>Feminin </span></label>
                    </div>
                    <div class="form-item form-type-radio form-item-sexe custom-control custom-radio"><input
                        type="radio" id="edit-sexe-3" name="sexe" v-model="selected_civilite"  checked="checked"
                        class="form-radio custom-control-input" /> <label class="option custom-control-label"
                        for="edit-sexe-3"><span>Indifférent </span></label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <h3>Localisation</h3>
          <div id="place-ajax-wrapper" class="cn-form-group">
            <div id="edit-place" class="form-wrapper">
              <div id="place-ajax-wrapper" class="cn-form-group">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-item form-type-select form-item-region">
                      <label for="region">Région </label>
                      <select id="region" name="region" class="form-select form-control" v-model="selected_region">
                        <option value="" selected="selected">Selectionner une région</option>
                        <option v-for="region in options_regions"  :key="region">
                          {{ region }}
                        </option>
                      </select><i class="select-icon fas fa-chevron-down"></i>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-item form-type-select form-item-departement">
                      <label for="departement">Département </label>
                      <select id="departement" name="departement" class="form-select form-control" v-model="selected_departement">
                        <option value="" selected="selected">Selectionner un département</option>
                        <option v-for="departement in options_departements"  :key="departement">
                          {{ departement }}
                        </option>
                      </select><i class="select-icon fas fa-chevron-down"></i>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-item form-type-textfield form-item-localite">
                      <label for="edit-localite">Commune </label>
                      <input placeholder="Commune" class="form-control form-text" type="text" id="edit-localite"
                        name="commune" size="60" maxlength="30" v-model="commune"/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-lg-12">
              <input class="btn btn-primary form-submit" type="submit" id="submit_adv_search" name="op"
                value="Rechercher" @click="sendDataResearch"/> </div>
          </div>
        </div>
        <b-modal id="modalErrorData" ref="errorData"  hide-footer title="Erreur Recherche" center>
            <div>
              Veuillez renseignez au moins un élément de recherche.
            </div>
        </b-modal>
    </div>
  </section>
</template>

<script>
import Axios from 'axios';
  export default {
    name: "ResearchDesigned",
    data() {
      return {

            nom_professionnel: '',
            prenom_professionnel: '',
            selected_profession: '',
            selected_civilite: '',
            selected_groupement: '',
            selected_mode_exercice: '',
            selected_status: '',
            selected_region: '',
            selected_departement: '',
            commune: '',
  
        options_professions: [],
        options_groupementActs: [],
        options_mode_exercice: [],
        options_regions: [],
        options_departements: [],
        field_data: 0,
        emptyDataResearch: false
      };
    },
    methods: {
      /*-- Récupération données de l'API pour afficher des éléments de recherche --*/
      getProfessions(){
          Axios
          .get("http://localhost/annuairesante/backend/index.php", { params: {
              route: 'professions',
              }}
          )
          .then( response => {
              response.data.professions.forEach(element => {
                if(element.profession){
                  this.options_professions.push(element.profession);
                }
              });
          })
          .catch(error => {
              console.log(error)
              this.errored = true
          })
      },
      getGroupementsActs(){
          Axios
          .get("http://localhost/annuairesante/backend/index.php", { params: {
              route: 'groupementsActs',
              }}
          )
          .then( response => {
              response.data.groupementsActs.forEach(element => {
                if(element.regroupement && element.regroupement != 'None'){
                  this.options_groupementActs.push(element.regroupement);
                }
              });
          })
          .catch(error => {
              console.log(error)
              this.errored = true
          })
      },
      getModeExercices(){
          Axios
          .get("http://localhost/annuairesante/backend/index.php", { params: {
              route: 'modes_exercice',
              }}
          )
          .then( response => {
              response.data.modes_exercice.forEach(element => {
                if(element.mode_exercice){
                  this.options_mode_exercice.push(element.mode_exercice);
                }
              });
          })
          .catch(error => {
              console.log(error)
              this.errored = true
          })
      },
      getRegions(){
          Axios
          .get("http://localhost/annuairesante/backend/index.php", { params: {
              route: 'regions',
              }}
          )
          .then( response => {
              response.data.regions.forEach(element => {
                if(element.region){
                  this.options_regions.push(element.region);
                }
              });
          })
          .catch(error => {
              console.log(error)
              this.errored = true
          })
      },
      getCities(){
          Axios
          .get("http://localhost/annuairesante/backend/index.php", { params: {
              route: 'cities',
              }}
          )
          .then( response => {
              response.data.departements.forEach(element => {
                if(element.departement){
                  this.options_departements.push(element.departement);
                }
              });
          })
          .catch(error => {
              console.log(error)
              this.errored = true
          })
      },
      /*---*/
      checkFieldsData(){
        if(this.nom_professionnel == '' && this.selected_profession == '' && this.selected_civilite== '' && this.selected_groupement == '' && this.selected_mode_exercice == ''
          && this.selected_status == '' && this.selected_region == '' && this.selected_departement == '' && this.commune == '') {
            return true;
        } else {
          return false;
        }

        // for (const property in this.dataResearch) {
        //   if (this.dataResearch[property]  != null){
        //     this.field_data+=1;
        //   }
        // }
      },
      sendDataResearch() {
        // this.checkFieldsData();
        if(this.checkFieldsData()){
          this.emptyDataResearch = true;
          this.$refs['errorData'].show();
        }
        else{
          this.$emit('data-sent', { 'newRequest': true, 'nom_professionnel': this.nom_professionnel, 'selected_profession': this.selected_profession,
          'selected_civilite': this.selected_civilite,  'selected_groupement': this.selected_groupement, 'selected_mode_exercice': this.selected_mode_exercice,
          'selected_status': this.selected_status, 'selected_region': this.selected_region, 'selected_departement': this.selected_departement, 
          'commune': this.commune });
        }
      }, 
    },
    beforeMount(){
      this.getProfessions();
      this.getModeExercices();
      this.getGroupementsActs();
      this.getRegions();
      this.getCities();
    }
  }
</script>

<style>

.page{
  flex: 1 0 auto;
}
.h1 {
    font-size: 4rem !important;
    font-weight: 400 !important;
    margin: 30px 0 !important;
}
.container{
  max-width: 1600px !important;
}
.liquid-container {
    max-width: 1600px;
    margin: auto;
    padding: 0 15px;
}
.breadcrumbs {
    background-color: #2962FF;
    display: flex;
    height: 2rem;
    line-height: 2rem;
    margin: 1rem 0 1rem 0;
    overflow: hidden;
    padding: 0 0 0 10px;
    align-items: center;
}
.breadcrumbs .breadcrumb-item {
    color: #fff !important;
    font-size: 0.875rem;
}
a{
    color: #2962FF;
    text-decoration: none;
    background-color: transparent;
}
.fa, .fas {
    font-weight: 900;
}
.fa, .fab, .fal, .far, .fas {
    -moz-osx-font-smoothing: grayscale;
    -webkit-font-smoothing: antialiased;
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    line-height: 1;
}
.breadcrumbs .breadcrumb-separator {
    color: #fff;
    font-size: 0.75rem;
    line-height: 2rem;
    margin: 0 0.25rem;
}

/*Test design research component*/
.search-med-advanced-form h3 {
    font-size: 1.3rem !important;
    font-weight: 700 !important;
    line-height: 1.2;
}
.cn-form-group {
    background-color: rgba(41,98,255,0.1);
    border-radius: 8px;
    margin-bottom: 1.5rem;
    padding: 15px;
}
.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
.search-med-advanced-form .form-item {
    padding: 0 1rem;
}
.form-item, .form-actions {
    margin-top: 1em;
    margin-bottom: 1em;
}
.form-radios .form-item {
    margin-top: 0.4em;
    margin-bottom: 0.4em;
}
.element-invisible {
    position: absolute !important;
    clip: rect(1px 1px 1px 1px);
    clip: rect(1px,1px,1px,1px);
    overflow: hidden;
    height: 1px;
}
.search-med-advanced-form label {
    display: inline-block;
    margin-bottom: 0.5rem;
    font-weight: bold;
}
.form-control {
    min-height: 48px;
    color: #8A8D94;
    letter-spacing: -0.25px;
    display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;
}
.search-med-advanced-form select {
    -webkit-appearance: none;
    -moz-appearance: none;
    -o-appearance: none;
    appearance: none;
}
.search-med-advanced-form button, select {
    text-transform: none;
}
.search-med-advanced-form select + i.select-icon {
    background-color: transparent;
    color: #2962FF;
    float: right;
    margin-top: -31px;
    margin-right: 10px;
    padding-right: 5px;
    pointer-events: none;
}
.fa-chevron-down::before {
    content: "\f078";
}
.search-med-advanced-form select option {
    padding-right: 21px;
}
.custom-control {
    position: relative;
    display: block;
    min-height: 1.5rem;
}
.custom-control-input {
    position: absolute;
    z-index: -1;
    opacity: 0;
}
label.option {
    display: inline;
    font-weight: normal;
}
.custom-control-label {
    position: relative;
    margin-bottom: 0;
    vertical-align: top;
}
.search-med-advanced-form .btn, .search-med-advanced-form button.btn, .search-med-advanced-form input.btn, .search-med-advanced-form a.btn, 
.search-med-advanced-form button.btn, .search-med-advanced-form input.btn, .search-med-advanced-form a.btn {
    font-size: 16px;
    border: none;
    border-radius: 150px;
    color: #fff;
    font-weight: 400;
    line-height: 2;
    margin: 0 5px 10px;
    min-height: 40px;
    padding: 0.5rem 0.75rem;
    width: 200px;
}
.search-med-advanced-form .btn, .search-med-advanced-form button.btn, .search-med-advanced-form input.btn, .search-med-advanced-form a.btn {
    display: inline-block;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;
}
.search-med-advanced-form .btn-primary, .search-med-advanced-form .btn-primary2 {
    background-color: #2962FF !important;
    color: #fff !important;
}
.search-med-advanced-form .btn-primary:not(:disabled):not(.disabled):hover, .search-med-advanced-form.btn-primary2:not(:disabled):not(.disabled):hover {
    background-color: #1d45b3 !important;
}
.search-med-advanced-form input {
    overflow: visible;
}
.custom-control-label::before, .custom-control-label::after {
    top: 0 !important;
}

#modalErrorData .modal-content{
    align-items: center;
    color: red;
}

@media (min-width: 374px) and (max-width: 1024px) {
  .h1{
      font-size: 2rem !important;
  }
}
</style>