<!DOCTYPE html>
<!-- This site was created in Webflow. https://www.webflow.com -->
<!-- Last Published: Thu Apr 06 2023 12:13:09 GMT+0000 (Coordinated Universal Time) -->
<html data-wf-domain="www.algovie-app.fr" data-wf-page="63bd73a09b9b6ed16489bd17" data-wf-site="63bd73a09b9b6e369089bd16">
    <head>
        <meta charset="utf-8"/>
        <title>Algovie - Time to be Happy</title>
        <meta content="Algovie, votre Assistant de développement personnel prend le temps de vous connaître, optimise votre quotidien et vous motive pour atteindre tous vos objectifs. L’application trouve des solutions adaptées pour optimiser votre temps. Grâce à elle, gagnez en équilibre de vie et bien-être." name="description"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="Webflow" name="generator"/>

        <link href="https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/css/algovie-time-to-be-happy.webflow.fa93868cc.css" rel="stylesheet" type="text/css"/>
        <!-- <link rel="stylesheet" href="style.css" /> -->

        <!-- lien Bootstrap -->
        <link rel="stylesheet" href="bootstrap-5.2.3-dist/css/bootstrap.min.css" />
        <!-- Autres lien CSS -->
        <link rel="stylesheet" href="navbar.css" />
        <link rel="stylesheet" href="menu-burger.css" />
        <!-- links pour icones fontawesome -->
        <script src="https://kit.fontawesome.com/896637ab26.js" crossorigin="anonymous"></script>


        <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif]-->
        <script type="text/javascript">
            !function(o, c) {
                var n = c.documentElement
                  , t = " w-mod-";
                n.className += t + "js",
                ("ontouchstart"in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
            }(window, document);
        </script>
        <link href="https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bebecabae4d614f19e878f_Favicon-Algovie.png" rel="shortcut icon" type="image/x-icon"/>
        <link href="https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bebed342064b294d9d1e7c_Icone-Algovie.jpg" rel="apple-touch-icon"/>
        <script src="https://www.google.com/recaptcha/api.js" type="text/javascript"></script>
    </head>
    <body class="body">
        <!-- Bar de navigation -->
        <nav class=" navigation-bar navbar navbar-expand-lg navbar-light bg-gradient-white ">
            <div class="container">
                <a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="Logo de votre site" class="logo"></a>

            <!-- ------------------------------------ -->
            
            <!-- le bouton admin n'apparaitra que pour un utilisateur qui a les droits d'admin -->
            <?php if(internauteConnecteAdmin()): ?>
                
            <a class="nav-link" href="admin/index.php"><button type="button" class="btn btn-outline-primary">Admin</button></a>
            <?php endif; ?>
            <!-- ------------------------------------ -->

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse justify-content-end " id="navbarNav">
                <ul class="navbar-nav ml-auto" >
                    <li class="nav-item ">
                    <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                </ul>
                </div>
                
                <div class="text-right mx-auto">

                <!-- -------------------------- -->
                <?php if(internauteConnecte()): ?>
                <!-- si l'internaute est connecté il aura accés aux pages profil, deposer votre article et un bouton de deconnexion  -->

                <a class="btn btn-primary" href="connexion.php?action=deconnexion">Déconnexion</a>

                <?php else: ?>
                    <a class="#" href="connexion.php"><button class="btn btn-outline-primary shadow px-4">Se connecter</button></a>
                    <?php endif; ?>
                <!-- ------------------------------------ -->


                </div>
            </div>
        </nav>
        
        <!-- MENU BURGER -->
        <!-- SUR TOUTE LA LARGEUR BAKGROUND ASSOMBRIE  -->
        <div id="sidebar">
            <div class="side-nav ">
                <ul class="abs-center nav-options">
                    <li class="rela-block"><a class="nav-link " href="index.php">Accueil</a></li>
                    <li class="rela-block"><a class="nav-link " href="blog.php">Blog</a></li>
                </ul>
            </div>
            <div class="rela-block top-section">
                <div class="nav-button my-2 top">
                    <div class="abs-center nav-bars"></div>
                </div>
                <div class="search-button">
                    <div class="abs-center magnefying-glass"></div>
                </div>
            </div>
        </div>
