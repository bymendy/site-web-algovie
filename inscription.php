<?php
require_once('include/init.php');

$pageTitle = "Formulaire d'inscription ";

// redirection de l'internaute déjà connecté, il n'a rien a faire sur une page inscription (on le redirige vers sa page profil grace à header(location))
if(internauteConnecte()){
    header("Location: profil.php");
}

// tout le controle des inputs et la procédure d'envoi de données en BDD devra etre codé dans cette condition
if($_POST){
    if(isset($_POST['valider'])) {
        $inscriptionReussie = true; // une variable pour indiquer si l'annonce a été déposée avec succès ou non

    }
    // echo (isset($inscriptionReussie)) ? '<div class="alert alert-success alert-dismissible fade show " role="alert">
    // <p>Merci de votre inscription ! Connectez vous sur votre espace membre et déposez votre annonce 😉 !</p> 
    // <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //     <span aria-hidden="true">&times;</span>
    // </button>
    // </div>' : '';

    // controle du pseudo avec un preg_match
    if(!isset($_POST['pseudo']) || !preg_match('#^[a-zA-Z0-9-_.]{3,20}$#', $_POST['pseudo'])){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format pseudo !</div>';
    }

    
    if(!isset($_POST['mdp']) || strlen($_POST['mdp']) < 3 || strlen($_POST['mdp']) > 20 ){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format mdp !</div>';
    }


    if(!isset($_POST['nom']) || iconv_strlen($_POST['nom']) < 3 || iconv_strlen($_POST['nom']) > 20 ){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format nom !</div>';
    }

    if(!isset($_POST['prenom']) || iconv_strlen($_POST['prenom']) < 3 || iconv_strlen($_POST['prenom']) > 20 ){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format prénom !</div>';
    }


    if(!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format email !</div>';
    }

    // va vérifier que le pseudo entré n'existe pas déjà en BDD. 
    $verifPseudo = $pdo->prepare("SELECT pseudo FROM membre WHERE pseudo = :pseudo ");
    $verifPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $verifPseudo->execute();

    // le résultat de notre requete ne doit pas = 1, 
    if($verifPseudo->rowCount() == 1){
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur, ce pseudo existe déjà, vous devez en choisir un autre !</div>';
    }

    // hasher le mot de passe avant de l'envoyer en BDD
    $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    // procédure d'envoi en BDD
    if(empty($erreur)){
        $inscrireUser = $pdo->prepare(" INSERT INTO membre (pseudo, mdp, nom, prenom, email, date_enregistrement, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, NOW(), 2) ");
        $inscrireUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $inscrireUser->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
        $inscrireUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $inscrireUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $inscrireUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $inscrireUser->execute();

        header('location' . URL . 'connexion.php?action=validate');
    }

}

require_once('header.php');
?>

<?= $erreur ?>

<div class="">
	<div class=" header background-cov row align-items-center justify-content-center vh-100">
	    <div class=" col-lg-4">
	<form class="border-0 card bg-transparent" method="POST" action=""> 
    <h2 class=" mx-4  mt-5 pt-4">Formulaire d'inscription</h2>
        <div class="col-md-4 mt-5 "></div>                    

        <?php echo (isset($inscriptionReussie)) ? '<div class="alert alert-success alert-dismissible fade show " role="alert">
    <p>Merci de votre inscription ! Connectez vous sur votre espace membre et déposez votre article 😉 !</p> 
    <button type="button" class="btn btn-secondary" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>' : '';?>

					<div class="form-group">
						<label class="form-label" for="pseudo"></label>
						<input class="form-control" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" max-length="20" pattern="[a-zA-Z0-9-_.]{3,20}" title="caractères acceptés: majuscules et minuscules, chiffres, signes tels que: - _ . , entre trois et vingt caractères." required>
					</div>

					<div class="form-group">
						<label class="form-label" for="mdp"></label>
						<input class="form-control" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" required>
					</div>

					<div class="form-group">
						<label class="form-label" for="nom"></label>
						<input class="form-control" type="text" name="nom" id="nom" placeholder="Votre nom">
					</div>

					<div class="form-group">
						<label class="form-label" for="prenom"></label>
						<input class="form-control" type="text" name="prenom" id="prenom" placeholder="Votre prénom">
					</div>


					<div class="form-group">
						<label class="form-label" for="email"></label>
						<input class="form-control" type="email" name="email" id="email" placeholder="Votre email" required>
					</div>
					<button type="submit" name="valider"class="btn btn-primary my-5">S'inscrire</button>

			</div>
		</div>
    </form>

</div>

<?php require_once('footer.php') ?>