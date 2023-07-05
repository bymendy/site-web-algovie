<?php
require_once('../include/init.php');

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
if (isset($_GET['action'])) {
// tous ce qui va concernée l'envoie en base de donnée
    if ($_POST) {
// Les contraintes pour chaque champs

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
            // si dans l'URL action == update, on entame une procédure de modification
            if($_GET['action'] == 'update'){
                $modifArticle = $pdo->prepare("UPDATE articles SET id_article = :id_article, titre = :titre, description_courte = :description_courte, description_longue = :description_longue, categorie_id = :categorie_id, photo = :photo  WHERE id_article = :id_article");
                $modifArticle->bindValue(':id_article', $_POST['id_article'], PDO::PARAM_INT);
                $modifArticle->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $modifArticle->bindValue(':description_courte', $_POST['description_courte'], PDO::PARAM_STR);
                $modifArticle->bindValue(':description_longue', $_POST['description_longue'], PDO::PARAM_STR);
                $modifArticle->bindValue(':categorie_id', $_POST['categorie'], PDO::PARAM_STR);
                $modifArticle->bindValue(':photo', $photoBdd, PDO::PARAM_STR);
                $modifArticle->execute();


                $queryArticle = $pdo->query(" SELECT titre FROM articles WHERE id_article = '$_GET[id_article]' ");

                $article = $queryArticle->fetch(PDO::FETCH_ASSOC);

                // Requete pour afficher un message personnaliser lorsque la modification à bien été réussie
                $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                        <strong>Félicitations !</strong> Modification de l\'article '. $article['titre'] .' réussie !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {


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
    }

    // procédure de récupération des infos en BDD pour les afficher dans le formulaire lorsque on fait un update (plus pratique et plus sur)
    if ($_GET['action'] == 'update') {
        $tousArticle = $pdo->query("SELECT * FROM articles WHERE id_article = '$_GET[id_article]' ");
        $articleActuel = $tousArticle->fetch(PDO::FETCH_ASSOC);
    }

    $id_article = (isset($articleActuel['id_article'])) ? $articleActuel['id_article'] : "";
    $categorie = (isset($articleActuel['categorie'])) ? $articleActuel['categorie'] : "";
    $titre = (isset($articleActuel['titre'])) ? $articleActuel['titre'] : "";

    $description_courte = (isset($articleActuel['description_courte'])) ? $articleActuel['description_courte'] : "";
    $description_longue = (isset($articleActuel['description_longue'])) ? $articleActuel['description_longue'] : "";

    $photoActuelle = (isset($articleActuel['photo'])) ? $articleActuel['photo'] : "";


    // Requete pour effectuer une Supression
    if($_GET['action'] == 'delete'){
        $pdo->query("DELETE FROM articles WHERE id_article = '$_GET[id_article]' ");
    }
}
require_once('includeAdmin/header.php');
?>


<h1 class="text-center my-5">
    <div class="badge badge-warning text-wrap p-3">Gestion des Articles</div>
</h1>

<?= $erreur ?>
<?= $content ?>

<!-- <?= debug($_POST) ?>  -->

<?php if (isset($_GET['action']) && isset($_GET['page'])) : ?>
<div class="blockquote alert alert-dismissible fade show mt-5 shadow border border-warning rounded" role="alert">
    <p>Gérez ici votre base de données des Articles</p>
    <p>Vous pouvez modifier leurs données, ajouter ou supprimer une article</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<!-- AFFICHAGE article -->
<?php if (isset($_GET['action']) && $_GET['action'] == 'see'): ?>
    <div class="text-center py-5 col-10 mx-auto">
        <div class="d-md-flex">
            <div class="card shadow p-3 mb-5 bg-white rounded">
                <img src="<?= URL . 'img/' . $detail['photo'] ?>" class="card-img-top maxImg" alt="image du produit">
                <div>
                    <img src="<?= URL . 'img/' . $test[''] ?>" alt="">

                </div>
            </div>
            <div class="col-5 mx-auto text-center">
                <h1 class=""><?= $detail['titre'] ?></h1>
                <h2 class="mt-3"><?= $detail['description_courte']?></h2>
                <p class=""><?= $detail['description_longue']?></p>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- Titre Formulaire -->
<?php if(isset($_GET['action'])): ?>
<h2 class="pt-5">Formulaire <?= ($_GET['action'] == 'add') ? "d'ajout" : "de modification" ?> des Articles</h2>
<!-- FORMULAIRE -->
<form id="monForm" class="my-5" method="POST" action="" enctype="multipart/form-data">
    <!-- id_article pour effectuer des modifications  -->
    <input type="hidden" name="id_article" value="<?= $id_article ?>">

    <div class="row mt-5">
        <div class="col-md-4">
            <label class="form-label" for="categorie">
                <div class="badge badge-dark text-wrap">Catégorie</div>
            </label>
            <!-- Mettre une balise select et faire une boucle While -->
            <select class="form-control"  name="categorie" id="categorie">
            <?php             
            while($categorie = $listeCategorie->fetch(PDO::FETCH_ASSOC)){
                echo "<option value='$categorie[id_categorie]'> $categorie[titre] </option> ";
            }
        
            ?>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label" for="titre">
                <div class="badge badge-dark text-wrap">Titre</div>
            </label>
            <input class="form-control" type="text" name="titre" id="titre" placeholder="Titre" value="<?= $titre ?>">
        </div>
    </div>

    <div class="row justify-content-around mt-5">
        <div class="col-md-12">
            <label class="form-label" for="description_courte">
                <div class="badge badge-dark text-wrap">Description</div>
            </label>
            <textarea class="form-control" name="description_courte" id="description_courte" placeholder="Description" rows="5" ><?= $description_courte ?></textarea>
        </div>
    </div>
    <div class="row justify-content-around mt-5">
        <div class="col-md-12">
            <label class="form-label" for="description_longue">
                <div class="badge badge-dark text-wrap">Description longue </div>
            </label>
            <textarea class="form-control" name="description_longue" id="description_longue" placeholder="Description longue" rows="5" ><?= $description_longue ?></textarea>
        </div>
    </div>

    <div class="row mt-5">

        <div class="col-md-4">
            <label class="form-label" for="photo">
                <div class="badge badge-dark text-wrap">Photo</div>
            </label>
            <input class="form-control" type="file" name="photo" id="photo" placeholder="Photo">
        </div>
        <!-- ----------------- -->
        <!-- -->        
        <?php if(!empty($photo_bdd)): ?>
        <div class="mt-4">
            <p>Vous pouvez changer d'image
                <img src="<?= URL . 'img/' . $photo_bdd ?>" width="50px">
            </p>
        </div>
        <?php endif; ?>
        <!-- pour modifier la photo existante par une nouvelle  -->
        <input type="hidden" name="photoActuelle" value="<?= $photoActuelle ?>">
        <!-- -------------------- -->

    </div>


    <div class="col-md-1 mt-5">
        <button type="submit" class="btn btn-outline-dark btn-warning">Valider</button>
    </div>

</form>
<?php endif; ?>
<div class="w-100 row justify-content-center py-5">
    <a href='?action=add'>
        <button type="button" class="btn btn-sm btn-outline-dark shadow rounded">
            <i class="bi bi-plus-circle-fill"></i> Ajouter une article
        </button>
    </a>
</div>
<!-- Nombres d'Articles en Base de données -->
<?php $queryArticles = $pdo->query(" SELECT id_article FROM articles "); ?>
<h2 class="py-5">Nombre de Articles en base de données: <?= $queryArticles->rowCount() ?></h2>


<!-- TABLEAU DES Articles -->
<div class="col-12">
<table class="table col-12  table-dark text-center table-responsive table-hover">
    <!-- Complété pour n'afficher que 10 prduits dans le tableau le OFFST détermine quel article affichée dans la nouvelle page -->
    <?php $afficheArticles = $pdo->query("SELECT * FROM articles ORDER BY titre ASC LIMIT $parPage OFFSET $premierArticle") ?>
    <thead class="col-12">
        <tr>
            <?php for ($i = 0; $i < $afficheArticles->columnCount(); $i++) :
                $colonne = $afficheArticles->getColumnMeta($i) ?>
                <th><?= $colonne['name'] ?></th>
            <?php endfor; ?>
            <th colspan=2>Actions</th>
        </tr>
    </thead>
    <tbody class="col-12">
        <?php while ($article = $afficheArticles->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($article as $key => $value) : ?>
                        <td><img class="img-fluid" src="<?= URL . 'img/' . $value ?>" width="50" loading="lazy"></td>
                        <td><?= $value ?></td>
                <?php endforeach; ?>
                <!-- Crayon pour modifier (UPDATE) et poubelle pour supprimer (DELETE) -->
                <td><a href='?action=update&id_article=<?= $article['id_article'] ?>'><i class="bi bi-pen-fill text-warning"></i></a></td>
                <td><a data-href="?action=delete&id_article=<?= $article['id_article'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger" style="font-size: 1.5rem;"></i></a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
<!-- Debut de pagignation -->
<nav aria-label="">
    <ul class="pagination justify-content-end">
        <li class="page-item <?= ($pageCourante == 1) ? 'disabled' : "" ?> ">
            <a class="page-link text-dark" href="?page=<?= $pageCourante - 1 ?>" aria-label="Previous">
                <span aria-hidden="true">précédente</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <?php for($page = 1; $page <= $nombrePages; $page++): ?>
        <li class="mx-1 page-item">
            <a class="btn btn-outline-warning <?= ($pageCourante == $page) ? 'active' : "" ?>" href="?page=<?= $page ?>"><?= $page ?> </a>
        </li>
        <?php endfor; ?>
        <li class="page-item <?= ($pageCourante == $nombrePages)? 'disabled' : '' ?>">
            <a class="page-link text-dark" href="?page=<?= $pageCourante + 1 ?>" aria-label="Next">
                <span aria-hidden="true">suivante</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>

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
<?php require_once('includeAdmin/footer.php'); ?>