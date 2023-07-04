<?php
require_once('../include/init.php');

if (!internauteConnecteAdmin()) {
    header("Location: connexion.php");
    exit();
}
// pagination selon Membres
// si un indice page existe dans l'url et qu'on retrouve une valeur dedans
if(isset($_GET['page']) && !empty($_GET['page'])){

    $pageCourante = (int) strip_tags($_GET['page']);
}else{
    // $pageCourante prendra la valeur de defaut qui est 1
    $pageCourante = 1;
}
$queryMembres = $pdo->query("SELECT COUNT(id_membre) AS nombreMembres FROM membre" );
$resultatMembres = $queryMembres->fetch();
$nombreMembres = (int) $resultatMembres['nombreMembres'];
// echo debug($nombreMembres);
// je veux que sur chaque page s'affiche 5 Membres
$parPage =  5; 
$nombrePages = ceil($nombreMembres / $parPage);
$premierMembre = ($pageCourante - 1) * $parPage;
// fin pagination


// introduire le formulaire, et vérifier que j'ai reçu dans l'URL un indice action. 
if (isset($_GET['action'])) {

    if ($_POST) {

        if (!isset($_POST['pseudo']) || !preg_match('#^[a-zA-Z0-9-_.]{3,20}$#', $_POST['pseudo'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format pseudo !</div>';
        }

        if ($_GET['action'] == 'add') {
            $verifPseudo = $pdo->prepare("SELECT pseudo FROM membre WHERE pseudo = :pseudo ");
            $verifPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
            $verifPseudo->execute();

            if ($verifPseudo->rowCount() == 1) {

                $erreur .= '<div class="alert alert-danger" role="alert">Erreur, ce pseudo existe déjà, vous devez en choisir un autre !</div>';
            }

            if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 3 || strlen($_POST['mdp']) > 20) {
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur format mdp !</div>';
            }

            $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        }

        if (!isset($_POST['nom']) || iconv_strlen($_POST['nom']) < 3 || iconv_strlen($_POST['nom']) > 20) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format nom !</div>';
        }

        if (!isset($_POST['prenom']) || iconv_strlen($_POST['prenom']) < 3 || iconv_strlen($_POST['prenom']) > 20) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format prénom !</div>';
        }


        if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format email !</div>';
        }




        if (empty($erreur)) {
            // si dans l'URL action == update, on entame une procédure de modification
            if ($_GET['action'] == 'update') {
                $modifIuser = $pdo->prepare(" UPDATE membre SET id_membre = :id_membre , pseudo = :pseudo, nom = :nom, prenom = :prenom, email = :email WHERE id_membre = :id_membre ");
                $modifIuser->bindValue(':id_membre', $_POST['id_membre'], PDO::PARAM_INT);
                $modifIuser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $modifIuser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $modifIuser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $modifIuser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $modifIuser->execute();
            } else {
                // si on récupère autre chose que update (et donc add) on entame une procédure d'insertion en BDD
                $inscrireUser = $pdo->prepare(" INSERT INTO membre (pseudo, mdp, nom, prenom, email,  date_enregistrement, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, NOW(), 2) ");
                $inscrireUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $inscrireUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);

                $inscrireUser->execute();
            }
        }
    }

    // procédure de récupération des infos en BDD pour les afficher dans le formulaire lorsque on fait un update 
    if ($_GET['action'] == 'update') {
        $tousUsers = $pdo->query("SELECT * FROM membre WHERE id_membre = '$_GET[id_membre]' ");
        $userActuel = $tousUsers->fetch(PDO::FETCH_ASSOC);
    }

    $id_membre = (isset($userActuel['id_membre'])) ? $userActuel['id_membre'] : "";
    $pseudo = (isset($userActuel['pseudo'])) ? $userActuel['pseudo'] : "";
    $email = (isset($userActuel['email'])) ? $userActuel['email'] : "";
    $nom = (isset($userActuel['nom'])) ? $userActuel['nom'] : "";
    $prenom = (isset($userActuel['prenom'])) ? $userActuel['prenom'] : "";
    
    if($_GET['action'] == 'delete'){
        $pdo->query("DELETE FROM membre WHERE id_membre = '$_GET[id_membre]' ");
    }
}


require_once('includeAdmin/header.php');
?>

<h1 class="text-center my-5">
    <div class="badge badge-primary text-wrap p-3">Gestion des utilisateurs</div>
</h1>

<?= $erreur ?>




<?php if (isset($_GET['action'])) : ?>
    <h2 class="my-5">Formulaire <?= ($_GET['action'] == 'add') ? "d'ajout" : "de modification" ?> des utilisateurs</h2>

<!-- FORMULAIRE  -->
    <form class="my-5" method="POST" action="">
        <!-- input pour l'id-membre, indispensable pour la requete de modification en BDD -->
        <input type="hidden" name="id_membre" value="<?= $id_membre ?>">

        <div class="row">
            <div class="col-md-4 mt-5">
                <label class="form-label" for="pseudo">
                    <div class="badge badge-dark text-wrap">Pseudo</div>
                </label>
                <input class="form-control" type="text" name="pseudo" id="pseudo" placeholder="Pseudo" value="<?= $pseudo ?>">
            </div>

            <?php if ($_GET['action'] == "add") : ?>

                <div class="col-md-4 mt-5">
                    <label class="form-label" for="mdp">
                        <div class="badge badge-dark text-wrap">Mot de passe</div>
                    </label>
                    <input class="form-control" type="password" name="mdp" id="mdp" placeholder="Mot de passe">
                </div>

            <?php endif; ?>

            <div class="col-md-4 mt-5">
                <label class="form-label" for="email">
                    <div class="badge badge-dark text-wrap">Email</div>
                </label>
                <input class="form-control" type="email" name="email" id="email" placeholder="Email" value="<?= $email ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mt-5">
                <label class="form-label" for="nom">
                    <div class="badge badge-dark text-wrap">Nom</div>
                </label>
                <input class="form-control" type="text" name="nom" id="nom" placeholder="Nom" value="<?= $nom ?>">
            </div>

            <div class="col-md-4 mt-5">
                <label class="form-label" for="prenom">
                    <div class="badge badge-dark text-wrap">Prénom</div>
                </label>
                <input class="form-control" type="text" name="prenom" id="prenom" placeholder="Prénom" value="<?= $prenom ?>">
            </div>

        </div>

        <div class="col-md-1 mt-5">
            <button type="submit" class="btn btn-dark btn-outline-primary">Valider</button>
        </div>

    </form>
<?php endif; ?>

<!-- requete SQL pour récupérer le nb d'utilisateurs inscrits en BDD -->
<?php $nbUsers = $pdo->query("SELECT id_membre FROM membre"); ?>
<h2 class="py-5">Nombre d'utilisateurs en base de données: <?= $nbUsers->rowCount() ?></h2>

<div class="row justify-content-center py-5">
    <a href='?action=add'>
        <button type="button" class="btn btn-sm btn-outline-dark shadow rounded">
            <i class="bi bi-plus-circle-fill"></i> Ajouter un utilisateur
        </button>
    </a>
</div>
<!-- TABLEAU MEMBRE -->
<table class="table table-outline-light text-center table-hover">
     <!-- Afficher que 5 membres dans le tableau-->   
    <?php $afficheUsers = $pdo->query("SELECT * FROM membre ORDER BY pseudo ASC LIMIT $parPage OFFSET $premierMembre"); ?>
    <thead>
        <tr>
            <?php for ($i = 0; $i < $afficheUsers->columnCount(); $i++) :
                $colonne = $afficheUsers->getColumnMeta(($i)) ?>
                <?php if ($colonne['name'] != 'mdp') : ?>
                    <th><?= $colonne['name'] ?></th>
                <?php endif; ?>
            <?php endfor; ?>
            <th colspan=2>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $afficheUsers->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($user as $key => $value) : ?>
                    <?php if ($key != 'mdp') : ?>
                        <td><?= $value ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td><a href='?action=update&id_membre=<?= $user['id_membre'] ?>'><i class="bi bi-pen-fill text-warning"></i></a></td>-->
                <td><a data-href="?action=delete&id_membre=<?= $user['id_membre'] ?>" data-toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger" style="font-size: 1.5rem;"></i></a></td>
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
</div>

<!-- modal -->
<?php if (!isset($_GET['action']) && isset($_GET['page'])) : ?>
    <!-- modal infos -->
    <div class="modal fade" id="myModalUsers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-warning" id="exampleModalLabel">Gestion des utilisateurs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Gérez ici votre base de données des utilisateurs</p>
                    <p>Vous pouvez modifier leurs données, ajouter ou supprimer un utilisateur</p>
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