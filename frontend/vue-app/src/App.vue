<template>
  <div id="app">
    <nav class="navbar navbar-expand-lg navbar-light" id="topOfPage">
      <div class="container">
        <!-- menu burger -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
          aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/">AnnuaireSante</a>
        <div class="collapse navbar-collapse" id="navbarToggler">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <router-link to="/" class="nav-link">Accueil</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/professionnelsante" class="nav-link">Trouver un professionnel de Sante</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/about" class="nav-link">About</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/contact" class="nav-link">Contact</router-link>
            </li>
          </ul>
          <!-- account connexion -->
          <div class="btn-group dropdown">
            <button type="button" class="btn btn-outline-warning dropdown-toggle" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              Connexion <i class="fas fa-lock"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <!-- formulaire de connexion -->
              <form action="/home/connexion" method="post" class="px-4 py-3" role="form">
                <div class="form-group">
                  <label for="pseudoConnexion">Pseudo</label>
                  <input type="text" class="form-control" id="pseudoConnexion" name="pseudoConnexion">
                </div>
                <div class="form-group">
                  <label for="password">Mot de passe</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="*******">
                </div>
                <button type="submit" class="btn btn-warning">Connexion</button>
              </form>
              <div class="dropdown-divider"></div>
              <a type="button" class="btn btn-primary m-1" href="/inscription">
                Inscription !
              </a>
              <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#forgetPassword">
                Mot de passe oublié ?
              </button>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <router-view />
  </div>
</template>

<script>
export default {
  
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
    border-bottom: 0.3rem solid #BC8F8F }
  
.btn.btn-outline-warning {
  color: #A0522D !important; }

.show > .btn-outline-warning.dropdown-toggle {
  background-color: #ff8c00 !important;
  color: rgba(0, 0, 0, 0.7) !important; }

.modal-header {
  background: #ff8c00 !important; }

@media all and (max-width: 991px) {
  .dropdown-menu-right {
    right: auto !important;
    left: 0 !important; 
  } 
}
  
</style>
