<template>
    <footer>
        <div class="footer-primary">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 link-block">
                        <div class="h5 link-block-title">
                            Lorem ipsum
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="link-block-links">
                                    <a href="#" class="link-block-link footer-visited-link">
                                        <div class="footer-visited-link-number">1</div>
                                        <div class="footer-visited-link-text">Trouver un médecin</div>
                                        <div class="footer-visited-link-icon"><i class="fas fa-chevron-right"></i></div>
                                    </a>
                                    <a href="#" class="link-block-link footer-visited-link">
                                        <div class="footer-visited-link-number">2</div>
                                        <div class="footer-visited-link-text">Le serment d’Hippocrate</div>
                                        <div class="footer-visited-link-icon"><i class="fas fa-chevron-right"></i></div>
                                    </a>
                                    <a href="#" class="link-block-link footer-visited-link">
                                        <div class="footer-visited-link-number">3</div>
                                        <div class="footer-visited-link-text">Lorem ipsum dolor sit amet</div>
                                        <div class="footer-visited-link-icon"><i class="fas fa-chevron-right"></i></div>
                                    </a>
                                    <a href="#" class="link-block-link footer-visited-link">
                                        <div class="footer-visited-link-number">4</div>
                                        <div class="footer-visited-link-text">Lorem ipsum dolor sit amet</div>
                                        <div class="footer-visited-link-icon"><i class="fas fa-chevron-right"></i></div>
                                    </a>
                                    <a href="#" class="link-block-link footer-visited-link">
                                        <div class="footer-visited-link-number">5</div>
                                        <div class="footer-visited-link-text">Lorem ipsum dolor sit amet</div>
                                        <div class="footer-visited-link-icon"><i class="fas fa-chevron-right"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 link-block d-none d-md-block">
                        <div class="h5 link-block-title">
                            Lorem ipsum
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="link-block-links">
                                    <a href="#" class="link-block-link footer-visited-link">
                                        <div class="footer-visited-link-number">1</div>
                                        <div class="footer-visited-link-text">Lorem ipsum dolor sit amet</div>
                                        <div class="footer-visited-link-icon"><i class="fas fa-chevron-right"></i></div>
                                    </a>
                                    <a href="#" class="link-block-link footer-visited-link">
                                        <div class="footer-visited-link-number">2</div>
                                        <div class="footer-visited-link-text">Lorem ipsum dolor sit amet</div>
                                        <div class="footer-visited-link-icon"><i class="fas fa-chevron-right"></i></div>
                                    </a>
                                    <a href="#" class="link-block-link footer-visited-link">
                                        <div class="footer-visited-link-number">3</div>
                                        <div class="footer-visited-link-text">Lorem ipsum dolor sit amet</div>
                                        <div class="footer-visited-link-icon"><i class="fas fa-chevron-right"></i></div>
                                    </a>
                                    <a href="#" class="link-block-link footer-visited-link">
                                        <div class="footer-visited-link-number">4</div>
                                        <div class="footer-visited-link-text">Lorem ipsum dolor sit amet</div>
                                        <div class="footer-visited-link-icon"><i class="fas fa-chevron-right"></i></div>
                                    </a>
                                    <a href="#" class="link-block-link footer-visited-link">
                                        <div class="footer-visited-link-number">5</div>
                                        <div class="footer-visited-link-text">Lorem ipsum dolor sit amet</div>
                                        <div class="footer-visited-link-icon"><i class="fas fa-chevron-right"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 link-block">
                        <div class="h5 link-block-title d-none d-md-block">
                            Suivez-nous
                        </div>
                        <div class="link-block-links contact-links">
                            <a href="https://twitter.com/ordre_medecins" target="_blank"><i
                                    class="fab fa-twitter contact-icons"></i></a>
                            <a href="https://www.youtube.com/channel/UCPPbEF38xAUBvXyKkMuLbOQ/featured"
                                target="_blank"><i class="fab fa-youtube contact-icons"></i></a>
                            <a href="/rss.xml" target="_blank"><i class="fas fa-rss contact-icons"></i></a>
                        </div>
                    </div>
                    <div>
                        <p class="text-center"><small>&copy; 2018 - Tout droits réservés / SIte réalisé par Kamal
                                Tallih.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: 'Footer'
}
</script>

<style>
footer .footer-primary {
    background-color: #0C2050;
    padding: 3.5rem 0;
}
.container {
    max-width: 1600px;
}
footer .link-block .link-block-title {
    color: #fff;
    font-size: 1.20rem;
    letter-spacing: -0.21px;
}
.h5 {
    margin-bottom: 0.5rem;
    font-family: inherit;
    font-weight: 500;
    line-height: 1.2;
    color: inherit;
}
footer .footer-primary .link-block .link-block-links .footer-visited-link:not(:last-child) {
    border-bottom: 1px solid #fff;
}
footer .link-block .link-block-links .link-block-link {
    color: rgba(255,255,255,0.84);
    display: flex;
    padding: 0.75rem 0;
}
.footer-primary a {
    color: #2962FF;
    text-decoration: none;
    background-color: transparent;
}
.d-md-block {
    display: block !important;
}
footer .footer-primary .link-block .link-block-links.contact-links {
    text-align: left;
}
footer .footer-primary .link-block .link-block-links.contact-links .contact-icons {
    background-color: #2962FF;
    border-radius: 50%;
    color: #fff;
    display: inline-block;
    font-size: 1.5rem;
    margin-right: 1rem;
    margin-top: 1rem;
    padding: 0.75rem;
}
footer .footer-primary .link-block .link-block-links .footer-visited-link .footer-visited-link-text {
    flex: 80%;
    font-size: 0.75rem;
}
.text-white {
    color: #fff !important;
}
footer .footer-primary .link-block .link-block-links .footer-visited-link .footer-visited-link-icon {
    align-self: center;
    flex: 5%;
    font-size: 0.5rem;
}
footer .footer-primary .link-block .link-block-links .footer-visited-link .footer-visited-link-number {
    color: rgba(255,255,255,0.5);
    flex: 10%;
    font-size: 0.75rem;
    text-decoration: none !important;
}
</style>