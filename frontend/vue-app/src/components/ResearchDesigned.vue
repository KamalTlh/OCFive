<template>
  <mdb-card>
    <mdb-card-header class="pt-4 amy-crisp-gradient">
      <mdb-card-title><strong>Filtre de recherche</strong></mdb-card-title>
    </mdb-card-header>
    <mdb-card-body>
      <mdb-row>
        <mdb-col>
          <mdb-input label="Commune" icon="globe-europe" v-model="commune" />
        </mdb-col>
        <mdb-col>
          <b-form-select label="Profession" icon="user-md" v-model="selected_profession">
            <option v-for="profession in options_professions" v-bind:key="profession.text" v-bind:value="profession.value">
              {{ profession.text }}
            </option>
          </b-form-select>
        </mdb-col>
      </mdb-row>
      <mdb-row>
        <mdb-col>
          <mdb-input label="Nom" icon="user-md" v-model="nom_professionnel" />
        </mdb-col>
        <mdb-col>
               <b-form-group>
                    <b-form-radio-group
                        v-model="selected_civilite"
                        :options="options_civilite"
                        name="radio-inline"
                    ></b-form-radio-group>
                </b-form-group>
        </mdb-col>
      </mdb-row>
    </mdb-card-body>
    <mdb-card-footer class="white d-flex justify-content-end">
      <mdb-btn gradient="amy-crisp" class="black-text" icon="search" @click="sendDataResearch" rounded>Rechercher</mdb-btn>
    </mdb-card-footer>
  </mdb-card>
  
</template>

<script>
  import {
    mdbRow,
    mdbCol,
    mdbInput,
    mdbBtn,
    mdbCard,
    mdbCardBody,
    mdbCardHeader,
    mdbCardTitle,
    mdbCardFooter
  } from "mdbvue";

  export default {
    name: "ResearchDesigned",
    components: {
      mdbRow,
      mdbCol,
      mdbInput,
      mdbBtn,
      mdbCard,
      mdbCardBody,
      mdbCardHeader,
      mdbCardTitle,
      mdbCardFooter
    },

    data() {
      return {
        commune: null, 
        civilite: null, 
        nom_professionnel: null,
        selected_profession: null,
        options_professions: [
          { value: null, text: 'Profession' },
          { text: "Médecin généraliste", value: "Médecin généraliste" },
          { text: 'Anatomo-Cyto-Pathol', value: 'Anatomo-Cyto-Pathol' },
          { text: 'Anesthésiste réanim', value: 'Anesthésiste réanim' },
          { text: 'Cancérologue  radio', value: 'Cancérologue  radio' },
          { text: "Radiologue", value: "Radiologue" }
        ],
        selected_civilite: null,
        options_civilite: [
            { text: "Homme", value: "Homme" },
            { text: "Femme", value: "Femme" },
        ]
      };
    },
    methods: {
      sendDataResearch() {
        this.$emit('data-sent', { 'newRequest': true, 'commune': this.commune, 'civilite': this.selected_civilite, 'profession': this.selected_profession, 'nom_professionnel': this.nom_professionnel });}, }
  }
</script>

<style>
.row{
  align-items: center;
}
.custom-select{
  border-top: 0px !important;
  border-left: 0px !important;
  border-right: 0px !important;
}
.card-header{
    text-align: center;
}
.amy-crisp-gradient {
    background-image: linear-gradient(120deg, #839fe3 0%, #d1d2e6 100%) !important;
}
.bv-no-focus-ring{
    padding-top: 3%;
}
</style>