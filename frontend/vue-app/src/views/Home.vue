<template>
	<section class="page">
    <!-- Slider -->
    <Slider/>

    <!-- Icons Grid -->
    <section class="features-icons bg-light text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="fas fa-laptop-medical m-auto text-primary"></i>
              </div>
              <h3>Recherchez</h3>
                  <ul class="detailContentHome lead mb-0">
                    <li>La profession</li>
                    <li>La proximité</li>
                    <li>Le nom du professionnel</li>
                    <li> Le Status</li>
                    <li>...</li>
                  </ul>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="fas fa-file-medical-alt  m-auto text-primary"></i>
              </div>
              <h3>Trouvez</h3>
              <p class="lead mb-0">
                <ul class="detailContentHome">
                  <li>Les coordonnées</li>
                  <li>Le détail de l’activité</li>
                  <li>Le type de convention</li>
                  <li>L'équipement carte vitale</li>
                  <li>...</li>
                </ul>
              </p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="fas fa-comment-medical m-auto text-primary"></i>
              </div>
              <h3>Comparez</h3>
              <p class="lead mb-0">
                  <ul class="detailContentHome">
                    <li>Les notes</li>
                    <li>Les commentaires</li>
                    <li>...</li>
                  </ul>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Image Showcases -->
    <section class="showcase">
      <div class="container-fluid p-0">
        <div class="row ml-0 mr-0">
          <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('images/health-2082630_1280.jpg');"></div>
          <div class="col-lg-6 order-lg-1 my-auto showcase-text">
            <h2>Recherchez un professionnel de santé</h2>
            <p class="lead mb-0">AnnuaireSanté vous permet de recherche un professionnel de santé selon plusieurs critères: sa profession, la région, la ville, l'adresse,
              le nom du professionnel, son status, etc...
            </p>
          </div>
        </div>
        <div class="row ml-0 mr-0">
          <div class="col-lg-6 text-white showcase-img" style="background-image: url('images/pexels-pixabay-40568.jpg');"></div>
          <div class="col-lg-6 my-auto showcase-text">
            <h2>Trouvez des informations sur un professionnel de santé</h2>
            <p class="lead mb-0">Vous pourrez consulter les informations disponibles sur un médecin tel que ses informations de contact, son type d'activité, son type de convention,
              etc...
            </p>
          </div>
        </div>
        <div class="row ml-0 mr-0">
          <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('images/heart-665177_1920.jpg');"></div>
          <div class="col-lg-6 order-lg-1 my-auto showcase-text">
            <h2>Visitez le profil d'un professionnel</h2>
            <p class="lead mb-0">Vous pourrez consulter les profils de vos médecins, voir leurs notes, leurs commentaire et vous connectez à votre compte AnnuaireSanté pour vous même
              laisser une note ou un commentaire! </p>
          </div>
        </div>
      </div>
    </section>
	</section>
</template>

<script>
import Slider from '../components/Slider';
export default {
	name: "Contact",
	components: {
    Slider
	},
	methods: {
		viewdep(payload){
			alert ('Message: '+payload.message);
		}
	}
}
</script>

<style scoped>
.detailContentHome{
  list-style: none;
  padding-left: inherit;
}
</style>