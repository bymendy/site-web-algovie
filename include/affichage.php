<?php
// Filtre affichage des catégories dans la navigation 
$afficheMenuCategories = $pdo->query(" SELECT * FROM categorie ORDER BY titre ");
// fin de navigation laterale catégories

// tout l'affichage par categorie
if(isset($_GET['categorie'])){

    // affichage de tous les Articles concernés par une categorie
    $afficheArticles = $pdo->query(" SELECT * FROM annonce WHERE categorie_id = '$_GET[categorie]' ORDER BY prix ASC ");
    // fin affichage des Articles par categorie

    // affichage de la categorie dans le <h2>
    $afficheTitreCategorie = $pdo->query(" SELECT titre FROM categorie WHERE id_categorie = '$_GET[categorie]' ");
    $titreCategorie = $afficheTitreCategorie->fetch(PDO::FETCH_ASSOC);
    // fin du h2 categorie

    // pour les onglets categories
    $pageTitle = "Nos modèles de " . $_GET['categorie'];
    // fin onglets categories
}
// fin affichage par categorie

// ----------------------------------------------------------------------------------
// tout l'affichage par articles
if(isset($_GET['articles'])){

    // affichage des Articles par articles
    // requete qui va cibler tous les Articles qui ont en commun le articles récupéré dans l'URL
    $afficheArticles = $pdo->query(" SELECT * FROM articles WHERE titre = '$_GET[titre]' ORDER BY prix ASC ");
    // fin affichage des Articles par articles

    // affichage de l'articles dans le <h2>
    $afficheTitreArticle = $pdo->query(" SELECT titre FROM articles WHERE titre = '$_GET[titre]' ");
    $titreArticle = $afficheTitreArticle->fetch(PDO::FETCH_ASSOC);
    // fin du </h2> pour le articles

    // pour les onglets Articles
    $pageTitle = "Nos Articles " . ucfirst($_GET['articles']) . 's'; 
    // fin onglets Articles
}
// fin affichage par articles

// ---------------------------------------------------------------------------------------
// Tout ce qui concerne la fiche articles

// affichage d'une articles
if(isset($_GET['id_articles'])){
    $detailArticle = $pdo->query(" SELECT * FROM articles WHERE id_articles = '$_GET[id_articles]' ");
    // pour se protéger de qlq'un qui tenterait de modifier l'id-articles dans l'URL
    if($detailArticle->rowCount() <= 0){
        header('location:' . URL);
        exit;
    }
    
    $detail = $detailArticle->fetch(PDO::FETCH_ASSOC);
}
//  fin fiche articles

// --------------------------------------------------------------------------------------------