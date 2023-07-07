<?php
require_once('include/init.php');
require_once('include/affichage.php');

$id_membre = $_SESSION['membre']['id_membre'] ;
$pageTitle = "Profil de " . $_SESSION['membre']['pseudo'];

if (!internauteConnecte()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

// validation profil
if (isset($_GET['action']) && $_GET['action'] == 'validate') {
    $validate .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                    Félicitations <strong>' . $_SESSION['membre']['pseudo'] . '</strong>, vous etes connecté 😉 !
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
}

// liste des articles du user, revoir comment choisir spécifiquement les articles du user (2 conditions)


if (isset($_GET['page']) && !empty($_GET['page'])) {
    $pageCourante = (int) strip_tags($_GET['page']);
} else {
    $pageCourante = 1;
}

$listeArticle = $pdo->query("SELECT * FROM articles");

$queryArticle = $pdo->query(" SELECT COUNT(id_article) AS nombreAnnonce FROM articles ");
$resultatArticle = $queryArticle->fetch();
$nombreArticle = (int) $resultatArticle['nombreAnnonce'];
$parPage = 5;
$nombrePages = ceil($nombreArticle / $parPage);
$premierAnnonce = ($pageCourante - 1) * $parPage;


if (isset($_GET['action'])) {
    if ($_POST) {
        if (!isset($_POST['categorie'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format categorie !</div>';
        }
        if (!isset($_POST['titre']) || strlen($_POST['titre']) < 3 || strlen($_POST['titre']) > 20) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format titre !</div>';
        }
        if (!isset($_POST['description_courte']) || strlen($_POST['description_courte']) < 3 || strlen($_POST['description_courte']) > 255) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format description_courte !</div>';
        }
        if (!isset($_POST['description_longue']) || strlen($_POST['description_longue']) < 3 || strlen($_POST['description_longue']) > 500) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format description_longue !</div>';
        }

        $photo_bdd = "";
        if ($_GET['action'] == 'update') {
            $photo_bdd = $_POST['photoActuelle'];
        }
        // à verifier : n'ayant pas la référence de l'annonce je prends le titre 
        if (!empty($_FILES['photo']['name'])) {
            $photo_nom = $_POST['titre'] . '_' . $_FILES['photo']['name'];
            $photo_bdd = "$photo_nom";
            $photo_dossier = RACINE_SITE . "/img/$photo_nom";
            copy($_FILES['photo']['tmp_name'], $photo_dossier);
        }

        if (empty($erreur)) {
            if ($_GET['action'] == 'update') {
                $modifArticle = $pdo->prepare(" UPDATE articles SET titre = :titre, description_courte = :description_courte, description_longue = :description_longue, photo = :photo, categorie_id = :categorie WHERE id_article = :id_article ");
                $modifArticle->bindValue(':id_article', $_POST['id_article'], PDO::PARAM_INT);
                $modifArticle->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $modifArticle->bindValue(':description_courte', $_POST['description_courte'], PDO::PARAM_STR);
                $modifArticle->bindValue(':description_longue', $_POST['description_longue'], PDO::PARAM_STR);
                $modifArticle->bindValue(':photo', $photo_bdd, PDO::PARAM_STR);
                $modifArticle->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_STR);
                $modifArticle->execute();

                $queryArticle = $pdo->query("SELECT titre FROM articles WHERE id_article = '$_GET[id_article]' ");
                $article = $queryArticle->fetch(PDO::FETCH_ASSOC);
                $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                        <strong>Félicitations !</strong> Modification de l\' annonce ' . $article['titre'] . ' réussie !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } 
        }
    }
    if ($_GET['action'] == 'update') {
        $queryArticle = $pdo->query("SELECT * FROM articles WHERE id_article = '$_GET[id_article]' ");
        $articleActuel = $queryArticle->fetch(PDO::FETCH_ASSOC);
    }
    $id_article = (isset($articleActuel['id_article'])) ? $articleActuel['id_article'] : "";
    $titre = (isset($articleActuel['titre'])) ? $articleActuel['titre'] : "";
    $description_courte = (isset($articleActuel['description_courte'])) ? $articleActuel['description_courte'] : "";
    $description_longue = (isset($articleActuel['description_longue'])) ? $articleActuel['description_longue'] : "";
    $photo = (isset($articleActuel['photo'])) ? $articleActuel['photo'] : "";
    // affichage de l'annonce (voir)
    // ( ! ) Warning: Undefined array key "id_annnonce" in C:\wamp64\www\annonceo\admin\gestion_annonce.php on line 168

    if ($_GET['action'] == 'affichage') {
        $queryArticle = $pdo->query("SELECT * FROM articles WHERE id_article = '$_GET[id_annnonce]' ");
        $articleActuel = $queryArticle->fetch(PDO::FETCH_ASSOC);
    }
    $id_article = (isset($articleActuel['id_article'])) ? $articleActuel['id_article'] : "";
    $titre = (isset($articleActuel['titre'])) ? $articleActuel['titre'] : "";
    $description_courte = (isset($articleActuel['description_courte'])) ? $articleActuel['description_courte'] : "";
    $description_longue = (isset($articleActuel['description_longue'])) ? $articleActuel['description_longue'] : "";
    $photo = (isset($articleActuel['photo'])) ? $articleActuel['photo'] : "";

    // Requete pour effectuer une Supression
    if($_GET['action'] == 'delete'){
        $pdo->query("DELETE FROM articles WHERE id_article = '$_GET[id_article]' ");
    }
}
require_once('header.php');

?>

<h2 class="text-center">
    <div class="badge badge-dark text-wrap p-3">Bonjour <?= (internauteConnecteAdmin()) ? $_SESSION['membre']['pseudo'] . ", vous etes admin du site" : $_SESSION['membre']['pseudo'] ?></div>
</h2>

<?= $validate ?>



<h1 class="text-center">
    <div class="badge badge-primary text-wrap p-3">Gestion des articles</div>
</h1>

<?= $erreur ?>
<?= $content ?>


<?php if (!isset($_GET['action']) && !isset($_GET['page'])) : ?>
    <div class="blockquote alert alert-dismissible fade show mt-5 shadow border border-primary rounded" role="alert">
        <p>Vous pouvez modifier les données ou supprimer un article</p>
    </div>
<?php endif; ?>

<?php if (isset($_GET['action'])) : ?>
    <h2 class="pt-5">Formulaire <?= ($_GET['action'] == 'add') ? "d'ajout" : "de modification" ?> des articles</h2>

    <form id="monForm" class=" method="POST" action="" enctype="multipart/form-data">
        <?= $erreur ?>
        <input type="hidden" name="id_article" value="<?= $id_article ?>">
        <div class="row mt-5">
            <div class="col-md-6">
                <label class="form-label" for="titre">
                    <div class="badge badge-dark text-wrap">Titre</div>
                </label>
                <input class="form-control" type="text" name="titre" id="titre" placeholder="titre" value="<?= $titre ?>">
            </div>
        </div>
        <div class="row justify-content-around mt-5">
            <div class="col-md-6">
                <label class="form-label" for="description_courte">
                    <div class="badge badge-dark text-wrap">Description courte</div>
                </label>
                <textarea class="form-control" name="description_courte" id="description_courte" placeholder="description courte" rows="5"><?= $description_courte ?></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="description_longue">
                    <div class="badge badge-dark text-wrap">Description longue</div>
                </label>
                <textarea class="form-control" name="description_longue" id="description_longue" placeholder="description longue" rows="5"><?= $description_longue ?></textarea>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-4">
                <label class="form-label" for="categorie">
                    <div class="badge badge-dark text-wrap">Catégorie</div>
                </label>
                <select class="form-control" id="categorie" name="categorie">
                <?php while ($menuCategorie = $afficheMenuCategories->fetch(PDO::FETCH_ASSOC)) : ?>
                        <option value="<?= $menuCategorie['id_categorie'] ?>"> <?= $menuCategorie['titre'] ?></option>
                    <?php endwhile ?>
                </select>
            </div>
            <div class="col-md-4">
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
        </div>
        <div class="col-md-1 mt-5">
            <button type="submit" class="btn btn-outline-dark btn-primary">Valider</button>
        </div>

    </form>

<?php endif; ?>

<?php 
// Le membre peut modifier ou supprimer supprimer son annonce 
$membre_id=$_SESSION['membre']['id_membre'];
$queryArticle = $pdo->query(" SELECT id_article FROM articles WHERE membre_id = $membre_id"); ?>
<h2 class=" p-5 py-5">Vous avez publiée <?= $queryArticle->rowCount() ?> articles</h2>

<div class="container">
<table class="table table-striped table-hover text-center table-responsive">

    <?php $afficheArticles = $pdo->query("SELECT * FROM articles WHERE membre_id = $id_membre ORDER BY titre ASC LIMIT $parPage OFFSET $premierAnnonce") ?>

     <thead>
        <tr>
            <?php for ($i = 0; $i < $afficheArticles->columnCount(); $i++) :
                $colonne = $afficheArticles->getColumnMeta($i) ?>
                <th><?= $colonne['name'] ?></th>
            <?php endfor; ?>

            <th colspan=3>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($article = $afficheArticles->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($article as $key => $value) : ?>
                    <?php if ($key == 'titre') : ?>
                        <td><?= $value ?></td>
                    <?php elseif ($key == 'photo') : ?>
                        <td><img class="img-fluid" src="<?= URL . 'img/' . $value ?>" width="50" loading="lazy"></td>
                    <?php else : ?>
                        <td><?= $value ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- Crayon pour modifier (UPDATE) et poubelle pour supprimer (DELETE) -->
                <td><a href='?action=update&id_article=<?= $article['id_article'] ?>'><i class="bi bi-pen-fill text-warning"></i></a></td>
                <td><a data-href="?action=delete&id_article=<?= $article['id_article'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger" style="font-size: 1.5rem;"></i></a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>

<!-- modal suppression codepen https://codepen.io/lowpez/pen/rvXbJq -->

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Supprimer Utilisateur
            </div>
            <div class="modal-body">
                Etes-vous sur de vouloir retirer cet utilisateur de votre base de données ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                <a class="btn btn-danger btn-ok">Supprimer</a>
            </div>
        </div>
    </div>


<?php require_once('footer.php') ?>