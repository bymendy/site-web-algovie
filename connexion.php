<?php
require_once('include/init.php');

$pageTitle = "Connexion";

if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {
  unset($_SESSION['membre']);
  header("Location: connexion.php");
  exit();
}
if(internauteConnecte()){
  header("Location: profil.php");
  exit();
}

// condition a mettre obligatoirement pour éviter un undefined key $action (si la personne veut se connecter sans passer par la phase inscription)
if(isset($_GET['action']) && $_GET['action'] == 'validate' ){
$validate .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                    <strong>Félicitations !</strong> Votre inscription est réussie 😉, vous pouvez vous connecter !
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
}

if($_POST){

    // requete qui va comparer le pseudo entré dans le champs du form avec les infos en BDD (Ce pseudo existe t-il ?)
    $verifPseudo = $pdo->prepare(" SELECT * FROM membre WHERE pseudo = :pseudo ");
    $verifPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $verifPseudo->execute();

    // si un même pseudo existe en BDD (rowCount == 1), alors on continue la procédure d'authentification
    if($verifPseudo->rowCount() == 1){
        // on fait un fetch pour récupérer toutes les valeurs de cette entrée en BDD qui à le même pseudo
        $user = $verifPseudo->fetch(PDO::FETCH_ASSOC);
        // si le mot de passe correspond, on authentifie
        // password_verify est une fonction prédéfinie qui permet de comparer le mdp en BDD hashé, avec le vrai mdp du user (elle va déhasher le mdp en BDD)
        if(password_verify($_POST['mdp'], $user['mdp'])){
            // les deux mots de passe correspondent, on crée une session utilisateur qui va enregistrer toutes les infos le concernant, il en aura besoin sur le site
            foreach($user as $key => $value){
                // on récupère toutes les infos en BDD sauf son mot de passe, dangeureux et inutile
                if($key != 'mdp'){
                    // boucle qui permet de ne pas taper toutes les lignes en dessous
                    $_SESSION['membre'][$key] = $value;


                    // une fois qu'il s'est authentifié et crée la session['membre'], on fait nos redirections UX (expérience utilisateur)
                    // premier cas de redirection, le user est l'admin du site, on l'envoie vers le back-office
                    if(internauteConnecteAdmin()){
                        header('location:' . URL . 'admin/index.php?action=validate' );

                    }else{
          
                      header("Location: profil.php");
                    }
                    
                }
            }
        }else{
            // si le mot de passe ne correspond pas, message d'erreur
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur ce mot de passe ne correspond pas !</div>';
        }
    }else{
        // si le pseudo n'est pas référencé en BDD, on en avertit l'utilisateur
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur ce pseudo n\'existe pas, vérifiez !<br> Etes vous inscrit ?</div>';
    }

}

require_once('header.php');
?>

<?= $validate ?>
<form method="POST" action="">

<div class=" header d-flex align-items-center justify-content-center vh-100 ">
  <div class="card bg-transparent ">
    <div class="card-body  ">
            <h3 class="text-center mb-4">Se connecter</h3>
              <div class="form-group">
              <label class="form-label" for="pseudo"><div class="badge badge-dark text-wrap">Pseudo</div></label>
                <input class="form-control btn btn-outline-primary mb-4" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo">
              </div>
              <div class="form-group">
              <label class="form-label" for="mdp"><div class="badge badge-dark text-wrap">Mot de passe</div></label>
                <input class="form-control btn btn-outline-primary mb-4" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe">
              </div>
              <button type="submit" class="btn btn-primary btn-block">Connexion</button>
          </div>
        </div>

  </div>




</form>
<?php require_once('footer.php') ?>