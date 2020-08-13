<template>
	<b-container fluid="md">
		<h3> Filtre de recherche </h3>
		<b-row class="my-1">
			<b-col sm="3">
				<label for="find-item-commune">Commune : </label>
			</b-col>
			<b-col sm="9">
				<b-form-input  v-model="commune" placeholder="Entrez" id="find-item-commune" type="string" />
			</b-col>
		</b-row>
		<b-row class="my-1">
			<b-col sm="3">
				<label for="find-item-commune">Nom professionnel : </label>
			</b-col>
			<b-col sm="9">
				<b-form-input  v-model="nom_professionnel" placeholder="Entrez" id="find-item-nom_professionnel" type="string" />
			</b-col>
		</b-row>
		<b-form-group>
			<b-form-radio v-model="civilite" name="some-radios" value="Homme">Homme</b-form-radio>
			<b-form-radio v-model="civilite" name="some-radios" value="Femme">Femme</b-form-radio>
		</b-form-group>
		<b-row class="my-1">
			<b-col sm="3">
				<label for="find-item-commune">Profession : </label>
			</b-col>
			<b-col sm="9">
				<b-form-select v-model="selected">
					<option v-for="profession in options" v-bind:key="profession.text" v-bind:value="profession.value">
						{{ profession.text }}
					</option>
				</b-form-select>
			</b-col>
		</b-row>
		<b-button block variant="success" @click="sendDataResearch">
			Rechercher
		</b-button>
	</b-container>
</template>

<script>
export default {
	name: "Research",
	props: {
		commune: String,
		civilite: String,
		selected: String,
		nom_professionnel: String
	},
	data() { return { options: [ { text: 'Anatomo-Cyto-Pathol', value: 'Anatomo-Cyto-Pathol' },{ text: 'Anesthésiste réanim', value: 'Anesthésiste réanim' },{ text: 'Cancérologue  radio', value: 'Cancérologue  radio' }, { text: 'Radiologue', value: 'Radiologue' }] }
	},
	methods: {
		sendDataResearch() {
			this.$emit('data-sent', { 'newRequest': true, 'commune': this.commune, 'civilite': this.civilite, 'profession': this.selected, 'nom_professionnel': this.nom_professionnel });	
		},
	}
}
</script>

<style>
h3{
	text-align: center;
}
/* .form-group{
	margin-left: 45%;
} */
#form-select{
	display: flex;
	flex-wrap: wrap;
}
</style>
