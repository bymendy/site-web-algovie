<?php

require_once('include/init.php');

$id_membre = $_SESSION['membre']['id_membre'];

// Récupération des nouvelles données
$nouveau_pseudo = $_POST['nouveau_pseudo'];
$nouveau_prenom = $_POST['nouveau_prenom'];
$nouveau_nom = $_POST['nouveau_nom'];
$nouveau_email = $_POST['nouveau_email'];

// Mise à jour des données dans la BDD
$recup = $pdo->prepare("UPDATE membre SET pseudo=:pseudo, prenom=:prenom, nom=:nom, email=:email WHERE id_membre=:id_membre");
$recup->bindValue(':pseudo', $nouveau_pseudo, PDO::PARAM_STR);
$recup->bindValue(':prenom', $nouveau_prenom, PDO::PARAM_STR);
$recup->bindValue(':nom', $nouveau_nom, PDO::PARAM_STR);
$recup->bindValue(':email', $nouveau_email, PDO::PARAM_STR);
$recup->bindValue(':id_membre', $id_membre, PDO::PARAM_INT);
$recup->execute();

// Mise à jour des données dans la session PHP de l'utilisateur
$_SESSION['membre']['pseudo'] = $nouveau_pseudo;
$_SESSION['membre']['prenom'] = $nouveau_prenom;
$_SESSION['membre']['nom'] = $nouveau_nom;
$_SESSION['membre']['email'] = $nouveau_email;

// Redirection vers la page de profil
header("Location: profil.php");
exit();


?>