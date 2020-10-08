<template>
    <div class="app">
        <div id="site_inner">
            <div id="hautsite"></div>
            <div id="centresite">
                <div class="choix-ps-es">
                    <h2>Je recherche :</h2>
                    <div class="buttonType">
                        <a id="buttonPS" href="#"
                            class="">
                            <span class="btnRadio"><span class="state">Un professionnel de santé<br />
                                    <div class="exemple">Un médecin, un chirurgien-dentiste, une infirmière...</div>
                            </span></span>
                        </a>
                        <input type="hidden" name="type" value="" />
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="accueil-pre-choix">
                    <h2>Avec l'annuaire santé </h2>
                    <ol>
                        <li>
                            <h3>Recherchez <span>sur plusieurs critères</span></h3>
                            <ul>
                                <li>La profession</li>
                                <li>La proximité</li>
                                <li>Le type d'honoraires</li>
                                <li>L’équipement carte Vitale</li>
                                <li>...</li>
                            </ul>
                        </li>
                        <li>
                            <h3>Trouvez</h3>
                            <ul>
                                <li>Les coordonnées</li>
                                <li>Le détail de l’activité</li>
                                <li>Les horaires de consultation</li>
                                <li>Les durées d’hospitalisation</li>
                                <li>...</li>
                            </ul>
                        </li>
                    </ol>
                    <div class="clear"></div>
                </div>
            </div>
            <div id="bassite"></div>
        </div>
    </div>
</template>

<style>
body {
    font-size: 1em;
}
#site_inner {
    width: 1004px;
    margin: 0 auto;
}
#hautsite {
    background: url(/images/bg_site_haut.png) no-repeat center top;
    height: 14px;
    overflow: hidden;
}
#centresite {
    background: url(/images/bg_site_centre.png) repeat-y center top;
    padding: 60px 63px 60px;
}
#bassite {
    background: url(/images/bg_site_bas.png) no-repeat center top;
    height: 14px;
    overflow: hidden;
    margin-bottom: 10px;
}
.buttonType{
    display: flex;
    justify-content: center;
}
a{
    color: #0363ad;
    text-decoration: none;
}
.choix-ps-es a {
    background: url(/images/choix-ps-es_bt-inact.png) no-repeat;
    height: 114px;
    float: left;
    width: 429px;
    margin-left: 20px;
    text-decoration: none;
    padding: 0;
}
#buttonPS .btnRadio {
    background: url(/images/bloc_critere_picto_nom.png) no-repeat 35px 32px;
}
.choix-ps-es {
    margin-bottom: 40px;
}
.choix-ps-es .btnRadio .state {
    display: block;
    padding-left: 92px;
}
.choix-ps-es .btnRadio {
    font-size: 1.93em;
    color: #fff;
    text-shadow: -1px 1px 1px #580030;
}
.choix-ps-es .btnRadio {
    display: block;
    padding: 30px 0 0 15px;
    font-size: 1.93em;
    height: 84px;
    color: #fff;
    text-shadow: -1px 1px 1px #580030;
}
.choix-ps-es .btnRadio .exemple {
    display: block;
    color: #fff;
    font-size: 0.53em;
    text-shadow: none;
    font-style: normal;
}
.choix-ps-es h2 {
    color: #a1296c;
    font-weight: normal;
    font-style: italic;
    font-size: 2.67em;
    text-align: center;
    margin: 0 0 46px;
}
.accueil-pre-choix {
    background-color: #ebebed;
    width: 738px;
    margin: 80px auto 0;
    padding: 16px 0 0 142px;
    color: #484848;
    height: 304px;
    position: relative;
    bottom: -7px;
    border-radius: 15%;
}
.accueil-pre-choix h2 {
    padding-left: 20%;
    font-size: 1.83em;
    font-weight: normal;
    margin: 0 0 22px;
    color: #7a7a7b;
}
.accueil-pre-choix ol {
    padding: 0 0 0 49px;
}
.accueil-pre-choix ol > li {
    float: left;
    width: 187px;
    padding-right: 10px;
    border-right: 1px solid #bababb;
    font-size: 2em;
    margin-right: 49px;
}
.accueil-pre-choix ol > li h3 {
    font-size: 1em;
    margin: 0;
    font-weight: normal;
    min-height: 60px;
}
.accueil-pre-choix ol > li h3 span {
    font-size: 0.585em;
    display: block;
}
.accueil-pre-choix ol > li ul {
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 0.55em;
}
.accueil-pre-choix ol > li + li {
    padding: 0;
    border: none;
    margin: 0;
}
.clear {
    clear: both;
    height: 0;
    overflow: hidden;
}
</style>