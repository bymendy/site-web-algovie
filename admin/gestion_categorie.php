<?php
require_once('../include/init.php');

if (!internauteConnecteAdmin()) {
    header("Location: connexion.php");
    exit();
}
// pagination selon Categorie
// si un indice page existe dans l'url et qu'on retrouve une valeur dedans
if(isset($_GET['page']) && !empty($_GET['page'])){

    $pageCourante = (int) strip_tags($_GET['page']);
}else{
    // $pageCourante prendra la valeur de defaut qui est 1
    $pageCourante = 1;
}
$queryCategorie = $pdo->query("SELECT COUNT(id_membre) AS nombreCategorie FROM membre" );
$resultatCategorie = $queryCategorie->fetch();
$nombreCategorie = (int) $resultatCategorie['nombreCategorie'];
// echo debug($nombreCategorie);
// je veux que sur chaque page s'affiche 5 Categorie
$parPage =  5; 
$nombrePages = ceil($nombreCategorie / $parPage);
$premierMembre = ($pageCourante - 1) * $parPage;
// fin pagination


$categorie = "";

// ************ CONTRAINTE ************

if (isset($_GET['action'])) {

    if ($_POST) {

// Les contraintes pour chaque champs    
        if (!isset($_POST['categorie']) || iconv_strlen($_POST['categorie']) < 3 || iconv_strlen($_POST['categorie']) > 20) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format categorie !</div>';
        }    
        if (!isset($_POST['titre']) || iconv_strlen($_POST['titre']) < 3 || iconv_strlen($_POST['titre']) > 20) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format titre !</div>';
        }

        if (!isset($_POST['motcles']) || iconv_strlen($_POST['motcles']) < 3 || iconv_strlen($_POST['motcles']) > 20) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format motcles !</div>';
        }

        // Condition si user à bien renseigner les champs et ne s'est pas tromper
        if (empty($erreur)) {
            // si dans l'URL action == update, on on modifie
            if ($_GET['action'] == 'update') {
                $modifCategorie = $pdo->prepare(" UPDATE categorie SET id_categorie = :id_categorie , titre = :titre, motcles = :motcles WHERE id_categorie = :id_categorie ");
                $modifCategorie->bindValue(':id_categorie', $_POST['id_categorie'], PDO::PARAM_INT);
                $modifCategorie->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $modifCategorie->bindValue(':motcles', $_POST['motcles'], PDO::PARAM_STR);
                $modifCategorie->execute();

                // Requete pour afficher un message personnaliser lorsque la modification à bien été réussie
                $queryCategorie = $pdo->query(" SELECT categorie FROM titre WHERE id_categorie = '$_GET[id_categorie]' ");
                $categorie = $queryCategorie->fetch(PDO::FETCH_ASSOC);

                $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                        <strong>Félicitations !</strong> Modification de l`\'utilisateur '. $categorie['categorie'] .' réussie !
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                // si on récupère autre chose que update (et donc add) on entame une procédure d'insertion en BDD
                $inscrireCategorie = $pdo->prepare(" INSERT INTO categorie (id_categorie, titre, motcles, categorie,date_enregistrement) VALUES (:id_categorie, :titre, :motcles, :categorie, NOW()) ");               
                $inscrireCategorie->bindValue(':id_categorie', $_POST['id_categorie'], PDO::PARAM_STR);
                $inscrireCategorie->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $inscrireCategorie->bindValue(':motcles', $_POST['motcles'], PDO::PARAM_STR);
                $inscrireCategorie->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_INT);
                $inscrireCategorie->execute();
            }
        }
    }

    // procédure de récupération des infos en BDD pour les afficher dans le formulaire lorsque on fait un update (plus pratique et plus sur)
    if ($_GET['action'] == 'update') {
        $tousCategories = $pdo->query("SELECT * FROM categorie WHERE titre = '$_GET[titre]' ");
        $categorieActuel = $tousCategories->fetch(PDO::FETCH_ASSOC);
    }

    $titre = (isset($categorieActuel['titre'])) ? $categorieActuel['titre'] : "";
    $motcles = (isset($categorieActuel['motcles'])) ? $categorieActuel['motcles'] : "";
   
    
    // syntaxe de condition classique équivalente à la ternaire juste au dessus
    /*if(isset($categorieActuel['pseudo'])){
            $pseudo = $categorieActuel['pseudo'];
        }else{
            $pseudo = "";
        }*/

    if($_GET['action'] == 'delete'){
        // requete de suppression d'une entrée (pas besoin de stocker une valeur dans une variable que l'on declare, on travaille directement avec l'objet $pdo qui pointe sur la méthode query pour faire un DELETE)
        $pdo->query(" DELETE FROM categorie WHERE id_categorie = '$_GET[id_categorie]' ");
    }
}

require_once('includeAdmin/header.php');
?>


<h1 class="text-center my-5">
    <div class="badge badge-primary text-wrap p-3">Gestion des categories</div>
</h1>

<?= $erreur ?>
<?= $content ?>

<?php if (isset($_GET['action'])) : ?>
    <h2 class="my-5">Formulaire <?= ($_GET['action'] == 'add') ? "d'ajout" : "de modification" ?> des categories</h2>

<!-- FORMULAIRE -->
<?php $id_categorie = isset($_POST['id_categorie']) ? $_POST['id_categorie'] : ''; ?>

<form class="my-5 w-100" method="POST" action="">
    <input type="hidden" name="id_categorie" value="<?= $id_categorie ?>">

    <div class="row">
        <div class="col-md-6 mt-5">
            <label class="form-label" for="categorie">
                <div class="badge badge-dark text-wrap">Categorie</div>
            </label>
            <input class="form-control" type="text" name="categorie" id="categorie" placeholder="categorie" value="<?= $categorie ?>">
        </div>
        <div class="col-md-6 mt-5">
            <label class="form-label" for="titre">
                <div class="badge badge-dark text-wrap">Titre</div>
            </label>
            <input class="form-control" type="text" name="titre" id="titre" placeholder="titre" value="<?= $titre ?>">
        </div>
        <div class="col-md-6 mt-5">
            <label class="form-label" for="motcles">
                <div class="badge badge-dark text-wrap">Mots clés</div>
            </label>
            <input class="form-control" type="text" name="motcles" id="motcles" placeholder="mots clés" value="<?= $motcles ?>">
        </div>
    </div>

    <div class="col-md-1 mt-5">
        <button type="submit" class=" btn btn-dark btn-outline-primary">Valider</button>
    </div>
</form>
<?php endif; ?>

<!-- requete SQL pour récupérer le nb d'categories inscrits en BDD, nb que je pourrais afficher grace à rowCount deux lignes en dessous -->
<?php $nbCategories = $pdo->query("SELECT id_categorie FROM categorie"); ?>
<h2 class="py-5">Nombre de categories en base de données: <?= $nbCategories->rowCount() ?></h2>

<div class="row justify-content-center py-5">
    <a href='?action=add'>
        <button type="button" class="btn btn-sm btn-outline-dark shadow rounded">
            <i class="bi bi-plus-circle-fill"></i> Ajouter une categorie
        </button>
    </a>
</div>

<table class=" table table-outline-light text-center table-hover">
    <?php $afficheCategorie = $pdo->query("SELECT * FROM categorie ORDER BY titre ASC "); ?>
    <thead>
        <tr>
            <?php for ($i = 0; $i < $afficheCategorie->columnCount(); $i++) :
                $colonne = $afficheCategorie->getColumnMeta(($i)) ?>
                <?php if ($colonne['name'] != 'categorie') : ?>
                    <th><?= $colonne['name'] ?></th>
                <?php endif; ?>
            <?php endfor; ?>
            <th colspan=2>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($categorie = $afficheCategorie->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($categorie as $key => $value) : ?>
                    <?php if ($key != 'categorie') : ?>
                        <td><?= $value ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td><a href='?action=update&id_categorie=<?= $categorie['id_categorie'] ?>'><i class="bi bi-pen-fill text-warning"></i></a></td>
                <td><a data-href="?action=delete&id_categorie=<?= $categorie['id_categorie'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger" style="font-size: 1.5rem;"></i></a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- DEBUT PAGINATION -->
<nav>
<ul class="pagination justify-content-end">

        <li class="page-item <?= ($pageCourante == 1 ) ? 'disabled' : "" ?>">

            <a class="page-link text-dark" href="?page=<?= $pageCourante -1?>" aria-label="Previous">
                <span aria-hidden="true">précédente</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <!-- AFFICHE LE NOMBRE DE PAGES -->
        <?php for($page = 1; $page <= $nombrePages; $page++): ?>
        <li class="mx-1 page-item <?= ($pageCourante == $page) ?'active' : "" ?>">
            <a class="btn btn-outline-dark " href="?page=<?= $page ?>"><?= $page ?></a>
        </li>
        <?php endfor; ?>

        <!-- FIN NOMBRE DE PAGES -->
        <li class="page-item <?= ($pageCourante == $nombrePages)? 'disabled' : '' ?>">
            <a class="page-link text-dark" href="?page=<?= $pageCourante +1?>" aria-label="Next">
                <span aria-hidden="true">suivante</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>

<!-- <td><a href=''><i class="bi bi-pen-fill text-warning"></i></a></td>-->
<!-- <td><a data-href="" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger" style="font-size: 1.5rem;"></i></a></td> -->

<!-- modal suppression codepen https://codepen.io/lowpez/pen/rvXbJq -->

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Supprimer categorie
            </div>
            <div class="modal-body">
                Etes-vous sur de vouloir retirer cette categorie de votre base de données ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
                <a class="btn btn-danger btn-ok">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<!-- modal -->

<!-- pour empecher la modale de s'ouvrir à chaque rafraichissement de page, le temps de terminer de coder cette page -->
<?php if (!isset($_GET['action']) && !isset($_GET['page'])) : ?>
    <!-- modal infos -->
    <div class="modal fade" id="myModalCategories" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-warning" id="exampleModalLabel">Gestion des categories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Gérez ici votre base de données des categories</p>
                    <p>Vous pouvez modifier leurs données, ajouter ou supprimer un categorie</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning text-dark" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
<?php endif; ?>

<?php require_once('includeAdmin/footer.php'); ?>