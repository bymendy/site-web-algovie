<?php
require_once('include/init.php');

// variable listeCategorie et appliquer la requete SQL
$listeCategorie = $pdo->query("SELECT * FROM categorie");
// Traitement
$id_article = (isset($_POST['id_article'])) ? $_POST['id_article'] : "";
$titre = (isset($_POST['titre'])) ? $_POST['titre'] : "";
$description_courte = (isset($_POST['description_courte'])) ? $_POST['description_courte'] : "";
$description_longue = (isset($_POST['description_longue'])) ? $_POST['description_longue'] : "";
$photo = (isset($_POST['photo'])) ? $_POST['photo'] : "";

// ************ CONTRAINTE ************
// 1ére contrainte

if (!internauteConnecteAdmin()) {
  header("Location: connexion.php");
  exit();
}
// pagination selon les articless

// si un indice page existe dans l'url et qu'on retrouve une valeur dedans
if(isset($_GET['page']) && !empty($_GET['page'])){
  $pageCourante = (int) strip_tags($_GET['page']);
}else{
  // dans le cas ou aucune information n'a transité dans l'URL, $pageCourante prendra la valeur de defaut qui est 1
  $pageCourante = 1;
}
// Faire une variable listeCategorie et appliquer la requete SQL
$listeCategorie = $pdo->query("SELECT * FROM categorie");

$queryArticles = $pdo->query("SELECT COUNT(id_article) AS nombreArticles FROM articles" );
$resultatArticles = $queryArticles->fetch();
$nombreArticles = (int) $resultatArticles['nombreArticles'];
// je veux que sur chaque page s'affiche 10 Articles
$parPage =  10; 
$nombrePages = ceil($nombreArticles / $parPage);
//  definir la premiere article qui va s'afficher à chaque nouvelle page
$premierArticle = ($pageCourante - 1) * $parPage;

// fin pagination
$description_courte = "";
$photoActuelle = "";
$photo_bdd = "";
// ************ CONTRAINTE ************
// 1ére contrainte

// tous ce qui va concernée l'envoie en base de donnée
if ($_POST) {

      if (!isset($_POST['categorie'])) {
          $erreur .= '<div class="alert alert-danger" role="alert">Erreur format categorie !</div>';
      }
      if (!isset($_POST['titre']) || iconv_strlen($_POST['titre']) < 3 || iconv_strlen($_POST['titre']) > 20) {
          $erreur .= '<div class="alert alert-danger" role="alert">Erreur format titre !</div>';
      }
      if (!isset($_POST['description_courte']) || iconv_strlen($_POST['description_courte']) < 3 || iconv_strlen($_POST['description_courte']) > 500) {
          $erreur .= '<div class="alert alert-danger" role="alert">Erreur format description !</div>';
      }
      if (!isset($_POST['description_longue']) || iconv_strlen($_POST['description_longue']) < 3 || iconv_strlen($_POST['description_longue']) > 6000) {
          $erreur .= '<div class="alert alert-danger" role="alert">Erreur format description_longue !</div>';
      }


      // ***  Traitement pour la photo
      $photoBdd = (!empty($_POST['photoActuelle'])) ? $_POST['photoActuelle'] : "";
      // if($_GET['action'] == 'update'){
      //     $photoBdd = $_POST['photoActuelle'];
      // }

      if(!empty($_FILES['photo']['name'])){
          $photo_nom = uniqid() . '_' . $_FILES['photo']['name'];
          $photoBdd = "$photo_nom";
          $photoDossier = RACINE_SITE . "img/$photo_nom";
          if(is_uploaded_file($_FILES['photo']['tmp_name']) && file_exists(RACINE_SITE . "img/")){
              copy($_FILES['photo']['tmp_name'], $photoDossier);
          } else {
              echo "Une erreur est survenue lors du téléchargement du fichier.";
          }
      }
      // A VOIR POUR LES 5 AUTRES PHOTOS

      // *** Fin traitement photo
      
    // Condition si user à bien renseigner les champs et ne s'est pas tromper
    if (empty($erreur)) {

              $inscrireArticle = $pdo->prepare(" INSERT INTO articles (titre, description_courte, description_longue, photo, membre_id, categorie_id, date_enregistrement) VALUES (:titre, :description_courte, :description_longue, :photo, :membre_id, :categorie, NOW() )");
              $inscrireArticle->bindValue(':membre_id', $_SESSION['membre']['id_membre'], PDO::PARAM_STR);
              $inscrireArticle->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
              $inscrireArticle->bindValue(':description_courte', $_POST['description_courte'], PDO::PARAM_STR);
              $inscrireArticle->bindValue(':description_longue', $_POST['description_longue'], PDO::PARAM_STR);

              $inscrireArticle->bindValue(':photo', $photo_bdd, PDO::PARAM_STR);

              $inscrireArticle->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_STR);
              $inscrireArticle->execute();
              $content .= '<div class="alert alert-success alert-dismissible fade show
              mt-5" role="alert">
              <strong>Félicitations !</strong> Votre article a bien été déposée avec succès 😉 !
              <button type="button" class="close" data-dismiss="alert" arialabel="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>';  
    }
}




require_once('header.php');
?>
<?= $content ?>

<div class="d-flex align-items-center justify-content-center vh-100 ">


    <div class="vh-100 margin-top container  bg-transparent">
    
    <div class="row  bg-transparent">
      <div class=" col-lg-8">
        <!-- SECTION PUBLIER UN ARTICLE -->
        <?php if(internauteConnecte()) : ?>
        <form id="monForm" method="POST" action="" enctype="multipart/form-data">
        <?= $erreur ?>
            <input type="hidden" name="id_article" value="<?= $id_article ?>">


            <section id="publier">
            <div class="dropdown p-2 my-4">
                <!-- Choix de La Langue -->
                <!-- <button class="btn btn-light dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                  Choix de la langue
                </button> -->
                <!-- <ul class="dropdown-menu " aria-labelledby="languageDropdown">
                  <li><a class="dropdown-item" href="#">Anglais</a></li>
                  <li><a class="dropdown-item" href="#">Français</a></li>
                </ul>
              </div> -->
              <!-- Boutton choix de la catégorie -->
            <div class="mb-3">
                <label for="categorie" class="form-label w-50"><strong>Catégorie </strong></label>
                <select class="form-select  w-50" id="categorie" name="categorie">
                <?php
                        while ($categorie = $listeCategorie->fetch(PDO::FETCH_ASSOC)) {
                            //var_dump($categorie);
                            echo "<option value = '$categorie[id_categorie]'> $categorie[titre]</option>";
                        }
                        ?>
                </select>
              </div>
              <div class="d-flex justify-content-between mb-3">
                <!-- Titre de l'article -->
              <input type="text" class="form-control w-50 " placeholder="Titre de votre article" value="<?= $titre ?>">
      
                <!-- Boutton Modifier & Apercçu -->
                <div>
                  <button class="btn btn-light me-2">Modifier</button>
                  <button class="btn btn-light">Aperçu</button>
                </div>
              </div>
                <!-- Insertion d'une image de couverture -->
              <div class="mb-3">
              <label class="form-label" for="photo">
                        <div class="badge badge-dark text-wrap">Photo Principale</div>
                    </label>
                    <input class="form-control" type="file" name="photo" id="photo" placeholder="Photo">
                    <?php if (!empty($photo)) : ?>
                        <div class="mt-4">
                            <p>Vous pouvez changer d'image
                                <img src="<?= URL . 'img/' . $photo ?>" width="50px">
                            </p>
                        </div>
                    <?php endif; ?>
                    <input type="hidden" name="photoActuelle" value="<?= $photo ?>">
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
                <textarea class="form-control" id="description_courte" rows="2" placeholder="Description courte"><?= $description_courte ?></textarea>
              </div>
              <div class="mb-3">
                <textarea class="form-control" id="description_longue" rows="6" placeholder="Écrivez le contenu de votre article ici"><?= $description_longue ?></textarea>
              </div>
                <!-- Boutton Publié et Brouillon -->
              <div>
              <button type="submit" name="publier" class="btn  btn-primary">Publier</button>
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
        </form>
      <!-- Fin du Formulaire -->

  <?php endif; ?>
    </div>
    </div>
  </div>
</div> 
    <?php require_once('footer.php'); ?>

