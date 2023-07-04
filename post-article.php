<?php
require_once('include/init.php');
require_once('header.php');

?>
<div class="d-flex align-items-center justify-content-center vh-100 ">


    <div class="vh-100 margin-top container  bg-transparent">
    
    <div class="row  bg-transparent">
      <div class=" col-lg-8">
        <!-- SECTION PUBLIER UN ARTICLE -->
        <section id="publier">
        <div class="dropdown p-2 my-4">
            <!-- Choix de La Langue -->
            <!-- <button class="btn btn-light dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              Choix de la langue
            </button> -->
            <ul class="dropdown-menu " aria-labelledby="languageDropdown">
              <li><a class="dropdown-item" href="#">Anglais</a></li>
              <li><a class="dropdown-item" href="#">Français</a></li>
            </ul>
          </div>
          <!-- Boutton choix de la catégorie -->
        <div class="mb-3">
            <label for="categorie" class="form-label w-50"><strong>Catégorie </strong></label>
            <select class="form-select  w-50" id="categorie">
              <option selected>Actualité</option>
              <option>Sport</option>
              <option>Santé</option>
              <option>Technologie</option>
            </select>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <!-- Titre de l'article -->
          <input type="text" class="form-control w-50 " placeholder="Titre de votre article">
  
            <!-- Boutton Modifier & Apercçu -->
            <div>
              <button class="btn btn-light me-2">Modifier</button>
              <button class="btn btn-light">Aperçu</button>
            </div>
          </div>
            <!-- Insertion d'une image de couverture -->
          <div class="mb-3">
            <label for="image" class="form-label">Image de couverture</label>
            <input type="file" class="form-control" id="image">
          </div>
            <!-- Plusieurs Icones de mise en page -->
          <div class="d-flex justify-content-center mb-3">
            <div class="btn-group">
              <button class="btn btn-light"><i class="far fa-image"></i></button>
              <button class="btn btn-light"><i class="fas fa-bold"></i></button>
              <button class="btn btn-light"><i class="fas fa-italic"></i></button>
              <button class="btn btn-light"><i class="fas fa-list-ul"></i></button>
              <button class="btn btn-light"><i class="fas fa-underline"></i></button>
              <button class="btn btn-light"><i class="fas fa-paperclip"></i></button>
            </div>
          </div>
            <!-- Bloc de rédaction du contenu de l'article -->
            <div class="mb-3">
            <textarea class="form-control" rows="2" placeholder="Description courte"></textarea>
          </div>
          <div class="mb-3">
            <textarea class="form-control" rows="6" placeholder="Écrivez le contenu de votre article ici"></textarea>
          </div>
            <!-- Boutton Publié et Brouillon -->
          <div>
            <button class="btn btn-primary">Publié</button>
            <button class="btn btn-light">Brouillon</button>
            <button class="btn btn-danger"><a href="index.php">Annuler la publication </a></button>
          </div>
        </section>
      </div>
      <!-- Infos de Publications -->
      <div class="col-lg-4">
        <div class="p-5 my-4">
          <div>
            <strong>Écrire un excellent titre d'article</strong>
          </div>
          <p class="text-secondary">Pensez à votre titre d'article comme une description super courte (mais convaincante!) - comme un aperçu de l'article réel en une phrase courte.</p>
          <br>
          <p class="text-secondary">Utilisez des mots-clés lorsque cela est approprié pour aider à garantir que les gens puissent trouver votre article par recherche.</p>
        </div>
      </div>
    </div>
    </div>
  </div>
</div> 
    <?php require_once('footer.php'); ?>

