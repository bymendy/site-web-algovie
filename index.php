<?php
require_once('include/init.php');


require_once('header.php')
?>
        <!-- SECTION 1  -->
        <section class="header w-row">
            

            <div class="column-2 w-col w-col-6 w-col-medium-6 ">

                <img src="https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bd73f0d1bf3f1eafe1fb43_Logo_Algovie.png" loading="lazy" width="235" alt="" class="image"/>
                <h1 class="heading">
                    Avec du temps et de l’envie, <br/>atteignez tous vos objectifs !
                </h1>
                <a href="#email-form" class="button transitionbutton w-button">Lancez-vous !</a>
            </div>
            <div class="w-col w-col-6 w-col-medium-6"></div>
        </section>
        <div class="header-mobile wf-section">
            <img src="https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bd73f0d1bf3f1eafe1fb43_Logo_Algovie.png" loading="lazy" width="167" alt="" class="image"/>
            <h1 class="heading">
                Avec du temps et de l’envie, <br/>atteignez tous vos objectifs !
            </h1>
            <a href="#email-form" class="button transitionbutton w-button">Lancez-vous !</a>
        </div>
        <div class="header-mobile-image wf-section">
            <img src="https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bd73f098f7597b3f54214c_Header_Algovie_mobile.jpg" loading="lazy" sizes="(max-width: 479px) 100vw, (max-width: 991px) 90vw, 100vw" srcset="https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bd73f098f7597b3f54214c_Header_Algovie_mobile-p-500.jpg 500w, https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bd73f098f7597b3f54214c_Header_Algovie_mobile.jpg 711w" alt="" class="image-2"/>
        </div>

        <div class="section wf-section">
            <div class="div-block">
                <div class="hero-wrapper-two-2">
                    <h1 class="heading-2">
                        <span class="text-span-2">Osez rêver plus grand ! </span>
                        <br/>
                        <span class="text-span">Testez Algovie et atteignez vos objectifs plus rapidement et facilement.</span>
                    </h1>
                    <img src="https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bd73f11f7a833bd24d944b_ALGOVIE-icone-1.gif" loading="lazy" width="150" alt="" class="image-4"/>
                </div>
            </div>
        </div>
        <section id="beta" class="devenez wf-section">
            <div class="">
                <div class="hero-wrapper">
                    <div class="w-100 hero-split">
                        <h2 class="titlegradient">
                            Devenez <br/>bêta-testeur
                        </h2>
                        <p class="paragraph-4">Participer au bêta test vous donne accès à un compte premium et ses avantages pendant 1 an.</p>
                        <p class="paragraph-5">
                            Être bêta testeur d’Algovie c’est tester et analyser l’ergonomie de l’application. <br/>
                            ‍<br/>
                            Libre cours à votre imagination pour créer le plus de contenu adapté à vos besoins, les partager et interagir à ceux de votre communauté.<br/>
                            ‍<br/>Chaque semaine, un formulaire vous sera transmis afin de remonter les éventuelles anomalies, vos remarques et avis en vue d’améliorer et adapter l’expérience utilisateur.
                        </p>
                    </div>
                    <div class="form">
                        <div class="w-form">
                            <form id="email-form" name="email-form" data-name="Email Form" method="get">
                                <label for="name" class="field-label">Nom *</label>
                                <input type="text" class="w-input" maxlength="256" name="name" data-name="Name" placeholder="" id="name" required=""/>
                                <label for="Prenom">Prénom *</label>
                                <input type="text" class="w-input" maxlength="256" name="Prenom" data-name="Prenom" placeholder="" id="Prenom" required=""/>
                                <label for="email">Email *</label>
                                <input type="email" class="w-input" maxlength="256" name="email" data-name="Email" placeholder="" id="email" required=""/>
                                <label for="Telephone">Téléphone *</label>
                                <input type="tel" class="w-input" maxlength="256" name="Telephone" data-name="Telephone" placeholder="" id="Telephone" required=""/>
                                <p class="paragraph-3">* Les champs marqués d &#x27;une étoile doivent être renseignés.</p>
                                <div data-sitekey="6Lcs6hkkAAAAAHuaKh9IsY_-MmTIHoKZbmX4ygUJ" class="w-form-formrecaptcha g-recaptcha g-recaptcha-error g-recaptcha-disabled"></div>
                                <label class="w-checkbox">
                                    <input type="checkbox" id="RGPD" name="RGPD" data-name="RGPD" required="" class="w-checkbox-input"/>
                                    <span class="w-form-label" for="RGPD">En envoyant ce formulaire, j’accepte que mes données soient enregistrées afin de me recontacter.</span>
                                </label>
                                <input type="submit" value="Envoyer" data-wait="Veuillez patienter" class="submit-button transitionbutton w-button"/>
                            </form>
                            <div class="success-message w-form-done">
                                <div>
                                    Merci pour votre inscription. <br/>Nous revenons vers vous dès que possible.
                                </div>
                            </div>
                            <div class="w-form-fail">
                                <div>Veuillez renseigner les champs avec une *.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bonheur wf-section">
            <div class="#">
                <h2 class="heading-2">C’est quoi le bonheur pour vous ?</h2>
                <h2 class="heading-3">Si vous pouvez le dire, vous êtes déjà en train d’y parvenir !</h2>
                <p class="margin-bottom-24px text-center">Algovie, votre Assistant de développement personnel prend le temps de vous connaître, optimise votre quotidien et vous motive pour atteindre tous vos objectifs. L’application trouve des solutions adaptées pour optimiser votre temps. Grâce à elle, gagnez en équilibre de vie et bien-être.</p>
                <div class="columns-3 w-row">
                    <div class="column-5 shadow w-col w-col-4 w-col-small-small-stack">
                        <img src="https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bd73f06f98816f8af2f071_Connaitre_Algovie.png" loading="lazy" alt=""/>
                        <p class="paragraph">Du temps pour vous connaître</p>
                        <p class="paragraph-2">Pendant 1 mois, notre application apprend à vous connaître.</p>
                    </div>
                    <div class="column-3 shadow w-col w-col-4 w-col-small-small-stack">
                        <img src="https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bd73f06484421dce43f642_Optimisation_Algovie.png" loading="lazy" alt=""/>
                        <p class="paragraph">
                            Optimisation de<br/>votre quotidien
                        </p>
                        <p class="paragraph-2">Nous vous aidons à organiser votre planning.</p>
                    </div>
                    <div class="column-4 shadow w-col w-col-4 w-col-small-small-stack">
                        <img src="https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bd73f19a78d2a43d0060f4_Motivation_Algovie.png" loading="lazy" alt=""/>
                        <p class="paragraph">
                            Motivation <br/>pour vos objectifs
                        </p>
                        <p class="paragraph-2">Grâce au coaching, atteignez vos objectifs plus rapidement.</p>
                    </div>
                </div>
            </div>
        </section>

        <?php require_once('footer.php'); ?>
