
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


    $photo_bdd = "";

    if (!empty($_FILES['photo']['name'])) {
    $photo_nom = $_POST['titre'] . '_' . $_FILES['photo']['name'];
    $photo_bdd = "$photo_nom";
    $photo_dossier = RACINE_SITE . "/img/$photo_nom";

    // Ajouter une vérification pour vérifier que le fichier source existe
    if (file_exists($_FILES['photo']['tmp_name'])) {
        copy($_FILES['photo']['tmp_name'], $photo_dossier);
    } else {
        // Si le fichier source n'existe pas, afficher un message d'erreur
        echo "Erreur : le fichier source n'a pas été trouvé.";
    }
}

    if (empty($erreur)) {

            $inscrirePhoto = $pdo->prepare("INSERT INTO photo (photo) VALUES (:photo)");
            $inscrirePhoto->bindValue(':photo', $photo_bdd, PDO::PARAM_STR);

            $inscrirePhoto->execute();

            $photo_id = $pdo->lastInsertId();

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