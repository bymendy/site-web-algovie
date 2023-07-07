<?php
require_once('include/init.php');

require_once('header-blog.php')
?>
<body>
  
<main>
  
  <section class="previews">
    <div>
      <figure class="absolute-bg preview__img" style="background-image: url('https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bd73f098f7597b3f54214c_Header_Algovie_mobile.jpg');"></figure>
      <figure class="absolute-bg preview__img" style="background-image: url('https://images.pexels.com/photos/10439804/pexels-photo-10439804.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');"></figure>
      <figure class="absolute-bg preview__img" style="background-image: url('https://images.pexels.com/photos/3757650/pexels-photo-3757650.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');"></figure>
      <figure class="absolute-bg preview__img" style="background-image: url('https://images.pexels.com/photos/5647266/pexels-photo-5647266.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');"></figure>
      <figure class="absolute-bg preview__img" style="background-image: url('https://images.pexels.com/photos/6432056/pexels-photo-6432056.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');"></figure>    
      <div class="previews__container">
        <span>Bienvenue sur notre page</span>
        <h1>Blog</h1>
        <!-- BOUTTON APPARAIT SEULEMENT QUAND L'INTERNAUTE EST CONNECTER  -->
        <?php if(internauteConnecteAdmin()): ?>
          <a class="nav-link" href="admin/index.php"><button type="button" class="shadow btn btn-light btn-outline-primary btn-16">Mon espace Admin</button></a>
    
      <?php endif; ?>
      </div>

      
    </div>

    <div class="section-left">
        <?php if(internauteConnecte()): ?>
      <!-- si l'internaute est connecté il aura accés aux pages profil, deposer votre article et un bouton de deconnexion  -->
        <a class="my-2 nav-link btn btn-primary border-0" href="#" role="button">
        <button type="button" class="btn btn-primary">Espace <strong><?= $_SESSION['membre']['pseudo'] ?></strong></button>
        </a>
        <div class="d-flex align-items-center justify-content-center btn btn-outline-light border-0">
          <a class="dropdown-item" href="profil.php">Profil <?= $_SESSION['membre']['pseudo'] ?></a>
     

          <a class="dropdown-item" href="connexion.php?action=deconnexion">Déconnexion</a>
        </div>
    <?php else: ?>
      <!-- ---------------------------- -->
      <!-- si il n'est pas connecté, il aura droit aux pages inscription, connexion, voir toutes les articles et contact  (mais pas aux autres)-->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle mr-5" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <button type="button" class="btn btn-outline-dark">Espace Membre</button>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= URL ?>inscription.php"><button class="btn btn-outline-dark">Inscription</button></a>
          <a class="dropdown-item" href="<?= URL ?>connexion.php"><button class="btn btn-outline-dark px-4">Connexion</button></a>

          <a class="dropdown-item" href="<?= URL ?>contact.php"><button class="btn btn-outline-dark px-4">Contact</button></a>
        </div>
      </li> -->
      <?php endif; ?>
      

    
     <!-- ------------------------------------ -->
    <div class="navigation-bar home-nav-brand text-center">
    <a href="index.php" class="navbar-brand home-nav-brand">
        <i class="fa fa-home"></i><img src="https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bd73f13cd2084ea3007a8a_Logo_Algovie_footer.png" loading="lazy" width="200" alt="" class="image-3"/>
      

      
      <!-- --------------Boutton pour Activer la Modal------------ -->

        <a><button class="btn btn-outline-primary" data-toggle="modal" id="model" data-target="#connexionModal">Déposer un article<?= (isset($_SESSION['membre'])) ? '<style>#model{ display: none; }</style>' : ''; ?></button> </a>
        
      <!-- ------------------------------------ -->
    </a>    
    </div>

      <header>
        
        <ul class="tabs">
          <li class="tabs__item">Articles</li>
          <li class="tabs__item">Categories</li>
        </ul>
        
      </header>
      
      <div class="tab">
        <ul itemscope itemtype="http://schema.org/Blog">    
          <li class="preview" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
            <a class="preview__link" href="fiche_article.php" itemprop="url">
              <span class="preview__date" itemprop="datePublished" datetime="2016-09-08T00:00:00-07:00">Jun 8, 2023</span>
              <h2 class="preview__header" itemprop="name">Lorem ipsum</h2>
              <p class="preview__excerpt" itemprop="description">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Magni cumque eveniet, quae similique ut deleniti iure vel sint excepturi natus in magnam sit obcaecati illo asperiores provident placeat, blanditiis error.</p>
              <span class="preview__more">Lire plus</span>
            </a>
          </li>
          <li class="preview" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
            <a class="preview__link" href="#" itemprop="url">
              <span class="preview__date" itemprop="datePublished" datetime="2016-09-07T00:00:00-07:00">Jun 7, 2023</span>
              <h2 class="preview__header" itemprop="name">Lorem damet ipsum</h2>
              <p class="preview__excerpt" itemprop="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita iste cum commodi eligendi qui deserunt eveniet dolorum quisquam tempore aut minus voluptate, ab animi ducimus voluptates nulla aliquam quae asperiores?.</p>
              <span class="preview__more">Lire plus</span>
            </a>
          </li>   
          <li class="preview" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
            <a class="preview__link" href="#" itemprop="url">
              <span class="preview__date" itemprop="datePublished" datetime="2016-09-06T00:00:00-07:00">Jun 6, 2023</span>
              <h2 class="preview__header" itemprop="name">Lorem ipsum </h2>
              <p class="preview__excerpt" itemprop="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae hic quo ratione voluptatum earum, nostrum magni saepe a mollitia impedit. Fugiat veniam ex a error nostrum fuga ipsa ad nobis?Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto quas aperiam hic accusantium ipsa?</p>
              <span class="preview__more">Lire plus</span>
            </a>
          </li>
          <li class="preview" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
            <a class="preview__link" href="#" itemprop="url">
              <span class="preview__date" itemprop="datePublished" datetime="2016-09-05T00:00:00-07:00">Jun 5, 2023</span>
              <h2 class="preview__header" itemprop="name">Lorem ipsum damet ipsim</h2>
              <p class="preview__excerpt" itemprop="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae hic quo ratione voluptatum earum, nostrum magni saepe a mollitia impedit. Fugiat veniam ex a error nostrum fuga ipsa ad nobis?Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
              <span class="preview__more">Lire plus</span>
            </a>
          </li>     
          <li class="preview" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
            <a class="preview__link" href="#" itemprop="url">
              <span class="preview__date" itemprop="datePublished" datetime="2016-09-04T00:00:00-07:00">Jun 4, 2023</span>
              <h2 class="preview__header" itemprop="name">Lorem ipsum damet</h2>
              <p class="preview__excerpt" itemprop="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae hic quo ratione voluptatum earum, nostrum magni saepe a mollitia impedit. Fugiat veniam ex a error nostrum fuga ipsa ad nobis?.</p>
            <span class="preview__more">Lire plus</span>
          </a>
        </li>
      </ul>
      <footer class="section-padding--sm footer">
        <a class="footer__archive" href="#">Derniers articles</a>
        <ul class="footer__social">
          <li><a class="fa fa-lg fa-envelope-o" href="mailto:#"></a></li>

          <li><a class="fa fa-lg fa-linkedin" href="#" target="_blank"></a></li>
          <li><a class="fa fa-lg fa-twitter" href="#" target="_blank"></a></li>
          <li><a class="fa fa-lg fa-facebook" href="#" target="_blank"></a></li>
          <li><a class="fa fa-lg fa-instagram" href="#" target="_blank"></a></li> 
        </ul>
      </footer>
    </div>

    <div class="tab">
      <ul class="cards">
        <li class="card">
          <a class="card__link" href="#">
            <div class="card__img">
              <figure class="absolute-bg" style="background-image: url('https://uploads-ssl.webflow.com/63bd73a09b9b6e369089bd16/63bd73f098f7597b3f54214c_Header_Algovie_mobile.jpg');"></figure>
            </div>
            <div class="card__container">
              <h2 class="card__header">Actualites</h2>
              <p class="card__count">3 Articles</p>
              <span class="card__more">Voir plus</span>
            </div>
          </a>
        </li>
        <li class="card">
          <a class="card__link" href="#">
            <div class="card__img">
              <figure class="absolute-bg" style="background-image: url('https://images.pexels.com/photos/10439804/pexels-photo-10439804.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');"></figure>
            </div>
            <div class="card__container">
              <h2 class="card__header">Sport</h2>
              <p class="card__count">2 Articles</p>
              <span class="card__more">Voir plus</span>
            </div>
          </a>
        </li>
        <li class="card">
          <a class="card__link" href="#">
            <div class="card__img">
              <figure class="absolute-bg" style="background-image: url('https://images.pexels.com/photos/5647266/pexels-photo-5647266.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');"></figure>
            </div>  
            <div class="card__container">
              <h2 class="card__header">Sante</h2>
              <p class="card__count">3 Articles</p>
              <span class="card__more">Voir plus</span>
            </div>
          </a>
        </li>
        <li class="card">
          <a class="card__link" href="#">
            <div class="card__img">
              <figure class="absolute-bg" style="background-image: url('https://images.pexels.com/photos/6432056/pexels-photo-6432056.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');"></figure>
            </div>
            <div class="card__container">
              <h2 class="card__header">Technologie</h2>
              <p class="card__count">2 Articles</p>
              <span class="card__more">Voir plus</span>
            </div>
          </a>
        </li>
      </ul>
      <footer class="section-padding--sm footer">
        <a class="footer__archive" href="#">Derniers articles</a>
        <ul class="footer__social">
          <li><a class="fa fa-lg fa-envelope-o" href="mailto:"></a></li>
          <li><a class="fa fa-lg fa-linkedin" href="#" target="_blank"></a></li>
          <li><a class="fa fa-lg fa-twitter" href="#" target="_blank"></a></li>
          <li><a class="fa fa-lg fa-facebook" href="#" target="_blank"></a></li>
          <li><a class="fa fa-lg fa-instagram" href="#" target="_blank"></a></li>  
        </ul>
      </footer>
    </div>
  </section>
</main>
<!-- ------------------------------------ -->

<div class="#">
          <!-- Modal -->
          <div class="modal fade" id="connexionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                <h3 class="modal-title " id="exampleModalLabel"><img src="img/logo.png " class="rounded-circle"> Bonjour !  <br> Connectez-vous ou créez un compte pour déposer votre article </h3>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-center">
                <a class="dropdown-item" href="inscription.php"><button class="btn btn-outline-primary">Créer un compte</button></a>
                <a class="" href="connexion.php"><button class="btn btn-outline-primary px-4">Me connecter</button></a>
                </div>

              </div>
            </div>
          </div>

<!-- ------------------------------------ -->

  

<?php require_once('footer-blog.php'); ?>

