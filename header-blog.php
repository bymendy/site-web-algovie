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
                <!-- lien Bootstrap -->
        <link rel="stylesheet" href="bootstrap-5.2.3-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="style.css" />
        <!-- <link rel="stylesheet" href="menu-burger.css" /> -->
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
    <body>
        <nav>
        <?php if(internauteConnecte()): ?>
      <!-- si l'internaute est connecté il aura accés aux pages profil, deposer votre article et un bouton de deconnexion  -->
      <li class="nav-item dropdown mr-1">
        <a class="nav-link dropdown-toggle btn btn-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <button type="button" class="btn btn-dark">Espace <strong><?= $_SESSION['membre']['pseudo'] ?></strong></button>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= URL ?>profil.php">Profil <?= $_SESSION['membre']['pseudo'] ?></a>
     

          <a class="dropdown-item" href="<?= URL ?>connexion.php?action=deconnexion">Déconnexion</a>
        </div>
      </li>
    <?php else: ?>
      <!-- ---------------------------- -->
      <!-- si il n'est pas connecté, il aura droit aux pages inscription, connexion, voir toutes les articles et contact  (mais pas aux autres)-->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle mr-5" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <button type="button" class="btn btn-outline-dark">Espace Membre</button>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= URL ?>inscription.php"><button class="btn btn-outline-dark">Inscription</button></a>
          <a class="dropdown-item" href="<?= URL ?>connexion.php"><button class="btn btn-outline-dark px-4">Connexion</button></a>

          <a class="dropdown-item" href="<?= URL ?>contact.php"><button class="btn btn-outline-dark px-4">Contact</button></a>
        </div>
      </li>
      <?php endif; ?>
    
     <!-- ------------------------------------ -->
     <!-- le bouton admin n'apparaitra que pour un utilisateur qui a les droits d'admin -->
    <?php if(internauteConnecteAdmin()): ?>
      <li class="nav-item mr-5">
          <a class="nav-link" href="admin/index.php"><button type="button" class="btn btn-dark">Admin</button></a>
      </li>
    <?php endif; ?>

        </nav>
    

        

